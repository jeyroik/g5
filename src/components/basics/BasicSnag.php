<?php
namespace tratabor\components\basics;

use tratabor\components\systems\Item;
use tratabor\interfaces\basics\cells\ICellSnag;

/**
 * Class BasicSnag
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicSnag extends Basic implements ICellSnag
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param $creature
     *
     * @return mixed
     */
    public function applyTo($creature)
    {
        return $creature;
    }

    /**
     * @return bool
     */
    public function isCanBePassed(): bool
    {
        return $this->data['is_can_be_passed'] ?? true;
    }
}
