<?php

namespace App\Models\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Multicaret\Acquaintances\Models\Friendship;

class FriendsRepository implements Interfaces\IFriendsRepository
{

    public function getActiveFriends(User $user): Collection
    {
        return $user->getAllFriendships()->where('status', '<>', 'denied');
    }

    public function getAcceptedFriends(User $user): Collection
    {
        return $user->getAllFriendships()->where('status', '=', 'accepted');
    }

    public function getUserFriend(User $user, int $id): Friendship
    {
        return
            $user->getAllFriendships()->where('id', $id)->first()
            ??
            throw new Exception('Can not accept requested friend');
    }

    public function getAcceptedFriendsIds(User $user, bool $withLoggedUserId = false): array
    {
        $loggedUserId = $user->id;

        $userIds = $this->getAcceptedFriends($user)->map(function (Friendship $friendship) use ($loggedUserId) {
            return $friendship->sender()->first()->id !== $loggedUserId
                ? $friendship->sender()->first()->id
                : $friendship->recipient()->first()->id;
        })->all();

        if ($withLoggedUserId) {
            if (count($userIds) > 0) {
                return array_merge($userIds, [$loggedUserId]);
            }
            return [$loggedUserId];
        }

        return $userIds;
    }
}
