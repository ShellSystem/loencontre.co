
// ###########################################################
// Metodo donde se buscara cuales son los post del usuario que ha dado click 
// y retornar las publicaciones encontradas
// ###########################################################
function confirmPosts(){
  $.showLoading("Conectando con Facebook...")
  FB.getLoginStatus(function(response) {
    loginStatusVerificatePost(response);
  });
}

// ###########################################################
// Extraccion de datos del usuario de la cuenta de facebook para 
// extraer posts
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
// Busqueda por nombre
// ###########################################################
function newSearchName() {
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
