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
    const CONTEXT__ERRORS = '@directive.errors()';

    const MACHINE__CONFIG = '@directive.config()';
    const MACHINE__CONFIG__VERSION = 'version';
    const MACHINE__CONFIG__ALIAS = 'alias';
    const MACHINE__CONFIG__START_STATE = 'start';

    const ENV__START_STATE = 'G5__STATE__START';

    /**
     * For future purpose
     */
    const MACHINE__CONFIG__END_STATE = 'terminate';

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
     * @return IState|null
     */
    public function getCurrentState();

    /**
     * @return array
     */
    public function getStatesRoute();
}
