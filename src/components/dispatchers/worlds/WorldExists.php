<?php
namespace tratabor\components\dispatchers\worlds;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\components\systems\states\extensions\ExtensionContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use tratabor\components\extensions\basics\worlds\WorldContextExtension;

/**
 * Class WorldExists
 *
 * @require_interface tratabor\components\extensions\basics\worlds\WorldContext
 * @require_interface jeyroik\extas\components\systems\states\extensions\ExtensionContextOnFailure
 *
 * @package tratabor\components\dispatchers\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldExists extends DispatcherAbstract implements IStateDispatcher
{
    protected $requireInterfaces = [
        WorldContextExtension::class,
        ExtensionContextOnFailure::class
    ];

    /**
     * @param IContext $context
     *
     * @return IContext
     * @throws \Exception
     */
    public function dispatch(IContext $context): IContext
    {
        /**
         * @var $context WorldContextExtension|ExtensionContextOnFailure
         */
        if ($context->isWorldExist()) {
            $context->setSuccess();
        } else {
            $world = $context->findWorld();
            $context->pushItemByName('world', $world);
            $context->setSuccess();
        }

        return $context;
    }
}
