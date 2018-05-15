<?php
namespace tratabor\interfaces\basics\creatures;

/**
 * Interface ICreatureCharacteristic
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureCharacteristic
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return string
     */
    public function getDescription(): string;
}
