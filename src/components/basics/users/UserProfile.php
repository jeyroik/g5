<?php
namespace tratabor\components\basics\users;

use tratabor\components\basics\BasicObject;
use tratabor\interfaces\basics\ICreature;
use tratabor\interfaces\basics\users\IUserProfile;

/**
 * Class UserProfile
 *
 * @package tratabor\components\basics\users
 * @author Funcraft <me@funcraft.ru>
 */
class UserProfile extends BasicObject implements IUserProfile
{
    /**
     * @return int
     */
    public function getUID(): int
    {
        return $this->data['uid'] ?? 0;
    }

    /**
     * @return ICreature[]
     */
    public function getHeroes()
    {
        return $this->data['heroes'] ?? [];
    }

    /**
     * @return int
     */
    public function getHeroesMax(): int
    {
        return $this->data['heroes_max'] = 1;
    }

    /**
     * @return ICreature[]
     */
    public function getCreatures()
    {
        return $this->data['creatures'] ?? [];
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->data['creatures_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getDecks()
    {
        return $this->data['decks'] ?? [];
    }

    /**
     * @return int
     */
    public function getDecksMax(): int
    {
        return $this->data['decks_max'] ?? 1;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->data['id'] ?? '';
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getUpdatedAt($format = '')
    {
        return $format ? date($format, $this->data['updated_at']) : $this->data['updated_at'];
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->data['created_at']) : $this->data['created_at'];
    }

    /**
     * @return int
     */
    public function getCurrentLevel(): int
    {
        return $this->data['level_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getCurrentExp(): int
    {
        return $this->data['exp_current'] ?? 0;
    }
}
