<?php
namespace tratabor\components\dispatchers\users;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class UserAuthorized
 *
 * @package tratabor\components\dispatchers\users
 * @author Funcraft <me@funcraft.ru>
 */
class UserAuthorized extends DispatcherAbstract
{
    protected $requireInterfaces = [];

    /**
     * @param IContext|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        return $context;
    }
}
