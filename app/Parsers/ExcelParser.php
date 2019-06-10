<?php

namespace App\Parsers;

use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class ExcelParser
 */
class ExcelParser implements ParserInterface
{
    /**
     * @var array ALLOWED_FILE_TYPES
     */
    public const ALLOWED_FILE_TYPES = ['xlsx', 'xls', 'csv'];

    /**
     * Parses file.
     *
     * @param UploadedFile $file
     *
     * @return array
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function parse(UploadedFile $file): array
    {
        $reader = IOFactory::createReader(ucfirst($file->getClientOriginalExtension()));

        $spreadsheet = $reader->load($file->path());
        $worksheet = $spreadsheet->getActiveSheet();

        return $this->makeRow($worksheet);
    }

    /**
     * Builds row from file cells
     *
     * @param Worksheet $worksheet
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function makeRow(Worksheet $worksheet)
    {
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cells = $this->makeCell($row);
            $rows[] = $cells;
        }

        return array_filter($rows);
    }

    /**
     * Make cell from file
     *
     * @param Row $row
     *
     * @return array
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function makeCell(Row $row)
    {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
        }

        return array_filter($cells);
    }
}