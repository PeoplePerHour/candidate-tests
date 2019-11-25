<?php

namespace app\Components\Files\FileOperations;

use App\Components\Files\FileOperations\FileOperator;
use App\City;
class FO_ValidFilePerLine extends FileOperator
{
    const backSlash = '\\';
    public function applyOperation(array $data)
    { 
        foreach ($this->getLines(base_path() . "\\" . $data['file']) as $n => $line) {
           list($id , $city_name , $elevation , $state_code , $state_name , $country_code  , $country_code , $country_name) = explode(",", $line);
            $city = new City;
            $city->id = $id;
            $city->city_name = $city_name;
            $city->elevation = $elevation;
            $city->state_code = $state_code;
            $city->state_name = $state_name;
            $city->country_code = $country_code;
            $city->country_code = $country_code;
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
