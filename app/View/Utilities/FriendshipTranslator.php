<?php

namespace App\View\Utilities;

use Exception;
use Multicaret\Acquaintances\Models\Friendship;

class FriendshipTranslator
{
    protected ?int $currentUserId;
    protected array $statusConfig = [
        'accepted' => [
            'icon' => [
                'name' => 'users',
                'color' => 'rgb(34 197 94)',
            ],
            'actions' => [
                'remove' => [
                    'name' => 'Remove Friend',
                    'icon' => 'user-minus',
                    'color' => 'rgb(220 38 38)',
                    'link' => '#' // TODO add proper route()
                ],
            ],
        ],
        'pending' => [
            'icon' => [
                'name' => 'clock',
                'color' => 'rgb(245 158 11)',
            ],
            'actions' => [
                'accept' => [
                    'name' => 'Accept Invite',
                    'icon' => 'user-check',
                    'color' => 'rgb(34 197 94)',
                    'link' => '#' // TODO add proper route()
                ],
                'reject' => [
                    'name' => 'Reject/Cancel Invite',
                    'icon' => 'user-x',
                    'color' => 'rgb(220 38 38)',
                    'link' => '#' // TODO add proper route()
                ],
            ],
        ],
    ];

    public function __construct()
    {
        if (!$this->currentUserId = auth()->id()) {
            throw new Exception('User not authenticated.');
        }
    }

    public function getFriendNameOfLoggedUser(Friendship $friendship) : string
    {
        $sender = $friendship->sender()->first();
        $recipient = $friendship->recipient()->first();

        return $sender->id == $this->currentUserId ? $recipient->username : $sender->username;
    }

    public function getStatusIconName(Friendship $friendship) : ?string
    {
        return $this->statusConfig[$friendship->status]['icon']['name'] ?? null;
    }

    public function getStatusIconColor(Friendship $friendship) : ?string
    {
        return $this->statusConfig[$friendship->status]['icon']['color'] ?? null;
    }

    public function getPossibleActions(Friendship $friendship) : ?array
    {
        return $this->removeAcceptActionForSender(
            $friendship,
            $this->statusConfig[$friendship->status]['actions']
        );
    }

    protected function removeAcceptActionForSender(Friendship $friendship, array $actions) : array
    {
        if ($friendship->sender()->first()->id == $this->currentUserId) {
            unset($actions['accept']);
        }
        return $actions;
    }
}
