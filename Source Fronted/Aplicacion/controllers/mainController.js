class MainController {

  constructor() {
    this.init();

  }
  
  init(){
    $.ajax({
          dataType: "json",
          url: "http://entregascontinuas.goodfirmcolombia.co/get-page?pageNumber=1"
        }).done(function(data) {
          setPost(data);
        });

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
}


$(document).ready(function() {
  var controller = new MainController();
});