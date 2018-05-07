<?php
namespace tratabor\interfaces\systems\states\machines;

/**
 * Interface IMachineStream
 *
 * @package tratabor\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineStream
{
    /**
     * IMachineStream constructor.
     * @param mixed
     */
    public function __construct($data = null);

    /**
     * @param int $index
     *
     * @return mixed
     */
    public function read($index = null);

    /**
     * @param $data
     *
     * @return $this
     */
    public function write($data);
}
