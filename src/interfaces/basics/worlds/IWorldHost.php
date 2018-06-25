<?php
namespace tratabor\interfaces\basics\worlds;

/**
 * Interface IWorldHost
 *
 * @package tratabor\interfaces\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
interface IWorldHost
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIp();

    /**
     * @return string
     */
    public function getState();

    /**
     * @return array
     */
    public function __toArray(): array;
}
