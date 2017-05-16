
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
	$('.post')._t('post');
	$('.newLink')._t('new');
	$('.search_name')._t('search_name');
	$('.search_date')._t('search_date');
	$('.start_date')._t('start_date');
	$('.end_date')._t('end_date');
	$('.title_modal_new')._t('title_modal_new');
	$('.sutitle_modal_new')._t('sutitle_modal_new');
	$('.title_modal_contact')._t('title_modal_contact');
	$('.bottomContact')._t('bottomContact');
	$('.photo')._t('photo');
	$('.contact_label')._t('contact_label');
	$(".send_button").prop('value', $.i18n._('send_button'));
	$(".search_button").prop('value', $.i18n._('search_button'));
	$(".search_input").prop('placeholder', $.i18n._('search_input'));
}


var language = window.navigator.language||navigator.browserLanguage;
setLanguage(language.substring(0,2));
