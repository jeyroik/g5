<?php
namespace tratabor\components\basics;

use tratabor\components\basics\boards\BoardRepository;
use tratabor\components\basics\boards\cells\CellRepository;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;
use jeyroik\extas\interfaces\systems\IRepository;

/**
 * Class BasicBoard
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicBoard extends Basic implements IBoard
{
    const FIELD__CELLS_SPAWN = 'cells_spawn';
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
        return $this->config[static::FIELD__ID] ?? '';
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->config[static::FIELD__SIZE] ?? 0;
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

        $spawnCell = $this->getFreeSpawnCell($spawnCells);

        if (!$spawnCell) {
            throw new \Exception('There is no free spawn cells on the current board');
        }

        $attached = $spawnCell->attachCreature($creature);

        if ($attached) {
            $this->config[static::FIELD__CREATURES][] = $creature->getId();
            $this->config[static::FIELD__CREATURES_COUNT] += 1;

            $this->cellsUpdate($spawnCell)->commit();

            return $spawnCell;
        }

        throw new \Exception(
            'Can not attached creature to a cell: ' . implode(', ', $spawnCell->getCrashes())
        );
    }

    /**
     * @return ICell[]
     */
    public function getCells()
    {
        /**
         * @var $repo IRepository
         */
        $repo = $this->config[static::FIELD__CELLS];
        return $repo->find(['board_id' => $this->getId()])->all();
    }

    /**
     * @return array
     */
    public function getSpawnCells()
    {
        /**
         * @var $repo IRepository
         */
        $repo = $this->config[static::FIELD__CELLS];
        $spawnCells = $repo->find(['board_id' => $this->getId(), 'is_spawn' => true])->all();

        return $spawnCells;
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->config[static::FIELD__CREATURES_MAX] ?? 1;
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
    public function getCreaturesCount(): int
    {
        return $this->config[static::FIELD__CREATURES_COUNT] ?? 0;
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
            static::FIELD__CREATURES_MAX => $this->getCreaturesMax(),
            static::FIELD__CREATURES => $this->getCreatures(),
            static::FIELD__CREATURES_COUNT => $this->getCreaturesCount(),
            static::FIELD__CREATED_AT => $this->getCreatedAt(),
            static::FIELD__UPDATED_AT => $this->getUpdatedAt()
        ];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return IBoard::SUBJECT;
    }

    /**
     * @param $spawnCells ICell[]
     *
     * @return bool|ICell
     */
    protected function getFreeSpawnCell($spawnCells)
    {
        foreach ($spawnCells as $spawnCell) {
            if ($spawnCell->isEmpty()) {
                return $spawnCell;
            }
        }

        return false;
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
     * @param ICell $cell
     *
     * @return $this
     */
    protected function cellsUpdate($cell)
    {
        /**
         * @var $repo CellRepository
         */
        $repo = $this->config[static::FIELD__CELLS];
        $repo->find(['id' => $cell->getId()])->update($cell);
        $repo->commit();
        $this->config[static::FIELD__CELLS] = $repo;

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
        $repo = new CellRepository();
        $cells = $repo->find(['board_id' => $this->getId()])->all();
        if (empty($cells) && isset($this->config[static::FIELD__CELLS])) {
            foreach ($this->config[static::FIELD__CELLS] as $cell) {
                $repo->create($cell);
            }
        }
        $this->config[static::FIELD__CELLS] = $repo;

        return $this;
    }

    /**
     * @return array
     */
    protected function __toArrayCreatures(): array
    {
        return $this->config[static::FIELD__CREATURES];
    }

    /**
     * @return int
     */
    protected function __toArrayCells(): int
    {
        $repo = new CellRepository();
        $cells = $repo->find(['board_id' => $this->getId()])->all();

        return count($cells);
    }
}
