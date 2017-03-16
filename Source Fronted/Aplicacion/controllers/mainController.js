class MainController {

  constructor() {
    this.initData();
  }
  
  initData(){
    firtTime();

    $.ajax({
      dataType: "json",
      url: "http://entregascontinuas.goodfirmcolombia.co/pagination"
    }).done(function(pages) {
      $('#pagination-here').bootpag({
        total: pages.pageAmount
      }).on("page", function(event, num){
        $.ajax({
          dataType: "json",
          url: "http://entregascontinuas.goodfirmcolombia.co/get-page?pageNumber="+num
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
    $("#thumbnails").append('<article>' +
      '<a class="thumbnail" href="'+post.image+'" data-position="center"><img src="'+post.image+'" alt="" /></a>'+
      '<h2>'+post.date+'</h2>' +
      '<p><a href="https://www.facebook.com/photo.php?fbid='+post.link+'" target="_blank">Ir al post</a></p>' +
      '</article>');
  }
  return true;
}

function firtTime() {
  $.ajax({
          dataType: "json",
          url: "http://entregascontinuas.goodfirmcolombia.co/get-page?pageNumber=1"
        }).done(function(data) {
          setPost(data);
        });

    return true;
}



var controller = new MainController()

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