<?php

namespace App\Models;

use App\Utilities\Request\UndecodedRequestParamsInterface;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Request;

interface ItemableInterface
{
    public function item() : MorphOne;
    public function getTitle() : string;
    public function getPublisherName() : ?string;
    public function getPublishedAt() : ?int;
    public function getThumbnail() : ?string;
    public function getComment() : ?string;
    public function getTags() : ?Collection;
    public function getItemableType() : string;
    public function scopeOfUsers($query, array $userIds);
    public function scopeUsingQueryString($query, Request $request, UndecodedRequestParamsInterface $undecodedRequestParams);
}
