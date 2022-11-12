<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

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
}
