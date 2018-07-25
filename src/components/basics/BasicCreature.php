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
        return $this->config['name'] ?? '';
    }

    /**
     * @return int
     */
    public function getLevelCurrent(): int
    {
        return $this->config['level_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getLevelNext(): int
    {
        return $this->config['level_next'] ?? 1;
    }

    /**
     * @return int
     */
    public function getExpCurrent(): int
    {
        return $this->config['exp_current'] ?? 0;
    }

    /**
     * @return int
     */
    public function getExpNext(): int
    {
        return $this->config['exp_next'] ?? 1;
    }

    /**
     * @return int
     */
    public function getSkillsMax(): int
    {
        return $this->config['skills_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getSkills()
    {
        return $this->config['skills'] ?? [];
    }

    /**
     * @return int
     */
    public function getPropertiesMax(): int
    {
        return $this->config['properties_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->config['properties'] ?? [];
    }

    /**
     * @return string
     */
    public function getBoardId(): string
    {
        return $this->config['board_id'] ?? 0;
    }

    /**
     * @return ICreatureInventory|null
     */
    public function getInventory()
    {
        return $this->config['inventory'] ?? null;
    }

    /**
     * @return int
     */
    public function getCharacteristicsMax(): int
    {
        return $this->config['characteristics_max'] ?? 1;
    }

    /**
     * @return array
     */
    public function getCharacteristics()
    {
        return $this->config['characteristics'] ?? [];
    }

    /**
     * @return ICreatureRoute|null
     */
    public function getRoute()
    {
        return $this->config['route'] ?? null;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->config['type'] ?? 'creature';
    }

    /**
     * @param IBoard $board
     *
     * @return bool
     */
    public function attachToBoard(IBoard $board): bool
    {
        $this->config['board_id'] = $board->getId();

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
            'updated_at' => $this->getUpdatedAt(),
            'class' => static::class
        ];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'creature';
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
        $this->config['route'] = new CreatureRoute($this->config['route']);

        return $this;
    }

    /**
     * @return $this
     */
    protected function initSkills()
    {
        if (isset($this->config['skills'])) {
            foreach ($this->config['skills'] as $index => $item) {
                $this->config['skills'][$index] = new CreatureSkill($item);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initProperties()
    {
        if (isset($this->config['properties'])) {
            foreach ($this->config['properties'] as $index => $property) {
                $this->config['properties'][$index] = new CreatureProperty($property);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initCharacteristics()
    {
        if (isset($this->config['characteristics'])) {
            $charsInitialized = [];

            foreach ($this->config['characteristics'] as $char) {
                $charsInitialized[] = new CreatureCharacteristic($char);
            }
            $this->config['characteristics'] = $charsInitialized;
        } else {
            $this->config['characteristics'] = $this->initDefaultCharacteristics();
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
        $this->config['inventory'] = new CreatureInventory($this->config['inventory'] ?? []);

        return $this;
    }
}
