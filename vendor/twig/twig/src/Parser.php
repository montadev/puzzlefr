<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig;

use Twig\Error\SyntaxError;
use Twig\Node\BlockNode;
use Twig\Node\BlockReferenceNode;
use Twig\Node\BodyNode;
use Twig\Node\EmptyNode;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Expression\Variable\AssignTemplateVariable;
use Twig\Node\Expression\Variable\TemplateVariable;
use Twig\Node\MacroNode;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\Node\NodeCaptureInterface;
use Twig\Node\NodeOutputInterface;
use Twig\Node\Nodes;
use Twig\Node\PrintNode;
use Twig\Node\TextNode;
use Twig\TokenParser\TokenParserInterface;
use Twig\Util\ReflectionCallable;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Parser
{
    private $stack = [];
    private $stream;
    private $parent;
    private $visitors;
    private $expressionParser;
    private $blocks;
    private $blockStack;
    private $macros;
    private $importedSymbols;
    private $traits;
    private $embeddedTemplates = [];
    private $varNameSalt = 0;
    private $ignoreUnknownTwigCallables = false;

    public function __construct(
        private Environment $env,
    ) {
    }

    public function getEnvironment(): Environment
    {
        return $this->env;
    }

    public function getVarName(): string
    {
        trigger_deprecation('twig/twig', '3.15', 'The "%s()" method is deprecated.', __METHOD__);

        return \sprintf('__internal_parse_%d', $this->varNameSalt++);
    }

    public function parse(TokenStream $stream, $test = null, bool $dropNeedle = false): ModuleNode
    {
        $vars = get_object_vars($this);
        unset($vars['stack'], $vars['env'], $vars['handlers'], $vars['visitors'], $vars['expressionParser'], $vars['reservedMacroNames'], $vars['varNameSalt']);
        $this->stack[] = $vars;

        // node visitors
        if (null === $this->visitors) {
            $this->visitors = $this->env->getNodeVisitors();
        }

        if (null === $this->expressionParser) {
            $this->expressionParser = new ExpressionParser($this, $this->env);
        }

        $this->stream = $stream;
        $this->parent = null;
        $this->blocks = [];
        $this->macros = [];
        $this->traits = [];
        $this->blockStack = [];
        $this->importedSymbols = [[]];
        $this->embeddedTemplates = [];

        try {
            $body = $this->subparse($test, $dropNeedle);

            if (null !== $this->parent && null === $body = $this->filterBodyNodes($body)) {
                $body = new EmptyNode();
            }
        } catch (SyntaxError $e) {
            if (!$e->getSourceContext()) {
                $e->setSourceContext($this->stream->getSourceContext());
            }

            if (!$e->getTemplateLine()) {
                $e->setTemplateLine($this->getCurrentToken()->getLine());
            }

            throw $e;
        }

        $node = new ModuleNode(new BodyNode([$body]), $this->parent, new Nodes($this->blocks), new Nodes($this->macros), new Nodes($this->traits), $this->embeddedTemplates, $stream->getSourceContext());

        $traverser = new NodeTraverser($this->env, $this->visitors);

        /**
         * @var ModuleNode $node
         */
        $node = $traverser->traverse($node);

        // restore previous stack so previous parse() call can resume working
        foreach (array_pop($this->stack) as $key => $val) {
            $this->$key = $val;
        }

        return $node;
    }

    public function shouldIgnoreUnknownTwigCallables(): bool
    {
        return $this->ignoreUnknownTwigCallables;
    }

    public function subparseIgnoreUnknownTwigCallables($test, bool $dropNeedle = false): void
    {
        $previous = $this->ignoreUnknownTwigCallables;
        $this->ignoreUnknownTwigCallables = true;
        try {
            $this->subparse($test, $dropNeedle);
        } finally {
            $this->ignoreUnknownTwigCallables = $previous;
        }
    }

    public function subparse($test, bool $dropNeedle = false): Node
    {
        $lineno = $this->getCurrentToken()->getLine();
        $rv = [];
        while (!$this->stream->isEOF()) {
            switch (true) {
                case $this->stream->getCurrent()->test(Token::TEXT_TYPE):
                    $token = $this->stream->next();
                    $rv[] = new TextNode($token->getValue(), $token->getLine());
                    break;

                case $this->stream->getCurrent()->test(Token::VAR_START_TYPE):
                    $token = $this->stream->next();
                    $expr = $this->expressionParser->parseExpression();
                    $this->stream->expect(Token::VAR_END_TYPE);
                    $rv[] = new PrintNode($expr, $token->getLine());
                    break;

                case $this->stream->getCurrent()->test(Token::BLOCK_START_TYPE):
                    $this->stream->next();
                    $token = $this->getCurrentToken();

                    if (!$token->test(Token::NAME_TYPE)) {
                        throw new SyntaxError('A block must start with a tag name.', $token->getLine(), $this->stream->getSourceContext());
                    }

                    if (null !== $test && $test($token)) {
                        if ($dropNeedle) {
                            $this->stream->next();
                        }

                        if (1 === \count($rv)) {
                            return $rv[0];
                        }

                        return new Nodes($rv, $lineno);
                    }

                    if (!$subparser = $this->env->getTokenParser($token->getValue())) {
                        if (null !== $test) {
                            $e = new SyntaxError(\sprintf('Unexpected "%s" tag', $token->getValue()), $token->getLine(), $this->stream->getSourceContext());

                            $callable = (new ReflectionCallable(new TwigTest('decision', $test)))->getCallable();
                            if (\is_array($callable) && $callable[0] instanceof TokenParserInterface) {
                                $e->appendMessage(\sprintf(' (expecting closing tag for the "%s" tag defined near line %s).', $callable[0]->getTag(), $lineno));
                            }
                        } else {
                            $e = new SyntaxError(\sprintf('Unknown "%s" tag.', $token->getValue()), $token->getLine(), $this->stream->getSourceContext());
                            $e->addSuggestions($token->getValue(), array_keys($this->env->getTokenParsers()));
                        }

                        throw $e;
                    }

                    $this->stream->next();

                    $subparser->setParser($this);
                    $node = $subparser->parse($token);
                    if (!$node) {
                        trigger_deprecation('twig/twig', '3.12', 'Returning "null" from "%s" is deprecated and forbidden by "TokenParserInterface".', $subparser::class);
                    } else {
                        $node->setNodeTag($subparser->getTag());
                        $rv[] = $node;
                    }
                    break;

                default:
                    throw new SyntaxError('The lexer or the parser ended up in an unsupported state.', $this->getCurrentToken()->getLine(), $this->stream->getSourceContext());
            }
        }

        if (1 === \count($rv)) {
            return $rv[0];
        }

        return new Nodes($rv, $lineno);
    }

    public function getBlockStack(): array
    {
        trigger_deprecation('twig/twig', '3.12', 'Method "%s()" is deprecated.', __METHOD__);

        return $this->blockStack;
    }

    /**
     * @return string|null
     */
    public function peekBlockStack()
    {
        return $this->blockStack[\count($this->blockStack) - 1] ?? null;
    }

    public function popBlockStack(): void
    {
        array_pop($this->blockStack);
    }

    public function pushBlockStack($name): void
    {
        $this->blockStack[] = $name;
    }

    public function hasBlock(string $name): bool
    {
        trigger_deprecation('twig/twig', '3.12', 'Method "%s()" is deprecated.', __METHOD__);

        return isset($this->blocks[$name]);
    }

    public function getBlock(string $name): Node
    {
        trigger_deprecation('twig/twig', '3.12', 'Method "%s()" is deprecated.', __METHOD__);

        return $this->blocks[$name];
    }

    public function setBlock(string $name, BlockNode $value): void
    {
        if (isset($this->blocks[$name])) {
            throw new SyntaxError(\sprintf("The block '%s' has already been defined line %d.", $name, $this->blocks[$name]->getTemplateLine()), $this->getCurrentToken()->getLine(), $this->blocks[$name]->getSourceContext());
        }

        $this->blocks[$name] = new BodyNode([$value], [], $value->getTemplateLine());
    }

    public function hasMacro(string $name): bool
    {
        trigger_deprecation('twig/twig', '3.12', 'Method "%s()" is deprecated.', __METHOD__);

        return isset($this->macros[$name]);
    }

    public function setMacro(string $name, MacroNode $node): void
    {
        $this->macros[$name] = $node;
    }

    public function addTrait($trait): void
    {
        $this->traits[] = $trait;
    }

    public function hasTraits(): bool
    {
        trigger_deprecation('twig/twig', '3.12', 'Method "%s()" is deprecated.', __METHOD__);

        return \count($this->traits) > 0;
    }

    /**
     * @return void
     */
    public function embedTemplate(ModuleNode $template)
    {
        $template->setIndex(mt_rand());

        $this->embeddedTemplates[] = $template;
    }

    public function addImportedSymbol(string $type, string $alias, ?string $name = null, AbstractExpression|AssignTemplateVariable|null $internalRef = null): void
    {
        if ($internalRef && !$internalRef instanceof AssignTemplateVariable) {
            trigger_deprecation('twig/twig', '3.15', 'Not passing a "%s" instance as an internal reference is deprecated ("%s" given).', __METHOD__, AssignTemplateVariable::class, $internalRef::class);

            $internalRef = new AssignTemplateVariable(new TemplateVariable($internalRef->getAttribute('name'), $internalRef->getTemplateLine()), $internalRef->getAttribute('global'));
        }

        $this->importedSymbols[0][$type][$alias] = ['name' => $name, 'node' => $internalRef];
    }

    /**
     * @return array{name: string, node: AssignTemplateVariable|null}|null
     */
    public function getImportedSymbol(string $type, string $alias)
    {
        // if the symbol does not exist in the current scope (0), try in the main/global scope (last index)
        return $this->importedSymbols[0][$type][$alias] ?? ($this->importedSymbols[\count($this->importedSymbols) - 1][$type][$alias] ?? null);
    }

    public function isMainScope(): bool
    {
        return 1 === \count($this->importedSymbols);
    }

    public function pushLocalScope(): void
    {
        array_unshift($this->importedSymbols, []);
    }

    public function popLocalScope(): void
    {
        array_shift($this->importedSymbols);
    }

    public function getExpressionParser(): ExpressionParser
    {
        return $this->expressionParser;
    }

    public function getParent(): ?Node
    {
        trigger_deprecation('twig/twig', '3.12', 'Method "%s()" is deprecated.', __METHOD__);

        return $this->parent;
    }

    /**
     * @return bool
     */
    public function hasInheritance()
    {
        return $this->parent || 0 < \count($this->traits);
    }

    public function setParent(?Node $parent): void
    {
        if (null === $parent) {
            trigger_deprecation('twig/twig', '3.12', 'Passing "null" to "%s()" is deprecated.', __METHOD__);
        }

        if (null !== $this->parent) {
            throw new SyntaxError('Multiple extends tags are forbidden.', $parent->getTemplateLine(), $parent->getSourceContext());
        }

        $this->parent = $parent;
    }

    public function getStream(): TokenStream
    {
        return $this->stream;
    }

    public function getCurrentToken(): Token
    {
        return $this->stream->getCurrent();
    }

    private function filterBodyNodes(Node $node, bool $nested = false): ?Node
    {
        // check that the body does not contain non-empty output nodes
        if (
            ($node instanceof TextNode && !ctype_space($node->getAttribute('data')))
            || (!$node instanceof TextNode && !$node instanceof BlockReferenceNode && $node instanceof NodeOutputInterface)
        ) {
            if (str_contains((string) $node, \chr(0xEF).\chr(0xBB).\chr(0xBF))) {
                $t = substr($node->getAttribute('data'), 3);
                if ('' === $t || ctype_space($t)) {
                    // bypass empty nodes starting with a BOM
                    return null;
                }
            }

            throw new SyntaxError('A template that extends another one cannot include content outside Twig blocks. Did you forget to put the content inside a {% block %} tag?', $node->getTemplateLine(), $this->stream->getSourceContext());
        }

        // bypass nodes that "capture" the output
        if ($node instanceof NodeCaptureInterface) {
            // a "block" tag in such a node will serve as a block definition AND be displayed in place as well
            return $node;
        }

        // "block" tags that are not captured (see above) are only used for defining
        // the content of the block. In such a case, nesting it does not work as
        // expected as the definition is not part of the default template code flow.
        if ($nested && $node instanceof BlockReferenceNode) {
            throw new SyntaxError('A block definition cannot be nested under non-capturing nodes.', $node->getTemplateLine(), $this->stream->getSourceContext());
        }

        if ($node instanceof NodeOutputInterface) {
            return null;
        }

        // here, $nested means "being at the root level of a child template"
        // we need to discard the wrapping "Node" for the "body" node
        // Node::class !== \get_class($node) should be removed in Twig 4.0
        $nested = $nested || (Node::class !== \get_class($node) && !$node instanceof Nodes);
        foreach ($node as $k => $n) {
            if (null !== $n && null === $this->filterBodyNodes($n, $nested)) {
                $node->removeNode($k);
            }
        }

        return $node;
    }
}
