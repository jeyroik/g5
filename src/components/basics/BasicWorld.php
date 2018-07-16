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
     * BasicWorld constructor.
     * @param array $worldConfig
     */
    public function __construct($worldConfig = [])
    {
        parent::__construct($worldConfig);

        $this->buildWorld();
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getUpdatedAt($format = '')
    {
        return $format ? date($format, $this->config['updated_at']) : $this->config['updated_at'];
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->config['created_at']) : $this->config['created_at'];
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->config['size'] ?? 0;
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->config['creatures_max'] ?? 0;
    }

    /**
     * @return int
     */
    public function getCreaturesCurrent(): int
    {
        return $this->config['creatures_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getBoardsMax(): int
    {
        return $this->config['boards_max'] ?? 0;
    }

    /**
     * @return int
     */
    public function getBoardsCurrent(): int
    {
        return $this->config['boards_current'] ?? 0;
    }

    /**
     * @return mixed|string
     */
    public function getId()
    {
        return $this->config['id'] ?? '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config['name'] ?? '';
    }

    /**
     * @return mixed|WorldHost
     */
    public function getHost()
    {
        return $this->config['host'] ?? new WorldHost();
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
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return IWorld::SUBJECT;
    }

    /**
     * @return $this
     */
    protected function buildWorld()
    {
        $this->config[IWorld::FIELD__HOST] = new WorldHost($this->config[IWorld::FIELD__HOST]);

        return $this;
    }
}
