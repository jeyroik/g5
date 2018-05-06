<?php
namespace tratabor\interfaces\systems;

/**
 * Interface IItem
 * @package tratabor\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IItem
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param $value
     *
     * @return IItem
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return IState
     */
    public function getState(): string;

    /**
     * @param string $format
     *
     * @return string|int
     */
    public function getCreatedAt($format = '');

    /**
     * @param string $format
     *
     * @return string|int
     */
    public function getUpdatedAt($format = '');

    /**
     * @return mixed
     */
    public function getId();
}
