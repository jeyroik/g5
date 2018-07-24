<?php
namespace tratabor\components\basics\users\profiles;

use tratabor\components\basics\users\UserProfile;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;
use tratabor\interfaces\basics\users\profiles\IProfileRepository;

/**
 * Class ProfileRepository
 *
 * @package tratabor\components\basics\users\profiles
 * @author Funcraft <me@funcraft.ru>
 */
class ProfileRepository extends RepositoryMongo implements IProfileRepository
{
    protected $collectionName = 'g5__user_profiles';
    protected $itemClass = UserProfile::class;
}
