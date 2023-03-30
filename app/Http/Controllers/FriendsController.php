<?php

namespace App\Http\Controllers;

use App\Models\Repositories\Interfaces\IFriendsRepository;
use App\View\Utilities\FriendshipTranslator;
use Multicaret\Acquaintances\Models\Friendship;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function index(IFriendsRepository $friendsRepository)
    {
        return view('friends', [
            'friends' => $friendsRepository->getActiveFriends(auth()->user()),
            'friendshipTranslator' => new FriendshipTranslator(),
        ]);
    }

    public function store(Request $request)
    {
        // TODO don't allow to invite yourself
    }

    public function update(Request $request, Friendship $friendship)
    {
        //
    }

    public function destroy(Friendship $friendship)
    {
        //
    }
}
