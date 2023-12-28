<?php

namespace App\Models;

use App\Models\Repositories\Interfaces\IFriendsRepository;
use App\Utilities\Request\UndecodedRequestParamsInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

trait ItemableTrait
{
    public function item() : \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Item::class, 'itemable');
    }

    public function getTitle() : string
    {
        return $this->item->title;
    }

    public function getPublisherName() : ?string
    {
        return $this->item->publisher?->name;
    }

    public function getPublishedAt() : ?int
    {
        return $this->item->published_at;
    }

    public function getThumbnail() : ?string
    {
        return $this->item->thumbnail;
    }

    public function getComment() : ?string
    {
        return $this->item->comment;
    }

    public function getTags() : ?Collection
    {
        return $this->item->tags;
    }

    public function getItemableType() : string
    {
        return $this->item->itemable_type;
    }

    public function scopeOfUsers($query, array $userIds)
    {
        return $query->whereHas('item', function($query) use ($userIds) {
            $query->whereIn('user_id', $userIds);
        });
    }

    public function scopeUsingGenericQueryString(
        $query,
        Request $request,
        UndecodedRequestParamsInterface $undecodedRequestParams,
        IFriendsRepository $friendsRepository
    )
    {
        $queryParams = $request->query();

        if (isset($queryParams['publishedAtMin'])) {
            $query = $query->whereHas('item', function($query) use ($queryParams) {
                $query
                    ->where('published_at', '>=', $queryParams['publishedAtMin'])
                    ->orWhereNull('published_at');
            });
        }

        if (isset($queryParams['publishedAtMax'])) {
            $query = $query->whereHas('item', function($query) use ($queryParams) {
                $query
                    ->where('published_at', '<=', $queryParams['publishedAtMax'])
                    ->orWhereNull('published_at');
            });
        }

        if (filter_var($queryParams['publishedAtRequired'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            $query = $query->whereHas('item', function($query) use ($queryParams) {
                $query->whereNotNull('published_at');
            });
        }

        if (isset($queryParams['tags'])) {
            $tags = array_map(
                fn($tag) => rawurldecode($tag),
                explode(',', $undecodedRequestParams->get('tags')));

            $query = $query->whereHas('item', function($query) use ($tags) {
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('name', $tags);
                });
            });
        }

        if (isset($queryParams['users'])) {

            $allowedUsersIds = $friendsRepository->getAcceptedFriendsIds($request->user(), true);

            $selectedUsersNames = array_map(
                fn($user) => rawurldecode($user),
                explode(',', $undecodedRequestParams->get('users')));
            $selectedUsersArray = User::whereIn('username', $selectedUsersNames)->get(['id'])->toArray();
            $selectedUsersIds = array_map(fn($value) => $value['id'], $selectedUsersArray);

            $allowedAndSelectedUsersIds = array_intersect($allowedUsersIds, $selectedUsersIds);

            if (!filter_var($queryParams['excludeMyItems'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                $allowedAndSelectedUsersIds[] = $request->user()->id;
            }

            $query = $query->whereHas('item', function($query) use ($allowedAndSelectedUsersIds) {
                $query->whereIn('user_id', $allowedAndSelectedUsersIds);
            });

        } else {
            $query = $query->whereHas('item', function($query) use ($request) {
                $query->where('user_id', '=', $request->user()->id);
            });
        }

        return $query;
    }
}
