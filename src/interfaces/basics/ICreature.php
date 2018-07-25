<?php
namespace tratabor\interfaces\basics;

use tratabor\interfaces\basics\cells\ICellSnag;
use tratabor\interfaces\basics\creatures\ICreatureCharacteristic;
use tratabor\interfaces\basics\creatures\ICreatureInventory;
use tratabor\interfaces\basics\creatures\ICreatureProperty;
use tratabor\interfaces\basics\creatures\ICreatureRoute;
use tratabor\interfaces\basics\creatures\ICreatureSkill;

/**
 * Interface ICreature
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreature extends ICellSnag
{
    const FIELD__ID = 'id';
    const FIELD__NAME = 'name';
    const FIELD__LEVEL_CURRENT = 'level_current';
    const FIELD__LEVEL_NEXT = 'level_next';
    const FIELD__EXP_CURRENT = 'exp_current';
    const FIELD__EXP_NEXT = 'exp_next';
    const FIELD__SKILLS = 'skills';
    const FIELD__SKILLS_MAX = 'skills_max';
    const FIELD__PROPERTIES = 'properties';
    const FIELD__PROPERTIES_MAX = 'properties_max';
    const FIELD__BOARD_ID = 'board_id';
    const FIELD__INVENTORY = 'inventory';
    const FIELD__CHARACTERISTICS = 'characteristics';
    const FIELD__CHARACTERISTICS_MAX = 'characteristics_max';
    const FIELD__ROUTE = 'route';
    const FIELD__TYPE = 'type';

    const TYPE__HERO = 'hero';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getLevelCurrent(): int;

    /**
     * @return int
     */
    public function getLevelNext(): int;

    /**
     * @return int
     */
    public function getExpCurrent(): int;

    /**
     * @return int
     */
    public function getExpNext(): int;

    /**
     * @return ICreatureSkill[]
     */
    public function getSkills();

    /**
     * @return int
     */
    public function getSkillsMax(): int;

    /**
     * @return ICreatureProperty[]
     */
    public function getProperties();

    /**
     * @return int
     */
    public function getPropertiesMax(): int;

    /**
     * @return string
     */
    public function getBoardId(): string;

    /**
     * @return ICreatureInventory
     */
    public function getInventory();

    /**
     * @return ICreatureCharacteristic[]
     */
    public function getCharacteristics();

    /**
     * @return int
     */
    public function getCharacteristicsMax(): int;

    /**
     * @return ICreatureRoute
     */
    public function getRoute();

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param IBoard $board
     *
     * @return bool
     */
    public function attachToBoard(IBoard $board): bool;
}
