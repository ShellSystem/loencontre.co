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
      $.ajax({
        dataType: "json",
        url: base + "loencontre.co/SourceBackend/get-page?pageNumber="+pageNumber
      }).done(function(data) {
        setPostLoad(data);
      }); 
    }
  });
}
