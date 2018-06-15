<?php
namespace tratabor\components\dispatchers\users;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class UserAuthorized
 *
 * @package tratabor\components\dispatchers\users
 * @author Funcraft <me@funcraft.ru>
 */
class UserAuthorized implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        return $context;
    }
}
