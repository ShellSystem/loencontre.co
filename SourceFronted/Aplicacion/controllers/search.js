var lazyload = true;

// ###########################################################
// Metodo donde se buscara cuales son los post del usuario
// que ha dado click y retornar las publicaciones encontradas
// ###########################################################
function confirmPosts(){
  lazyload = false;
  $.showLoading("Conectando con Facebook...");
  FB.getLoginStatus(function(response) {
    loginStatusVerificatePost(response);
  });
}


// ###########################################################
// Extraccion de datos del usuario de la cuenta de facebook
// para extraer posts
// ###########################################################
function loginStatusVerificatePost(response){
  if(response.status != 'conected'){    
    FB.login(function(response) {
      if(response.status = 'connected'){
        FB.api('/me?fields=id,name,email', function(response) {
          if(response.email != ''){
              id = response.id;
              $.hiddenLoading();
              $.showNotify('Conexión correcta', response.name, 'success');
              $.showLoading("Cargando publicaciones");
              //console.log("ID obtenido:"+response.id)
              //llamado api
              $.ajax({
                  type: "POST",
                  url: base + "loencontre.co/SourceBackend/user-posts?id=" + id,
                  data: id,
                  dataType: "json"
              })
              .done(function(response) {
                  $.hiddenLoading()
                  if(response.status == 'success'){
                      data = response.data;
                      if(data.length == 0){
                          $.showNotify('Sin resultados', 'No se encontraron coincidencias', 'error');
                      } else if(data.length == 1) {
                          $.showNotify('Busqueda completada', 'Se encontro '+data.length+' coincidencia', 'success');
                          setPostAfterId(data);
                          $.showNotify('Ayuda', 'Oprima sobre la publicación que ha entregado','info');
                      } else {
                          $.showNotify('Busqueda completada', 'Se encontraron '+data.length+' coincidencias', 'success');
                          setPostAfterId(data);
                          $.showNotify('Ayuda', 'Oprima sobre la publicación que ha entregado','info');
                      }
                  } else {
                      responseB = response.data;
                      if(responseB == 'Incorrect parameter'){
                          $.showNotify('Error', 'Ocurrió un error en la busqueda, intente mas tarde.', 'error');
                      }
                  }
              })
              .fail(function(err){
                  $.hiddenLoading()
                  $.showNotify('Error', 'Ocurrió un error en la busqueda, intente mas tarde.', 'error');
              });
          }else{
            $.hiddenLoading()
            $.showNotify('Error', 'Error obtener datos de usuario desde facebook. Intente de nuevo', 'error');
          }
        });
      }else{
        $.hiddenLoading();
        $.showNotify('Error', 'Error al iniciar sesión con facebook', 'error');
      }
    });
  }else{
    $.hiddenLoading();
    $.showNotify('Error', 'No se pudo conectar con facebook', 'error');
  }
}


// ###########################################################
// Pintado de publicaciones luego de una busqueda
// ###########################################################
function setPostAfterId(data) {
  $("#main").html("");
  for (var i in data) {
    var post = data[i];
    var fecha = new Date(post.date);
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    addPostId(post, options, fecha)
  }
  setMain();
  return true;
}


// ###########################################################
// Creacion de elemento individual para cada publicacion
// ###########################################################
function addPostId(post, options, fecha){
    $("#main").append('<article class="thumb">' +
      '<a class="image" onclick="confirmDelivery('+post.id+'); return false"><img src="'+post.image+'" alt="" /></a>'+
      '<h2>'+fecha.toLocaleDateString("es-ES", options)+'</h2>' +
      '</article>'); 
}


// ###########################################################
// Metodo encargadao de recibir el id del post y enviar
// una petición al servidor para el cambio de estado de dicha publicación
// ###########################################################
function confirmDelivery(idPost){
  $.showConfirm("La publicación se reportará como entregada", "changeState", idPost,"info");
}

function changeState(idPost){
  $.showLoading("Cambiando estado de publicación a Entregado");
  $.ajax({
    type: "POST",
    url: base + "loencontre.co/SourceBackend/change-state?id=" + idPost,
    data: idPost,
    dataType: "json"
  })
  .done(function(response) {
    $.hiddenLoading();
    $.showNotify('Correcto', 'Se ha cambiado el estado a Entregado', 'success');
    $.showLoading("Cargando publicaciones");
    //console.log("ID obtenido:"+response.id)
    //llamado api
    $.ajax({
      type: "POST",
      url: base + "loencontre.co/SourceBackend/user-posts?id=" + id,
      data: id,
      dataType: "json"
    })
    .done(function(response) {
      $.hiddenLoading()
      if(response.status == 'success'){
        data = response.data;
        if(data.length == 0){
          $.showNotify('Reporte completado', '¡Ya no te quedan más carnés por entregar!', 'success');
          
        } else {
          $.showNotify('Reporte completado', '¡Aún te quedan '+data.length+' por entregar', 'success');
          setPostAfterId(data);
        }
      } else {
        responseB = response.data;
        if(responseB == 'Incorrect parameter'){
          $.showNotify('Error', 'Ocurrió un error en el reporte del carné, intente mas tarde.', 'error');
          }     
      }
      })
      .fail(function(err){
        $.hiddenLoading();
        $.showNotify('Error', 'Ocurrió un error en el reporte del carné, intente mas tarde.', 'error');
        
      });
  })
  .fail(function(err){
    $.hiddenLoading();
    $.showNotify('Error', 'Ocurrió un error al buscar el post, intente mas tarde.', 'error');
  });
}


// ###########################################################
// Busqueda por nombre
// ###########################################################
function newSearchName() {
  lazyload = false;
  search = $("#search_input").val();
  $.showLoading("Realizando búsqueda por nombre")
  $.ajax({
   type: "POST",
   url: base + "loencontre.co/SourceBackend/search-name?name=" + search,
   data: search,
   dataType: "json"
 })
  .done(function(response)
  {
    if(response.status == 'success'){
      data = response.data;
      if(data.length == 0){
        $.showNotify('Sin resultados', 'No se encontraron coincidencias', 'error');
      } else if(data.length == 1) {
        $.showNotify('Busqueda completada', 'Se encontro '+data.length+' coincidencia', 'success');
        setPostAfter(data);
      } else {
       $.showNotify('Busqueda completada', 'Se encontraron '+data.length+' coincidencias', 'success');
       setPostAfter(data);
     }
   } else {
    responseB = response.data;
    if(responseB == 'Incorrect parameter'){
      $.showNotify('Error', 'Ocurrió un error en la busqueda, intente mas tarde.', 'error');
    }
  }
  $.hiddenLoading()
})
  .fail(function(err){
    $.showNotify('Error', 'Ocurrió un error en la busqueda, intente mas tarde.', 'error');
    $.hiddenLoading()
  });
}


// ###########################################################
// Busqueda por fecha
// ###########################################################
function newSearchDate() {
  lazyload = false;
  startRange = $("#startRange").val();
  endRange = $("#endRange").val();
  $.ajax({
    dataType: "json",
    url: base + "loencontre.co/SourceBackend/date-range?startRange",
    data : {startRange : startRange, endRange : endRange}
  })
  .done(function(response)
  {
    if(response.status == 'success'){
      data = response.data;

      if (data[0] == 'La fecha final debe ser mayor a la fecha inicial. Y la fecha inicial y final deben ser menores o iguales a la fecha actual.') {
       $.showNotify('Error', data[0], 'error');      
     }else if(data.length == 0){
      $.showNotify('Sin resultados', 'No se encontraron coincidencias', 'error');
    } else if(data.length == 1) {
      $.showNotify('Busqueda completada', 'Se encontro '+data.length+' coincidencia', 'success');
      setPostAfter(data);
    } else {
     $.showNotify('Busqueda completada', 'Se encontraron '+data.length+' coincidencias', 'success');
     setPostAfter(data);
   }

 }else{
  $.showNotify('Error', 'Ocurrió un error en la busqueda, intente mas tarde.', 'error');
}
})
  .fail(function(err){
    $.showNotify('Error', 'Ocurrió un error en la busqueda, intente mas tarde.', 'error');
  });
}
