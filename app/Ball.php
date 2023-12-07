<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ball extends Model
{
    protected $fillable = ['color', 'size'];

    public function buckets()
    {
        return $this->belongsToMany(Bucket::class, 'bucket_suggestion')->withPivot('quantity');
    }
}
