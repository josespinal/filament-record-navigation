<?php

declare(strict_types=1);

namespace JoseEspinal\RecordNavigation\Traits;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;

trait HasRecordNavigation
{
    /**
     * The current record ID being viewed/edited.
     */
    public string|int|null $recordId;

    /**
     * Whether the current page is a view record page.
     */
    public bool $isViewPage = false;

    /**
     * The URL of the current record.
     */
    public string $url;

    /**
     * Whether the data has been updated.
     */
    public bool $isDataDirty = false;

    /**
     * Mount the record navigation functionality.
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->initializeProperties($record);
        $this->dispatch('startRecordNavigation', [
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
        // Generate the correct URL with the new record ID
        $this->url = route($this->getRouteName(), ['record' => $recordId]);

        $this->dispatch('changeNavigationRecord', [
            'recordId' => $recordId,
            'url' => $this->url,
            'isViewPage' => $this->isViewPage,
            'confirmMessage' => __('filament-panels::unsaved-changes-alert.body'),
            'isDataDirty' => $this->isDataDirty
        ]);
    }

    public function updatedData()
    {
        $this->isDataDirty = true;

        if (method_exists(parent::class, 'updatedData') && parent::updatedData()) {
            parent::updatedData();
        }
    }

    /**
     * Execute the record change after confirmation.
     */
    #[On('executeChangeRecord')]
    public function executeChangeRecord(int|string $recordId): void
    {
        $this->recordId = $recordId;
        $this->initializeProperties($this->recordId);
        $this->initializeComponentRecordProperty();
    }

    protected function initializeProperties(int|string $recordId): void
    {
        $this->isDataDirty = false;
        $this->recordId = $recordId;
        $this->isViewPage = $this instanceof ViewRecord;
        $this->url = route($this->getRouteName(), ['record' => $recordId]);
        parent::mount($this->recordId);
    }

    /**
     * Initialize the record instance.
     */
    protected function initializeComponentRecordProperty(): void
    {
        $this->record = $this->loadModel();
    }

    /**
     * Load the model instance for the current record.
     */
    protected function loadModel(): Model
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
