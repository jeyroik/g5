<?php
namespace tratabor\interfaces\basics\users;

/**
 * Interface IUserProfile
 *
 * @package tratabor\interfaces\basics\users
 * @author Funcraft <me@funcraft.ru>
 */
interface IUserProfile
{
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
