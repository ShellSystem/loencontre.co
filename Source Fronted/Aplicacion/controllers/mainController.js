class MainController {

  constructor() {
    var database = new Database();
    this.posts = database.posts;
  }
  
  setPosts(){
    for (var i in this.posts) {
      var post = this.posts[i];
      $("#thumbnails").append('<article>' +
        '<a class="thumbnail" href="images/fulls/'+post.image+'.jpg" data-position="center"><img src="images/thumbs/'+post.image+'.jpg" alt="" /></a>'+
        '<h2>'+post.date+'</h2>' +
        '<p><a href="https://www.facebook.com/photo.php?fbid='+post.link+'" target="_blank">Ir al post</a></p>' +
        '</article>');
    }
    
  }
  
}
var controller = new MainController();
controller.setPosts();