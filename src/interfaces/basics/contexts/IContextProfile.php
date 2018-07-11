<?php
namespace tratabor\interfaces\basics\contexts;

use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\users\IUserProfile;

interface IContextProfile
{
    const CONTEXT_ITEM__PROFILE = 'profile';

    /**
     * @param IContext|null $context
     *
     * @return IUserProfile
     */
    public function getProfile(IContext &$context = null);

    /**
     * @param IUserProfile|array $profile
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setProfile(IUserProfile $profile, IContext &$context = null);
}
