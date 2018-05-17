<?php
namespace tratabor\components\systems\states;

use tratabor\components\systems\Context;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateFactory;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\IMachineStream;
use tratabor\interfaces\systems\states\machines\streams\IStreamFactory;

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
     * @return mixed
     */
    public function run($stateId = null)
    {
        /**
         * Terminate state transition.
         */
        if ($this->currentState && !$stateId) {
            return true;
        }

        /**
         * State is a StateMachine
         */
        if (is_array($stateId)) {
            $stateMachine = new static($stateId, $this->currentContext);
            return $stateMachine->run();
        }

        $stateId = $this->validateStateId($stateId);

        if (!isset($this->config[$stateId])) {
            throw new \Exception('Unknown state "' . $stateId . '"');
        }

        if ($this->currentState && ($this->currentState == $stateId)) {
            // it seems to be an infinity cycle
            // break it
            return true;
        }

        $state = $this->buildState($stateId);

        return $this->runState($state);
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
     * @return bool
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

        return true;
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
     * @return bool|mixed
     * @throws \Exception
     */
    protected function validateContextFor($state)
    {
        if ($this->currentContext->readItem(static::CONTEXT__SUCCESS)->getValue()) {
            if (!$state->getOnSuccess()) {// у терминальных состояний нет продолжения
                return true;
            }

            return $this->run($state->getOnSuccess());
        } else {
            $this->states[$state->getId()]++;

            return $this->run($state->getOnFailure());
        }
    }

    /**
     * @param $stateId
     *
     * @return string
     */
    protected function validateStateId($stateId)
    {
        return $stateId
            ?: (
                getenv('G5__STATE__START')
                ?: 'app:run'
            );
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
        $this->currentContext->pushItemByName(static::CONTEXT__SUCCESS, true);

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
