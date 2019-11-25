<?php
namespace app\Components\Files\Source;

use Illuminate\Support\ServiceProvider;

class SourcesProvider extends ServiceProvider{

    /**
     * Apla ena demo gia na mhn kanei th douleia mesa ston controller
     */
    public function toTheSourceStuff($class)
    {
        $baseFolderSource = "App\Components\Files\Sources";
        $class = $baseFolderSource . "\\" . $_POST['provider'];
        $source = new  $class($_POST);
        $source->doThePostCall();
        print json_encode($source->returnResponse(), 200);
    }
}