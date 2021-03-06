<?php

namespace Muserpol\Policies;

use Muserpol\User;
use Muserpol\Models\Spouse;
use Illuminate\Auth\Access\HandlesAuthorization;
use Muserpol\Helpers\Util;
class SpousePolicy
{
    use HandlesAuthorization;
    const ClASS_NAME = 'Spouse';
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * Determine whether the user can view the spouse.
     *
     * @param  \Muserpol\User  $user
     * @param  \Muserpol\Spouse  $spouse
     * @return mixed
     */
    public function view(User $user, Spouse $spouse)
    {
        //
        $permission = Util::CheckPermission(self::ClASS_NAME,self::READ);
        return $permission?true:false;
    }

    /**
     * Determine whether the user can create spouses.
     *
     * @param  \Muserpol\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $permission = Util::CheckPermission(self::ClASS_NAME,self::CREATE);
        return $permission?true:false;
    }

    /**
     * Determine whether the user can update the spouse.
     *
     * @param  \Muserpol\User  $user
     * @param  \Muserpol\Spouse  $spouse
     * @return mixed
     */
    public function update(User $user, Spouse $spouse)
    {
        //
        $permission = Util::CheckPermission(self::ClASS_NAME,self::UPDATE);
        return $permission?true:false;
    }

    /**
     * Determine whether the user can delete the spouse.
     *
     * @param  \Muserpol\User  $user
     * @param  \Muserpol\Spouse  $spouse
     * @return mixed
     */
    public function delete(User $user, Spouse $spouse)
    {
        //
        $permission = Util::CheckPermission(self::ClASS_NAME,self::DELETE);
        return $permission?true:false;
    }
}
