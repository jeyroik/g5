<?php
namespace tratabor\components\basics\worlds;

use tratabor\components\basics\BasicWorld;

/**
 * Class WorldRepository
 *
 * @package tratabor\components\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldRepository
{
    /**
     * @var WorldRepository
     */
    protected static $instance = null;

    /**
     * @var array|mixed
     */
    protected $worlds = [];

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
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * WorldRepository constructor.
     */
    public function __construct()
    {
        $worldsPath = getenv('G5__WORLD__PATH') ?: G5__ROOT_PATH . '/resources/worlds.php';

        if (is_file($worldsPath)) {
            $this->worlds = include $worldsPath;
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $worlds = [];

        foreach ($this->worlds as $world) {
            $worlds[] = new BasicWorld($world);
        }

        return $worlds;
    }
}
