<?php

/*
 * This file is part of the Behat Testwork.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Testwork\Tester\ServiceContainer;

use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\Environment\ServiceContainer\EnvironmentExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Behat\Testwork\Specification\ServiceContainer\SpecificationExtension;
use Behat\Testwork\Suite\ServiceContainer\SuiteExtension;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Provides tester services.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
abstract class TesterExtension implements Extension
{
    /*
     * Available services
     */
    public const EXERCISE_ID = 'tester.exercise';
    public const SUITE_TESTER_ID = 'tester.suite';
    public const SPECIFICATION_TESTER_ID = 'tester.specification';
    public const RESULT_INTERPRETER_ID = 'tester.result.interpreter';
    public const STOP_ON_FAILURE_ID = 'tester.stop_on_failure';

    /**
     * Available extension points
     */
    public const EXERCISE_WRAPPER_TAG = 'tester.exercise.wrapper';
    public const SUITE_TESTER_WRAPPER_TAG = 'tester.suite.wrapper';
    public const SPECIFICATION_TESTER_WRAPPER_TAG = 'tester.specification.wrapper';
    public const RESULT_INTERPRETATION_TAG = 'test.result.interpretation';

    /**
     * @var ServiceProcessor
     */
    private $processor;

    /**
     * Initializes extension.
     *
     * @param null|ServiceProcessor $processor
     */
    public function __construct(?ServiceProcessor $processor = null)
    {
        $this->processor = $processor ?: new ServiceProcessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'testers';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $childrenBuilder = $builder
            ->addDefaultsIfNotSet()
            ->children()
        ;
        $childrenBuilder
                ->scalarNode('stop_on_failure')
                ->defaultValue(null)
        ;
        $childrenBuilder
                ->booleanNode('strict')
                    ->info('Sets the strict mode for result interpretation')
                    ->defaultFalse()
        ;
        $childrenBuilder
                ->booleanNode('skip')
                    ->info('Tells tester to skip all tests')
                    ->defaultFalse()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadExerciseController($container, $config['skip']);
        $this->loadStopOnFailureHandler($container, $config['stop_on_failure']);
        $this->loadStrictController($container, $config['strict']);
        $this->loadResultInterpreter($container);
        $this->loadExercise($container);
        $this->loadSuiteTester($container);
        $this->loadSpecificationTester($container);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->processExerciseWrappers($container);
        $this->processSuiteTesterWrappers($container);
        $this->processSpecificationTesterWrappers($container);
        $this->processResultInterpretations($container);
    }

    /**
     * Loads exercise cli controllers.
     *
     * @param ContainerBuilder $container
     * @param bool          $skip
     */
    protected function loadExerciseController(ContainerBuilder $container, $skip = false)
    {
        $definition = new Definition('Behat\Testwork\Tester\Cli\ExerciseController', [
            new Reference(SuiteExtension::REGISTRY_ID),
            new Reference(SpecificationExtension::FINDER_ID),
            new Reference(self::EXERCISE_ID),
            new Reference(self::RESULT_INTERPRETER_ID),
            $skip,
        ]);
        $definition->addTag(CliExtension::CONTROLLER_TAG, ['priority' => 0]);
        $container->setDefinition(CliExtension::CONTROLLER_TAG . '.exercise', $definition);
    }


    /**
     * Loads stop on failure handler.
     */
    private function loadStopOnFailureHandler(ContainerBuilder $container, ?bool $stopOnFailure)
    {
        $definition = new Definition('Behat\Testwork\Tester\Handler\StopOnFailureHandler', [
            new Reference(EventDispatcherExtension::DISPATCHER_ID),
            new Reference(TesterExtension::RESULT_INTERPRETER_ID),
        ]);

        if ($stopOnFailure === true) {
            $definition->addMethodCall('registerListeners');
        }
        $container->setDefinition(self::STOP_ON_FAILURE_ID, $definition);
    }

    /**
     * Loads exercise cli controllers.
     *
     * @param ContainerBuilder $container
     * @param bool          $strict
     */
    protected function loadStrictController(ContainerBuilder $container, $strict = false)
    {
        $definition = new Definition('Behat\Testwork\Tester\Cli\StrictController', [
            new Reference(self::RESULT_INTERPRETER_ID),
            $strict,
        ]);
        $definition->addTag(CliExtension::CONTROLLER_TAG, ['priority' => 300]);
        $container->setDefinition(CliExtension::CONTROLLER_TAG . '.strict', $definition);
    }

    /**
     * Loads result interpreter controller
     *
     * @param ContainerBuilder $container
     */
    protected function loadResultInterpreter(ContainerBuilder $container)
    {
        $definition = new Definition('Behat\Testwork\Tester\Result\ResultInterpreter');
        $container->setDefinition(self::RESULT_INTERPRETER_ID, $definition);

        $definition = new Definition('Behat\Testwork\Tester\Result\Interpretation\SoftInterpretation');
        $definition->addTag(self::RESULT_INTERPRETATION_TAG);
        $container->setDefinition(self::RESULT_INTERPRETATION_TAG . '.soft', $definition);
    }

    /**
     * Loads exercise tester.
     *
     * @param ContainerBuilder $container
     */
    protected function loadExercise(ContainerBuilder $container)
    {
        $definition = new Definition('Behat\Testwork\Tester\Runtime\RuntimeExercise', [
            new Reference(EnvironmentExtension::MANAGER_ID),
            new Reference(self::SUITE_TESTER_ID),
        ]);
        $container->setDefinition(self::EXERCISE_ID, $definition);
    }

    /**
     * Loads suite tester.
     *
     * @param ContainerBuilder $container
     */
    protected function loadSuiteTester(ContainerBuilder $container)
    {
        $definition = new Definition('Behat\Testwork\Tester\Runtime\RuntimeSuiteTester', [
            new Reference(self::SPECIFICATION_TESTER_ID),
        ]);
        $container->setDefinition(self::SUITE_TESTER_ID, $definition);
    }

    /**
     * Loads specification tester.
     *
     * @param ContainerBuilder $container
     */
    abstract protected function loadSpecificationTester(ContainerBuilder $container);

    /**
     * Processes all registered exercise wrappers.
     *
     * @param ContainerBuilder $container
     */
    protected function processExerciseWrappers(ContainerBuilder $container)
    {
        $this->processor->processWrapperServices($container, self::EXERCISE_ID, self::EXERCISE_WRAPPER_TAG);
    }

    /**
     * Processes all registered suite tester wrappers.
     *
     * @param ContainerBuilder $container
     */
    protected function processSuiteTesterWrappers(ContainerBuilder $container)
    {
        $this->processor->processWrapperServices($container, self::SUITE_TESTER_ID, self::SUITE_TESTER_WRAPPER_TAG);
    }

    /**
     * Processes all registered specification tester wrappers.
     *
     * @param ContainerBuilder $container
     */
    protected function processSpecificationTesterWrappers(ContainerBuilder $container)
    {
        $this->processor->processWrapperServices($container, self::SPECIFICATION_TESTER_ID, self::SPECIFICATION_TESTER_WRAPPER_TAG);
    }

    /**
     * Processes all registered result interpretations.
     *
     * @param ContainerBuilder $container
     */
    protected function processResultInterpretations(ContainerBuilder $container)
    {
        $references = $this->processor->findAndSortTaggedServices($container, self::RESULT_INTERPRETATION_TAG);
        $definition = $container->getDefinition(self::RESULT_INTERPRETER_ID);

        foreach ($references as $reference) {
            $definition->addMethodCall('registerResultInterpretation', [$reference]);
        }
    }
}
