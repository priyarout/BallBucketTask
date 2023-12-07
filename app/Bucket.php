<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    protected $fillable = ['name', 'volume'];

    public function balls()
    {
        return $this->belongsToMany(Ball::class, 'bucket_suggestion')->withPivot('quantity');
    }
}
