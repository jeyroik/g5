<?php
namespace tratabor\components\systems\repositories;

use deflou\components\compares\CompareDefault;
use deflou\interfaces\ICompare;
use tratabor\interfaces\systems\IItem;
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

        if (empty($this->where)) {
            $items = $this->items;

            $item = array_shift($items);


            return new $itemClass($item);
        }

        foreach ($this->items as $item) {
            if ($this->isItemApplicable($item)) {
                return new $itemClass($item);
            }
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
            if ($this->isItemApplicable($item)) {
                $items[] = new $itemClass($item);
            }
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
     * @return mixed
     */
    public function create($item)
    {
        return null;
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
