<?php

namespace JoseEspinal\RecordNavigation\Traits;

use Filament\Pages\Actions\Action;

trait HasRecordNavigation
{
    public $recordId;

    public function mount($record): void
    {
        $this->recordId = $record;
        parent::mount($record);
    }

    public function nextRecord()
    {
        $ids = session('filament_record_navigation_ids');
        $currentIndex = array_search($this->recordId, $ids);

        if ($currentIndex !== false && isset($ids[$currentIndex + 1])) {
            return redirect()->route(static::getRouteName(), ['record' => $ids[$currentIndex + 1]]);
        }
    }

    public function previousRecord()
    {
        $ids = session('filament_record_navigation_ids');
        $currentIndex = array_search($this->recordId, $ids);

        if ($currentIndex !== false && isset($ids[$currentIndex - 1])) {
            return redirect()->route(static::getRouteName(), ['record' => $ids[$currentIndex - 1]]);
        }
    }

    protected function getNavigationActions(): array
    {
        return array_merge(parent::getHeaderActions(), [
            Action::make('Previous')
              ->action('previousRecord')
              ->color('gray')
              ->icon('heroicon-m-chevron-left')
              ->iconButton(),
            Action::make('Next')
              ->action('nextRecord')
              ->color('gray')
              ->icon('heroicon-m-chevron-right')
              ->iconButton(),
        ]);
    }
}
