<?php
namespace tratabor\interfaces\systems\states\dispatchers;

/**
 * Interface IDispatchersFactory
 *
 * @package tratabor\interfaces\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
interface IDispatchersFactory
{
    /**
     * @param $dispatcherConfig
     * @param string $dispatcherId
     *
     * @return mixed
     */
    public static function buildDispatcher($dispatcherConfig, $dispatcherId = null);
}
