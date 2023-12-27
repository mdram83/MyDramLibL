<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Repositories\Interfaces\IFriendsRepository;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class FriendsList extends Controller
{
    public function __invoke(Request $request, IFriendsRepository $friendsRepository)
    {
        try {
            $friendsIds = $friendsRepository->getAcceptedFriendsIds($request->user());
            $data = User::whereIn('id', $friendsIds)->orderBy('username')->get(['username'])->toArray();

        } catch (Exception) {
            return response()->json([], 500);
        }

        return response()->json($data);
    }
}
