<?php
namespace tratabor\components\systems\states\machines;

use tratabor\interfaces\systems\IItem;
use tratabor\interfaces\systems\states\machines\IMachineStream;

/**
 * Class MachineStream
 *
 * @package tratabor\components\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
class MachineStream implements IMachineStream
{
    /**
     * @var array|string|IItem
     */
    protected $contents = [];

    /**
     * MachineStream constructor.
     *
     * @param string|array|IItem $data
     */
    public function __construct($data = null)
    {
        $data && $this->contents = $data;
    }

    /**
     * @param int $index
     *
     * @return mixed
     */
    public function read($index = null)
    {
        if ($index) {
            if (is_string($this->contents)) {
                return substr($this->contents, 0, $index);
            } elseif (is_array($this->contents)) {
                return $this->contents[$index] ?? null;
            }
        } else {
            return $this->contents;
        }

        return null;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function write($data)
    {
        if (is_array($this->contents)) {
            $this->contents[] = $data;
        } elseif (is_string($this->contents)) {
            $data = (string) $data;
            $this->contents .= $data;
        } else {
            $this->errorUnSupportedType($data);
        }

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    protected function initContents($data)
    {
        if ($data) {
            if (is_array($data) || (is_string($data))) {
                $this->contents = $data;
            } elseif (is_object($data) && ($data instanceof IItem)) {
                $this->contents = [$data];
            } else {
                $this->errorUnSupportedType($data);
            }
        }

        return $this;
    }

    /**
     * @param $data
     *
     * @throws \Exception
     */
    protected function errorUnSupportedType($data)
    {
        throw new \Exception('Unsupported stream contents type "' . gettype($data) . '"');
    }
}
