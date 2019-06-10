<?php

namespace App\Parsers;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ParserStrategy
 */
class ParserStrategy
{
    /**
     * @var array Parser strategies.
     */
    private const PARSER_STRATEGIES = [
        ExcelParser::class => ExcelParser::ALLOWED_FILE_TYPES,
    ];

    /**
     * @var ParserInterface $strategy
     */
    private $strategy;

    /**
     * Sets strategy for parser we want to deal with
     *
     * @param string $fileType File extension.
     *
     * @return ParserStrategy
     * @throws \Exception
     */
    public function setStrategy(string $fileType)
    {
        foreach (self::PARSER_STRATEGIES as $parser => $allowedTypes) {
            if (in_array($fileType, $allowedTypes)) {
                $this->strategy = new $parser;
                return $this;
            }
        }

        throw new BadRequestHttpException('File type is not allowed');
    }

    /**
     * Parse uploaded file depending on strategy
     *
     * @param UploadedFile $file Uploaded file.
     *
     * @return array
     */
    public function parse(UploadedFile $file): array
    {
        return $this->strategy->parse($file);
    }
}