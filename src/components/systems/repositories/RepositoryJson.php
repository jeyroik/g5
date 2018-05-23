<?php
namespace tratabor\components\systems\repositories;

use tratabor\interfaces\systems\IItem;
use tratabor\interfaces\systems\IRepository;

/**
 * Class RepositoryJson
 *
 * @package tratabor\components\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
class RepositoryJson extends RepositoryPhp implements IRepository
{
    /**
     * RepositoryJson constructor.
     *
     * @param string $dsn
     * @param bool $autoConnect
     */
    public function __construct($dsn = '', $autoConnect = true)
    {
        parent::__construct($dsn);

        $autoConnect && $this->connect();
    }

    /**
     * @return IRepository
     * @throws \Exception
     */
    public function connect(): IRepository
    {
        if (empty($this->dsn)) {
            throw new \Exception('Empty dsn. Please, define dsn to use this storage');
        }

        if (is_file($this->dsn)) {
            $this->items = json_decode(file_get_contents($this->dsn), true);
        }

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
            $this->items[$item->getId()] = $item->__toArray();
        } elseif (is_array($item)) {
            $itemClass = $this->getItemClass();
            if (!isset($item['id']) || empty($item['id'])) {
                $item['id'] = substr(sha1($itemClass), 0, 10) . '_' . time() . mt_rand(1000, 9999);
            }
            $item = new $itemClass($item);

            return $this->create($item);
        } else {
            throw new \Exception('Unsupported item type "' . gettype($item) . '".');
        }

        return $item;
    }

    /**
     * @param $item
     *
     * @return int
     * @throws \Exception
     */
    public function delete($item): int
    {
        if (empty($this->where)) {
            if (is_array($item) && !empty($item)) {
                $this->where = $item;
            } elseif ($item instanceof IItem) {
                $this->where = $item->__toArray();
            } else {
                throw new \Exception('Unsupported item type "' . gettype($item) . '".');
            }

            return $this->delete($item);
        } else {
            $count = 0;
            foreach ($this->items as $id => $currentItem) {
                if ($this->isItemApplicable($currentItem)) {
                    unset($this->items[$id]);
                    $count++;
                }
            }

            return $count;
        }
    }

    /**
     * @param $item
     *
     * @return int
     */
    public function update($item): int
    {
        if (empty($this->where)) {
            $this->create($item);

            return 1;
        } else {
            $count = 0;
            foreach ($this->items as $id => $currentItem) {
                if ($this->isItemApplicable($currentItem)) {
                    foreach ($item as $field => $value) {
                        $this->items[$id][$field] = $value;
                        $count++;
                    }
                }
            }

            return $count;
        }
    }

    /**
     * Save storage on destruction.
     */
    public function __destruct()
    {
        $this->commit();
    }

    /**
     * @return bool
     */
    public function commit(): bool
    {
        if ($this->dsn) {
            file_put_contents($this->dsn, json_encode($this->items));
            return true;
        }

        return false;
    }
}
