<?php
namespace tratabor\components\plugins\basics\boards;

use tratabor\components\extensions\basics\boards\BoardExtensionContextFreeBoard;
use tratabor\components\systems\Plugin;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginInitContext;

/**
 * Class BoardPluginInitContextFree
 *
 * @package tratabor\components\plugins\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardPluginInitContextFree extends Plugin implements IPluginInitContext
{
    /**
     * @param IStateMachine $machine
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function __invoke(IStateMachine $machine, IContext $context = null)
    {
        $context->registerInterface(
            BoardExtensionContextFreeBoard::class,
            new BoardExtensionContextFreeBoard()
        );

        return $context;
    }
}
