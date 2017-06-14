var pageNumber = 1;

function load() {
  pageNumber++;
  console.log(pageNumber);
  $.ajax({
    dataType: "json",
    url: base + "loencontre.co/SourceBackend/get-page?pageNumber="+pageNumber
  }).done(function(data) {
    setPostLoad(data);
  }); 
}

$(function () {
 var $win = $(window);
 
 $win.scroll(function () {
  if ($win.height() + $win.scrollTop() == $(document).height()){
    load();
  }
});
});
