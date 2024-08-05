<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Process;
use Exception;

class HomeController
{
    public function index(): View
    {
        // Fetch transaction data
        $transactions = Transaction::getAll();

        // Render the view and pass the transaction data
        return View::make('transactions', ['transactions' => $transactions]);
    }

    public function upload(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['receipt'])) {
            // Handle file upload
            return $this->handleUpload($_FILES['receipt']);
        }

        // Return the upload form
        return <<<FORM
            <form action="/upload" method="post" enctype="multipart/form-data">
                <input type="file" name="receipt" />
                <button type="submit">Upload</button>
            </form>
    FORM;
    }

    private function handleUpload(array $file): string
    {

        $filePath = $file['tmp_name'];
            // Process the CSV file using the model
            Process::processCsv($filePath);

            return 'File uploaded and data processed successfully.';
    }
}
