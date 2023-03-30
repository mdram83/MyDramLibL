<?php

namespace App\Models\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class FriendsRepository implements Interfaces\IFriendsRepository
{

    public function getActiveFriends(User $user): Collection
    {
        return $user->getAllFriendships()->where('status', '<>', 'denied');
    }
}
