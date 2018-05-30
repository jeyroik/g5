<?php
namespace tratabor\components\systems\repositories;

use tratabor\interfaces\systems\IItem;
use tratabor\interfaces\systems\IRepository;

/**
 * Class RepositoryMongo
 *
 * @package tratabor\components\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
class RepositoryMongo extends RepositoryAbstract implements IRepository
{
    protected $collectionName = 'system';

    /**
     * @var \MongoClient
     */
    protected $driver = null;

    /**
     * @var \MongoCursor
     */
    protected $where = null;

    /**
     * @var \MongoCollection
     */
    protected $collection = null;

    /**
     * RepositoryMongo constructor.
     * @param string $dsn
     */
    public function __construct($dsn = '')
    {
        $dsn && $this->setDsn($dsn);
        $this->initDriver();
    }

    /**
     * @param array $where
     *
     * @return IRepository
     */
    public function find($where = []): IRepository
    {
        $this->initCollection();
        $this->where = $this->collection->find($where);

        return $this;
    }

    /**
     * @param $item
     *
     * @return mixed
     * @throws \Exception
     */
    public function create($item)
    {
        if (is_object($item) && ($item instanceof IItem)) {
            $data = $item->__toArray();
        } elseif (is_array($item)) {
            $data = $item;
        } else {
            throw new \Exception('Unsupported item type "' . gettype($item) . '".');
        }

        $this->collection->insert($data);
        $itemClass = $this->getItemClass();

        return new $itemClass($item);
    }

    /**
     * @param $item
     *
     * @return int
     */
    public function delete($item): int
    {
        if ($this->where) {
            $removed = $this->collection->remove($this->where);
            $this->reset();

            return is_array($removed) ? count($removed) : (int) $removed;
        }

        return 0;
    }

    /**
     * @param $item
     *
     * @return int
     * @throws \Exception
     */
    public function update($item): int
    {
        if (is_object($item) && ($item instanceof IItem)) {
            $data = $item->__toArray();
        } elseif (is_array($item)) {
            $data = $item;
        } else {
            throw new \Exception('Unsupported item type "' . gettype($item) . '".');
        }

        if ($this->where) {
            $updated = $this->collection->update((array) $this->where, $data);
            $this->reset();

            return (int) $updated;
        } else {
            $this->collection->update([], $data);
            return 1;
        }
    }

    /**
     * @return mixed
     */
    public function one()
    {
        $item = $this->where ? $this->where->current() : [];
        $itemClass = $this->getItemClass();
        $this->reset();

        return new $itemClass($item);
    }

    /**
     * @return array
     */
    public function all()
    {
        $items = [];
        $itemClass = $this->getItemClass();

        if ($this->where) {
            foreach ($this->where as $item) {
                $items[] = new $itemClass($item);
            }
        }

        $this->reset();

        return $items;
    }

    public function commit(): bool
    {
        return true;
    }

    /**
     * @return $this
     */
    protected function reset()
    {
        $this->where = [];

        return $this;
    }

    /**
     * @return $this
     */
    protected function initCollection()
    {
        if ($this->collection) {
            return $this;
        }

        $collectionName = $this->collectionName;
        $this->collection = $this->driver->g5->$collectionName;

        return $this;
    }

    protected function initDriver()
    {
        $this->driver = new \MongoDB\Client($this->dsn);

        return $this;
    }
}
