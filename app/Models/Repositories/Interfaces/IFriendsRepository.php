<?php

namespace App\Models\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;
use Multicaret\Acquaintances\Models\Friendship;

interface IFriendsRepository
{
    public function getActiveFriends(User $user) : Collection;
    public function getUserFriend(User $user, int $id) : Friendship;
}
