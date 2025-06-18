<?php

declare(strict_types=1);

namespace JoseEspinal\RecordNavigation\Traits;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\App;
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
        $this->dispatch('recordNavigation.startRecordNavigation', [
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

        $this->dispatch('recordNavigation.changeNavigationRecord', [
            'recordId' => $recordId,
            'url' => $this->url,
            'isViewPage' => $this->isViewPage,
            'confirmMessage' => __('filament-panels::unsaved-changes-alert.body'),
            'isDataDirty' => $this->isDataDirty,
        ]);
    }

    public function updatedHasRecordNavigation($property): void
    {
        if (str_starts_with($property, 'data.')) {
            if(function_exists('ray')) {
                ray($property);
            }
            $this->isDataDirty = true;
        }
    }

    /**
     * Execute the record change after confirmation.
     */
    #[On('recordNavigation.executeChangeRecord')]
    public function executeChangeRecord(int|string $recordId): void
    {
        $this->recordId = $recordId;
        $this->initializeProperties($this->recordId);
        $this->initializeComponentRecordProperty();

        // Update the header actions (buttons) to reflect the new record
        // $this->cacheHeaderActions();
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
        $this->record = $this->resolveRecord($this->recordId);
        $this->authorizeAccess();
        $this->fillForm();
        $this->dispatch('recordNavigation.reloadRelationManagers', recordId: $this->recordId);
    }

    /**
     * Get the navigation actions for the header.
     *
     * @return array<Action>
     */
    protected function getNavigationActions(): array
    {
        // $ids = session('filament_record_navigation_ids');
        $isSessionSet = session()->has('filament_record_navigation_ids');
        // $isPreviousDisabled = false;
        // $isNextDisabled = false;

        // if ($isSessionSet) {
        //     $position = array_search($this->recordId, $ids);

        //     $isPreviousDisabled = $position === 0;
        //     $isNextDisabled = $position === count($ids) - 1;
        // }

        $naigation_previous_icon = App::isLocal('ar')
            ? 'heroicon-s-chevron-right'
            : 'heroicon-s-chevron-left';

        $naigation_next_icon = App::isLocal('ar')
            ? 'heroicon-s-chevron-left'
            : 'heroicon-s-chevron-right';

        return [
            Action::make('Previous')
                ->action('previousRecord')
                ->color('gray')
                ->icon($naigation_previous_icon)
                ->iconButton()
                ->extraAttributes([
                    'data-record-navigation-buttons' => true,
                    'data-record-navigation-previous' => true,
                ])
                ->visible($isSessionSet),
            Action::make('Next')
                ->action('nextRecord')
                ->color('gray')
                ->icon($naigation_next_icon)
                ->iconButton()
                ->extraAttributes([
                    'data-record-navigation-buttons' => true,
                    'data-record-navigation-next' => true,
                ])
                ->visible($isSessionSet),
        ];
    }

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getHeaderActions(), $this->getNavigationActions());
    }
}
