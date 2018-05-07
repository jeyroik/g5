<?php
namespace tratabor\components\systems\states\machines\streams;

use tratabor\interfaces\systems\states\machines\IMachineStream;
use tratabor\interfaces\systems\states\machines\streams\IStreamFactory;

/**
 * Class StreamFactory
 *
 * @package tratabor\components\systems\states\machines\streams
 * @author Funcraft <me@funcraft.ru>
 */
class StreamFactory implements IStreamFactory
{
    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $streamTypesToClass = [];

    /**
     * @param $data
     *
     * @return IMachineStream
     */
    public static function buildStream($data): IMachineStream
    {
        return static::getInstance()->build($data);
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * StreamFactory constructor.
     */
    public function __construct()
    {
        $streamTypesPath = getenv('G5__STREAM__TYPES_PATH')
            ?: G5__ROOT_PATH . '/resources/configs/stream.types.php';

        if (is_file($streamTypesPath)) {
            $this->streamTypesToClass = include $streamTypesPath;
        } else {
            $this->streamTypesToClass = [
                'array' => StreamArray::class,
                'string' => StreamString::class,
                'object' => StreamObject::class
            ];
        }
    }

    /**
     * @param $data
     *
     * @return StreamArray
     */
    public function build($data)
    {
        $dataType = gettype($data);

        if (isset($this->streamTypesToClass[$dataType])) {
            $streamClass = $this->streamTypesToClass[$dataType];
            return new $streamClass($data);
        } else {
            $stream = new StreamArray();
            $stream->write('Unsupported stream type "' . $dataType . '"');

            return $stream;
        }
    }
}
