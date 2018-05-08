<?php
namespace tratabor\interfaces\basics;

/**
 * Interface IUser
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IUser
{
    /**
     * @return string
     */
    public function getIdentity(): string;

    /**
     * @return string
     */
    public function getSecret(): string;

    /**
     * @return int
     */
    public function getId(): int;

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
}
