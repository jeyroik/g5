<?php
namespace tratabor\interfaces\systems\states\machines\streams;

use tratabor\interfaces\systems\states\machines\IMachineStream;

/**
 * Interface IStreamFactory
 *
 * @package tratabor\interfaces\systems\states\machines\streams
 * @author Funcraft <me@funcraft.ru>
 */
interface IStreamFactory
{
    /**
     * @param $data
     *
     * @return IMachineStream
     */
    public static function buildStream($data): IMachineStream;
}
