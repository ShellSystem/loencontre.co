// ###########################################################
// Muestra notificacion, titulo, texto, tipo
// ###########################################################
$.showNotify = function($title, $text, $style, $position) {
  if($style == "error"){
    $icon = "fa fa-exclamation";
  }else if($style == "warning"){
    $icon = "fa fa-warning";
  }else if($style == "success"){
    $icon = "fa fa-check";
  }else if($style == "info"){
    $icon = "fa fa-question";
  }else{
    $icon = "fa fa-circle-o";
  }
  $.notify({
    title: $title,
    text: $text,
    image: "<i class='"+$icon+"'></i>"
  }, {
    style: 'metro',
    className: $style,
    globalPosition:$position,
    showAnimation: "show",
    showDuration: 0,
    hideDuration: 0,
    autoHideDelay: 15000,
    autoHide: true,
    clickToHide: true
  });
}


// ###########################################################
// texto a mostrar en el mnsje, metodo si le da click a si, y los parametros
//que tendria el meotod,y el estilo de la notifcacion
// ###########################################################
$.showConfirm = function($text, $method, $parameterMethod, $style){
  $style || ( $style = 'warning' );

  if($style == "error"){
    $icon = "fa fa-exclamation";
  }else if($style == "warning"){
    $icon = "fa fa-warning";
  }else if($style == "success"){
    $icon = "fa fa-check";
  }else if($style == "info"){
    $icon = "fa fa-question";
  }else{
    $icon = "fa fa-circle-o";
  }

  $.notify({
    title: '¿Esta seguro?',
    text: $text+'<div class="clearfix"></div><br><button onclick="'+$method+'('+$parameterMethod+'); return false" class="notify__hidden">Sí</button> <button class="notify__hidden">No</button>',
    image: "<i class='"+$icon+"'></i>"
  }, {
    style: 'metro',
    className: $style,
    showAnimation: "show",
    showDuration: 0,
    hideDuration: 0,
    autoHideDelay: 15000,
    autoHide: true,
    clickToHide: true
  });
}


// ###########################################################
// Muestra animacion de carga
// ###########################################################
$.showLoading = function($text){
  $('body').css('overflow','hidden');
  $('.popup__loading').addClass('active');
  $.showNotify('Estado', $text, 'info');
}


// ###########################################################
// Oculta animacion de carga
// ###########################################################
$.hiddenLoading = function(){
  $('body').css('overflow','auto');
  $('.popup__loading').removeClass('active');
}
