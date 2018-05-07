<?php
namespace tratabor\interfaces\systems\states\machines;

use tratabor\interfaces\systems\IItem;

/**
 * Interface IMachineStream
 *
 * @package tratabor\interfaces\systems\states\machines
 * @author aivanov@fix.ru
 */
interface IMachineStream
{
    /**
     * IMachineStream constructor.
     * @param string|array|IItem $data
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
