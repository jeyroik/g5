<?php
namespace tratabor\components\dispatchers\creatures;

use tratabor\components\basics\creatures\CreatureRepository;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\basics\users\IUserProfile;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class CreatureHeroCreate
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroCreate extends DispatcherAbstract implements IStateDispatcher
{
    protected function dispatch(IContext $context): IContext
    {
        $repo = new CreatureRepository();
        $hero = $repo->create([
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
        ]);

        if ($hero) {
            $context->pushItemByName('hero', $hero);
        } else {
            throw new \Exception('Can not create hero.');
        }

        /**
         * @var $profile IUserProfile
         */
        $profile = $context->readItem('profile')->getValue();
        $profile->addCreature($hero);
        $context->updateItem('profile', $profile);
        $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);

        return $context;
    }
}
