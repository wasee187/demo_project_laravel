<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;

class FileController extends Controller
{
    public function index(){
        $files_data = File::all();
        return view('file',['files'=> $files_data]);
    }
}
