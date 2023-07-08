<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Repositories\Interfaces\IFriendsRepository;
use App\Utilities\Librarian\NavigatorInterface;
use App\View\Utilities\FriendshipTranslator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(NavigatorInterface $navigator, IFriendsRepository $friendsRepository)
    {
        $user = auth()->user();

        return view('dashboard', [
            'items' => auth()->user()->items()->withOnly([])->latest()->take(5)->get(),
            'friendsItems' => Item::ofUsers($friendsRepository->getAcceptedFriendsIds($user))
                ->withOnly([])
                ->latest()
                ->take(5)
                ->get(),
            'played' => auth()->user()->musicAlbums()
                ->where('played_on', '>', '0')
                ->orderBy('played_on', 'desc')
                ->take(5)
                ->get(),
            'friends' => $friendsRepository->getActiveFriends($user),
            'friendshipTranslator' => new FriendshipTranslator(),
        ]);
    }
}
