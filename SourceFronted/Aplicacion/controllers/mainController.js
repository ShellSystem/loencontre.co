class MainController {

  constructor() {
    this.initData();
    $("#name").css("display", "none");
    $("#probability").css("display", "none");
  }
  
  initData(){
    firtTime();
    $.ajax({
      dataType: "json",
      url: "https://entregascontinuas.goodfirmcolombia.co/pagination"
    }).done(function(pages) {
      $('#pagination-here').bootpag({
        total: pages.pageAmount
      }).on("page", function(event, num){
        $.ajax({
          dataType: "json",
          url: "https://entregascontinuas.goodfirmcolombia.co/get-page?pageNumber="+num
        }).done(function(data) {
          setPost(data);
        });
      });
    });
    return true;
  }  
}

function setPost(data) {
  $("#thumbnails").html('');
  for (var i in data) {
    var post = data[i];
    //console.log(post);
    var fecha = new Date(post.date);
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    $("#thumbnails").append('<article>' +
      '<a class="thumbnail" href="'+post.image+'" data-position="center"><img src="'+post.image+'" alt="" /></a>'+
      '<h2>'+fecha.toLocaleDateString("es-ES", options)+'</h2>' +
     // '<p><a id="post" href="https://www.facebook.com/photo.php?fbid='+post.link+'" target="_blank">'+$.i18n._('post')+'</a></p>' +
      '<p><h1 id="extractContact" hidden="true" >'+post.contact+'</h1></p>' +
      '<p><button id="bottomContact" onclick="openModalContact();">Contacto</button></p>' +
     // '<p><a href="#ex1" rel="modal:open">Open Modal</a></p>' +
      //'<input type="hidden" name="contact" value="'+post.coctact+'">' +
      '</article>');
    
  }
  main.init();
  return true;
}

function openModalContact(post){
  parent.location='#miModalContact';
  $(document).ready(function() {
    $('#textContact').text($('#extractContact').text());
});
  
}

function firtTime() {
  $.ajax({
    dataType: "json",
    url: "https://entregascontinuas.goodfirmcolombia.co/get-page?pageNumber=1"
  }).done(function(data) {
    setPost(data);
  });

  return true;
}

function newPost(txtFilter) {
  var post = {};
  post.contact = $("#contact").val();
  var d = new Date();
  post.date = d.toString();
  post.img = $('#img').get(0).files[0];
  post.text = txtFilter;
  
  $("#name").val(txtFilter);
  
  post = new FormData($("#new")[0]);
  //post = new FormData(post);
  //console.log(post);  
  $.ajax({
   type: "POST",
   url: "https://entregascontinuas.goodfirmcolombia.co/add-post",
   data: post,
   contentType: false,
   processData: false
 })
  .done(function(data)
  {
    console.log(data)
    console.log("Publicado");
    firtTime();
  })
  .fail(function(err){
    console.log(err);
  });
}

function newSearchName() {
  search = $("#search_input").val();
  console.log(search);
  $.ajax({
   type: "POST",
   url: "https://entregascontinuas.goodfirmcolombia.co/search-name?name=" + search,
   data: search,
   dataType: "json"
 })
  .done(function(data)
  {
    console.log(data);
    setPost(data);
  })
  .fail(function(err){
    console.log("error");
    console.log(err.responseText);
    });
}

function newSearchDate() {
  startRange = $("#startRange").val();
  endRange = $("#endRange").val();
  console.log(startRange);
  console.log(endRange);
  $.ajax({
    dataType: "json",
    url: "https://entregascontinuas.goodfirmcolombia.co/date-range?startRange",
    data : {startRange : startRange, endRange : endRange}
  })
  .done(function(data)
  {
    if (data[0] == 'La fecha final debe ser mayor a la fecha inicial') {
      $('#message_error_date').html(data[0]);
    }else{
      $('#message_error_date').html("");
      console.log(data);
      setPost(data);
    }
  })
  .fail(function(err){
    console.log(err);
  });
}

function archivo(evt) {
  var files = evt.target.files; 
  for (var i = 0, f; f = files[i]; i++) {         
           //Solo admitimos imágenes.
           if (!f.type.match('image.*')) {
            continue;
          }

          var reader = new FileReader();

          reader.onload = (function(theFile) {
           return function(e) {
               // Creamos la imagen.
               document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
             };
           })(f);

           reader.readAsDataURL(f);
         }
       }

       document.getElementById('img').addEventListener('change', archivo, false);

       function getOCRMicrosft(){
        img = $('#img').get(0).files[0];
        params = {
          'language': 'es',
          'detectOrientation': 'true',
        };
        $.ajax({
         type: 'POST',
         url: 'https://westus.api.cognitive.microsoft.com/vision/v1.0/ocr?' + $.param(params),
         data: img,
         beforeSend: function(xhrObj){
  // Request headers
  xhrObj.setRequestHeader("Content-Type","application/octet-stream");
  xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","bfa235c067444a6a964cfa7045109e96");
},
processData: false
})
        .done(function(data)
        {
          regions = data.regions;
      if(regions.length>0){ //verificando que existen regiones con texto y monnstrandolas
        lines = data.regions[0].lines;
        txtMicrosoft = '';
        index = 0;
        lines.forEach(function(line){
          line.words.forEach(function(text){            
            if (index == 0){
              str=text.text.toLowerCase().replace(' ','').replace(/\./g,'');
              txtMicrosoft =  str;
            } else {
              str=text.text.toLowerCase().replace(' ','').replace(/\./g,'');
              txtMicrosoft = txtMicrosoft + '-' + str;
            }
            index++;
          });
        });
        txtFilter = pln(txtMicrosoft);
        var name = "";
        for (var index = 0; index < txtFilter.filterText.length; index++) {
         name = name + " " + txtFilter.filterText[index];
       }
       newPost(name);
       document.getElementById("close").click();
       document.getElementById("new").reset();
       document.getElementById("list").innerHTML = "";
     } else {
       console.log('Error');
     }
   })
        .fail(function(err){
          console.log(err);
        });
      }

      function pln(txt){
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
        filterWords[i].match(/sica$/)||filterWords[i].match(/diseño/)|| filterWords[i].match(/sogamoso/)||filterWords[i].match(/^chiquin/)||
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
var data = {}
data.filterText = filterWords;
data.probability = probability(txt,filterWords);
return data;
}

function probability(txtMicrosoft, txtFilter){
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

  return probability;
}



var controller = new MainController()
//test(controller);

function test(controller) {
  var countPass = 0;
  var countNoPass = 0;

//TEST 1
if(controller){
  console.log("Pass - Instancia controlador principal");
  countPass++;
}
else{
  console.log("No Pass - Instancia controlador principal"); 
  countNoPass++;
}

//TEST 2
if(controller.initData()){
  console.log("Pass - Inicializacion paginacion");
  countPass++;
}
else{
  console.log("No Pass - Inicializacion paginacion"); 
  countNoPass++;
}

//TEST 3
if(setPost("")){
  console.log("Pass - Renderizado post");
  countPass++;
}
else{
  console.log("No Pass - Renderizado post"); 
  countNoPass++;
}

//TEST 4
if(firtTime()){
  console.log("Pass - Inicializacion datos index");
  countPass++;
}
else{
  console.log("No Pass - Inicializacion datos index"); 
  countNoPass++;
}

console.log("Units Pass: " + countPass);
console.log("Units No Pass: " + countNoPass);
console.log("Units Evaluate: " + (countPass + countNoPass));
}
