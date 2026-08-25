<?php

namespace Workbench\App\Filament\Resources;

use Filament\Resources\Resource;
use Workbench\App\Models\Post;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
}
