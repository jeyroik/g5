<?php
namespace tratabor\components\systems\states\machines\streams;

use tratabor\interfaces\systems\states\machines\IMachineStream;

/**
 * Class StreamString
 *
 * @package tratabor\components\systems\states\machines\streams
 * @author Funcraft <me@funcraft.ru>
 */
class StreamString implements IMachineStream
{
    /**
     * @var string
     */
    protected $contents = '';

    /**
     * MachineStream constructor.
     *
     * @param string $data
     */
    public function __construct($data = '')
    {
        $this->contents = $data;
    }

    /**
     * @param int $index
     *
     * @return string
     */
    public function read($index = null)
    {
        return substr($this->contents, 0, $index);
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function write($data)
    {
        $data = (string) $data;
        $this->contents .= $data;

        return $this;
    }
}
