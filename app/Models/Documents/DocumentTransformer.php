<?php

namespace App\Models\Documents;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Trait DocumentTransformer
 */
trait DocumentTransformer
{
    /**
     * Dynamically adds columns to db.
     *
     * @param array $columns Array of columns that should add
     */
    protected function addNotExistingColumns(array $columns)
    {
        foreach ($columns as $column) {
            if (! Schema::hasColumn($this->table, $column)) {
                $this->addColumn($column);
            }
        }
    }

    /**
     * Adds column to db.
     *
     * @param $columnName
     */
    protected function addColumn($columnName)
    {
        Schema::table($this->table, function (Blueprint $table) use ($columnName) {
            $table->string($columnName)->nullable();
        });
    }

    /**
     * Transform arrays to be saved in db
     *
     * @param array $rows
     * @param array $columnNames
     *
     * @return array
     */
    protected function transformToDbFormat(array $rows, array $columnNames): array
    {
        $length = count($columnNames);

        return array_map(function ($row) use ($columnNames, $length) {
            $row = array_slice($row, 0, $length);
            return array_combine($columnNames, array_pad($row, $length, null));
        }, $rows);
    }
}