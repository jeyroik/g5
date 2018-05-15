<?php
namespace tratabor\components\basics\users\profiles;

use tratabor\components\basics\BasicRepository;
use tratabor\components\basics\users\UserProfile;

/**
 * Class ProfileRepository
 *
 * @package tratabor\components\basics\users\profiles
 * @author Funcraft <me@funcraft.ru>
 */
class ProfileRepository extends BasicRepository
{
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
}
