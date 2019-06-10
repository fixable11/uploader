<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Managers\DocumentManager;

/**
 * Class DocumentController
 */
class DocumentController extends Controller
{
    /**
     * @var DocumentManager $documentManager
     */
    private $documentManager;

    /**
     * DocumentManager constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * Uploads document depending on its type
     *
     * @param FileRequest $request
     *
     * @throws \Exception
     */
    public function upload(FileRequest $request)
    {
        $file = $request->file('document');

        $this->documentManager->saveDocument($file->getClientOriginalExtension(), $file);
    }
}
