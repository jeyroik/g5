<?php
namespace tratabor\components\systems\states;

use tratabor\components\systems\Context;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateFactory;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class StateMachine
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateMachine implements IStateMachine
{
    /**
     * key   = stateId
     * value = tries count
     *
     * @var array
     */
    protected $states = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var IContext
     */
    protected $currentContext = null;

    /**
     * @var IState
     */
    protected $currentState = null;

    /**
     * @var IStateFactory
     */
    protected $stateFactory = null;

    /**
     * @var array
     */
    protected $statesRoute = [
        'path' => [],
        'states' => []
    ];

    /**
     * StateMachine constructor.
     *
     * @param $statesConfig
     * @param array $contextData
     */
    public function __construct($statesConfig, $contextData = [])
    {
        $this->initStateFactory()
            ->setConfig($statesConfig)
            ->initContext($contextData);
    }

    /**
     * @param string $stateId
     *
     * @throws \Exception
     * @return string
     */
    public function run($stateId = null)
    {
        if ($stateId = $this->isRunningApplicableState($stateId)) {
            $state = $this->buildState($stateId);
            return $this->runState($state);
        }

        return $this->currentState ? $this->currentState->getId() : '';
    }

    /**
     * @return IState|null
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @return array
     */
    public function getStatesRoute()
    {
        return $this->statesRoute;
    }

    /**
     * @param $stateId
     *
     * @return IState
     */
    protected function buildState($stateId)
    {
        $stateConfig = $this->config[$stateId];
        $fromState = $this->currentState ? $this->currentState->getId() : '';

        $this->addToStatesRoute($fromState, $stateId);
        $state = $this->stateFactory::buildState($stateConfig, $fromState, $stateId);
        $this->currentState = $state;

        return $state;
    }

    /**
     * @param $from
     * @param $to
     *
     * @return $this
     */
    protected function addToStatesRoute($from, $to)
    {
        if (empty($from)) {
            $from = '@directive.machineInitialization()';
        }

        if (!isset($this->statesRoute['states'][$from])) {
            $this->statesRoute['states'][$from] = [];
        }

        $this->statesRoute['path'][] = [$from => $to];
        $this->statesRoute['states'][$from][] = $to;

        return $this;
    }

    /**
     * @param IState $state
     *
     * @return string
     */
    protected function runState($state)
    {
        if ($state->getMaxTry()) {
            if (!isset($this->states[$state->getId()])) {
                $this->states[$state->getId()] = 1;
            } else {
                if ($this->states[$state->getId()] > $state->getMaxTry()) {
                    return $this->run($state->getOnTerminate());
                }
            }

            $this->runStateDispatchers($state);

            return $this->validateContextFor($state);
        }

        return $this->currentState->getId();
    }

    /**
     * @param IState $state
     *
     * @return $this
     */
    protected function runStateDispatchers($state)
    {
        foreach ($state->getDispatchers() as $dispatcher) {
            $this->currentContext = $dispatcher($state, $this->currentContext);

            if (!$this->currentContext->readItem(static::CONTEXT__SUCCESS)->getValue()) {
                break;
            }
        }

        return $this;
    }

    /**
     * @param IState $state
     *
     * @return string
     * @throws \Exception
     */
    protected function validateContextFor($state)
    {
        if ($this->currentContext->readItem(static::CONTEXT__SUCCESS)->getValue()) {
            if (!$state->getOnSuccess()) {// у терминальных состояний нет продолжения
                return $this->currentState->getId();
            }

            return $this->run($state->getOnSuccess());
        } else {
            $this->states[$state->getId()]++;

            return $this->run($state->getOnFailure());
        }
    }

    /**
     * @param string|array $stateId
     *
     * @return bool|string
     * @throws \Exception
     */
    protected function isRunningApplicableState($stateId)
    {
        /**
         * Terminate state transition.
         */
        if ($this->isTerminatingState($stateId)) {
            return false;
        }

        /**
         * State is a StateMachine
         */
        if ($this->isStateMachineConfig($stateId)) {
            return $this->runSubMachine($stateId);
        }

        $stateId = $this->getStartState($stateId);

        if (!isset($this->config[$stateId])) {
            $from = $this->currentState ? $this->currentState->getId() : '@directive.initializeMachine()';
            throw new \Exception(
                'Unknown to state "' . $stateId . '" from "' . $from . '"'
            );
        }

        if ($this->currentState && ($this->currentState == $stateId)) {
            // it seems to be an infinity cycle
            // break it
            return false;
        }

        return $stateId;
    }

    /**
     * @param $stateId
     *
     * @return bool
     */
    protected function isStateMachineConfig($stateId): bool
    {
        return is_array($stateId);
    }

    /**
     * @param $machineConfig
     *
     * @return string
     */
    protected function runSubMachine($machineConfig)
    {
        $stateMachine = new static($machineConfig, $this->currentContext);
        $nextPrimaryState = $stateMachine->run();
        $this->addToStatesRoute($this->currentState->getId(), $stateMachine->getStatesRoute());

        return $nextPrimaryState;
    }

    /**
     * @param $stateId
     *
     * @return bool
     */
    protected function isTerminatingState($stateId): bool
    {
        return $this->currentState && !$stateId;
    }

    /**
     * @param string $stateId
     *
     * @return string
     */
    protected function getStartState($stateId): string
    {
        return $stateId
            ?: (
                ($startState = $this->hasEnvStartState())
                    ? $startState
                    : $this->getStartStateFromConfig()
            );
    }

    /**
     * @return string
     */
    protected function hasEnvStartState(): string
    {
        return getenv(static::ENV__START_STATE);
    }

    /**
     * @return string
     */
    protected function getStartStateFromConfig(): string
    {
        $machineConfig = $this->config[static::MACHINE__CONFIG];

        return $machineConfig[static::MACHINE__CONFIG__START_STATE];
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param $contextData
     *
     * @return $this
     */
    protected function initContext($contextData)
    {
        $this->currentContext = new Context($contextData);

        /**
         * Try to get context_success item.
         * If this is sub-machine, than this item is already exists - so we don't need to do anything.
         * If this is primary machine, than item is not exists, so exception will be thrown.
         */
        try {
            $this->currentContext->readItem(static::CONTEXT__SUCCESS);
        } catch (\Exception $e) {
            $this->currentContext->pushItemByName(static::CONTEXT__SUCCESS, true);
            $this->currentContext->pushItemByName(static::CONTEXT__ERRORS, []);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initStateFactory()
    {
        $this->stateFactory = SystemContainer::getItem(IStateFactory::class);

        return $this;
    }
}
