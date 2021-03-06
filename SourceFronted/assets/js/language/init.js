
function setLanguage(language) {
	$.i18n.dict = null;
	if (language == 'es') {
		$.i18n.load(language_es);
	}
	else{
		$.i18n.load(language_en);	
	}

	$('.title')._t('title');
	$('.description')._t('description');
	$('.section01_title')._t('section01_title');
	$('.section01_text')._t('section01_text');
	$('.section02_title')._t('section02_title');
	$('.section02_text')._t('section02_text');
	$('.section03_title')._t('section03_title');
	$('.section04_title')._t('section04_title');
}


var language = window.navigator.language||navigator.browserLanguage;
setLanguage(language.substring(0,2));
