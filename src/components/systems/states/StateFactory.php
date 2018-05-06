<?php
namespace tratabor\components\systems\states;

use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateFactory;

/**
 * Class StateFactory
 *
 * State config:
 * [
 *      'id' => '',
 *      'dispatchers' => [...], // see DispatcherFactory for details
 *      'on_success' => '', // another state name
 *      'on_failure' => '', // t.s.
 *      'on_terminate' => '', // t.s.
 *      'max_try' => 1, // greater or equal 1
 * ]
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateFactory implements IStateFactory
{
    /**
     * @var static
     */
    protected static $instance = null;

    protected $states = [];

    /**
     * @param $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return IState
     */
    public static function buildState($stateConfig, $fromState, $stateId = null): IState
    {
        return static::getInstance()->build($stateConfig, $fromState, $stateId);
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * @param $stateConfig
     * @param $fromState
     * @param $stateId
     *
     * @return StateBasic|StateError
     */
    public function build($stateConfig, $fromState, $stateId)
    {
        if (!is_array($stateConfig)) {
            return new StateError($stateId, $fromState, [], '', '', '', 0);
        }

        $stateId = $stateId
            ?: (
                $stateConfig['id']
                ?? sha1(json_encode($stateConfig))
            );

        return new StateBasic(
            $stateId,
            $fromState,
            $stateConfig['dispatchers'] ?? [],
            $stateConfig['on_success'] ?? '',
            $stateConfig['on_failure'] ?? '',
            $stateConfig['on_terminate'] ?? '',
            $stateConfig['max_try'] ?? 1
        );
    }
}
