<?php
namespace tratabor\components\systems\states;

use tratabor\components\systems\Context;
use tratabor\components\systems\states\machines\MachineStream;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateFactory;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\IMachineStream;

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
     * @var IMachineStream
     */
    protected $stream = null;

    /**
     * StateMachine constructor.
     *
     * @param $statesConfig
     * @param array $contextData
     */
    public function __construct($statesConfig, $contextData = [])
    {
        $this->initStream()
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
         * @var $stateFactory IStateFactory
         */
        $stateFactory = SystemContainer::getItem(IStateFactory::class);

        $this->stream->write(' [i] Got state factory: "' . get_class($stateFactory) . '".');
        $stateId = $this->validateStateId($stateId);
        $this->stream->write(' [i] Current state id = "' . $stateId . '".');

        if (!isset($this->config[$stateId])) {
            throw new \Exception('Unknown state "' . $stateId . '"');
        }

        if ($this->currentState && ($this->currentState == $stateId)) {
            $this->stream->write(' (!) Infinity cycle is detected. Terminate machine.');
            // it seems to be an infinity cycle
            // break it
            return true;
        }

        $stateConfig = $this->config[$stateId];
        $this->stream
            ->write(' [i] Current state config:')
            ->write($stateConfig);

        $fromState = $this->currentState ? $this->currentState->getId() : '';
        $this->stream->write(' [i] Current "from state" = "' . $fromState . '"');

        $state = $stateFactory::buildState($stateConfig, $fromState, $stateId);
        $this->currentState = $state;

        $this->stream
            ->write(' [i] State is built:')
            ->write($state);

        if ($state->getMaxTry()) {
            $this->stream->write(' [i] Current state max try is "' . $state->getMaxTry() . '".');

            if (!isset($this->states[$state->getId()])) {
                $this->states[$state->getId()] = 1;

                $this->stream
                    ->write(' [i] Current state is new. Registered it in the state list:')
                    ->write($this->states);
            } else {
                $this->stream->write(' [i] Current state is already was');

                if ($this->states[$state->getId()] >= $state->getMaxTry()) {
                    $this->stream->write('Too much state tries. Run "on terminate" state');
                    return $this->run($state->getOnTerminate());
                }
            }

            $this->stream
                ->write(' [i] Start calling state dispatchers. Current context is:')
                ->write($this->currentContext);

            foreach ($state->getDispatchers() as $dispatcher) {
                $this->stream->write(' [i] Current dispatcher: ')->write($dispatcher);
                $this->currentContext = $dispatcher($state, $this->currentContext);
                $this->stream->write(' [i] Current context is')->write($this->currentContext);

                if (!$this->currentContext->readItem(static::CONTEXT__SUCCESS)) {
                    $this->stream
                        ->write(' [i] Context result is not success. Terminate current state dispatchers cycle.');
                    break;
                }
            }

            return $this->validateContextFor($state);
        } else {
            $this->stream->write(' [w] State max try is 0. Terminate current state cycle.');
        }

        $this->stream->write(' [i] State cycle is finished. Terminate state cycle.');

        return true;
    }

    /**
     * @return IMachineStream
     */
    public function getStream(): IMachineStream
    {
        return $this->stream;
    }

    /**
     * @param IState $state
     *
     * @return bool|mixed
     * @throws \Exception
     */
    protected function validateContextFor($state)
    {
        $this->stream->write(' [i] Start state context validation.');

        if ($this->currentContext->readItem(static::CONTEXT__SUCCESS)) {
            $this->stream->write(' [i] Context result is success');
            if (!$state->getOnSuccess()) {// у терминальных состояний нет продолжения
                $this->stream->write(' [i] Termination state is detected. Terminate cycle.');
                return true;
            }

            $this->stream->write(' [i] Run "on success" state: "' . $state->getOnSuccess() . '".');
            return $this->run($state->getOnSuccess());
        } else {
            $this->states[$state->getId()]++;
            $this->stream
                ->write(' [i] Context result is failure. Inc max try state (' . $state->getId() . ') counter:')
                ->write($this->states)
                ->write(' [i] Run "on failure" state: "' . $state->getOnFailure() . '".');

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

        $this->stream
            ->write('Config set')
            ->write('Config hash: ' . sha1(json_encode($config)));

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

        $this->stream
            ->write(' [i] Init context with data:')
            ->write($contextData);

        $this->currentContext->pushItemByName(static::CONTEXT__SUCCESS, true);

        $this->stream->write(' [i] Push item "' . static::CONTEXT__SUCCESS . '" to the context.');

        return $this;
    }

    /**
     * @return $this
     */
    protected function initStream()
    {
        $this->stream = new MachineStream([]);

        return $this;
    }
}
