<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
