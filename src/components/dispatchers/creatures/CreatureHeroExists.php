<?php
namespace tratabor\components\dispatchers\creatures;

use tratabor\components\basics\users\profiles\ProfileRepository;
use tratabor\interfaces\basics\users\IUserProfile;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class CreatureHeroExists
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroExists implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        try {
            $profile = $context->readItem('profile');
        } catch (\Exception $e) {
            $profiles = ProfileRepository::all();
            if (empty($profiles)) {
                $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);

                return $context;
            } else {
                /**
                 * @var $profile IUserProfile
                 */
                $profile = array_shift($profiles);
                $context->pushItemByName('profile', $profile);
            }
        }

        $heroes = $profile->getHeroes();

        if (empty($heroes)) {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);
        } else {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
            $context->pushItemByName('heroes', $heroes);
        }

        return $context;
    }
}
