<?php
namespace tratabor\components\basics\creatures;

use tratabor\interfaces\basics\creatures\ICreatureCharacteristic;

/**
 * Class CreatureCharacteristic
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureCharacteristic implements ICreatureCharacteristic
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * CreatureCharacteristic constructor.
     * @param $characteristicConfig
     */
    public function __construct($characteristicConfig)
    {
        $this->initCharacteristic($characteristicConfig);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->data['value'] ?? '';
    }

    /**
     * @param $characteristicConfig
     *
     * @return $this
     */
    protected function initCharacteristic($characteristicConfig)
    {
        $this->data = $characteristicConfig;

        return $this;
    }
}
