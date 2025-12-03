<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Trade extends Model
{
    protected $fillable = ['name'];


    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_trade')->withTimestamps();
    }
}
