var app = angular.module('mainModule', ['ngFacebook']);

app.controller('controller',function($scope,$http,$facebook){
	//Metodo principal
	$scope.main = function () {
	    $scope.getOCRMicrosft($scope.img);
	    //var aux= $scope.img;
	    //console.log(aux.match(/blica$/));
	    $scope.l = $scope.img;
	};
	$scope.getOCRMicrosft = function (img){
		var data = {
			url: img
		}
		var param = {
			'language': 'spa',
			'detectOrientation': 'true'
		}
		var config = {
			headers : {
				'Content-Type': 'application/octet-stream ',
				'Ocp-Apim-Subscription-Key' : 'bfa235c067444a6a964cfa7045109e96'
			}
		}
		$scope.txtMicrosoft='extrayendo texto...';
		$http.post('https://api.projectoxford.ai/vision/v1.0/ocr?' + param, data, config)
		.success(function(data){
			var regions = data.regions;
			if(regions.length>0){ //verificando que existen regiones con texto y monnstrandolas
				$scope.lines = data.regions[0].lines;
				$scope.txtMicrosoft = '';
				var index = 0;
				$scope.lines.forEach(function(line){
					line.words.forEach(function(text){						
						if (index == 0){
							var str=text.text.toLowerCase().replace(' ','').replace(/\./g,'');
							$scope.txtMicrosoft =  str;
						} else {
							var str=text.text.toLowerCase().replace(' ','').replace(/\./g,'');
							$scope.txtMicrosoft =  $scope.txtMicrosoft + '-' + str;
						}
						index++;
					});
				});
				$scope.pln($scope.txtMicrosoft);
			} else {
				$scope.txtMicrosoft = 'no se ha podido identificar ni extraer el texto de la imagen';
			}
			
		})
		.error(function(err){
			console.log(err.message);
			$scope.txtMicrosoft = 'No se ha podido extraer el texto, error: '+err.message;
		})
	};
	
	$scope.pln = function (txt){
		//filtrando el texto  que ingresa
				var filterWords = txt.split('-');
				for (var i = filterWords.length - 1; i >= 0; i--) {
					if (filterWords[i].length<3||filterWords[i].match(/^upt/)||filterWords[i].match(/^univer/)||filterWords[i].match(/^hote/)||
						filterWords[i].match(/^compu/)||filterWords[i].match(/^edu/)||filterWords[i].match(/^matema/)||filterWords[i].match(/^elec/)||
						filterWords[i].match(/^peda/)||filterWords[i].match(/^natural/)||filterWords[i].match(/^enfermer/)||filterWords[i].match(/^profe/)||
						filterWords[i].match(/^agro/)||filterWords[i].match(/^huma/)||filterWords[i].match(/^estadis/)||filterWords[i].match(/^merca/)||
						filterWords[i].match(/^psico/)||filterWords[i].match(/^trans/)||filterWords[i].match(/^fisi/)||filterWords[i].match(/^bio/)||
						filterWords[i].match(/^extra/)||filterWords[i].match(/^pre/)||filterWords[i].match(/^econo/)||filterWords[i].match(/^cien/)||
						filterWords[i].match(/^zoo/)||filterWords[i].match(/^admin/)||filterWords[i].match(/^indus/)||filterWords[i].match(/^filo/)||
						filterWords[i].match(/^empre/)||filterWords[i].match(/^ambien/)||filterWords[i].match(/[0-9]/)||filterWords[i].match(/^geo/)||
						filterWords[i].match(/^finan/)||filterWords[i].match(/^comer/)||filterWords[i].match(/^tecn/)||filterWords[i].match(/^prod/)||
						filterWords[i].match(/^lic/)||filterWords[i].match(/gica/)||filterWords[i].match(/^aseso/)||filterWords[i].match(/fasis$/)||
						filterWords[i].match(/^mensa/)||filterWords[i].match(/ypțę/)||filterWords[i].match(/^cod/)||filterWords[i].match(/^sist/)||
						filterWords[i].match(/tunja/)||filterWords[i].match(/^ing/)||filterWords[i].match(/^www/)||filterWords[i].match(/cembia/)||
						filterWords[i].match(/^origi/)||filterWords[i].match(/ohmbu/)||filterWords[i].match(/del/)||filterWords[i].match(/acero/)||
						filterWords[i].match(/coo/)||filterWords[i].match(/vias/)||filterWords[i].match(/^derec/)||filterWords[i].match(/^socia/)||
						filterWords[i].match(/civil/)||filterWords[i].match(/^lengu/)||filterWords[i].match(/finanzas/)||filterWords[i].match(/^especia/)||
						filterWords[i].match(/idiomas/)||filterWords[i].match(/modernos/)||filterWords[i].match(/tc/)||filterWords[i].match(/minas/)||
						filterWords[i].match(/sica$/)||filterWords[i].match(/diseño/)||	filterWords[i].match(/sogamoso/)||filterWords[i].match(/^chiquin/)||
						filterWords[i].match(/t&tc/)||filterWords[i].match(/ñol$/)||filterWords[i].match(/ingles/)||filterWords[i].match(/duitama/)||
						filterWords[i].match(/medicina/)||filterWords[i].match(/^veteri/)||filterWords[i].match(/procesos/)||filterWords[i].match(/rccnol,igica/)||
						filterWords[i].match(/gestion/)||filterWords[i].match(/nuevo/)||filterWords[i].match(/chitaraqu/)||filterWords[i].match(/ląc/)||
						filterWords[i].match(/estudiante/)||filterWords[i].match(/semestre/)||filterWords[i].match(/valido/)||filterWords[i].match(/fcrfaaoos/)||
						filterWords[i].match(/sionau/)||filterWords[i].match(/ion/)||filterWords[i].match(/musica/)||filterWords[i].match(/atura$/)||
						filterWords[i].match(/qumca/)||filterWords[i].match(/имс/)||filterWords[i].match(/оамсо/)||filterWords[i].match(/аяманоо/)||
						filterWords[i].match(/соо/)||filterWords[i].match(/pe=iay/)||filterWords[i].match(/pcd@gógŕ•/)||filterWords[i].match(/^quimi/)||
						filterWords[i].match(/tuwa/)||filterWords[i].match(/p_țț_,/)||filterWords[i].match(/^colom/)||filterWords[i].match(/^coc/)||
						filterWords[i].match(/alta/)||filterWords[i].match(/^did/)||filterWords[i].match(/^bases/)||filterWords[i].match(/^servi/)||
						filterWords[i].match(/^turis/)||filterWords[i].match(/^conta/)||filterWords[i].match(/blica$/)||filterWords[i].match(/^inter/)||
						filterWords[i].match(/ticas$/)||filterWords[i].match(/ción$/)||filterWords[i].match(/^depor/)||filterWords[i].match(/^recre/)||
						filterWords[i].match(/nible$/)||filterWords[i].match(/^insta/)||filterWords[i].match(/^rede/)||filterWords[i].match(/^herra/)||
						filterWords[i].match(/^tele/)||filterWords[i].match(/^farma/)||filterWords[i].match(/ungvers'dad/)) { //el texto
						filterWords.splice(i, 1);
					}
				}
				$scope.filterMicrosoft = filterWords;
				$scope.probability(txt,filterWords);
	}

	$scope.probability = function(txtMicrosoft, txtFilter){
		var lengthMicrosoft = txtMicrosoft.split('-').length;
		var lengthFilter = txtFilter.length;
		var probability = 0.0;
		if(lengthFilter == 0){
			probability=0;
		} else if (lengthMicrosoft<=4 || lengthFilter<=4){
			probability+=0.85;
		} else if(lengthFilter<lengthMicrosoft){
			probability+=0.70;
		} else if(lengthFilter==lengthMicrosoft) {
			probability+=0.50;
		} else {
			probability+=0.30;
		}

		$scope.probabilityName = probability;
	}
});
