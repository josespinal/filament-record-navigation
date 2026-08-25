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

        $model = static::getResource()::getModel();
        $routeKeyName = (new $model)->getRouteKeyName() ?? 'id';

        // Let Filament apply the sort so that columns declaring a custom sort
        // query (`sortable(query: ...)`) are honoured instead of being ordered
        // by their name. The returned builder is reassigned because a table
        // whose `defaultSort()` returns a builder is sorted on a new instance.
        $query = $this->applySortingToTableQuery($query);

        // Store record IDs in session
        session(['filament_record_navigation_ids' => $query->pluck($routeKeyName)->toArray()]);

        return $query;
    }
}
