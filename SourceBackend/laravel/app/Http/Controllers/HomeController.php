<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use goodfirmLaravel\Http\Requests;

class MainController extends Controller{

     public function index(){
    	  $archivo = Storage::get('files/post.txt');
    }

    public function sisas(){
    	echo "sisas";
    }

   

}


