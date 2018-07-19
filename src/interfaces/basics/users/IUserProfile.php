<?php
namespace tratabor\interfaces\basics\users;

use jeyroik\extas\interfaces\systems\IItem;
use tratabor\interfaces\basics\ICreature;

/**
 * Interface IUserProfile
 *
 * @stage.expand.type IUserProfile
 * @stage.expand.name tratabor\interfaces\basics\users\IUserProfile
 *
 * @stage.name user.profile.init
 * @stage.description User profile initialization finish
 * @stage.input IUserProfile $userProfile
 * @stage.output void
 *
 * @stage.name user.profile.after
 * @stage.description User profile destructing
 * @stage.input IUserProfile $userProfile
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\users
 * @author Funcraft <me@funcraft.ru>
 */
interface IUserProfile extends IItem
{
    const SUBJECT = 'subject';

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $format
     *
     * @return mixed
     */
    public function getCreatedAt($format = '');

    /**
     * @param string $format
     *
     * @return mixed
     */
    public function getUpdatedAt($format = '');

    /**
     * @return int
     */
    public function getUID(): int;

    /**
     * Profile can has not only heroes...may be some pets or anything else
     *
     * @return mixed
     */
    public function getCreatures();

    /**
     * @return int
     */
    public function getCreaturesMax(): int;

    /**
     * @param ICreature $creature
     *
     * @return IUserProfile
     */
    public function addCreature(ICreature $creature);

    /**
     * @return mixed
     */
    public function getHeroes();

    /**
     * @return int
     */
    public function getHeroesMax(): int;

    /**
     * @return int
     */
    public function getCurrentExp(): int;

    /**
     * @return int
     */
    public function getCurrentLevel(): int;

    /**
     * For future needs
     *
     * @return mixed
     */
    public function getDecks();

    /**
     * @return int
     */
    public function getDecksMax(): int;
}
