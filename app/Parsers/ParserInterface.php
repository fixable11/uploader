<?php

namespace App\Parsers;

use Illuminate\Http\UploadedFile;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * @param UploadedFile $file Uploaded file.
     *
     * @return array
     */
    public function parse(UploadedFile $file): array;
}