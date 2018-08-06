// ###########################################################
// User facebook conectado
// ###########################################################
var userConnected;
// ###########################################################
// User facebook conectado
// ###########################################################
var name = "";
// ###########################################################
// Nueva publicacion
// ###########################################################
function newPost(txtFilter, user) {
    $.showLoading("Enviando publicación...")
    if (txtFilter.length == 0) {
        txtFilter = 'NN';
    }
    var post = {};
    post.contact = $("#contact").val();
    var d = new Date();
    post.date = d.toString();
    post.img = $('#img').get(0).files[0];
    post.text = txtFilter;
    $("#name").val(txtFilter);
    $("#user_id").val(user.id);
    $("#user_name").val(user.name);
    $("#user_email").val(user.email);
    post = new FormData($("#new")[0]);
    console.log(post);
    $.ajax({
        type: "POST",
        url: base + "loencontre/SourceBackend/add-post",
        data: post,
        contentType: false,
        processData: false
    }).done(function(response) {
        response = JSON.parse(response);
        data = response.data;
        if (response.status == 'success') {
            $.showNotify('Publicación exitosa', 'El carné fue publicado', 'success');
            resetForm();
            firtTime();
        } else {
            $.showNotify('Error', data, 'error');
        }
        $.hiddenLoading()
    }).fail(function(err) {
        $.showNotify('Error', 'Ocurrió un error al publicar, intente mas tarde.', 'error');
        $.hiddenLoading()
    });
}
// ###########################################################
// Previsualizador en el formulario de nueva publicacion
// ###########################################################
function archivo(evt) {
    var files = evt.target.files;
    for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {
                document.getElementById("list").innerHTML = ['<img class="thumbNew" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
            };
        })(f);
        reader.readAsDataURL(f);
    }
}
document.getElementById('img').addEventListener('change', archivo, false);
// ###########################################################
// Extraccion de texto
// ###########################################################
function getOCR(user) {
    userConnected = user;
    hidePanel();
    var formData = new FormData($('#new')[0]);
    $.ajax({
        type: 'POST',
        url: 'http://localhost:8000/upload',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
    }).done(function(data) {
        pipeline(data.id);
    }).fail(function(err) {
        console.log(err);
        $.showNotify('Error', 'Ocurrió un error en el procesamiento del texto, intente mas tarde.', 'error');
    });
}
// ###########################################################
// Tratamiento de texto
// ###########################################################
function pln(txt) {
    var filterWords = txt.replace(/\n/g, ' ').split(' ');
    for (var i = filterWords.length - 1; i >= 0; i--) {
        if (filterWords[i].length < 3 || filterWords[i].match(/^upt/) || filterWords[i].match(/^univer/) || filterWords[i].match(/^hote/) || filterWords[i].match(/^compu/) || filterWords[i].match(/^edu/) || filterWords[i].match(/^matema/) || filterWords[i].match(/^elec/) || filterWords[i].match(/^peda/) || filterWords[i].match(/^natural/) || filterWords[i].match(/^enfermer/) || filterWords[i].match(/^profe/) || filterWords[i].match(/^agro/) || filterWords[i].match(/^huma/) || filterWords[i].match(/^estadis/) || filterWords[i].match(/^merca/) || filterWords[i].match(/^psico/) || filterWords[i].match(/^trans/) || filterWords[i].match(/^fisi/) || filterWords[i].match(/^bio/) || filterWords[i].match(/^extra/) || filterWords[i].match(/^pre/) || filterWords[i].match(/^econo/) || filterWords[i].match(/^cien/) || filterWords[i].match(/^zoo/) || filterWords[i].match(/^admin/) || filterWords[i].match(/^indus/) || filterWords[i].match(/^filo/) || filterWords[i].match(/^empre/) || filterWords[i].match(/^ambien/) || filterWords[i].match(/[0-9]/) || filterWords[i].match(/^geo/) || filterWords[i].match(/^finan/) || filterWords[i].match(/^comer/) || filterWords[i].match(/^tecn/) || filterWords[i].match(/^prod/) || filterWords[i].match(/^lic/) || filterWords[i].match(/gica/) || filterWords[i].match(/^aseso/) || filterWords[i].match(/fasis$/) || filterWords[i].match(/^mensa/) || filterWords[i].match(/ypțę/) || filterWords[i].match(/^cod/) || filterWords[i].match(/^sist/) || filterWords[i].match(/tunja/) || filterWords[i].match(/^ing/) || filterWords[i].match(/^www/) || filterWords[i].match(/cembia/) || filterWords[i].match(/^origi/) || filterWords[i].match(/ohmbu/) || filterWords[i].match(/del/) || filterWords[i].match(/acero/) || filterWords[i].match(/coo/) || filterWords[i].match(/vias/) || filterWords[i].match(/^derec/) || filterWords[i].match(/^socia/) || filterWords[i].match(/civil/) || filterWords[i].match(/^lengu/) || filterWords[i].match(/finanzas/) || filterWords[i].match(/^especia/) || filterWords[i].match(/idiomas/) || filterWords[i].match(/modernos/) || filterWords[i].match(/tc/) || filterWords[i].match(/minas/) || filterWords[i].match(/sica$/) || filterWords[i].match(/diseño/) || filterWords[i].match(/sogamoso/) || filterWords[i].match(/^chiquin/) || filterWords[i].match(/t&tc/) || filterWords[i].match(/ñol$/) || filterWords[i].match(/ingles/) || filterWords[i].match(/duitama/) || filterWords[i].match(/medicina/) || filterWords[i].match(/^veteri/) || filterWords[i].match(/procesos/) || filterWords[i].match(/rccnol,igica/) || filterWords[i].match(/gestion/) || filterWords[i].match(/nuevo/) || filterWords[i].match(/chitaraqu/) || filterWords[i].match(/ląc/) || filterWords[i].match(/estudiante/) || filterWords[i].match(/semestre/) || filterWords[i].match(/valido/) || filterWords[i].match(/fcrfaaoos/) || filterWords[i].match(/sionau/) || filterWords[i].match(/ion/) || filterWords[i].match(/musica/) || filterWords[i].match(/atura$/) || filterWords[i].match(/qumca/) || filterWords[i].match(/имс/) || filterWords[i].match(/оамсо/) || filterWords[i].match(/аяманоо/) || filterWords[i].match(/соо/) || filterWords[i].match(/pe=iay/) || filterWords[i].match(/pcd@gógŕ•/) || filterWords[i].match(/^quimi/) || filterWords[i].match(/tuwa/) || filterWords[i].match(/p_țț_,/) || filterWords[i].match(/^colom/) || filterWords[i].match(/^coc/) || filterWords[i].match(/alta/) || filterWords[i].match(/^did/) || filterWords[i].match(/^bases/) || filterWords[i].match(/^servi/) || filterWords[i].match(/^turis/) || filterWords[i].match(/^conta/) || filterWords[i].match(/blica$/) || filterWords[i].match(/^inter/) || filterWords[i].match(/ticas$/) || filterWords[i].match(/ción$/) || filterWords[i].match(/^depor/) || filterWords[i].match(/^recre/) || filterWords[i].match(/nible$/) || filterWords[i].match(/^insta/) || filterWords[i].match(/^rede/) || filterWords[i].match(/^herra/) || filterWords[i].match(/^tele/) || filterWords[i].match(/^farma/) || filterWords[i].match(/ungvers'dad/)) {
            filterWords.splice(i, 1);
        }
    }
    var data = {}
    data.filterText = filterWords;
    data.probability = probability(txt, filterWords);
    return data;
}
// ###########################################################
// Valores de probabilidad del texto extraido
// ###########################################################
function probability(txtMicrosoft, txtFilter) {
    var lengthMicrosoft = txtMicrosoft.split('-').length;
    var lengthFilter = txtFilter.length;
    var probability = 0.0;
    if (lengthFilter == 0) {
        probability = 0;
    } else if (lengthMicrosoft <= 4 || lengthFilter <= 4) {
        probability += 0.85;
    } else if (lengthFilter < lengthMicrosoft) {
        probability += 0.70;
    } else if (lengthFilter == lengthMicrosoft) {
        probability += 0.50;
    } else {
        probability += 0.30;
    }
    return probability;
}
// ###########################################################
// Reinicio al formulario de una nueva publicacion
// ###########################################################
function resetForm() {
    document.getElementById("new").reset();
    document.getElementById("list").innerHTML = "";
}
// ###########################################################
// Ocultamiento del panel footer
// ###########################################################
function hidePanel() {
    var $panels = $('.panel');
    $panels.trigger('---hide');
}

function pipeline(id) {
    var steps = ["crop_morphology", "enhance_basic_sharpness", "enhance_basic_brightness", "negative", "histogram_equalization"];
    $.ajax({
        type: 'POST',
        url: 'http://localhost:8000/pipeline/' + id,
        data: JSON.stringify({
            steps: steps
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
    }).done(function(data) {
        ocr(data.pipeline[0][1]);
    }).fail(function(err) {
        console.log(err);
        $.showNotify('Error', 'Ocurrió un error en el procesamiento del texto, intente mas tarde.', 'error');
    });
}

function ocr(id) {
    $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/ocr-individual/' + id,
    }).done(function(data) {
        textDetect = data.results.text;
        txtFilter = pln(textDetect);
        var nameDetect = txtFilter.filterText;
        for (var index = 0; index < txtFilter.filterText.length; index++) {
            name = name + " " + txtFilter.filterText[index];
        }
        // getMembersFacebook(nameDetect);
        console.log(nameDetect);
        console.log(userConnected);
        newPost(nameDetect, userConnected);
    }).fail(function(err) {
        console.log(err);
        $.showNotify('Error', 'Ocurrió un error en el procesamiento del texto, intente mas tarde.', 'error');
    });
}