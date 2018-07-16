<?php
namespace tratabor\components\basics\creatures;

use jeyroik\extas\components\systems\Item;
use tratabor\interfaces\basics\creatures\ICreatureCharacteristic;

/**
 * Class CreatureCharacteristic
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureCharacteristic extends Item implements ICreatureCharacteristic
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config['name'] ?? '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->config['description'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->config['value'] ?? '';
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return ICreatureCharacteristic::SUBJECT;
    }
}
