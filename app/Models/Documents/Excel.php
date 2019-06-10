<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Excel Model
 */
class Excel extends Model implements DocumentSaverInterface
{
    use DocumentTransformer;

    /**
     * @var string $table Table.
     */
    protected $table = 'excel';

    /**
     * @var array $guarded The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Saves document.
     *
     * @param array $rows
     */
    public function saveDocument(array $rows)
    {
        $columnNames = array_shift($rows);

        $this->addNotExistingColumns($columnNames);

        $rows = $this->transformToDbFormat($rows, $columnNames);

        foreach ($rows as $row) {
            self::create($row);
        }
    }
}
