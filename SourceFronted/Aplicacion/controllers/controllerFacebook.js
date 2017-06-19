// ###########################################################
// Id grupo "UPTC"
// ###########################################################
var idGroup = 5347104545 


// ###########################################################
// Id grupo "info. ing. de sistemas y computación (I.S.C)"
// ###########################################################
// var idGroup = 160626413991175 

var members = new Array();
var candidates = new Array();
var selected = new Array();
var name = new Array();
var combinationsName = new Array();
var nameDetect;


// ###########################################################
// Activacion de la conexion con la cuenta de facebook
// ###########################################################
function newPostAction(){
  FB.getLoginStatus(function(response) {
    loginStatusVerificate(response);
  });
}

// ###########################################################
// Extraccion de datos del usuario de la cuenta de facebook
// ###########################################################
function loginStatusVerificate(response){
  if(response.status != 'conected'){    
    FB.login(function(response) {
      if(response.status = 'connected'){
        FB.api('/me?fields=id,name,email', function(response) {
          if(response.email != ''){ 
            $.showLoading("Conectado con facebook")
            getOCRMicrosft(response);
          }else{
            $.showNotify('Error', 'Error obtener datos de usuario desde facebook. Intente de nuevo', 'error');
          }

        });
      }else{
        $.showNotify('Error', 'Error al iniciar sesión con facebook', 'error');
      }

    });
  }else{
    $.showNotify('Error', 'No se pudo conectar con facebook', 'error');
  }
}


// ###########################################################
// Desconexion de la cuenta de facebook
// ###########################################################
function exitFacebook(){
  FB.logout(function(response) {
   $.showLoading("Sesion de facebook cerrada");
 });
}


// ###########################################################
// Obtencion de miembros del grupo de facebook mediante DB
// ###########################################################
function getMembersFacebook (name) {
  nameDetect = name;
  $.showLoading('Obteniendo miembros ...');
  loadAllDB('members');
};



// ###########################################################
// Obtencion de miembros del grupo de facebook mediante API
// ###########################################################
function refresh(after) {
  FB.api(
    '/'+idGroup+'/members','GET',{'fields':'name,link,picture.type(large)','limit':'1000','after':after},
    function(response) {
      if (response && !response.error) {
        members = members.concat(response.data);
        try {
          refresh(response.paging.cursors.after);
          $.showLoading('Numero de miembros: ' + members.length);
        }
        catch(e){
          saveDB('members', members);
          $.showLoading('Clasificando por nombre ...');
          classifierMembersFacebookName(nameDetect);
        }
      }
    }
    );
};


// ###########################################################
// Clasificacion de miembros del grupo de facebook por nombre
// ###########################################################
function classifierMembersFacebookName (nameDetect) {
  combinationsName = combinations(nameDetect);
  for (var i = members.length - 1; i >= 0; i--) {
    for (var j = combinationsName.length - 1; j >= 0; j--) {
      if(cleanString(members[i].name) == cleanString(combinationsName[j]))
      {
        members[i].state = 'Activo';
        candidates.push(members[i]);
        break;
      }
    }
  }
  $.showNotify('Candidatos', 'Se encontraron '+ candidates.length + ' candidatos.', 'success');
  console.log('Candidatos: ');
  console.log(candidates);
  if (candidates.length == 0) {
    makePost();
  }
  else if (candidates.length == 1) {
    selected.push(candidates[0]);
    makePost();
  }else{
    $.showLoading('Clasificando por foto de perfil ...');
    classifierMembersFacebookPicture();
  }
};


