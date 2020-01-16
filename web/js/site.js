var chacheCity = {},//Кэш для городов
	chacheGroup = {},//Кэш для группы
	filter = {},//Фильтр поиска аккаунтов
	find_result = $('#find_result');

$.postJSON = function(url, data, func)
{
	$.post(url, data, func, 'json');
}

/**
 * Событие возникающее когда выбрано значение в AutoComplete страны (Страница "Выборка аккаунтов")
 */
function onAutoCompleteCountry(event, ui) {
	filter[this.id] = ui.item.id;
	$('#selectvkform-city').prop('disabled', false);
}

/**
 * Событие возникающее когда выбрано значение в AutoComplete, для AutoComplete страны отдельный обработчик выше (Страница "Выборка аккаунтов")
 */
function onAutoComplete(event, ui) {
	filter[this.id] = ui.item.id;
}

/**
 * Источник данных для AutoComplete города
 */
function citySource(request, response) {
	var term = request.term.toLowerCase();
	request.method = 'getCities';
	request.country_id = filter['selectvkform-country'];
	if (term in chacheCity) {
		response(chacheCity[term]);
		return;
	}

	$.postJSON('', request, function(data, status, xhr) {
		chacheCity[term] = data;
		response(data);
	});
}

/**
 * Источник данных для AutoComplete группы
 */
function groupSource(request, response) {
	request.term = request.term.toLowerCase().trim();
	var term = request.term;
	request.method = 'getGroup';
	if (term in chacheGroup) {
		response(chacheGroup[term]);
		return;
	}
	if (request.term.search('^(https://vk.com/|vk.com/)?([a-z0-9_.])+$') < 0)
		return;//Некорректный формат
	//Обрежем ссылку на ВК
	request.term = request.term.replace(/https:\/\/vk.com\/|vk.com\//g, '');

	$.postJSON('', request, function(data, status, xhr) {
		chacheGroup[term] = data;
		response(data);
	});
}

/**
 * Поиск аккаунтов и вывод результата
 */
function submitSelect() {
	var obj_data = {},
		form_data = {};
	
	$(this).find('input:not(.ui-autocomplete-input), select').each(function () {
		var el = $(this);
		form_data[el.prop('name')] = el.val();
	});

	$(this).find('.ui-autocomplete-input').each(function () {
		var el = $(this);
		form_data[el.prop('name')] = filter[this.id] ? filter[this.id] : '';
	});
	
	obj_data.method = 'findVK';
	obj_data.form = $.param(form_data);
	$.ajax({
		data: obj_data,
		type: 'POST',
		success: function (res) {
			find_result.html(res);
		},
		error: function () {
			alert('Ошибка! Не удалось отправить форму!');
		}
	});
	return false;
}

/**
 * Валидация заполненности наименования выборки
 */
function saveSelect(handler) {
	var selectName = $('#selectName');
	if (selectName.val() == '') {
		alert('Перед сохранением необходимо ввести название выборки');
		return false;
	}
	handler.href += '&sname=' + selectName.val();
	return true;
}