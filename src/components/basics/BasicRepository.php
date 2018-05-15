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

        return static::$instances[$staticClass] ?: static::$instances[$staticClass] = new $staticClass();
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

        foreach ($this->items as $world) {
            $items[] = new $itemClass($world);
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
