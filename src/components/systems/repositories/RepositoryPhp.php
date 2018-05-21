<?php
namespace tratabor\components\systems\repositories;

use tratabor\interfaces\systems\IRepository;

/**
 * Class RepositoryPhp
 *
 * Read-only file based storage.
 *
 * @package tratabor\components\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
class RepositoryPhp extends RepositoryAbstract implements IRepository
{
    /**
     * @var string
     */
    protected $dsn = '';

    /**
     * @var string
     */
    protected $itemClass = '';

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $where = [];

    /**
     * RepositoryPhp constructor.
     * @param $dsn
     */
    public function __construct($dsn = '')
    {
        $dsn && $this->setDsn($dsn);
    }

    /**
     * @return null|mixed
     */
    public function one()
    {
        $itemClass = $this->getItemClass();

        if (empty($this->where)) {
            $items = $this->items;

            $item = array_shift($items);


            return new $itemClass($item);
        }

        foreach ($this->items as $item) {
            $skip = false;
            foreach ($this->where as $field => $value) {
                if (!isset($item[$field]) || ($item[$field] != $value)) {
                    $skip = true;
                    break;
                }
            }

            if ($skip) {
                continue;
            }

            return new $itemClass($item);
        }

        return null;
    }

    /**
     * @return array
     */
    public function all()
    {
        $itemClass = $this->getItemClass();
        $items = [];

        foreach ($this->items as $item) {

            if (!empty($this->where)) {
                $skip = false;
                foreach ($this->where as $field => $value) {
                    if (!isset($item[$field]) || ($item[$field] != $value)) {
                        $skip = true;
                        break;
                    }
                }

                if ($skip) {
                    continue;
                }
            }
            $items[] = new $itemClass($item);
        }

        return $items;
    }

    /**
     * @throws \Exception
     */
    public function connect(): IRepository
    {
        parent::connect();

        if (is_file($this->dsn)) {
            $this->items = include $this->dsn;
        }

        return $this;
    }

    /**
     * @param $item
     *
     * @return bool
     */
    public function create($item): bool
    {
        return true;
    }

    /**
     * @param $item
     *
     * @return int
     */
    public function update($item): int
    {
        return 0;
    }

    /**
     * @param $item
     *
     * @return int
     */
    public function delete($item): int
    {
        return 0;
    }
}
