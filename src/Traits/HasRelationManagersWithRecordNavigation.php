<?php

namespace JoseEspinal\RecordNavigation\Traits;

use Livewire\Attributes\On;

trait HasRelationManagersWithRecordNavigation
{
    public static function isLazy(): bool
    {
        return false;
    }

    #[On('recordNavigation.reloadRelationManagers')]
    public function refreshRelationManager($recordId)
    {
        $model = resolve($this->ownerRecord->getModel()::class);
        $newRecord = $model->find($recordId);
        $this->ownerRecord = $newRecord;
    }
}
