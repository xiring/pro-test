<?php


namespace App\Traits\Search;


use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait BasicFilter
{

    public function scopeQ(Builder $query, mixed $q = null): Builder
    {
        if (empty($q)) {
            return $query;
        }
        $columns = Schema::getColumnListing($this->getTable());
        return $query->where(function (Builder $query) use ($q, $columns) {
            foreach ($columns as $column) {
                if (in_array(DB::getSchemaBuilder()->getColumnType($this->getTable(), $column), ['date', 'datetime'])) {
                    try {
                        $q = Carbon::parse($q)->format('Y-m-d');
                    } catch (InvalidFormatException $e) {
                    }
                }
                $query->orWhere($column, 'LIKE', '%' . trim($q) . '%');
            }
        });
    }

    /**
     * Scope a query to sort group by specific column.
     *
     * @param Builder $query
     * @param $sortBy
     * @param string $sortMethod
     * @return Builder
     */
    public function scopeSort(Builder $query, $sortBy = 'created_at', $sortMethod = 'desc')
    {
        if (empty($sortBy)) {
            $sortBy = 'created_at';
        }
        if (empty($sortMethod)) {
            $sortMethod = 'desc';
        }
        return $query->orderBy($sortBy, $sortMethod);
    }

    /**
     * Scope a query to only include group of a greater date creation.
     *
     * @param Builder $query
     * @param $dateFrom
     * @return Builder
     */
    public function scopeDateFrom(Builder $query, $dateFrom)
    {
        if (empty($dateFrom)) return $query;

        try {
            $formattedData = Carbon::parse($dateFrom)->format('Y-m-d');
            return $query->where(DB::raw('DATE(created_at)'), '>=', $formattedData);
        } catch (InvalidFormatException $exception) {
            return $query;
        }
    }

    /**
     * Scope a query to only include group of a less date creation.
     *
     * @param Builder $query
     * @param $dateTo
     * @return Builder
     */
    public function scopeDateTo(Builder $query, $dateTo)
    {
        if (empty($dateTo)) return $query;

        try {
            $formattedData = Carbon::parse($dateTo)->format('Y-m-d');
            return $query->where(DB::raw('DATE(created_at)'), '<=', $formattedData);
        } catch (InvalidFormatException $exception) {
            return $query;
        }
    }

    public function scopeFilterPaginate($query)
    {
        $search = request('search');
        $is_json_search = request('is_json');
        $per_page = request('per_page') ?? 10;
        $sortBy = request('sort_by') ?? 'latest';
        $start_date = request()->start_date ?? '';
        $end_date = request()->end_date ?? '';
        if ($search)
            $query->where(function ($query) use ($search, $is_json_search) {
                foreach ($this->searchAttributes as $column)
                    $is_json_search ?
                        $query->orWhere('properties->' . $column, "LIKE", "%{$search}%")
                        : $query->orWhere($column, 'LIKE', '%' . trim($search) . '%');
            });
        $query->when($start_date, function ($q) use ($start_date, $end_date) {
            $q->whereBetween('created_at', [$start_date, $end_date]);
        });

        $query->$sortBy();
        if ($per_page == -1) {
            $results = $query->get();
            return new LengthAwarePaginator($results, $results->count(), -1);
        }
        return $query->paginate($per_page);

    }

}
