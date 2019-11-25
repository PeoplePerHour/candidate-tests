<?php

namespace app\Components\Files\FileOperations;

abstract class File{
    abstract function applyOperation(array $data);
}