<?php
namespace tratabor\interfaces\systems;

use tratabor\interfaces\systems\states\IStateDispatcher;

/**
 * Interface IState
 * @package tratabor\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IState
{
    /**
     * IState constructor.
     * @param $id
     * @param $fromState
     * @param $dispatchers
     * @param $onSuccess
     * @param $onFailure
     * @param $onTerminate
     * @param $maxTry
     */
    public function __construct($id, $fromState, $dispatchers, $onSuccess, $onFailure, $onTerminate, $maxTry);

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getFromState(): string;

    /**
     * @param string $format
     * @return mixed
     */
    public function getCreatedAt($format = '');

    /**
     * @return IStateDispatcher[]
     */
    public function getDispatchers();

    /**
     * @return int
     */
    public function getMaxTry(): int;

    /**
     * @return string|array
     */
    public function getOnSuccess();

    /**
     * @return string|array
     */
    public function getOnFailure();

    /**
     * @return string|array
     */
    public function getOnTerminate();
}
