(function($) {
	/* Dynamic Table :: Remove */
	$(document.body).on('click', 'button[name="remove"]', function(event) {
		var element			= $(this);
		
		element.parents('tr').remove();
		
		var name			= element.val();
		var table_empty		= $('tbody.dynamic_' + name + ' tr.table_empty');
		var table_entrys	= $('tbody.dynamic_' + name + ' tr');
		
		if(table_entrys.length < 2) {
			table_empty.removeClass('hide');
		} else {
			table_empty.addClass('hide');
		}
	});
	
	/* Dynamic Table :: Add */
	$(document.body).on('click', 'button[name="add"]', function(event) {
		var element			= $(this);
		var data			= element.data();
		var name			= element.val();
		var template		= $('#entry_' + name).html();
		var table_empty		= $('tbody.dynamic_' + name + ' tr.table_empty');
		var table_body		= $('tbody.dynamic_' + name + '');
		var table_entrys	= $('tbody.dynamic_' + name + ' tr');
		template			= template.replace(/\$index/g, (table_entrys.length));
		
		if(Object.keys(data).length > 0) {
			for(var entry in data) {
				var value		= data[entry];
				try {
					var selector	= $(value);
					
					if(selector.is('option') && selector != undefined && selector.length == 1) {
						value		= selector.val();
					}
				} catch(e) {
					/* Do Nothing */
				}
				
				template	= template.replace(new RegExp(entry.replace(/\$/g, '\\$'), 'g'), value);
			}
		}
		
		table_body.append(template);
		
		table_entrys		= $('tbody.dynamic_' + name + ' tr');
		
		if(table_entrys.length < 2) {
			table_empty.removeClass('hide');
		} else {
			table_empty.addClass('hide');
		}
	});
	
	/* Ajax Form Search */
	$(document.body).on('keydown keyup keypress', 'form.ajax-search', function(event) {
		$(this).trigger('submit');
	});
	
	$(document.body).on('submit', 'form.ajax-search', function(event) {
		var element = $(this);
		var parent 	= element.parent();
		
		$.ajax({
			type:		element.attr('method'),
			url:		element.attr('action'),
			data:		element.serialize(),
			success:	function(data) {
				if(data.status === 0) {
					alert('Es ist ein Fehler aufgetreten: ' + data.message);
					return;
				}
				
				if(data.count === 0) {
					$('div.ajax-result', parent).html('<p class="bg-warning">Es wurden keine Ergebnisse für "<strong>' + data.query + '</strong>" gefunden!</p>');
				} else {
					$('div.ajax-result', parent).html(data.html);
				}
			}
		});
		
		event.preventDefault();
		return false;
	});
	
	/* Form Submit */
	$(document.body).on('submit', 'form', function(event) {
		if($(this).hasClass('no-submit')) {
			event.preventDefault();
			return false;
		}
	});
	
	$(document.body).on('keydown keyup keypress', 'input[data-autocomplete]', function(event) {
		switch(event.keyCode || event.which) {
			case 13:
				event.preventDefault();
				return;
			break;
		}
	});
	
	/* Input :: Autocomplete */
	var autocomplete_selected	= -1;
	var autocomplete_results	= 0;
	
	$(document.body).on('focus', '[data-autocomplete]', function(event) {
		var element = $(this);
		
		if(element.data('show_all')) {
			$('[data-autocomplete]').removeClass('autocomplete-visible');
			element.trigger('keyup');
		}
	});
	
	$(document.body).on('keyup', '[data-autocomplete]', function(event) {
		var code	= event.keyCode || event.which; 
		var element = $(this);
		var parent 	= element.parent();
		var data	= {
			action:	'autocomplete',
			type:	element.data('autocomplete'),
			query:	element.val()
		};
		
		if(element.data('additional')) {
			var entrys = JSON.parse(element.data('additional').replace(/'/g, '"'));
			for(var name in entrys) {
				var value	= entrys[name];
				
				if(value.substring(0, 1) === '$') {
					value = $('[name="' + value.substring(1) + '"]').val();
				}
				
				data[name]	= value;
			}
		}
		
		if(element.data('bind')) {
			data.reference = $('input[name="autocomplete_reference_' + element.data('bind') + '"]').val();
			
			if(data.reference != undefined && (data.reference.length === 0 || data.reference <= -1)) {
				alert(element.data('reference_error'));
				return;
			}
		}
		
		if(code == 40) {
			if(autocomplete_selected + 1 < autocomplete_results) {
				autocomplete_selected++;
			}
			
			$('.well.autocomplete .autocomplete-result', parent).removeClass('selected');
			$('.well.autocomplete .autocomplete-result:eq(' + autocomplete_selected + ')', parent).addClass('selected');
			
			event.preventDefault();
			return false;
		} else if(code == 38) {
			if(autocomplete_selected - 1 >= 0) {
				autocomplete_selected--;
			}
			
			$('.well.autocomplete .autocomplete-result', parent).removeClass('selected');
			$('.well.autocomplete .autocomplete-result:eq(' + autocomplete_selected + ')', parent).addClass('selected');
			
			event.preventDefault();
			return false;
		} else if(code == 13 && autocomplete_selected > -1) {
			$('.well.autocomplete .autocomplete-result:eq(' + autocomplete_selected + ')', parent).trigger('click');
			event.preventDefault();
			return false;
		}
		
		$.ajax({
			type:		'POST',
			url:		element.data('action'),
			data:		data,
			success:	function(data) {
				autocomplete_selected = -1;
				
				if(data.status === 0) {
					alert('Es ist ein Fehler aufgetreten: ' + data.message);
					return;
				}
				
				autocomplete_results = data.count;
				
				if(data.count === 0) {
					parent.removeClass('autocomplete-visible');
					autocomplete_selected = -1;
				} else {
					parent.addClass('autocomplete-visible');
					$('.well.autocomplete', parent).html(data.html);
					autocomplete_selected = 0;
					$('.well.autocomplete .autocomplete-result', parent).removeClass('selected');
					$('.well.autocomplete .autocomplete-result:eq(' + autocomplete_selected + ')', parent).addClass('selected');
				}
			}
		});
		
		event.preventDefault();
		return false;
	});
	
	$(document.body).on('click', '.autocomplete-result', function(event) {
		var element = $(this);
		var parent 	= element.parent().parent();
		var fillout	= element.data('fillout');
		
		try {
			fillout = JSON.parse(fillout.replace(/'/g, '"'));
			for(var entry in fillout) {
				if(typeof(fillout[entry]) == 'string') {
					$('input[name="' + entry + '"]').val(fillout[entry]).trigger('change');
				} else {
					$('select[name="' + entry + '"]').html('<option value="">- Bitte auswählen -</option>');
					
					for(var value in fillout[entry]) {
						$('select[name="' + entry + '"]').append('<option value="' + value + '">' + fillout[entry][value] + '</option>');
					}
				}
			}
		} catch(e) {
			console.log(e);
			/* Do Nothing */
		}
		
		$('[data-autocomplete]', parent).val(element.data('replace')).trigger('change');
		$('input[name="autocomplete_reference_' + element.data('type') + '"]', parent).val(element.data('reference')).trigger('change');
		parent.removeClass('autocomplete-visible');
		
		event.preventDefault();
		return false;
	});
	
	$(document.body).on('click', function(event) {
		$('[data-autocomplete]').parent().removeClass('autocomplete-visible');
	});
	
	/* Quickinfo */
	$(document.body).on('mouseover', '[data-quickinfo]', function(event) {
		var element		= $(this);
		var api_url		= $('input[name="api_url"]').val();
		var magnet		= $(event.target);
		var position	= magnet.offset();
		var quickbox	= $('div#quickbox');
		var action		= element.data('quickinfo');
		var id			= element.data('id');
		
		quickbox.css({
			top:	position.top + magnet.outerHeight(),
			left:	position.left
		});
		
		$.ajax({
			type:		'POST',
			url:		api_url,
			data:		{
				action: 'quickbox',
				type:	action,
				id:		id
			},
			success:	function(data) {
				if(data.status === 0) {
					quickbox.html('<div class="loading"></div>');
					quickbox.hide();
					return;
				}
				
				quickbox.html(data.html);
			}
		});
		
		quickbox.show();
	});
	
	$(document.body).on('mouseout', '[data-quickinfo]', function(event) {
		var element		= $(this);
		var quickbox	= $('div#quickbox');
		quickbox.html('<div class="loading"></div>');
		quickbox.hide();
	});
	
	/* Popups */
	$(document.body).on('click', 'button[name="popup"]', function(event) {
		var element			= $(this);
		var name			= element.val();
		
		$('#popup_' + name).modal();
	});

	/* Timepicker */
	$('.form_datetime').each(function() {
		var element = $(this);
		
		element.datetimepicker({
			format:		element.data('format'),
			showClear:	element.data('clear'),
		});
	});
	
	/* Toggle */
	$('input[type="checkbox"].switch').bootstrapSwitch();
	
	/* Alerts */
	window.alert = function(message) {
		$('div.alert .alert-content').html(message);
		$('div.alert').modal('show');
	};
	
	// Contract Editor
	function changeStep(step_next, step_current) {
		$('div.contract-editor a.tab_wizard').removeClass('current');
		$('div.contract-editor a.tab_wizard_' + step_next).addClass('current');
		
		$('div.contract-editor div.tabs').addClass('hide');
		$('div.contract-editor div.tab_' + step_next).removeClass('hide');
		
		$('div.contract-editor input[name="current_step"]').val(step_next).trigger('change', [step_next, step_current]);
	}
	
	$('div.contract-editor button[type="button"]').on('click', function(event) {
		var element			= $(this);
		var parent			= element.parent();
		var step_current	= $('input[name="step_current"]', parent).val() || '';
		var step_next		= $('input[name="step_next"]', parent).val() || '';
		
		changeStep(step_next, step_current);
	});

	$('div.contract-editor input[name="customer"]').on('click', function(event) {
		$('input[name="customer[id]"], input[name="customer[contact_email]"], input[name="customer[contact_telephone_public]"], input[name="customer[contact_telephone_private]"], input[name="customer[contact_telephone_mobile]"]').val('').trigger('change');
		$(this).val('');
	});
	
	$('div.contract-editor input[name="customer[id]"]').on('change', function(event) {
		// Check if customer is selected
		var customer_id = $('div.contract-editor input[name="customer[id]"]').val();
		if(customer_id.length == 0) {
			$('.next button[name="next_step"]').removeClass('btn-primary').addClass('btn-default');
		} else {
			$('.next button[name="next_step"]').removeClass('btn-default').addClass('btn-primary');
		}
	});
	
	$('div.contract-editor input[name="current_step"]').on('change', function(event, step_current, step_last) {
		switch(step_current) {
			case 'object':
				var customer_id = $('div.contract-editor input[name="customer[id]"]').val();
				
				if(customer_id.length == 0) {
					changeStep(step_last, step_current);
					alert('Bitte wählen Sie einen Kunden aus!');
					$('.next button[name="next_step"]').removeClass('btn-primary').addClass('btn-default');
				} else {
					$('.next button[name="next_step"]').removeClass('btn-default').addClass('btn-primary');
					
					if(step_last == 'service') {
						return;
					}
					
					$.ajax({
						type:		'POST',
						url:		$('input[name="api_url"]').val(),
						data:		{
							action:	'json_search',
							type:	'objects',
							query:	customer_id
						},
						success:	function(data) {
							if(data.status === 0) {
								alert('Es ist ein Fehler aufgetreten: ' + data.message);
								return;
							}
							
							if(data.count === 0) {
								$('.objects_html').html('<p>Es existieren leider keine Mietobjekte. Bitte fügen bearbeiten Sie zuerst den Kunden bevor Sie einen Auftrag erstellen.</p>');
							} else {
								var html = '';
								for(var index in data.result) {
									var entry = data.result[index];
									html += '<div class="entry">';
									html += '<input type="radio" name="unit_id" id="object_entry_' + index + '" value="' + entry.unit_id + '"' + (index == 0 ? ' CHECKED' : '') + ' />';
									html += '<address>';
									html += '<label for="object_entry_' + index + '">';
									html += entry.unit_type_name;
									html += '</label>';
									html += '<br />';
									html += entry.street_name + ' ' + entry.street_number;
									html += '<br />';
									html += entry.city_zip + ' ' + entry.city_name;
									html += '</address>';
									html += '</div>';
								}
								$('.objects_html').html(html);
							}
						}
					});
				}
			break;
			case 'service':
				var unit_id = parseInt($('div.contract-editor input[name="unit_id"]').val());
				
				if(unit_id > 0) {
					$('.next button[name="next_step"]').removeClass('btn-default').addClass('btn-primary');

					if(step_last == 'company') {
						return;
					}
					
					$.ajax({
						type:		'POST',
						url:		$('input[name="api_url"]').val(),
						data:		{
							action:	'json_search',
							type:	'service'
						},
						success:	function(data) {
							if(data.status === 0) {
								alert('Es ist ein Fehler aufgetreten: ' + data.message);
								return;
							}
							
							if(data.count === 0) {
								$('.services_html').html('<p>Es existieren leider keine Dienstleistungen.</p>');
							} else {
								var html = '<select class="form-control" name="service_id">';
								for(var index in data.result) {
									var entry = data.result[index];
									html += '<option value="' + entry.id + '">';
									html += entry.name;
									html += '</option>';
								}
								html += '</select>';
								
								$('.services_html').html(html);
							}
						}
					});
				} else {
					changeStep(step_last, step_current);
					alert('Bitte wählen Sie ein Mietobjekt aus!');
					$('.next button[name="next_step"]').removeClass('btn-primary').addClass('btn-default');
				}
			break;
			case 'company':
				var service_id = parseInt($('div.contract-editor select[name="service_id"] option:selected').val());
				
				if(service_id > 0) {

				} else {
					changeStep(step_last, step_current);
					alert('Bitte wählen Sie eine Dienstleistung aus!');
					$('.next button[name="next_step"]').removeClass('btn-primary').addClass('btn-default');
				}
			break;
		}
	});
}(jQuery));