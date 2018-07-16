<?php
namespace tratabor\interfaces\basics;

/**
 * Interface IUser
 *
 * @stage.expand.type IUser
 * @stage.expand.name tratabor\interfaces\basics\IUser
 *
 * @stage.name user.init
 * @stage.description User initialization finish
 * @stage.input IUser $user
 * @stage.output void
 *
 * @stage.name user.after
 * @stage.description User destructing
 * @stage.input IUser $user
 * @stage.output void
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IUser
{
    const SUBJECT = 'user';

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
