<?php
namespace tratabor\components\extensions\basics\users;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextProfile;
use tratabor\interfaces\basics\users\IUserProfile;

/**
 * Class UserProfileContextExtension
 *
 * @package tratabor\components\extensions\basics
 * @author Funcraft <me@funcraft.ru>
 */
class UserProfileContextExtension extends Extension implements IContextProfile
{
    public $methods = [
        'getProfile' => UserProfileContextExtension::class,
        'setProfile' => UserProfileContextExtension::class
    ];

    public $subject = IContext::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return IUserProfile|null
     */
    public function getProfile(IContext &$context = null)
    {
        return $context[static::CONTEXT_ITEM__PROFILE] ?? null;
    }

    /**
     * @param IUserProfile $profile
     * @param IContext|null $context
     *
     * @return $this
     */
    public function setProfile(IUserProfile $profile, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__PROFILE] = $profile;

        return $this;
    }
}
