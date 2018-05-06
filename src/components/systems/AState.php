<?php
namespace tratabor\components\systems;

use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\dispatchers\IDispatchersFactory;

/**
 * Class AState
 *
 * @package tratabor\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class AState implements IState
{
    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $fromState = '';

    /**
     * @var int
     */
    protected $maxTry = 1;

    /**
     * @var string
     */
    protected $onSuccess = '';

    /**
     * @var string
     */
    protected $onFailure = '';

    /**
     * @var string
     */
    protected $onTerminate = '';

    /**
     * @var array
     */
    protected $dispatchers = [];

    /**
     * @var int
     */
    protected $createdAt = 0;

    /**
     * AState constructor.
     *
     * @param $id
     * @param $fromState
     * @param $dispatchers
     * @param $onSuccess
     * @param $onFailure
     * @param $onTerminate
     * @param $maxTry
     */
    public function __construct($id, $fromState, $dispatchers, $onSuccess, $onFailure, $onTerminate, $maxTry)
    {
        $this->setId($id)
            ->setFromState($fromState)
            ->setDispatchers($dispatchers)
            ->setOnSuccess($onSuccess)
            ->setOnFailure($onFailure)
            ->setOnTerminate($onTerminate)
            ->setMaxTry($maxTry)
            ->setCreatedAt();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFromState(): string
    {
        return $this->fromState;
    }

    /**
     * @return int
     */
    public function getMaxTry(): int
    {
        return $this->maxTry;
    }

    /**
     * @return string
     */
    public function getOnSuccess(): string
    {
        return $this->onSuccess;
    }

    /**
     * @return string
     */
    public function getOnFailure(): string
    {
        return $this->onFailure;
    }

    /**
     * @return string
     */
    public function getOnTerminate(): string
    {
        return $this->onTerminate;
    }

    /**
     * @param string $format
     *
     * @return false|int|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->createdAt) : $this->createdAt;
    }

    /**
     * @return \Generator|\tratabor\interfaces\systems\states\IStateDispatcher[]
     */
    public function getDispatchers()
    {
        $factory = SystemContainer::getItem(IDispatchersFactory::class);

        if (!$factory) {
            return [];
        }

        foreach ($this->dispatchers as $dispatcher) {
            yield $factory::buildDispatcher($dispatcher);
        }
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    protected function setId($id)
    {
        $this->id = (string) $id;

        return $this;
    }

    /**
     * @param string $fromState
     *
     * @return $this
     */
    protected function setFromState($fromState)
    {
        $this->fromState = (string) $fromState;

        return $this;
    }

    /**
     * @param int $maxTry
     *
     * @return $this
     */
    protected function setMaxTry($maxTry)
    {
        $this->maxTry = (int) $maxTry;

        return $this;
    }

    /**
     * @param string $onSuccess
     *
     * @return $this
     */
    protected function setOnSuccess($onSuccess)
    {
        $this->onSuccess = (string) $onSuccess;

        return $this;
    }

    /**
     * @param string $onFailure
     *
     * @return $this
     */
    protected function setOnFailure($onFailure)
    {
        $this->onFailure = (string) $onFailure;

        return $this;
    }

    /**
     * @param string $onTerminate
     *
     * @return $this
     */
    protected function setOnTerminate($onTerminate)
    {
        $this->onTerminate = (string) $onTerminate;

        return $this;
    }

    /**
     * @param mixed[] $dispatchers
     *
     * @return $this
     */
    protected function setDispatchers($dispatchers)
    {
        $this->dispatchers = is_array($dispatchers) ? $dispatchers : [$dispatchers];

        return $this;
    }

    /**
     * @return $this
     */
    protected function setCreatedAt()
    {
        $this->createdAt = time();

        return $this;
    }
}
