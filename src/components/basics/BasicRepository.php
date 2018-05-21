<?php
namespace tratabor\components\basics;

/**
 * Class BasicRepository
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
abstract class BasicRepository
{
    /**
     * @var BasicRepository[]
     */
    protected static $instances = [];

    /**
     * @var array|mixed
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $storageType = 'php';

    /**
     * @return array
     */
    public static function all()
    {
        return static::getInstance()->findAll();
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        $staticClass = static::class;

        if (isset(static::$instances[$staticClass])) {
            return static::$instances[$staticClass];
        } else {
            static::$instances[$staticClass] = new $staticClass();

            return static::getInstance();
        }
    }

    /**
     * WorldRepository constructor.
     */
    public function __construct()
    {
        $path = getenv($this->getPathKey()) ?: $this->getPathDefault();

        if (is_file($path)) {
            $this->items = include $path;
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $itemClass = $this->getItemClass();
        $items = [];

        foreach ($this->items as $item) {
            $items[] = new $itemClass($item);
        }

        return $items;
    }

    /**
     * @return string
     */
    abstract protected function getItemClass(): string;

    /**
     * @return string
     */
    abstract protected function getPathKey(): string;

    /**
     * @return string
     */
    abstract protected function getPathDefault(): string;
}
