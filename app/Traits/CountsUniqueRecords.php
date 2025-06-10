<?php
namespace App\Traits;

trait CountsUniqueRecords
{
    /**
     * Get the count of unique records based on a column.
     * 
     * @param string $modelClass The model class to query
     * @param string $column The column name to eliminate duplicates on
     * @return int
     */
    public function countUnique(string $modelClass, string $column): int
    {
        return $modelClass::distinct($column)->count($column);
    }
}
