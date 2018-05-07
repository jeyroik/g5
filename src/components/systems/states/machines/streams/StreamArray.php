<?php
namespace tratabor\components\systems\states\machines\streams;

use tratabor\interfaces\systems\states\machines\IMachineStream;

/**
 * Class StreamArray
 *
 * @package tratabor\components\systems\states\machines\streams
 * @author Funcraft <me@funcraft.ru>
 */
class StreamArray implements IMachineStream
{
    /**
     * @var array
     */
    protected $contents = [];

    /**
     * MachineStream constructor.
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->contents = $data;
    }

    /**
     * @param int $index
     *
     * @return mixed
     */
    public function read($index = null)
    {
        return $index ? ($this->contents[$index] ?? null) : $this->contents;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function write($data)
    {
        $this->contents[] = $data;

        return $this;
    }
}
