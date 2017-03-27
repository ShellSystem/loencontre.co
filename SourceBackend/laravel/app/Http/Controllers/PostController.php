<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use goodfirmLaravel\Http\Requests;
use App\Post;
use Validator;

class PostController extends Controller{

  public $postAmountPerPage = 6;
  
  public function addFromFile(){
    $archivo = Storage::get('files/post.txt');
    $lineas = explode(';', $archivo); //Se separan las lineas
    
    $return = array();
    foreach ($lineas as $linea){
      if (strcmp($linea, "") !== 0){
        $response = $this->postValidation($linea);
        if ($response[0] == 1) { # Paso la validacion          
          $post = new Post();
          $post->link = $response[1]['link'];
          $post->image = $response[1]['image'];
          $post->date = $response[1]['date'];

          if(!$this->repeated($post->link)){# No hay un post con el mismo link
            $post->save();
            array_push($return, 1);
          }else{
            array_push($return, ['error' => 'Ya existe un articulo con el mismo link']);  
          }
        }else{
          array_push($return, $response[1]);
        }

      }

    }

    return json_encode($return);
    
  }

  public function repeated($link){
    $post = null;
    $post = Post::where('link', $link)->first();       
    if(is_null($post)){//no existe el post
            return false;
    }else{
            return true;
    }
  }
  
  public function postValidation($linea){
    $campos = explode(',', $linea); //Se separan los campos
    
    if (sizeof($campos) > 1){
      $post['link'] = explode(':', $campos[0])[1]; // link
      $post['image'] = explode(':', $campos[1])[1]; // image
      $post['date'] = explode(':', $campos[2])[1]; // date
    }else{
      $post['link'] = "";
      $post['image'] = "";
      $post['date'] = "";
    }
    
    $reglas = [                 
      'link' => 'required | alpha_dash',
      'image' => 'required | alpha_dash',
      'date' => 'required | date',      
    ];
    $mensajes = [  
      'required' => 'El campo :attribute no puede estar vacio',
      'alpha_dash' => 'El atributo :attribute contiene caracteres inaceptados',
      'date' => 'La fecha debe ser una fecha valida '
    ];
    $validator = Validator::make($post, $reglas, $mensajes);       
    if ($validator->fails()) {
      $errores = $validator->errors()->all();           
      return([-1, $errores]);
    }
    else{
      return [1, $post];
    }
  }
  
  public function getPage(Request $request){   
    #return  json_encode($request->input());
    if ($request->pageNumber){
     
      #$posts = Post::all()->sortByDesc('Date'); # Pide todos los posts a la base de datos
      $posts = Post::orderBy('date', 'desc')->get();
      
      $amount = (int)(sizeof($posts) / $this->postAmountPerPage); # Cantidad  de paginas
      if((sizeof($posts) % $this->postAmountPerPage) > 0){ #Numero decimal
        $amount += 1;
      }      
      
      if ($request->pageNumber > $amount || $request->pageNumber < 0){ # error
        return json_encode(['error' => 'Pagina fuera de rango']);
      }else{      
        $begin = (($request->pageNumber -1) * $this->postAmountPerPage);  #e El numero del post que va de primero en la pagina
        $return = array();
        for ($i=$begin; $i < sizeof($posts); $i++) { 
          if( $i == ($this->postAmountPerPage + $begin)){ # Se completa la cantidad de post para la pagina
            break;
          }
          $posts[$i]->image = asset('/laravel/storage/app/images/'.$posts[$i]->image.".jpg");
          array_push($return, $posts[$i]);
        }
        return json_encode($return);
      }
    }else{
      return json_encode(['error' => 'No se ha encontrado un parámetro correcto']);
    }
  }

  public function pagination(){
    $posts = Post::all();
    $amount = (int)(sizeof($posts) / $this->postAmountPerPage); # Cantidad  de paginas
    if((sizeof($posts) % $this->postAmountPerPage) > 0){ #Numero decimal
      $amount += 1;
    }

    return json_encode(['pageAmount' => $amount]);
  }
  


}


