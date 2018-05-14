<?php
namespace tratabor\components\basics;

use tratabor\components\basics\worlds\WorldHost;
use tratabor\components\systems\Item;
use tratabor\interfaces\basics\IWorld;

/**
 * Class BasicWorld
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicWorld extends Item implements IWorld
{
    /**
     * @var array
     */
    protected $world = [];

    /**
     * BasicWorld constructor.
     * @param array $worldConfig
     */
    public function __construct($worldConfig = [])
    {
        $this->initWorld($worldConfig);
        parent::__construct('wid', 'world__' . time());
    }

    /**
     * @return array|mixed
     */
    public function getBoards()
    {
        return $this->world['boards'] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getCreatures()
    {
        return $this->world['creatures'] ?? [];
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getUpdatedAt($format = '')
    {
        return $format ? date($format, $this->world['updated_at']) : $this->world['updated_at'];
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->world['created_at']) : $this->world['created_at'];
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->world['size'] ?? 0;
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->world['creatures_max'] ?? 0;
    }

    /**
     * @return int
     */
    public function getBoardsMax(): int
    {
        return $this->world['boards_max'] ?? 0;
    }

    /**
     * @return mixed|string
     */
    public function getId()
    {
        return $this->world['id'] ?? '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->world['name'] ?? '';
    }

    /**
     * @return mixed|WorldHost
     */
    public function getHost()
    {
        return $this->world['host'] ?? new WorldHost();
    }

    /**
     * @param $worldConfig
     *
     * @return $this
     */
    protected function initWorld($worldConfig)
    {
        $this->world = $worldConfig;
        $this->world['host'] = new WorldHost($this->world['host']);

        return $this;
    }
}
