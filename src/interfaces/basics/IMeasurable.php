<?php
namespace tratabor\interfaces\basics;

/**
 * Interface IMeasurable
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IMeasurable
{
    /**
     * @return mixed
     */
    public function getCurrent();

    /**
     * @return mixed
     */
    public function getNext();

    /**
     * @return mixed
     */
    public function getMin();

    /**
     * @return mixed
     */
    public function getMax();

    /**
     * @return int
     */
    public function getStep(): int;
}
