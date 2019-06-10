<?php

namespace App\Models\Documents;

/**
 * Interface DocumentSaverInterface
 */
interface DocumentSaverInterface
{
    /**
     * Saves document in storage
     *
     * @param $document
     *
     * @return void
     */
    public function saveDocument(array $document);
}