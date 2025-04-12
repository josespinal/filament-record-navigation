<?php

namespace JoseEspinal\RecordNavigation\Traits;

use Filament\Actions\Action;

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
            $nextId = $ids[$currentIndex + 1];
            $url = route($this->getRouteName(), $nextId);

            $this->recordId = $nextId;
            $this->initializeRecord();
            $this->mount($this->recordId);

            $this->dispatch('nextRecord', [
                'recordId' => $nextId,
                'url' => $url,
            ]);
        }
    }

    public function previousRecord()
    {
        $ids = session('filament_record_navigation_ids');
        $currentIndex = array_search($this->recordId, $ids);

        if ($currentIndex !== false && isset($ids[$currentIndex - 1])) {
            $previousId = $ids[$currentIndex - 1];
            $url = route($this->getRouteName(), $previousId);

            $this->recordId = $previousId;
            $this->initializeRecord();
            $this->mount($this->recordId);

            $this->dispatch('previousRecord', [
                'recordId' => $previousId,
                'url' => $url,
            ]);
        }
    }

    public function initializeRecord()
    {
        $this->record = $this->loadModel();
    }

    protected function loadModel()
    {
        $modelClass = static::$resource::getModel();

        return $modelClass::find($this->recordId);
    }

    protected function getNavigationActions(): array
    {
        return array_merge(parent::getHeaderActions(), [
            Action::make('Previous')
                ->action('previousRecord')
                ->color('gray')
                ->icon('heroicon-s-chevron-left')
                ->iconButton(),
            Action::make('Next')
                ->action('nextRecord')
                ->color('gray')
                ->icon('heroicon-s-chevron-right')
                ->iconButton(),
        ]);
    }
}
