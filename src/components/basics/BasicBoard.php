<?php
namespace tratabor\components\basics;

use tratabor\components\basics\boards\BoardCell;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;

/**
 * Class BasicBoard
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicBoard extends Basic implements IBoard
{
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
        return $this->data['id'] ?? '';
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->data['size'] ?? 0;
    }

    /**
     * @return ICell[]
     */
    public function getCells()
    {
        return $this->data['cells'] ?? [];
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->data['creatures_max'] ?? 1;
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
    public function getCreaturesCount(): int
    {
        return $this->data['creatures_count'] ?? 0;
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'id' => $this->getId(),
            'size' => $this->getSize(),
            'cells' => $this->__toArrayCells(),
            'creatures_max' => $this->getCreaturesMax(),
            'creatures' => $this->getCreatures(),
            'creatures_count' => $this->getCreaturesCount(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
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
        if (isset($this->data['cells']) && !empty($this->data['cells'])) {
            foreach ($this->data['cells'] as $index => $cell) {
                if (is_array($cell)) {
                    $this->data['cells'][$index] = new BoardCell($cell);
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function __toArrayCells(): array
    {
        $cells = [];

        foreach ($this->data['cells'] as $cell) {
            /**
             * @var $cell ICell
             */
            $cells[] = $cell->__toArray();
        }

        return $cells;
    }
}
