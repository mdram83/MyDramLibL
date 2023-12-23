<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

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

    public function scopeUsingQueryString($query, array $queryParams)
    {
        if (isset($queryParams['publishedAtMin'])) {
            $query = $query->whereHas('item', function($query) use ($queryParams) {
                $query->where('published_at', '>=', $queryParams['publishedAtMin']);
            });
        }

        if (isset($queryParams['publishedAtMax'])) {
            $query = $query->whereHas('item', function($query) use ($queryParams) {
                $query->where('published_at', '<=', $queryParams['publishedAtMax']);
            });
        }

        if (filter_var($queryParams['publishedAtEmpty'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            $query = $query->orWhereHas('item', function($query) use ($queryParams) {
                $query->whereNull('published_at');
            });
        }

        if (
            isset($queryParams['publishedAtEmpty'])
            && !isset($queryParams['publishedAtMin'])
            && !isset($queryParams['publishedAtMax'])
            && filter_var($queryParams['publishedAtEmpty'], FILTER_VALIDATE_BOOLEAN) === false
        ) {
            $query = $query->WhereHas('item', function($query) use ($queryParams) {
                $query->whereNotNull('published_at');
            });
        }

        return $query;
    }
}
