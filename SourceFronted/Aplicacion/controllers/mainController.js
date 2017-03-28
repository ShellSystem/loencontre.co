class MainController {

  constructor() {
    this.initData();
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
    $("#thumbnails").append('<article>' +
      '<a class="thumbnail" href="'+post.image+'" data-position="center"><img src="'+post.image+'" alt="" /></a>'+
      '<h2>'+post.date+'</h2>' +
      '<p><a id="post" href="https://www.facebook.com/photo.php?fbid='+post.link+'" target="_blank">'+$.i18n._('post')+'</a></p>' +
      '</article>');
  }
  main.init();
  return true;
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

function newPost() {
  var post = {};
  post.img = $("#new")[0];
  post.contact = $("#contact").val();
  var d = new Date();
  post.data = d.toString();
  console.log(post);
  // Obtener texto y probabilidad luego agregarlo al data que sera enviado al server
  // post.ocr = ocr(img);
 //  $.ajax({
 //   type: "POST",
 //   url: "https://entregascontinuas.goodfirmcolombia.co/",
 //   data: post,
 //   success: function(data)
 //   {
 //      // Avisar al usuario que la publicación se hizo con exito
 //      alert("Publicado");
 //   }
 // });
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
