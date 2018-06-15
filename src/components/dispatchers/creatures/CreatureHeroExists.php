<?php
namespace tratabor\components\dispatchers\creatures;

use tratabor\components\basics\users\profiles\ProfileRepository;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\basics\users\IUserProfile;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

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
            $context->readItem('profile')->getValue();
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        } catch (\Exception $e) {
            $profiles = ProfileRepository::all();
            if (empty($profiles)) {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);

                return $context;
            } else {
                /**
                 * @var $profile IUserProfile
                 */
                $profile = array_shift($profiles);
                $context->pushItemByName('profile', $profile);
            }

            $heroes = $profile->getHeroes();

            if (empty($heroes)) {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);
            } else {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
                $context->pushItemByName('heroes', $heroes);
            }
        }

        return $context;
    }
}
