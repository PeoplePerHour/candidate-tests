<?php

namespace app\Components\Files\FileOperations\FileOperator.php

abstract class FileOperator{
    abstract function applyOperation(array $data);
}