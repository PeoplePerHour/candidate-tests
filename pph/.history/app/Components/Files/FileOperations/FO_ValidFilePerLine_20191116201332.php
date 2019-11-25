<?php
namespace app\Components\Files\FileOperations;

use App\Components\Files\FileOperations\FileOperator;

class FO_ValidFilePerLine extends FileOperator
{
    public function applyOperation(array $data)
    {
        foreach (getLines("http://127.0.0.1/ips/cities_full.csv") as $n => $line) { }
    }
}