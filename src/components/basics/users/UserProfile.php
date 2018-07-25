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
        return $this->config[static::FIELD__UID] ?? 0;
    }

    /**
     * @return ICreature[]
     */
    public function getHeroes()
    {
        return $this->config[static::FIELD__HEROES] ?? [];
    }

    /**
     * @return int
     */
    public function getHeroesMax(): int
    {
        return $this->config[static::FILED__HEROES_MAX] = 1;
    }

    /**
     * @return ICreature[]
     */
    public function getCreatures()
    {
        return $this->config[static::FIELD__CREATURES] ?? [];
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->config[static::FIELD__CREATURES_MAX] ?? 1;
    }

    /**
     * @param ICreature $creature
     *
     * @return $this
     */
    public function addCreature(ICreature $creature)
    {
        $this->config[static::FIELD__CREATURES][] = $creature;

        if ($creature->getType() == ICreature::TYPE__HERO) {
            $this->config[static::FIELD__HEROES][] = $creature;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDecks()
    {
        return $this->config[static::FIELD__DECKS] ?? [];
    }

    /**
     * @return int
     */
    public function getDecksMax(): int
    {
        return $this->config[static::FIELD__DECKS_MAX] ?? 1;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config[static::FIELD__NAME] ?? '';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->config[static::FIELD__ID] ?? '';
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
        return $this->config[static::FIELD__CURRENT_LEVEL] ?? 0;
    }

    /**
     * @return int
     */
    public function getCurrentExp(): int
    {
        return $this->config[static::FIELD__CURRENT_EXP] ?? 0;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return IUserProfile::SUBJECT;
    }
}
