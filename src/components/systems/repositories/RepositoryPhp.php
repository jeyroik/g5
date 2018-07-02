<?php
namespace tratabor\components\systems\repositories;

use deflou\components\compares\CompareDefault;
use deflou\interfaces\ICompare;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IRepository;

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

    protected $whereClauseMap = [
        '=' => CompareDefault::class,
        '!=' => CompareDefault::class,
        '>' => CompareDefault::class,
        '<' => CompareDefault::class,
        '>=' => CompareDefault::class,
        '<=' => CompareDefault::class,
        'like' => CompareDefault::class
    ];

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
        $one = null;

        if (empty($this->where)) {
            $items = $this->items;
            $item = array_shift($items);

            $one = new $itemClass($item);
        } else {
            foreach ($this->items as $item) {
                if ($this->isItemApplicable($item)) {
                    $one = new $itemClass($item);
                    break;
                }
            }
            $this->reset();
        }

        return $one;
    }

    /**
     * @return array
     */
    public function all()
    {
        $itemClass = $this->getItemClass();
        $items = [];

        foreach ($this->items as $item) {
            if ($this->isItemApplicable($item)) {
                $items[] = new $itemClass($item);
            }
        }

        $this->reset();

        return $items;
    }

    /**
     * @throws \Exception
     */
    public function connect(): IRepository
    {
        parent::connect();

        if (is_array($this->dsn)) {
            $this->items = $this->dsn;
        } elseif (is_file($this->dsn)) {
            $this->items = include $this->dsn;
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
            $byId = array_column($this->items, null, 'id');

            if (isset($byId[$item->getId()])) {
                $byId[$item->getId()] = $item->__toArray();
            } else {
                $byId[] = $item->__toArray();
            }

            $this->items[] = $byId;
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
     */
    public function update($item): int
    {
        if (empty($this->where)) {
            $this->create($item);

            return 1;
        } else {
            $count = 0;
            if (is_object($item) && ($item instanceof IItem)) {
                $item = $item->__toArray();
            }
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
     * @param $item
     *
     * @return int
     */
    public function delete($item): int
    {
        return 0;
    }

    /**
     * @return bool
     */
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
     * @param $item
     *
     * @return bool|mixed
     * @throws \Exception
     */
    protected function isItemApplicable($item)
    {
        if ($this->isCompositeWhere()) {
            list($field, $clause, $value) = $this->where;

            if (!isset($item[$field])) {
                return false;
            }

            /**
             * Compare to another field
             */
            if (isset($item[$value])) {
                $value = $item[$value];
            }

            if (isset($this->whereClauseMap[$clause])) {
                $compareClass = $this->whereClauseMap[$clause];

                /**
                 * @var $compare ICompare
                 */
                $compare = new $compareClass();
                return $compare->compare($item[$field], $value, $clause);
            } else {
                throw new \Exception('Unknown compare clause: "' . $clause . '".');
            }

        } else {
            foreach ($this->where as $field => $value) {
                if (!isset($item[$field]) || ($item[$field] != $value)) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * @return bool
     */
    protected function isCompositeWhere()
    {
        $keys = array_keys($this->where);
        $key = array_shift($keys);

        return is_numeric($key);
    }
}
