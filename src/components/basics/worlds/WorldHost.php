<?php
namespace tratabor\components\basics\worlds;

use tratabor\interfaces\basics\worlds\IWorldHost;

/**
 * Class WorldHost
 *
 * @package tratabor\components\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldHost implements IWorldHost
{
    /**
     * @var array
     */
    protected $host = [];

    /**
     * WorldHost constructor.
     * @param array $hostConfig
     */
    public function __construct($hostConfig = [])
    {
        $this->initHost($hostConfig);
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->host['name'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getIp()
    {
        return $this->host['ip'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getState()
    {
        return $this->host['state'] ?? '';
    }

    /**
     * @param $hostConfig
     *
     * @return $this
     */
    protected function initHost($hostConfig)
    {
        $this->host = $hostConfig;

        return $this;
    }
}