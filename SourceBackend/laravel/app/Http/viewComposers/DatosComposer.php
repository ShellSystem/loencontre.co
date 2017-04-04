<?php 

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Category;
use App\Article;
use App\Area;
use App\Service;

class DatosComposer{

	public function compose(View $view){
		$categorias = Category::all();
		$arregloCategorias = array();
		foreach ($categorias as $categoria) {
			$articulos = Article::where('category_id', $categoria->id)->orderBy('id', 'desc')->get();
			$arregloArticulos = array();
			foreach ($articulos as $articulo) {
				$ruta = asset('home/articulo/'.$articulo->ruta);
				array_push($arregloArticulos, ['id' => $articulo->id, 'titulo' => $articulo->titulo, 'ruta' => $ruta]);
			}
			array_push($arregloCategorias, ['id' => $categoria->id, 'nombre' => $categoria->nombre, 'articulos' => $arregloArticulos]);
		}

		$areas = Area::all();
		$arregloAreas = array();
		foreach ($areas as $area) {
			$servicios = Service::where('area_id', $area->id)->get();
			$arregloServicios = array();
			foreach ($servicios as $servicio) {
				$ruta = asset('home/servicios/'.$servicio->ruta);
				array_push($arregloServicios, ['id' => $servicio->id, 'nombre' => $servicio->nombre, 'ruta' => $ruta]);
			}
			array_push($arregloAreas, ['id' => $area->id, 'nombre' => $area->nombre, 'servicios' => $arregloServicios]);
		}
		$view->with(['categorias' => $arregloCategorias, 'areas' => $arregloAreas]);
	}

}

 ?>