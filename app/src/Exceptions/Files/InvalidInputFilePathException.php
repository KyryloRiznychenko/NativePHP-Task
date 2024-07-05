<?php

namespace App\Exceptions\Files;

use Exception;

class InvalidInputFilePathException extends Exception
{
    public function __construct(string $filePath)
    {
        parent::__construct("Invalid input file path by $filePath");
    }
}