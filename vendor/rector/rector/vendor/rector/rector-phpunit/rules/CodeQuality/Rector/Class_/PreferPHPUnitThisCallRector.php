<?php

declare (strict_types=1);
namespace Rector\PHPUnit\CodeQuality\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector\PreferPHPUnitThisCallRectorTest
 */
final class PreferPHPUnitThisCallRector extends AbstractRector
{
    /**
     * @readonly
     */
    private TestsNodeAnalyzer $testsNodeAnalyzer;
    /**
     * @var string[]
     */
    private const NON_ASSERT_STATIC_METHODS = ['createMock', 'atLeast', 'atLeastOnce', 'once', 'never'];
    public function __construct(TestsNodeAnalyzer $testsNodeAnalyzer)
    {
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
    }
    public function getRuleDefinition() : RuleDefinition
    {
        return new RuleDefinition('Changes PHPUnit calls from self::assert*() to $this->assert*()', [new CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeClass extends TestCase
{
    public function run()
    {
        self::assertEquals('expected', $result);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeClass extends TestCase
{
    public function run()
    {
        $this->assertEquals('expected', $result);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(Node $node) : ?Node
    {
        if (!$this->testsNodeAnalyzer->isInTestClass($node)) {
            return null;
        }
        $hasChanged = \false;
        $this->traverseNodesWithCallable($node, function (Node $node) use(&$hasChanged) {
            $isInsideStaticFunctionLike = $node instanceof ClassMethod && $node->isStatic() || $node instanceof Closure && $node->static;
            if ($isInsideStaticFunctionLike) {
                return NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof StaticCall) {
                return null;
            }
            if ($node->isFirstClassCallable()) {
                return null;
            }
            $methodName = $this->getName($node->name);
            if (!\is_string($methodName)) {
                return null;
            }
            if (!$this->isNames($node->class, ['static', 'self'])) {
                return null;
            }
            if (\strncmp($methodName, 'assert', \strlen('assert')) !== 0 && !\in_array($methodName, self::NON_ASSERT_STATIC_METHODS)) {
                return null;
            }
            $hasChanged = \true;
            return $this->nodeFactory->createMethodCall('this', $methodName, $node->getArgs());
        });
        if ($hasChanged) {
            return $node;
        }
        return null;
    }
}
