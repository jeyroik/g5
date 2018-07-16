<?php
namespace tratabor\components\basics\users\profiles;

use tratabor\components\basics\users\UserProfile;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;

/**
 * Class ProfileRepository
 *
 * @package tratabor\components\basics\users\profiles
 * @author Funcraft <me@funcraft.ru>
 */
class ProfileRepository extends RepositoryMongo
{
    protected $collectionName = 'g5__user_profiles';
    protected $itemClass = UserProfile::class;
}
