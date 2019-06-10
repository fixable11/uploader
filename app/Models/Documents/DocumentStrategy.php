<?php

namespace App\Models\Documents;

use App\Parsers\ExcelParser;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class DocumentStrategy
 */
class DocumentStrategy
{
    /**
     * @var array Strategies of choosing document depending on file type.
     */
    private const DOCUMENT_STRATEGIES = [
        Excel::class => ExcelParser::ALLOWED_FILE_TYPES,
    ];

    /**
     * @var DocumentSaverInterface $document Repository that saves document.
     */
    private $strategy;

    /**
     * Sets strategy of choosing the document.
     *
     * @param string $fileType
     *
     * @return DocumentStrategy
     *
     * @throws \Exception
     */
    public function setStrategy(string $fileType)
    {
        foreach (self::DOCUMENT_STRATEGIES as $document => $allowedTypes) {
            if (in_array($fileType, $allowedTypes)) {
                $this->strategy = new $document;
                return $this;
            }
        }

        throw new BadRequestHttpException('File type is not allowed');
    }

    /**
     * Get persisting class
     *
     * @return DocumentSaverInterface
     */
    public function getDocument()
    {
        return $this->strategy;
    }
}