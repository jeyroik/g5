<?php
namespace tratabor\interfaces\basics\creatures;

use tratabor\interfaces\basics\ICreature;

/**
 * Interface IHero
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureHero extends ICreature
{
    /**
     * @return int
     */
    public function getProfileId(): int;
}
