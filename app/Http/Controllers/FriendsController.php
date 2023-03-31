<?php

namespace App\Http\Controllers;

use App\Mail\FriendshipInvite;
use App\Models\Repositories\Interfaces\IFriendsRepository;
use App\Models\User;
use App\View\Utilities\FriendshipTranslator;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FriendsController extends Controller
{
    protected User $user;

    public function index(IFriendsRepository $friendsRepository)
    {
        $this->assignUser();

        return view('friends', [
            'friends' => $friendsRepository->getActiveFriends($this->user),
            'friendshipTranslator' => new FriendshipTranslator(),
        ]);
    }

    public function add(Request $request)
    {
        $this->assignUser();

        $friend = User::where('username', '=', $request->input('friend'))->first();

        if ($friend === null) {
            return $this->onFailure('Friend could not be found')->withInput();
        }

        if ($this->user->befriend($friend)) {
            Mail::to($friend->email)->send(new FriendshipInvite($this->user->username));
            return $this->onSuccess('Invite sent');
        }

        return $this->onFailure('Could not send invite');
    }

    public function accept(IFriendsRepository $friendsRepository, int $friendshipId)
    {
        $this->assignUser();

        try {
            $sender = $friendsRepository->getUserFriend($this->user, $friendshipId)->sender()->first();
        } catch (Exception) {
            return $this->onFailure('Sorry, something went wrong with accepting friend\'s invite');
        }

        $this->user->acceptFriendRequest($sender);
        return $this->onSuccess("{$sender->username} is now added to your friends list");
    }

    public function remove(IFriendsRepository $friendsRepository, int $friendshipId)
    {
        $this->assignUser();

        try {
            $friend = $friendsRepository->getUserFriend($this->user, $friendshipId)->sender()->first();
        } catch (Exception) {
            return $this->onFailure('Sorry, something went wrong with removing friend from the list');
        }

        $this->user->unfriend($friend);
        return $this->onSuccess("{$friend->username} is removed from your friends list");
    }

    public function reject(IFriendsRepository $friendsRepository, int $friendshipId)
    {
        $this->assignUser();

        try {
            $friendship = $friendsRepository->getUserFriend($this->user, $friendshipId);
        } catch (Exception) {
            return $this->onFailure('Sorry, something went wrong with rejecting friend\'s invite');
        }

        $friend =
            $this->user->id == $friendship->sender_id
                ? $friendship->recipient()->first()
                : $friendship->sender()->first();

        $this->user->unfriend($friend);
        return $this->onSuccess("{$friend->username} invite was rejected");
    }

    protected function assignUser() : void
    {
        $this->user = auth()->user();
    }

    protected function onSuccess(string $message) : RedirectResponse
    {
        return redirect()->back()->with('success', $message);
    }

    protected function onFailure(string $message) : RedirectResponse
    {
        return redirect()->back()->withErrors([
            'general' => $message,
        ]);
    }
}
