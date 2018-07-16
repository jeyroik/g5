<?php
namespace tratabor\components\basics\creatures;

use tratabor\components\basics\Basic;
use tratabor\interfaces\basics\creatures\ICreatureSkill;

/**
 * Class CreatureSkill
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureSkill extends Basic implements ICreatureSkill
{
    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return ICreatureSkill::SUBJECT;
    }
}
