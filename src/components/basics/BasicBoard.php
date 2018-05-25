<?php
namespace tratabor\components\basics;

use tratabor\components\basics\boards\BoardRepository;
use tratabor\components\basics\boards\cells\CellRepository;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;
use tratabor\interfaces\systems\IRepository;

/**
 * Class BasicBoard
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicBoard extends Basic implements IBoard
{
    const FIELD__ID = 'id';
    const FIELD__CELLS = 'cells';
    const FIELD__CELLS_SPAWN = 'cells_spawn';
    const FIELD__SIZE = 'size';
    const FIELD__CREATURES = 'creatures';
    const FIELD__CREATURES_MAX = 'creatures_max';
    const FIELD__CREATURES_COUNT = 'creatures_count';
    const FIELD__CREATED_AT = 'created_at';
    const FIELD__UPDATED_AT = 'updated_at';

    /**
     * BasicBoard constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->initBoard();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->data[static::FIELD__ID] ?? '';
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->data[static::FIELD__SIZE] ?? 0;
    }

    /**
     * @param ICreature $creature
     *
     * @return ICell
     * @throws \Exception
     */
    public function attachCreature(ICreature $creature): ICell
    {
        $spawnCells = $this->getSpawnCells();

        if (empty($spawnCells)) {
            throw new \Exception('There is no spawn cells.');
        }

        if ($this->getCreaturesMax() == $this->getCreaturesCount()) {
            throw new \Exception('Board max creatures count is reached.');
        }

        /**
         * @var $spawnCell ICell
         */
        $spawnCell = array_shift($spawnCells);
        $attached = $spawnCell->attachCreature($creature);

        if ($attached) {
            $this->data[static::FIELD__CREATURES][] = $creature->getId();
            $this->data[static::FIELD__CREATURES_COUNT] += 1;

            $this->cellsUpdate($spawnCell)->removeSpawnCell($spawnCell)->commit();

            return $spawnCell;
        }

        throw new \Exception('Can not attached creature to a cell');
    }

    /**
     * @return ICell[]
     */
    public function getCells()
    {
        /**
         * @var $repo IRepository
         */
        $repo = $this->data[static::FIELD__CELLS];
        return $repo->find()->all();
    }

    /**
     * @return array
     */
    public function getSpawnCells()
    {
        $cellsIds = $this->data[static::FIELD__CELLS_SPAWN] ?? [];
        $spawnCells = [];

        /**
         * @var $repo IRepository
         */
        $repo = $this->data[static::FIELD__CELLS];

        foreach ($cellsIds as $id) {
            $cell = $repo->find([static::FIELD__ID => $id])->one();
            $cell && ($spawnCells[] = $cell);
        }

        return $spawnCells;
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->data[static::FIELD__CREATURES_MAX] ?? 1;
    }

    /**
     * @return ICreature[]
     */
    public function getCreatures()
    {
        return $this->data[static::FIELD__CREATURES] ?? [];
    }

    /**
     * @return int
     */
    public function getCreaturesCount(): int
    {
        return $this->data[static::FIELD__CREATURES_COUNT] ?? 0;
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            static::FIELD__ID => $this->getId(),
            static::FIELD__SIZE => $this->getSize(),
            static::FIELD__CELLS => $this->__toArrayCells(),
            static::FIELD__CELLS_SPAWN => $this->__toArrayCellsSpawn(),
            static::FIELD__CREATURES_MAX => $this->getCreaturesMax(),
            static::FIELD__CREATURES => $this->getCreatures(),
            static::FIELD__CREATURES_COUNT => $this->getCreaturesCount(),
            static::FIELD__CREATED_AT => $this->getCreatedAt(),
            static::FIELD__UPDATED_AT => $this->getUpdatedAt()
        ];
    }

    /**
     * @return $this
     */
    protected function commit()
    {
        $repo = new BoardRepository();
        $updated = $repo->update($this);
        if ($updated) {
            $repo->commit();
        }

        return $this;
    }

    /**
     * @param ICell $spawnCell
     *
     * @return $this
     */
    protected function removeSpawnCell(ICell $spawnCell)
    {
        $spawnCells = $this->getSpawnCells();

        foreach ($spawnCells as $index => $cell) {
            if ($cell->getId() == $spawnCell->getId()) {
                unset($this->data[static::FIELD__CELLS_SPAWN][$index]);
            }
        }

        return $this;
    }

    /**
     * @param ICell $cell
     *
     * @return $this
     */
    protected function cellsUpdate($cell)
    {
        /**
         * @var $repo CellRepository
         */
        $repo = $this->data[static::FIELD__CELLS];
        $repo->update($cell);
        $repo->commit();
        $this->data[static::FIELD__CELLS] = $repo;

        return $this;
    }

    /**
     * @return $this
     */
    protected function initBoard()
    {
        $this->initCells()->initCreatures();

        return $this;
    }

    /**
     * @return $this
     */
    protected function initCreatures()
    {
        return $this;
    }

    /**
     * @return $this
     */
    protected function initCells()
    {
        $this->data[static::FIELD__CELLS] = new CellRepository($this->data['cells']);
        $this->data[static::FIELD__CELLS]->connect();

        return $this;
    }

    /**
     * @return array
     */
    protected function __toArrayCreatures(): array
    {
        return $this->data[static::FIELD__CREATURES];
    }

    /**
     * @return array
     */
    protected function __toArrayCells(): array
    {
        /**
         * @var $repo IRepository
         */
        $repo = $this->data[static::FIELD__CELLS];
        $cells = $repo->find([])->all();
        $cellsAsArray = [];

        foreach ($cells as $cell) {
            /**
             * @var $cell ICell
             */
            $cellsAsArray[] = $cell->__toArray();
        }

        return $cellsAsArray;
    }

    /**
     * @return array
     */
    protected function __toArrayCellsSpawn(): array
    {
        return $this->data[static::FIELD__CELLS_SPAWN];
    }
}
