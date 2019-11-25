<?php

namespace app\Components\Files\Sources;
use App\Components\Files\Sources\Source;

class Source_Weatherbit extends Source{
    
    public function getSource(){
        return $this->source;
    }

    public function getSourceApiCall(){
        return $this->sourceApiCall
    }
}