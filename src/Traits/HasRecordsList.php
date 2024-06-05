<?php

namespace JoseEspinal\RecordNavigation\Traits;

trait HasRecordsList
{
    public function rendered($view, $html)
    {
        $query = static::getResource()::getEloquentQuery();
        $data = $this->tableFilters;
        $filters = $this->getTable()->getFilters();

        foreach ($filters as $filter) {
            $filter->apply(
                $query,
                $data[$filter->getName()] ?? [],
            );
        }

        // Store record IDs in session
        session(['filament_record_navigation_ids' => $query->pluck('id')->toArray()]);

        return $query;
    }
}
