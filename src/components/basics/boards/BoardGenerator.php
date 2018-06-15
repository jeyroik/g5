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
        $spawnRate = 5;

        for ($i = 0; $i < $y; $i++) {
            for ($j = 0; $j < $x; $j++) {
                for ($k = 0; $k < $z; $k++) {
                    $isSpawn = (mt_rand(0, $spawnRate) == 1);
                    $cells[] = [
                        'id' => $boardId . '_' . $j . $i . $k,
                        'state' => 'created',
                        'x' => $j,
                        'y' => $i,
                        'z' => $k,
                        'contain' => null,
                        'board_id' => $boardId,
                        'is_spawn' => $isSpawn
                    ];
                }
            }
        }

        return new BasicBoard([
            BasicBoard::FIELD__ID => $boardId,
            BasicBoard::FIELD__CELLS => $cells,
            BasicBoard::FIELD__SIZE => count($cells),
            BasicBoard::FIELD__CREATURES_MAX => 1,
            BasicBoard::FIELD__CREATURES_COUNT => 0,
            BasicBoard::FIELD__CREATURES => []
        ]);
    }
}
