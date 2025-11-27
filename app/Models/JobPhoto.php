<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPhoto extends Model
{
    protected $fillable = ['job_id','path','filename','mime','size'];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    // Accessor for public URL (if using storage:link)
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
