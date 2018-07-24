<?php
namespace tratabor\components\dispatchers\users;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextProfile;

/**
 * Class UserProfileExists
 *
 * @package tratabor\components\dispatchers\users
 * @author Funcraft <me@funcraft.ru>
 */
class UserProfileExists extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextProfile::class,
        IContextOnFailure::class
    ];

    /**
     * @param IContext|IContextProfile|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $profile = $context->getProfile();
        $context->setFailOn(empty($profile));

        return $context;
    }
}
