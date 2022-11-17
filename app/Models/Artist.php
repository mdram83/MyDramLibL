<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    public function getName() : string
    {
        return $this->lastname . ($this->firstname ? ", {$this->firstname}" : '');
    }
}
