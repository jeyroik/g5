<?php
namespace tratabor\interfaces\systems\states;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\machines\IMachineStream;

/**
 * Interface IStateMachine
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateMachine
{
    const CONTEXT__SUCCESS = '@directive.success()';
    const CONTEXT__STATES = '';

    /**
     * IStateMachine constructor.
     *
     * @param $statesConfig
     * @param array $contextData
     */
    public function __construct($statesConfig, $contextData = []);

    /**
     * @param $stateId string
     *
     * @return mixed
     */
    public function run($stateId = null);

    /**
     * @return IMachineStream
     */
    public function getStream(): IMachineStream;

    /**
     * @return IState|null
     */
    public function getCurrentState();
}
