<?php
namespace tratabor\components\basics\users;

use tratabor\components\basics\Basic;
use tratabor\interfaces\basics\ICreature;
use tratabor\interfaces\basics\users\IUserProfile;

/**
 * Class UserProfile
 *
 * @package tratabor\components\basics\users
 * @author Funcraft <me@funcraft.ru>
 */
class UserProfile extends Basic implements IUserProfile
{
    /**
     * @return int
     */
    public function getUID(): int
    {
        return $this->config['uid'] ?? 0;
    }

    /**
     * @return ICreature[]
     */
    public function getHeroes()
    {
        return $this->config['heroes'] ?? [];
    }

    /**
     * @return int
     */
    public function getHeroesMax(): int
    {
        return $this->config['heroes_max'] = 1;
    }

    /**
     * @return ICreature[]
     */
    public function getCreatures()
    {
        return $this->config['creatures'] ?? [];
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->config['creatures_max'] ?? 1;
    }

    /**
     * @param ICreature $creature
     *
     * @return $this
     */
    public function addCreature(ICreature $creature)
    {
        $this->config['creatures'][] = $creature;

        return $this;
    }

    /**
     * @return array
     */
    public function getDecks()
    {
        return $this->config['decks'] ?? [];
    }

    /**
     * @return int
     */
    public function getDecksMax(): int
    {
        return $this->config['decks_max'] ?? 1;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config['name'] ?? '';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->config['id'] ?? '';
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getUpdatedAt($format = '')
    {
        return $format ? date($format, $this->config['updated_at']) : $this->config['updated_at'];
    }

    /**
     * @param string $format
     *
     * @return false|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->config['created_at']) : $this->config['created_at'];
    }

    /**
     * @return int
     */
    public function getCurrentLevel(): int
    {
        return $this->config['level_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getCurrentExp(): int
    {
        return $this->config['exp_current'] ?? 0;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return IUserProfile::SUBJECT;
    }
}
