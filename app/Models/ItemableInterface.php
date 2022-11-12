<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Relations\MorphOne;

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

}
