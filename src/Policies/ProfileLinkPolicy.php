<?php

declare(strict_types=1);

namespace Tipoff\Seo\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Seo\Models\ProfileLink;
use Tipoff\Support\Contracts\Models\UserInterface;

class ProfileLinkPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view profile links') ? true : false;
    }

    public function view(UserInterface $user, ProfileLink $profile_link): bool
    {
        return $user->hasPermissionTo('view profile links') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create profile links') ? true : false;
    }

    public function update(UserInterface $user, ProfileLink $profile_link): bool
    {
        return $user->hasPermissionTo('update profile links');
    }

    public function delete(UserInterface $user, ProfileLink $profile_link): bool
    {
        return $user->hasPermissionTo('delete profile links');
    }
}
