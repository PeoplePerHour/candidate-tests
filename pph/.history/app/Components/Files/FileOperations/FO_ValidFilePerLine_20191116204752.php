<?php

namespace app\Components\Files\FileOperations;

use App\Components\Files\FileOperations\FileOperator;

class FO_ValidFilePerLine extends FileOperator
{
    public function applyOperation(array $data)
    {
   

        foreach ($this->getLines($data['file']) as $n => $line) {

         }
    }

    private function getLines($file)
    {
        $f = fopen($file, 'r');
        try {
            while ($line = fgets($f)) {
                yield $line;
            }
        } finally {
            fclose($f);
        }
    }
}
