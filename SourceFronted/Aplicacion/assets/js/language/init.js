
function setLanguage(language) {
	$.i18n.dict = null;
	if (language == 'es') {
		$.i18n.load(language_es);
	}
	else{
		$.i18n.load(language_en);	
	}

	$('#title')._t('title');
	$('h1#title')._t('title');
	$('#description')._t('description');
	$('#post')._t('post');
}


var language = window.navigator.language||navigator.browserLanguage;
setLanguage(language.substring(0,2));
