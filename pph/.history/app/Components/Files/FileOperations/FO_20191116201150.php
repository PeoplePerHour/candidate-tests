<?php

namespace app\Components\Files\FileOperations;

abstract class FileOperator{
    abstract function applyOperation(array $data);
}