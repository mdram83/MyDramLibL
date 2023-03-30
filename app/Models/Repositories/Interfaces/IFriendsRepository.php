<?php

namespace App\Models\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface IFriendsRepository
{
    public function getActiveFriends(User $user) : Collection;
}
