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

        $direction = $this->tableSortDirection ?? $this->getTable()->getDefaultSortDirection() ?? 'asc';
        $sort = $this->tableSortColumn ?? $this->getTable()->getDefaultSort($query, $direction);

        if ($sort) {
            $query->orderBy($sort, $direction);
        }

        // Store record IDs in session
        session(['filament_record_navigation_ids' => $query->pluck('id')->toArray()]);

        return $query;
    }
}
