<?php
namespace tratabor\components\basics\creatures;

use jeyroik\extas\components\systems\Item;
use tratabor\interfaces\basics\creatures\ICreatureProperty;

/**
 * Class CreatureProperty
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureProperty extends Item implements ICreatureProperty
{
    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return ICreatureProperty::SUBJECT;
    }
}
