<?php
namespace tratabor\components\basics\worlds;

use jeyroik\extas\components\systems\Item;
use tratabor\interfaces\basics\worlds\IWorldHost;

/**
 * Class WorldHost
 *
 * @package tratabor\components\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldHost extends Item implements IWorldHost
{
    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->config['name'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getIp()
    {
        return $this->config['ip'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getState()
    {
        return $this->config['state'] ?? '';
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'ip' => $this->getIp(),
            'name' => $this->getName(),
            'state' => $this->getState()
        ];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return IWorldHost::SUBJECT;
    }
}