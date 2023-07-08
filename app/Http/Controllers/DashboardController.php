<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Repositories\Interfaces\IFriendsRepository;
use App\Utilities\Librarian\NavigatorInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(NavigatorInterface $navigator, IFriendsRepository $friendsRepository)
    {
        // TODO recently added friends

        return view('dashboard', [
            'items' => auth()->user()->items()->withOnly([])->latest()->take(5)->get(),
            'friendsItems' => Item::ofUsers($friendsRepository->getAcceptedFriendsIds(auth()->user()))
                ->withOnly([])
                ->latest()
                ->take(5)
                ->get(),
            'played' => auth()->user()->musicAlbums()
                ->where('played_on', '>', '0')
                ->orderBy('played_on', 'desc')
                ->take(5)
                ->get(),
        ]);
    }
}
