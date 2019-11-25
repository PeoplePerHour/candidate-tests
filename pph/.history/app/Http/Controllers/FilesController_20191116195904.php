<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App;


class FilesController extends Controller
{
    const FILE_OPERATION = "fileOperation";
    public function admin()
    {
        $files = File::orderBy('created_at', 'desc')->paginate(10);
        return view('files.index')->with('files', $files);
    }

    public function settleOperation()
    {
        print_r($_GET);
        $data = [];
      
        $basePath = "App\Components\Files\FileOperations\ ";
        App::make(trim($basePath) . $_GET[self::FILE_OPERATION])->applyOperation($data);
    }
}
