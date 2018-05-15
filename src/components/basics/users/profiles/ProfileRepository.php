<?php
namespace tratabor\components\basics\users\profiles;

use tratabor\components\basics\BasicRepository;
use tratabor\components\basics\users\UserProfile;
use tratabor\interfaces\basics\users\IUserProfile;

/**
 * Class ProfileRepository
 *
 * @package tratabor\components\basics\users\profiles
 * @author Funcraft <me@funcraft.ru>
 */
class ProfileRepository extends BasicRepository
{
    /**
     * @param $item
     *
     * @return bool
     */
    public static function update($item)
    {
        return static::getInstance()->updateItem($item);
    }

    /**
     * @return string
     */
    protected function getItemClass(): string
    {
        return UserProfile::class;
    }

    /**
     * @return string
     */
    protected function getPathKey(): string
    {
        return 'G5__PROFILES__PATH';
    }

    /**
     * @return string
     */
    protected function getPathDefault(): string
    {
        return G5__ROOT_PATH . '/resources/profiles.php';
    }

    /**
     * @param IUserProfile $profile
     *
     * @return bool
     */
    public function updateItem(IUserProfile $profile)
    {
        foreach ($this->items as $index => $item) {
            if ($item['id'] == $profile->getId()) {
                $this->items[$index] = $profile->__toArray();
                return true;
            }
        }

        return false;
    }
}
