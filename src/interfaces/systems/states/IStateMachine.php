<?php
namespace tratabor\interfaces\systems\states;

/**
 * Interface IStateMachine
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateMachine
{
    const CONTEXT__SUCCESS = '@directive.success()';

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
     * @return void
     */
    public function run($stateId = null);
}
