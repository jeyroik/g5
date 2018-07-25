<?php
namespace tratabor\components\dispatchers\users;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextProfile;
use tratabor\interfaces\basics\users\IUserProfile;
use tratabor\interfaces\basics\users\profiles\IProfileRepository;

/**
 * Class UserProfileCreate
 *
 * @package tratabor\components\dispatchers\users
 * @author Funcraft <me@funcraft.ru>
 */
class UserProfileCreate extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextProfile::class
    ];

    /**
     * @param IContext|IContextProfile|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $profile = $context->getProfile();

        if ($profile) {
            $context->setSuccess();
        } else {
            /**
             * @var $repo IProfileRepository
             */
            $repo = SystemContainer::getItem(IProfileRepository::class);
            $profile = $repo->find([IUserProfile::FIELD__UID => 1])->one();// todo

            if (!$profile) {
                $profile = $repo->create([
                    IUserProfile::FIELD__ID => 1,// todo auto gen
                    IUserProfile::FIELD__UID => 1,// todo get current user uid
                    IUserProfile::FIELD__NAME => 'profile.generated.auto',
                    IUserProfile::FIELD__CREATURES_MAX => 1,
                    IUserProfile::FIELD__CREATURES => [],
                    IUserProfile::FIELD__CURRENT_EXP => 0,
                    IUserProfile::FIELD__CURRENT_LEVEL => 0,
                    IUserProfile::FIELD__DECKS => [],
                    IUserProfile::FIELD__DECKS_MAX => 1,
                    IUserProfile::FIELD__HEROES => [],
                    IUserProfile::FILED__HEROES_MAX => 1
                ]);
            }

            if ($profile) {
                $context->setProfile($profile);
                $context->setSuccess();
            } else {
                $context->setFail();
            }
        }

        return $context;
    }
}
