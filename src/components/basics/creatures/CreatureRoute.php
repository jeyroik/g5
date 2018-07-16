<?php
namespace tratabor\components\basics\creatures;

use tratabor\components\basics\Basic;
use tratabor\interfaces\basics\creatures\ICreatureRoute;
use tratabor\interfaces\basics\ICell;

/**
 * Class CreatureRoute
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureRoute extends Basic implements ICreatureRoute
{
    const FIELD__POSITION_CURRENT = 'position_current';
    const FIELD__POSITION_PREVIOUS = 'position_previous';
    const FIELD__ROUTE = 'route';
    const FIELD__ID = 'id';
    const FIELD__CREATED_AT = 'created_at';
    const FIELD__UPDATED_AT = 'updated_at';

    /**
     * @param ICell $cell
     *
     * @return bool
     */
    public function addStep(ICell $cell)
    {
        $current = $this->getCurrentPosition();

        if (!$current || ($current->getId() != $cell->getId())) {
            $this->config[static::FIELD__ROUTE][] = $cell;
            $this->config[static::FIELD__POSITION_PREVIOUS] = $current;
            $this->config[static::FIELD__POSITION_CURRENT] = $cell;

            return true;
        }

        return false;
    }

    /**
     * @return null|ICell
     */
    public function getCurrentPosition()
    {
        return $this->config[static::FIELD__POSITION_CURRENT] ?? null;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return ICreatureRoute::SUBJECT;
    }
}
