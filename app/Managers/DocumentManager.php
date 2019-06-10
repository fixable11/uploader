<?php

namespace App\Managers;

use App\Models\Documents\DocumentStrategy;
use App\Parsers\ParserStrategy;
use Illuminate\Http\UploadedFile;

/**
 * Class DocumentManager
 */
class DocumentManager
{
    /**
     * @var ParserStrategy $parserStrategy Chooses parser depending on file type.
     */
    private $parserStrategy;

    /**
     * @var DocumentStrategy $documentStrategy Chooses document we are dealing with.
     */
    private $documentStrategy;

    /**
     * DocumentManager constructor.
     *
     * @param ParserStrategy   $parserStrategy   ParserStrategy.
     * @param DocumentStrategy $documentStrategy DocumentStrategy.
     */
    public function __construct(ParserStrategy $parserStrategy, DocumentStrategy $documentStrategy)
    {
        $this->parserStrategy = $parserStrategy;
        $this->documentStrategy = $documentStrategy;
    }

    /**
     * Save document in the specific storage.
     *
     * @param string       $fileType File extension.
     * @param UploadedFile $document File we want to upload.
     *
     * @throws \Exception Exception.
     */
    public function saveDocument(string $fileType, UploadedFile $document)
    {
        $rows = $this->parserStrategy->setStrategy($fileType)->parse($document);

        $document = $this->documentStrategy->setStrategy($fileType)->getDocument();

        $document->saveDocument($rows);
    }
}