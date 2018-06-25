<?php
namespace tratabor\components\basics;

use tratabor\components\basics\worlds\WorldHost;
use jeyroik\extas\components\systems\Item;
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
    public function getCreaturesCurrent(): int
    {
        return $this->world['creatures_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getBoardsMax(): int
    {
        return $this->world['boards_max'] ?? 0;
    }

    /**
     * @return int
     */
    public function getBoardsCurrent(): int
    {
        return $this->world['boards_current'] ?? 0;
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
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'host' => $this->getHost()->__toArray(),
            'boards_max' => $this->getBoardsMax(),
            'boards_current' => $this->getBoardsCurrent(),
            'creatures_max' => $this->getCreaturesMax(),
            'creatures_current' => $this->getCreaturesCurrent(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
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
