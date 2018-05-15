<?php
namespace tratabor\components\basics;

use tratabor\components\basics\creatures\CreatureCharacteristic;
use tratabor\components\basics\creatures\CreatureInventory;
use tratabor\components\basics\creatures\CreatureProperty;
use tratabor\components\basics\creatures\CreatureRoute;
use tratabor\components\basics\creatures\CreatureSkill;
use tratabor\interfaces\basics\creatures\ICreatureInventory;
use tratabor\interfaces\basics\creatures\ICreatureRoute;
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
        $this->initCreature($creatureConfig);

        parent::__construct('cid', 'creature_' . time());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->data['avatar'] ?? '';
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
     * @return int
     */
    public function getBoardId(): int
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
     * @param $creatureConfig
     *
     * @return $this
     */
    protected function initCreature($creatureConfig)
    {
        $this->data = $creatureConfig;

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
