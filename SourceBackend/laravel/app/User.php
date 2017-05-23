<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Model{

	public $timestamps = false;
	
	public function prueba(){
		echo "sisas";
	}
        
}
