<?php

namespace App\Models\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Multicaret\Acquaintances\Models\Friendship;

class FriendsRepository implements Interfaces\IFriendsRepository
{

    public function getActiveFriends(User $user) : Collection
    {
        return $user->getAllFriendships()->where('status', '<>', 'denied');
    }

    public function getUserFriend(User $user, int $id) : Friendship
    {
        return
            $user->getAllFriendships()->where('id', $id)->first()
            ??
            throw new Exception('Can not accept requested friend');
    }
}