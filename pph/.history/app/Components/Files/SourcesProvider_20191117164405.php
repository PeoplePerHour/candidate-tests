<?php

namespace App\Components\Files;


class SourcesProvider
{

    protected $dataFromApi;
    /**
     * Apla ena demo gia na mhn kanei th douleia mesa ston controller
     */
    public  function doTheSourceStuff($data)
    {
        //TODO na ton paw se enan provider
        $baseFolderSource = "App\Components\Files\Sources";
        if (class_exists($baseFolderSource . "\\" . $data['provider'])) {
            $class = $baseFolderSource . "\\" . $data['provider'];
            $source = new  $class($data);
            $source->doThePostCall();
            $this->dataFromApi = json_decode($source->returnResponse(), 200);
             print json_encode($this->seperateDataToFrontEnd(), 200);
        }
    }

    public function seperateDataToFrontEnd()
    {
        print_r($data);
        $dataToFrontEnd['temp'] = current($this->data['data'])['temp'];
        $dataToFrontEnd['clouds'] = current($this->data['data'])['clouds'];
        return $dataToFrontEnd;
    }
}
