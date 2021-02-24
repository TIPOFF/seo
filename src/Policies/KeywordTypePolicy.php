<?php

declare(strict_types=1);

namespace Tipoff\Seo\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Seo\Models\KeywordType;
use Tipoff\Support\Contracts\Models\UserInterface;

class KeywordTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view keyword types') ? true : false;
    }

    public function view(UserInterface $user, KeywordType $keyword_type): bool
    {
        return $user->hasPermissionTo('view keyword types') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create keyword types') ? true : false;
    }

    public function update(UserInterface $user, KeywordType $keyword_type): bool
    {
        return $user->hasPermissionTo('update keyword types') ? true : false;
    }

    public function delete(UserInterface $user, KeywordType $keyword_type): bool
    {
        return false;
    }

    public function restore(UserInterface $user, KeywordType $keyword_type): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, KeywordType $keyword_type): bool
    {
        return false;
    }
}
