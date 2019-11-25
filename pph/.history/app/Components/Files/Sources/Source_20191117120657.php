<?php

namespace app\Components\Files\Sources;

use Illuminate\Support\ServiceProvider;

abstract class Source extends ServiceProvider{
    
    protected $source;
    protected $sourceApiCall;
}