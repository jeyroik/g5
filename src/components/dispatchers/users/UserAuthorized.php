<?php
namespace tratabor\components\dispatchers\users;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;

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
