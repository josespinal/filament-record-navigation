<?php

declare(strict_types=1);

namespace JoseEspinal\RecordNavigation\Traits;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\Concerns\HasUnsavedDataChangesAlert;
use Filament\Resources\Pages\ViewRecord;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Model;

trait HasRecordNavigation
{
    use HasUnsavedDataChangesAlert;

    /**
     * The current record ID being viewed/edited.
     */
    public string|int|null $recordId;

    /**
     * Whether the current page is a view record page.
     */
    public bool $isViewRecord = false;

    /**
     * The URL of the current record.
     */
    public string $url;

    /**
     * Mount the record navigation functionality.
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->initializeProperties($record);

        $this->dispatch('start-record-navigation', [
            'recordId' => $this->recordId,
            'url' => $this->url,
        ]);
    }

    public function nextRecord(): void
    {
        $ids = session('filament_record_navigation_ids');
        $currentIndex = array_search($this->recordId, $ids);

        if ($currentIndex !== false && isset($ids[$currentIndex + 1])) {
            $this->navigateToRecord($ids[$currentIndex + 1]);
        }
    }

    public function previousRecord(): void
    {
        $ids = session('filament_record_navigation_ids');
        $currentIndex = array_search($this->recordId, $ids);

        if ($currentIndex !== false && isset($ids[$currentIndex - 1])) {
            $this->navigateToRecord($ids[$currentIndex - 1]);
        }
    }

    /**
     * Handle the navigation to a specific record.
     */
    protected function navigateToRecord(string|int $recordId): void
    {
        $this->dispatch('changeNavigationRecord', [
            'recordId' => $recordId,
            'url' => $this->url,
            'isViewRecord' => $this->isViewRecord,
            'componentId' => $this->getId(),
            'confirmMessage' => __('filament-panels::unsaved-changes-alert.body'),
        ]);

        $this->mountHasUnsavedDataChangesAlert();
    }

    /**
     * Execute the record change after confirmation.
     */
    #[On('execute-change-record')]
    public function executeChangeRecord(int|string $recordId): void
    {
        $this->recordId = $recordId;
        $this->initializeComponentRecordProperty();
        $this->initializeProperties($this->recordId);
    }


    private function initializeProperties(int|string $recordId): void
    {
        $this->recordId = $recordId;
        $this->isViewRecord = $this instanceof ViewRecord;
        $this->url = route($this->getRouteName(), ['record' => $recordId]);
        $this->mountHasUnsavedDataChangesAlert();
        parent::mount($this->recordId);
    }

    /**
     * Initialize the record instance.
     */
    private function initializeComponentRecordProperty(): void
    {
        $this->record = $this->loadModel();
    }

    /**
     * Load the model instance for the current record.
     */
    private function loadModel(): Model
    {
        $modelClass = static::$resource::getModel();

        return $modelClass::find($this->recordId);
    }

    /**
     * Get the navigation actions for the header.
     *
     * @return array<Action>
     */
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
