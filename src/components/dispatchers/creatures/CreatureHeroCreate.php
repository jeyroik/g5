<?php
namespace tratabor\components\dispatchers\creatures;

use tratabor\components\basics\creatures\CreatureRepository;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class CreatureHeroCreate
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroCreate implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        $context->pushItemByName('creature', CreatureRepository::create([
            'name' => 'Hero #' . time(),
            'type' => 'hero',
            'avatar' => 'https://image.freepik.com/free-icon/no-translate-detected_318-9118.jpg',
            'level_current' => 0,
            'exp_current' => 0,
            'level_next' => 1,
            'exp_next' => 1,
            'skills' => [],
            'properties' => [],
            'board_id' => 0,
            'inventory' => [],
            'route' => [],
            'skills_max' => 1,
            'properties_max' => 1,
            'characteristics_max' => 3
        ]));

        $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);

        return $context;
    }
}
