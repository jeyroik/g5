<?php
namespace tratabor\components\basics;

use tratabor\components\basics\creatures\CreatureCharacteristic;
use tratabor\components\basics\creatures\CreatureInventory;
use tratabor\components\basics\creatures\CreatureProperty;
use tratabor\components\basics\creatures\CreatureRepository;
use tratabor\components\basics\creatures\CreatureRoute;
use tratabor\components\basics\creatures\CreatureSkill;
use tratabor\interfaces\basics\creatures\ICreatureInventory;
use tratabor\interfaces\basics\creatures\ICreatureRoute;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\basics\ICreature;

/**
 * Class BasicCreature
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicCreature extends BasicSnag implements ICreature
{
    const FIELD__ID = 'id';
    const FIELD__NAME = 'name';
    const FIELD__AVATAR = 'avatar';
    const FIELD__SKILLS = 'skills';
    const FIELD__SKILLS_MAX = 'skills_max';
    const FIELD__PROPERTIES = 'properties';
    const FIELD__PROPERTIES_MAX = 'properties_max';
    const FIELD__CHARACTERISTICS = 'characteristics';
    const FIELD__CHARACTERISTICS_MAX = 'characteristics_max';
    const FIELD__ROUTE = 'route';
    const FIELD__INVENTORY = 'inventory';
    const FIELD__LEVEL_CURRENT = 'level_current';
    const FIELD__LEVEL_NEXT = 'level_next';
    const FIELD__EXP_CURRENT = 'exp_current';
    const FIELD__EXP_NEXT = 'exp_next';
    const FIELD__BOARD_ID = 'board_id';
    const FIELD__TYPE = 'type';

    /**
     * BasicCreature constructor.
     *
     * @param $creatureConfig
     */
    public function __construct($creatureConfig)
    {
        parent::__construct($creatureConfig);
        $this->initCreature();
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
    public function getLevelCurrent(): int
    {
        return $this->data['level_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getLevelNext(): int
    {
        return $this->data['level_next'] ?? 1;
    }

    /**
     * @return int
     */
    public function getExpCurrent(): int
    {
        return $this->data['exp_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getExpNext(): int
    {
        return $this->data['exp_next'] ?? 1;
    }

    /**
     * @return int
     */
    public function getSkillsMax(): int
    {
        return $this->data['skills_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getSkills()
    {
        return $this->data['skills'] ?? [];
    }

    /**
     * @return int
     */
    public function getPropertiesMax(): int
    {
        return $this->data['properties_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->data['properties'] ?? [];
    }

    /**
     * @return string
     */
    public function getBoardId(): string
    {
        return $this->data['board_id'] ?? 0;
    }

    /**
     * @return ICreatureInventory|null
     */
    public function getInventory()
    {
        return $this->data['inventory'] ?? null;
    }

    /**
     * @return int
     */
    public function getCharacteristicsMax(): int
    {
        return $this->data['characteristics_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getCharacteristics()
    {
        return $this->data['characteristics'] ?? [];
    }

    /**
     * @return ICreatureRoute|null
     */
    public function getRoute()
    {
        return $this->data['route'] ?? null;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->data['type'] ?? 'creature';
    }

    /**
     * @param IBoard $board
     *
     * @return bool
     */
    public function attachToBoard(IBoard $board): bool
    {
        $this->data['board_id'] = $board->getId();

        $cell = $board->attachCreature($this);
        $this->getRoute()->addStep($cell);
        $this->commit();

        return true;
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            static::FIELD__ID => $this->getId(),
            static::FIELD__AVATAR => $this->getAvatar(),
            static::FIELD__ROUTE => $this->getRoute()->__toArray(),
            static::FIELD__NAME => $this->getName(),
            static::FIELD__BOARD_ID => $this->getBoardId(),
            static::FIELD__TYPE => $this->getType(),
            static::FIELD__CHARACTERISTICS => $this->getCharacteristics(),
            static::FIELD__CHARACTERISTICS_MAX => $this->getCharacteristicsMax(),
            static::FIELD__EXP_CURRENT => $this->getExpCurrent(),
            static::FIELD__EXP_NEXT => $this->getExpNext(),
            static::FIELD__LEVEL_CURRENT => $this->getLevelCurrent(),
            static::FIELD__LEVEL_NEXT => $this->getLevelNext(),
            static::FIELD__SKILLS => $this->getSkills(),
            static::FIELD__SKILLS_MAX => $this->getSkillsMax(),
            static::FIELD__PROPERTIES => $this->getProperties(),
            static::FIELD__PROPERTIES_MAX => $this->getPropertiesMax(),
            static::FIELD__INVENTORY => $this->getInventory(),

            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }

    /**
     * @return $this
     */
    protected function commit()
    {
        $repo = new CreatureRepository();
        $repo->update($this);
        $repo->commit();

        return $this;
    }

    /**
     * @return $this
     */
    protected function initCreature()
    {
        $this->initRoute()->initSkills()->initProperties()->initCharacteristics()->initInventory();

        return $this;
    }

    /**
     * @return $this
     */
    protected function initRoute()
    {
        $this->data['route'] = new CreatureRoute($this->data['route']);

        return $this;
    }

    /**
     * @return $this
     */
    protected function initSkills()
    {
        if (isset($this->data['skills'])) {
            foreach ($this->data['skills'] as $index => $item) {
                $this->data['skills'][$index] = new CreatureSkill($item);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initProperties()
    {
        if (isset($this->data['properties'])) {
            foreach ($this->data['properties'] as $index => $property) {
                $this->data['properties'][$index] = new CreatureProperty($property);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initCharacteristics()
    {
        if (isset($this->data['characteristics'])) {
            $charsInitialized = [];

            foreach ($this->data['characteristics'] as $char) {
                $charsInitialized[] = new CreatureCharacteristic($char);
            }
            $this->data['characteristics'] = $charsInitialized;
        } else {
            $this->data['characteristics'] = $this->initDefaultCharacteristics();
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function initDefaultCharacteristics()
    {
        return [new CreatureCharacteristic(['name' => 'Health', 'description' => 'Health', 'value' => 5])];
    }

    /**
     * @return $this
     */
    protected function initInventory()
    {
        $this->data['inventory'] = new CreatureInventory($this->data['inventory'] ?? []);

        return $this;
    }
}
