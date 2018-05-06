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
     * StateMachine constructor.
     *
     * @param $statesConfig
     * @param array $contextData
     */
    public function __construct($statesConfig, $contextData = [])
    {
        $this->setConfig($statesConfig)
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
         * @var $stateFactory IStateFactory
         */
        $stateFactory = SystemContainer::getItem(IStateFactory::class);
        $stateId = $this->validateStateId($stateId);

        if (!isset($this->config[$stateId])) {
            throw new \Exception('Unknown state "' . $stateId . '"');
        }

        if ($this->currentState && ($this->currentState == $stateId)) {
            // it seems to be an infinity cycle
            // break it
            return true;
        }

        $stateConfig = $this->config[$stateId];
        $fromState = $this->currentState ? $this->currentState->getId() : '';

        $state = $stateFactory::buildState($stateConfig, $fromState, $stateId);
        $this->currentState = $state;

        if ($state->getMaxTry()) {
            if (!isset($this->states[$state->getId()])) {
                $this->states[$state->getId()] = 1;
            } else {
                if ($this->states[$state->getId()] >= $state->getMaxTry()) {

                    return $this->run($state->getOnTerminate());
                }
            }

            foreach ($state->getDispatchers() as $dispatcher) {
                $this->currentContext = $dispatcher($state, $this->currentContext);
                if (!$this->currentContext->readItem(static::CONTEXT__SUCCESS)) {
                    break;
                }
            }

            return $this->validateContextFor($state);
        }

        return true;
    }

    /**
     * @param IState $state
     *
     * @return bool|mixed
     * @throws \Exception
     */
    protected function validateContextFor($state)
    {
        if ($this->currentContext->readItem(static::CONTEXT__SUCCESS)) {
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
                getenv('G5__STATE_START')
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
}
