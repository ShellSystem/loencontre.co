// ###########################################################
// Numero de pagina actual
// ###########################################################
var pageNumber = 1;


// ###########################################################
// Deteccion del borde inferior
// ###########################################################
$(function () {
  var $win = $(window); 
  $win.scroll(function () {
    if (lazyload)
      if ($win.height() + $win.scrollTop() == $(document).height())
        load();
  });
});


// ###########################################################
// Carga de nueva pagina de publicaciones
// ###########################################################
function load() {
  pageNumber++;
  $.ajax({
    dataType: "json",
    url: base + "loencontre.co/SourceBackend/pagination"
  }).done(function(data) {
    if (data.pageAmount>=pageNumber) {
      $.showNotify('Información', 'Cargando publicaciones...', 'info');
      $.ajax({
        dataType: "json",
        url: base + "loencontre.co/SourceBackend/get-page?pageNumber="+pageNumber
      }).done(function(data) {
        setPostLoad(data);
      }); 
    } else {
      $.showNotify('Alerta', 'Ya no quedan más publicaciones por mostrar', 'error');
    }
  });
}


// ###########################################################
// Pintado de publiaciones para lazyload
// ###########################################################
function setPostLoad(data) {
  for (var i in data) {
    var post = data[i];
    var fecha = new Date(post.date);
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    addPost(post, options, fecha)
  }
  setMain();
  return true;
}
