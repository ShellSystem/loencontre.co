

class MainController {
  
  constructor() {
    var database = new Database();
    this.posts = database.posts;
  }
  
  setPosts(){
    $("#thumbnails").append('<article>' +
							'<a class="thumbnail" href="images/fulls/01.jpg" data-position="left center"><img src="images/thumbs/01.jpg" alt="" /></a>'+
							'<h2>Diam tempus accumsan</h2>' +
							'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>' +
						'</article>');
  }
  
}
var controller = new MainController();
var image = controller.posts[1].image;
$("#header").append("<h1>" + image + "sisas</h1>");
controller.setPosts();