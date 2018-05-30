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
     * @var \MongoDB\Client
     */
    protected $driver = null;

    /**
     * @var \MongoDb\Driver\Cursor
     */
    protected $where = null;

    /**
     * @var \MongoDB\Collection
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

        $this->collection->insertOne($data);
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
            $removed = $this->collection->deleteMany($this->where);
            $this->reset();

            return $removed->getDeletedCount();
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
            $updated = $this->collection->updateMany($this->where, $data);
            $this->reset();

            return $updated->getUpsertedCount();
        } else {
            $this->collection->updateOne([], $data);
            return 1;
        }
    }

    /**
     * @return mixed
     */
    public function one()
    {
        $items = $this->where ? $this->where->toArray() : [];
        $item = count($items) ? array_shift($items) : [];

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
            $rows = $this->where->toArray();

            foreach ($rows as $item) {
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
