<?php

use Filament\Tables\Table;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Workbench\App\Livewire\ListPosts;
use Workbench\App\Models\Category;
use Workbench\App\Models\Post;

beforeEach(function () {
    Schema::create('categories', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
    });

    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->unsignedInteger('category_id');
    });

    // Seed a middle value first so that neither sorting direction lines up with
    // the key order, otherwise an unsorted query would satisfy one of them.
    foreach (['Mike', 'Alpha', 'Zulu'] as $name) {
        $category = Category::create(['name' => $name]);

        $this->{strtolower($name).'Post'} = Post::create([
            'title' => "Post for {$name}",
            'category_id' => $category->id,
        ]);
    }

    $this->byKey = [$this->mikePost->id, $this->alphaPost->id, $this->zuluPost->id];
    $this->byCategoryName = [$this->alphaPost->id, $this->mikePost->id, $this->zuluPost->id];
});

it('sorts the navigation ids through a column custom sort query', function () {
    Livewire::test(ListPosts::class)
        ->call('sortTable', 'category_name', 'asc');

    expect(session('filament_record_navigation_ids'))->toBe($this->byCategoryName);
})->group('sorting');

it('sorts the navigation ids descending through a column custom sort query', function () {
    Livewire::test(ListPosts::class)
        ->call('sortTable', 'category_name', 'desc');

    expect(session('filament_record_navigation_ids'))
        ->toBe(array_reverse($this->byCategoryName));
})->group('sorting');

it('sorts the navigation ids through a default sort that returns a new builder', function () {
    Livewire::test(ListPosts::class, ['defaultSortsThroughANewBuilder' => true]);

    expect(session('filament_record_navigation_ids'))->toBe($this->byCategoryName);
})
    ->group('sorting')
    // Filament only started honouring a builder returned from `defaultSort()`
    // once it merged the default sort column and query into `getDefaultSort()`.
    ->skip(
        fn (): bool => ! method_exists(Table::class, 'getDefaultSort'),
        'This Filament release discards the builder returned by defaultSort().',
    );

it('falls back to the key sort when no sort is applied', function () {
    Livewire::test(ListPosts::class);

    expect(session('filament_record_navigation_ids'))->toBe($this->byKey);
})->group('sorting');
