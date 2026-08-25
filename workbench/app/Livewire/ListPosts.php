<?php

namespace Workbench\App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use JoseEspinal\RecordNavigation\Traits\HasRecordsList;
use Livewire\Component;
use Workbench\App\Filament\Resources\PostResource;

/**
 * Stands in for a resource's List page: it composes the same Filament table
 * concerns a `ListRecords` page does, without needing a registered panel.
 */
class ListPosts extends Component implements HasForms, HasTable
{
    use HasRecordsList;
    use InteractsWithForms;
    use InteractsWithTable;

    /**
     * Sort the table by default through a closure that returns a brand new
     * builder, which is the case Filament reassigns `$query` for.
     */
    public bool $defaultSortsThroughANewBuilder = false;

    public static function getResource(): string
    {
        return PostResource::class;
    }

    public function table(Table $table): Table
    {
        $table = $table
            ->query(PostResource::getEloquentQuery())
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('category_name')
                    ->label('Category')
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query
                        ->withAggregate('category', 'name')
                        ->orderBy('category_name', $direction)),
            ]);

        if ($this->defaultSortsThroughANewBuilder) {
            $table->defaultSort(fn (Builder $query): Builder => $query->clone()
                ->withAggregate('category', 'name')
                ->orderBy('category_name'));
        }

        return $table;
    }

    public function render(): string
    {
        return <<<'BLADE'
        <div></div>
        BLADE;
    }
}
