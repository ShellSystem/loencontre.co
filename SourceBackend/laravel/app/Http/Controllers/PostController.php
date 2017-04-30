<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use goodfirmLaravel\Http\Requests;
use App\Post;
use Validator;


class PostController extends Controller{

  public $postAmountPerPage = 6;
  
  public function searchName(Request $request){
    //return $request->input();
    $resultado = array();    
    if($request->name){
      $nombrePeticion = explode(' ', $request->name);
      $post = -1;
      $posts = Post::all();  
      foreach ($posts as $post){
        $nombre = $post->name;
        $palabras = explode(' ', $nombre); # Separa el nombre

        $cantidadCoincidencias = 0;
        for ($i=0; $i < sizeof($palabras); $i++) { # Recorre el arreglo con el nombre traido de la base de datos
          for($j=0; $j < sizeof($nombrePeticion); $j++){# Recorremos el nombre traido de la base de datos
            //print strtolower($nombrePeticion[$j]);
            if(strtolower($palabras[$i]) == strtolower($nombrePeticion[$j])){# comparamos los nombre en minuscula
              $cantidadCoincidencias ++;
            }
          } 
        } # Termina el recorrido
        if($cantidadCoincidencias == 1 && sizeof($nombrePeticion) == 1 || $cantidadCoincidencias == sizeof($nombrePeticion)){ # la peticion solo tiene un nombre y existe conicidencia de un nombre, o tiene mas de dos coincidencias
          array_push($resultado, $post);
        }
      }
      foreach($resultado as $post){
        $post->image = asset('/laravel/storage/app/images/'.$post->image);  
      }    
    }
    return json_encode($resultado);
  }
  
  public function addPost(Request $request){
    #return $request->input();    
    $return = array();
    if ($this->validation($request->input()) == 1){
      $post = new Post();
      $post->name = $request->name;
      $caracteresRechazados = array(",", ";", ".", ":", "_", "{", "}", "'", "?","¿", "¡", "´", ")", "(", "/", "&", "%", "$", "#", "!");//se hace un filtro al nombre del articulo para convertirlo en una ruta
      //$post->name = str_replace($caracteresRechazados, "", $post->name);
      $post->date = date('Y/m/d');
      $post->contact = $request->contact;
      //return json_encode($post->date);
      $imagen = $request->img;
      $nombreImagen = $imagen->getClientOriginalName();
      $rutaDestino = 'images'.'/'.$nombreImagen;
      $resultado = Storage::put($rutaDestino,file_get_contents($imagen));
      if($resultado){
          $post->image = $nombreImagen;
          
      }else{
        array_push($return, ["Error en la imagen"]);
      }  
      if(!$this->repeated($post->name)){# No hay un post con el mismo link
        $post->save();
        array_push($return, ['1']);
      }else{
        array_push($return, ['error' => 'Ya existe una publicacion con el mismo nombre']);  
      }
      
    }else{
      array_push($return, ($this->validation($request->input())));
      }
    return json_encode($return);
  }
  
  public function validation($post){    
    $imagenesPermitidas = 'jpg,jpeg,bmp,png,pdf,gif';
    $maximoTamanoImagen = 3000;
    $reglas = [             
     // 'img' => 'mimes:'.$imagenesPermitidas .'|max:'.$maximoTamanoImagen .'|required',
      'name' => 'required',
    //  'date' => 'required | date',      
      'contact' => 'required',      
    ];
    $mensajes = [  
      'required' => 'El campo :attribute no puede estar vacio',
      'alpha_dash' => 'El atributo :attribute contiene caracteres inaceptados',
      'date' => 'La fecha debe ser una fecha valida '
    ];
    $validator = Validator::make($post, $reglas, $mensajes);       
    if ($validator->fails()) {
      $errores = $validator->errors()->all();           
      return($errores);
    }
    else{
      return 1;
    }
  }
  
  public function addFromFile(){ # Agrega post desde un archivo plano
    $archivo = Storage::get('files/post.txt');
    $lineas = explode(';', $archivo); //Se separan las lineas
    
    $return = array();
    foreach ($lineas as $linea){
      if (strcmp($linea, "") !== 0){
        $response = $this->postValidation($linea);
        if ($response[0] == 1) { # Paso la validacion          
          $post = new Post();
          $post->name = $response[1]['name'];
          $post->image = $response[1]['image'];
          $post->date = $response[1]['date'];
          $post->contact = $response[1]['contact'];

          if(!$this->repeated($post->name)){# No hay un post con el mismo link
            $post->save();
            array_push($return, 1);
          }else{
            array_push($return, ['error' => 'Ya existe una publicacion con el mismo nombre']);  
          }
        }else{
          array_push($return, $response[1]);
        }

      }

    }

    return json_encode($return);
    
  }

  public function repeated($name){// Determina si un post está guardado
    $post = null;
    $post = Post::where('name', $name)->first();       
    if(is_null($post)){//no existe el post
            return false;
    }else{
            return true;
    }
  }
  
  public function postValidation($linea){#valida cuando se agrega por archivo
    $campos = explode(',', $linea); //Se separan los campos
    
    if (sizeof($campos) > 1){
      $post['name'] = explode(':', $campos[0])[1]; // name
      $post['image'] = explode(':', $campos[1])[1]; // image
      $post['date'] = explode(':', $campos[2])[1]; // date
      $post['contact'] = explode(':', $campos[3])[1]; // contact
    }else{
      $post['name'] = "";
      $post['image'] = "";
      $post['date'] = "";
      $post['contact'] = "";
    }
    
    $reglas = [                 
      'name' => 'required | alpha_dash',
      'image' => 'required',
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
          $posts[$i]->image = asset('/laravel/storage/app/images/'.$posts[$i]->image);
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


  public function dateRange(Request $request){
    $validation = ($this->validarFechas($request)); #Prueba unitaria
    $dateCurrent = str_replace("-","/",date('Y-m-d')); 
    //return json_encode([$dateCurrent.' - '.$request->startRange.' - '.$request->endRange]); 
    if ($validation == 1) {
      $startRange = $request->startRange;
      $endRange = $request->endRange;
      if ($endRange >= $startRange && $startRange <= $dateCurrent && $endRange <= $dateCurrent) { #prueba unitaria
        $posts = Post::whereBetween('date', [$startRange, $endRange])->orderBy('date', 'desc')->get();
        
        for ($i=0; $i < sizeof($posts); $i++) { 
          $posts[$i]->image = asset('/laravel/storage/app/images/'.$posts[$i]->image);
        }
        
        
        return json_encode($posts);  
      }else {
        return json_encode(['La fecha final debe ser mayor a la fecha inicial. Y la fecha inicial y final deben ser menores o iguales a la fecha actual.']);  
      }
    }else{
      return json_encode($validation);
    }
  }

  public function validarFechas(Request $request){ # Se usa para validar los parametros para filtrar los posts que existan un rango de fechas
    $reglas = [                 
      'startRange' => 'required | date',
      'endRange' => 'required | date'     
    ];
    $mensajes = [  
      'required' => 'Parrametro :attribute requerido',
      'date' => 'Parrametro :attribute no valido'
    ];
    $validator = Validator::make($request->input(), $reglas, $mensajes);       
    if ($validator->fails()) {
      $errores = $validator->errors()->all();           
      return([$errores]);
    }
    else{
      return 1;
    }
  }
  


}


