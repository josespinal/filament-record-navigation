<?php

namespace JoseEspinal\FilamentRecordNavigation\Traits;

use Filament\Resources\Pages\Page;
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

        session()->flash('error', 'No next record.');
    }

    public function previousRecord()
    {
        $ids = session('filament_record_navigation_ids');
        $currentIndex = array_search($this->recordId, $ids);

        if ($currentIndex !== false && isset($ids[$currentIndex - 1])) {
            return redirect()->route(static::getRouteName(), ['record' => $ids[$currentIndex - 1]]);
        }

        session()->flash('error', 'No previous record.');
    }

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getHeaderActions(), [
            Action::make('Previous')->action('previousRecord')->color('secondary'),
            Action::make('Next')->action('nextRecord')->color('primary'),
        ]);
    }
}