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
        $profiles = ProfileRepository::all();

        if (empty($profiles)) {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);
        } else {
            /**
             * @var $profile IUserProfile
             */
            $profile = array_shift($profiles);
            $context->pushItemByName('profile', $profile);
            $heroes = $profile->getHeroes();

            if (empty($heroes)) {
                $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);
            } else {
                $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
                $context->pushItemByName('heroes', $heroes);
            }
        }

        echo '(after) Current state: <pre>';
        print_r($currentState);
        echo '</pre>';

        echo '(after) Current context: <pre>';
        print_r($context);
        echo '</pre>';

        return $context;
    }
}
