<?php
namespace tratabor\components\basics\boards;

use tratabor\components\basics\BasicBoard;

/**
 * Class BoardGenerator
 *
 * @package tratabor\components\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardGenerator
{
    /**
     * @var BoardGenerator
     */
    protected static $instance = null;

    /**
     * @param $x
     * @param $y
     * @param $z
     *
     * @return BasicBoard
     */
    public static function generate($x, $y, $z)
    {
        return static::getInstance()->generateBoard($x, $y, $z);
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return static::$instance ?: static::$instance = new static();
    }

    /**
     * @param $x
     * @param $y
     * @param $z
     *
     * @return BasicBoard
     */
    public function generateBoard($x, $y, $z)
    {
        $boardId = 'board_' . time();
        $cells = [];

        for ($i = 0; $i < $y; $i++) {
            for ($j = 0; $j < $x; $j++) {
                for ($k = 0; $k < $z; $k++) {
                    $cells[] = new BoardCell([
                        'id' => $boardId . '_' . $j . $i . $k,
                        'state' => 'created',
                        'x' => $j,
                        'y' => $i,
                        'z' => $k,
                        'contain' => null
                    ]);
                }
            }
        }

        return new BasicBoard([
            'id' => $boardId,
            'cells' => $cells,
            'size' => count($cells),
            'creatures_max' => 1,
            'creatures_count' => 0,
            'creatures' => []
        ]);
    }
}
