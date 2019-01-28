var loadingwheel = "<div class='la-ball-spin la-light la-3x'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
var darkloadingwheel = "<div class='la-ball-spin la-dark la-3x'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
var togglearray = {Y: 'on', N: 'off'};
var listener = new window.keypress.Listener();

$(document).ready(function() {
	// LISTENER
	$('input[type=text]').bind("focus", function() { listener.stop_listening(); }).bind("blur", function() { listener.listen(); });

	/*==============================================================
	   INITIALIZE BOOTSTRAP FUNCTIONS
	=============================================================*/
		$('body').popover({selector: '[data-toggle="popover"]', placement: 'top'});
		$('body').tooltip({selector: '[data-toggle="tooltip"]', placement: 'top'});

		init_datepicker();
		init_timepicker();
		init_bootstraptoggle();

		$('.phone-input').keyup(function() {
	    	$(this).val(format_phone($(this).val()));
	    });

		$('body').on('click', function (e) {
			$('[data-toggle="popover"]').each(function () {
				//the 'is' for buttons that trigger popups
				//the 'has' for icons within a button that triggers a popup
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
					$(this).popover('hide');
				}
			});
		});

		if ($(window).width() < 768) {
			$('#show-toolbar').removeClass('hidden');
		}

		$(config.modals.lightbox).on('show.bs.modal', function (event) {
			var image = $(event.relatedTarget).find('img');
			var source = image.attr('src');
			var desc = image.data('desc');
			var modal = $(this);
			modal.find('.lightbox-image').attr('src', source);
			modal.find('.description').text(desc);
		});

		$(config.modals.ajax).on('shown.bs.modal', function(event) {
			init_datepicker();
			init_timepicker();
		});

		$(config.modals.pricing).on('shown.bs.modal', function(event) { // DEPRECATED 8/22/2017 DELETE ON 9/1
			init_datepicker();
			init_timepicker();
			init_bootstraptoggle();
		});

		$(config.modals.lightbox).on('shown.bs.modal', function(event) {
			makeshadow();
		});

		$(config.modals.lightbox).on('hide.bs.modal', function(event) {
			removeshadow();
		});

		$(config.modals.itemlookup).on('shown.bs.modal', function(event) {
			$(this).find('.searchfield').focus();
		});

	/*==============================================================
	   PAGE SCROLLING FUNCTIONS
	=============================================================*/
		$(window).scroll(function() {
			if ($(this).scrollTop() > 50) { $('#back-to-top').fadeIn(); } else { $('#back-to-top').fadeOut(); }
		});

		// scroll body to 0px on click
	   $('#back-to-top').click(function () {
		   $('#back-to-top').tooltip('hide');
		   $('body,html').animate({ scrollTop: 0 }, 800);
		   return false;
	   });

	/*==============================================================
	   YOUTUBE NAVIGATION
	=============================================================*/
		$('.yt-menu-open').on('click', function(e) { //Youtube-esque navigation
			e.preventDefault();
			$('#yt-menu').toggle();
			$(this).toggleClass('menu-open');
			if ($(this).hasClass('menu-open')) {
				$(this).css({"background-color":"#242F40", "color": "#f8f8f8"});
			} else {
				$(this).removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

		$('.slide-menu-open').on('click', function(e) { //Youtube-esque navigation
			e.preventDefault();
			$('#slide-menu').toggle().animatecss('fadeInLeft');
			$(this).toggleClass('menu-open');
			if ($(this).data('function') === 'show') {
				$(this).data('function', "hide").css({"background-color":"#242F40", "color": "#f8f8f8"});
			} else {
				$(this).data('function', "show").removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

		$(config.toolbar.button).click(function() {
			if ($(config.toolbar.toolbar).is(":hidden")) {
				showtoolbar();
			} else {
				hidetoolbar();
			}
		});

		$(document).mouseup(function (e) {
			var container = $("#yt-menu");
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				 $('#yt-menu').hide();
				 $('.yt-menu-open').data('function', "show").removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

	/*==============================================================
	  FORM FUNCTIONS
	=============================================================*/
		$("body").on("click", ".dropdown-menu .searchfilter", function(e) {
			e.preventDefault();
			var inputgroup = $(this).closest('.input-group');
			var param = $(this).attr("href").replace("#","");
			var concept = $(this).text();
			inputgroup.find('span.showfilter').text(concept);
			inputgroup.find('.search_param').val(param);
		});

		$("body").on("click", ".select-button-choice", function(e) {
			e.preventDefault();
			var tasktype = $(this).data('value');
			$(".select-button-choice").removeClass("btn-primary");
			$(this).parent().find('.select-button-value').val(tasktype);
			$(this).addClass("btn-primary");
		});

		$(".page").on("change", ".results-per-page-form .results-per-page", function() {
			var form = $(this).closest("form");
			var ajax = form.hasClass('ajax-load');
			var href = get_paginationurl(form);
			if (ajax) {
				var loadinto = form.data('loadinto');
				var focuson = form.data('focus');
				loadin(href, loadinto, function() {
					if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);}
				});
			} else {
				window.location.href = href;
			}
		});

		$("body").on("submit", "#email-file-form", function(e) {
			e.preventDefault();
			var form = $(this);

			form.hide(1000).animatecss('zoomOutRight');
			$('#show-email-sending').removeClass('hidden').find('h4').text('Sending Email');
			$('#show-email-sending').find('.fa-spinner').addClass('fa-pulse');

			form.postform({formdata: false, jsoncallback: true, action: false}, function(json) {
				$.notify({
					icon: json.response.icon,
					message: json.response.message
				},{
					type: json.response.notifytype,
					onClose: function() {
						form.closest('.modal').modal('hide');
						$('#show-email-sending').addClass('hidden').find('h4').text('');
						$('#show-email-sending').find('fa-spinner').removeClass('fa-pulse');
					}
				});
			});
		});

		$("body").on("change", ".required", function() {
			if ($(this).val() != '') {
				$(this).closest('tr').removeClass('has-error');
			} else if ($(this).val() == '') {
				$(this).closest('tr').addClass('has-error');
			}
        });

		$("body").on("submit", ".form-ajax", function(e) {
			e.preventDefault();
			var form = $(this);
			var formurl = URI(form.attr('action'));
			var focus = form.data('focus');
			var loadinto = form.data('loadinto');
			var querystring = formurl.query() + "&"+ form.serialize();
			formurl.query(querystring).query(cleanparams).normalizeQuery();
			href = formurl.toString();
			var queries = URI.parseQuery(formurl.search())
			console.log(queries);
			console.log(href);

			$(loadinto).loadin(href, function() {
				if (focus.length > 0) {
					$('html, body').animate({scrollTop: $(focus).offset().top - 60}, 1000);
				}
			});
		});

		$("body").on("submit", ".actions-filter", function(e) {
			e.preventDefault();
			var form = $(this);
			var formurl = URI(form.attr('action'));
			formurl.removeQuery(/^completed/);
			formurl.removeQuery(/^assignedto/);
			formurl.removeQuery(/^actiontype/);
			var focus = form.data('focus');
			var loadinto = form.data('loadinto');
			var querystring = formurl.query() + "&"+ form.serialize();
			formurl.query(querystring).query(cleanparams).normalizeQuery();

			href = formurl.toString();

			$(loadinto).loadin(href, function() {
				if (focus.length > 0) {
					$('html, body').animate({scrollTop: $(focus).offset().top - 60}, 1000);
				}
			});
		});

		$("body").on('keypress', 'form input', function(e) {
			if ($(this).closest('form').hasClass('allow-enterkey-submit')) {
				return true;
			} else {
				return e.which !== 13;
			}
		});

	/*==============================================================
	  AJAX LOAD FUNCTIONS
	=============================================================*/
		$("body").on("click", ".load-link", function(e) {
			e.preventDefault();
			var button = $(this);
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var href = $(this).attr('href');
			if (button.hasClass('actions-refresh')) {
				showajaxloading();
			}
			$(loadinto).loadin(href, function() {
				if (button.hasClass('actions-refresh')) {
					hideajaxloading();
				}
				if (focuson.length > 0) {
					$('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);
				}
				init_bootstraptoggle();
			});
		});

		$("body").on("click", ".load-and-show", function(e) {
			e.preventDefault();
			showajaxloading();
			var button = $(this);
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var href = $(this).attr('href');

			$(loadinto).loadin(href, function() {
				hideajaxloading();
				if (focuson.length > 0) {
					$('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);
				}
				init_bootstraptoggle();
			});
		});

		$("body").on("click", ".load-into-modal", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			var closestmodal = $(this).closest('.modal');

			if (closestmodal) {
				if (closestmodal.attr('id') != ajaxloader.loadinto) {
					closestmodal.find("[data-dismiss='modal']").click();
				}

			}

			ajaxloader.url = URI(ajaxloader.url).addQuery('modal', 'modal').normalizeQuery().toString();
			if (button.hasClass('info-screen')) {
				showajaxloading();
			}

			$(ajaxloader.loadinto).loadin(ajaxloader.url, function() {
				if (button.hasClass('info-screen')) {
					hideajaxloading();
					$(ajaxloader.modal).find('.modal-body').addClass('modal-results');
				}
				$(ajaxloader.modal).resizemodal(ajaxloader.modalsize).modal();
			});
		});

		$("body").on("click", ".modal-load", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			ajaxloader.url = URI(ajaxloader.url).addQuery('modal', 'modal').normalizeQuery().toString();
			console.log(ajaxloader.loadinto);
			$(ajaxloader.loadinto).empty();
			var loadingwheel = $(darkloadingwheel);
			loadingwheel.addClass('display-inline-block').addClass('text-center');
			$(ajaxloader.loadinto).append("<div class='modal-body'><div class='text-center'>"+loadingwheel.prop('outerHTML')+"</div></div>");

			$(ajaxloader.loadinto).loadin(ajaxloader.url, function() {
				hideajaxloading();
				$(ajaxloader.modal).find('.modal-body').addClass('modal-results');
				$(ajaxloader.modal).resizemodal(ajaxloader.modalsize).modal();
			});
		});

		$("body").on("click", ".generate-load-link", function(e) { //MADE TO REPLACE $(.load-detail).click()
			e.preventDefault();
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var geturl = $(this).attr('href');
			showajaxloading();
			dplusrequesturl(geturl, function(url) {
				$(loadinto).loadin(url, function() {
					hideajaxloading();
					if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
				});
			});
		});

		$("body").on("click", ".load-notes", function(e) {
		    e.preventDefault();
		    var button = $(this);
		    var ajaxloader = new ajaxloadedmodal(button);
			showajaxloading();
			dplusrequesturl(ajaxloader.url, function(url) {
				wait(500, function() {
					url = URI(url).addQuery('modal', 'modal').toString();
					$(ajaxloader.loadinto).loadin(url, function() {
						$(ajaxloader.modal).resizemodal('lg').modal(); hideajaxloading();
					});
				});
			});
		});

	/*==============================================================
		ORDER LIST FUNCTIONS
	=============================================================*/
		$(".page").on("click", ".edit-order", function(e) {
			e.preventDefault();
			var href = $(this).attr('href');
			dplusrequesturl(href, function(url) {
				window.location.href = url;
			});
		});

		$(".page").on("click", ".load-cust-orders", function(event) { //Changed from #load-cust-orders  //DEPRECATED
			event.preventDefault();
			var loadinto = $(this).data('loadinto');
			var geturl = $(this).attr('href');
			var focuson = $(this).data('focus');
			dplusrequesturl(geturl, function(url) {
				$(loadinto).loadin(url, function() {
					if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
				});
			});
		});

		$("body").on("click", ".search-orders", function(e) {
			e.preventDefault();
			console.log('clicked');
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			$(ajaxloader.loadinto).loadin(ajaxloader.url, function() {
				 $(ajaxloader.modal).modal();
			});
		});

		$("body").on("submit", "#order-filter-form", function(e)  { //FIXME Barbara - changed from order-search-form
			e.preventDefault();
			var form = "#"+$(this).attr('id');
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var modal = $(this).data('modal');
			$(form).postform({formdata: false, jsoncallback: false, action: false}, function() { //form, overwriteformdata, returnjson, callback
				wait(500, function() {
					generateurl(function(url) {
						$(loadinto).loadin(url, function() {
							$(modal).modal('hide');
							if (focuson.length > 0) {
								$('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);
							}
						});
					 });
				});
			});
		});

		$("body").on("submit", ".orders-search-form", function(e)  { //FIXME Barbara - changed from order-search-form
			e.preventDefault();
			var form = $(this);
			var loadinto = form.data('loadinto');
			var focuson = form.data('focus');
			var action = URI(form.attr('action'));
			var ordertype = form.data('ordertype'); // sales-orders | quotes
			var queries = URI.parseQuery(URI(action).search())
			var orderby = queries.orderby; // Keep the orderby param value before clearing it
			var href = action.query('').query(form.serialize()).query(cleanparams).query(remove_emptyparams);
			if (Object.keys(href.query(true)).length == 1) {
				href.query('');
			}

			if (ordertype == 'sales-orders') {
				href.addQuery('ordn', queries.ordn);
			} else if (ordertype == 'quotes') {
				href.addQuery('qnbr', queries.qnbr);
			}

			if (orderby) {
				href = href.addQuery('orderby', orderby);
			}

			href = href.toString(); // Add orderby param

			$(loadinto).loadin(href, function() {
				if (focuson.length > 0) {
					$('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);
				}
			});
		});

		$("body").on("submit", ".item-reorder", function(e) {
			e.preventDefault();
			var form = new itemform($(this));
			var msg = "You added " + form.qty + " of " + form.desc + " to the cart";
			$(form.formID).postform({formdata: false, jsoncallback: false}, function() {
				$.notify({
					icon: "glyphicon glyphicon-shopping-cart",
					message: msg +"<br> (Click this Message to go to the cart.)" ,
					url: config.urls.cart.page,
					target: '_self'
				},{
					type: "success",
					url_target: '_self'
				});
			});
		});

		// USED FOR ORDER SEARCH FILTER
		$("body").on("click", ".get-custid-search", function(e) {
			var field = $(this).data('field');
			var modal = config.modals.ajax;
			var loadinto = modal+" .modal-content";
			var href = URI(config.urls.customer.load.loadindex).addQuery('function', 'os-order-cust-search').addQuery('modal', 'modal').addQuery('field', field).normalizeQuery().toString();
			$('.modal').modal('hide');
			$(loadinto).loadin(href, function() {
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
				setTimeout(function (){ $(modal).find('.query').focus();}, 500);
			});
		});

	/*==============================================================
		EDIT CART / QUOTES / SALES ORDER FUNCTIONS
	=============================================================*/
		$("body").on("click", ".view-item-details", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			if (button.data('kit') == 'Y') {
				var itemID = button.data('itemid');
				var qty = 1;
				showajaxloading();
				ii_kitcomponents(itemID, qty, function() {
					$(ajaxloader.loadinto).loadin(ajaxloader.url, function() {
						hideajaxloading();
						$(ajaxloader.modal).resizemodal('lg').modal();
					});
				});
			} else {
				$(ajaxloader.loadinto).loadin(ajaxloader.url, function() {
					$(ajaxloader.modal).resizemodal('lg').modal();
				});
			}
		});

	/*==============================================================
		SALES ORDER / QUOTES LIST FUNCTIONS
	=============================================================*/
		$("body").on("click", ".get-cust-contact-search", function(e) {
			var modal = config.modals.ajax;
			var loadinto = modal+" .modal-content";
			var custID = $(this).data('custid');
			var shipID = $(this).data('shipid');
			var uri = URI(config.urls.customer.load.searchcontacts).addQuery('function', 'eqo-contact').addQuery('modal', 'modal')
			var href = uri.addQuery('custID', custID).addQuery('shipID', shipID).normalizeQuery().toString();
			$('.modal').modal('hide');
			$(loadinto).loadin(href, function() {
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
				setTimeout(function (){ $(modal).find('.query').focus();}, 500);
			});
		});

		$("body").on("click", ".order-choose-contact", function(e) {
			e.preventDefault();
			var modal = config.modals.ajax;
			var button = $(this);
			var form = $('.order-form');
			form.find('input[name=contact]').val(button.data('contact'));
			form.find('input[name=contact-extension]').val(button.data('extension'));
			form.find('input[name=contact-fax]').val(button.data('fax'));
			form.find('input[name=contact-phone]').val(button.data('phone'));
			form.find('input[name=contact-email]').val(button.data('email'));
			$(modal).modal('hide');
			$('html, body').animate({scrollTop: form.find('input[name=contact]').offset().top - 80}, 1000);
		});

	/*==============================================================
		ADD ITEM MODAL FUNCTIONS
	=============================================================*/
		$("body").on("submit", ".add-and-edit-form", function(e) { //FIX MAKE IT JUST AJAX ADD ALSO FIX REGULAR ADD ITEM
			//WAS .add-to-order-form | MODIFIED TO SUIT BOTH QUOTES AND ORDERS
			e.preventDefault();
			var form = $(this);
			var addto = form.data('addto');
			var itemID = form.find('input[name="itemID"]').val();
			var custID = form.find('input[name="custID"]').val();
			var loadinto = config.modals.ajax+" .modal-content";
			var parentmodal = $(this).closest('.modal').modal('hide');
			var editurl = '';
			var jsonurl = form.find('input[name="jsondetailspage"]').val();
			var pageurl = new URI().addQuery('show', 'details').hash('#edit-page').toString();+
			showajaxloading();

			$('#'+form.attr('id')).postform({formdata: false, jsoncallback: false, action: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				wait(500, function() {
					$.getJSON(jsonurl, function(json) {
						console.log(jsonurl);
						if (addto === 'order') {
							linenumber = json.response.orderdetails.length;
						} else if (addto === 'quote') {
							linenumber = json.response.quotedetails.length;
						}
						editurl = URI(json.response.editurl).addQuery('line', linenumber).addQuery('modal', 'modal').normalizeQuery().toString();
						$('.page').loadin(pageurl, function() {
							edit_itempricing(itemID, custID,  function() {
								$(loadinto).loadin(editurl, function() {
									hideajaxloading();
									$(config.modals.ajax).resizemodal('xl').modal();
									set_childheightequaltoparent('.row.row-bordered', '.grid-item');
								});
							});
						});
					});
				});
			});
		});

		$('#add-item-modal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget);
			var addtype = button.data('addtype'); // order|cart|quote
			var modal = $(this);
			var title = '';
			var resultsurl = URI(button.data('resultsurl')).toString();
			var querystring = URI.parseQuery(URI(resultsurl).search());
			var custID = querystring.custID;
			var shipID = querystring.shipID;
			var addnonstockURI = URI(modal.find('.nonstock-btn').attr('href')).addQuery('custID', custID).addQuery('shipID', shipID);
			var addmultipleURI = URI(modal.find('.add-multiple-items').attr('href')).addQuery('custID', custID).addQuery('shipID', shipID);

			if (addnonstockURI.segment(-2) == addtype) {
				addnonstockURI.segment(-2, "");
				addmultipleURI.segment(-2, "");
			}

			switch (addtype) {
				case 'cart':
					$('#'+modal.attr('id')+ " .custID").val(custID);
					title = "Add Item";
					addnonstockURI.segment('cart');
					addmultipleURI.segment('cart');
					break;
				case 'order':
					var ordn = querystring.ordn;
					$('#'+modal.attr('id')+ " .custID").val(custID);
					title = "Add item to Order #" + ordn;
					addnonstockURI.addQuery('ordn', ordn);
					addnonstockURI.segment('order');
					addmultipleURI.addQuery('ordn', ordn);
					addmultipleURI.segment('order');
					break;
				case 'quote':
					var qnbr = querystring.qnbr;
					$('#'+modal.attr('id')+ " .custID").val(custID);
					title = "Add item to Quote #" + qnbr;
					addnonstockURI.addQuery('qnbr', qnbr);
					addnonstockURI.segment('quote');
					addmultipleURI.addQuery('qnbr', qnbr);
					addmultipleURI.segment('quote');
					break;
			}
			addnonstockURI.segment('');
			addnonstockURI.addQuery('modal', 'modal');
			addmultipleURI.segment('');
			addmultipleURI.addQuery('modal', 'modal');
			$('#add-item-modal-label').text(title);
			$('#add-item-modal .nonstock-btn').attr('href', addnonstockURI.toString());
			$('#add-item-modal .add-multiple-items').attr('href', addmultipleURI.toString());
			$('#'+modal.attr('id')+ " .resultsurl").val(resultsurl);
		});

		$('body').on('submit', '#add-multiple-item-form', function(e) {
			var form = $(this);
            if ($(this).attr('data-checked') != 'true') {
                e.preventDefault();
                $(this).validateitemids(function() {
					if (parseInt($(this).data('invaliditems')) < 1) {
	                    $(this).submit();
	                }
				});
            }
        });

		$('#add-item-modal').on('shown.bs.modal', function() {
			$('#add-item-modal .searchfield').focus();
		});

		$('#ajax-modal').on('shown.bs.modal', function() {
			if (!$('body').hasClass('modal-open')){
				$('body').addClass('modal-open');
			}
		});

		$("body").on("submit", "#add-item-search-form", function(e) {
			e.preventDefault();
			var formid = '#'+$(this).attr('id');
			var resultsurl = $(formid+ " .resultsurl").val();
			var addonurl = $(formid+ " .addonurl").val();
			var loadinto = '#' + $(this).closest('.modal').attr('id') + ' .results';
			var loadingdiv = "<div class='loading-item-results'>"+darkloadingwheel+"</div>";

			$.ajax({
				async: false,
				beforeSend: function () {
					$(loadinto).empty();
					$(loadingdiv).appendTo(loadinto);
				},
				url: $(formid).attr('action'),
				method: "POST",
				data: $(formid).serialize()
			}).done(function() {
				$(loadinto).loadin(resultsurl, function() {

				});
			});
		});

		$("body").on("submit", ".quick-entry-add", function(e) {
			e.preventDefault();
		});

		/*==============================================================
			CI / II / VI FUNCTIONS
		=============================================================*/
		//setup before functions
		var typingTimer;                //timer identifier
		var doneTypingInterval = 300;  //time in ms, 5 second for example
		
		$("body").on("keyup", ".ii-item-search", function() {
			clearTimeout(typingTimer);
			typingTimer = setTimeout(function() {
				ii_itemsearch()
			}, doneTypingInterval);
		});
		
		//on keydown, clear the countdown 
		$("body").on("keydown", ".ii-item-search", function () {
			clearTimeout(typingTimer);
		});
		
		function ii_itemsearch() {
			var thisform = $(".ii-item-search").closest('form');
			var href = thisform.attr('action')+"?q="+urlencode($(".ii-item-search").val());
			var loadinto = '#item-results';
			$(loadinto).loadin(href, function() { });
		}
		

		$("body").on("submit", "#ci-search-item", function(e) {
			e.preventDefault();
		});

		$("body").on("keyup", ".ci-item-search", function() {
			var input = $(this);
			var thisform = input.parent('form');
			var custID = thisform.find('input[name=custID]').val();
			//var shipID = thisform.find('input[name=shipID]').val();
			var action = thisform.find('input[name=action]').val();
			var href  = URI(thisform.attr('action')).addQuery('q', urlencode(input.val()))
												   .addQuery('custID', urlencode(custID))
												   //.addQuery('shipID', urlencode(shipID))
												   .addQuery('action', urlencode(action))
												   .toString();
			var loadinto = '#item-results';
			$(loadinto).loadin(href, function() { });
		});

		$("body").on("keyup", ".ci-history-item-search", function() {
				var input = $(this);
				var thisform = input.closest('form');
				var custID = thisform.find('input[name=custID]').val();
				var shipID = thisform.find('input[name=shipID]').val();
				var action = thisform.find('input[name=action]').val();
				var loadinto = '#item-results';
				var href  = URI(input.data('results')).addQuery('q', urlencode(input.val()))
													   .addQuery('custID', urlencode(custID))
													   .addQuery('shipID', urlencode(shipID))
													   .addQuery('action', urlencode(action))
													   .toString();
				$(loadinto).loadin(href, function() { });
		});

		$("body").on("submit", "#cust-index-search-form", function(e) {
			e.preventDefault();
			var form = $(this);
			var q = form.find('[name=q]').val();
			var pagefunction = form.find('[name=function]').val();
			var loadinto = '#cust-results';
			var href = URI(form.attr('action')).addQuery('q', q).addQuery('function', pagefunction);
			if (form.find('[name=field]').length) {
				var field = form.find('[name=field]').val();
				href.addQuery('field', field);
			}
			href = href.toString();
			$(loadinto).loadin(href+' '+loadinto, function() {

			});
		});

		$("body").on("submit", "#cust-contact-search-form", function(e) {
			e.preventDefault();
			var form = $(this);
			var q = form.find('[name=q]').val();
			var pagefunction = form.find('[name=function]').val();
			var custID = form.find('[name=custID]').val();
			var shipID = form.find('[name=shipID]').val();
			var loadinto = '#contact-results';
			var uri = URI(form.attr('action')).addQuery('q', q).addQuery('function', pagefunction);
			href = uri.addQuery('custID', custID).addQuery('shipID', shipID).toString();

			$(loadinto).empty();
			var loadingwheel = $(darkloadingwheel);
			loadingwheel.addClass('display-inline-block').addClass('text-center');
			$(loadinto).append("<div class='text-center'>"+loadingwheel.prop('outerHTML')+"</div>");

			$(loadinto).loadin(href+' '+loadinto, function() {

			});
		});

		$("body").on("submit", "#vi-search-item", function(e) {
			e.preventDefault();
		});

		$("body").on("keyup", ".vi-item-search", function() {
			var input = $(this);
			var thisform = input.parent('form');
			var vendorID = thisform.find('input[name=vendorID]').val();
			var action = thisform.find('input[name=action]').val();
			var href  = URI(thisform.attr('action')).addQuery('q', urlencode(input.val()))
												   .addQuery('vendorID', urlencode(vendorID))
												   .addQuery('action', urlencode(action))
												   .toString();
			var loadinto = '#item-results';
			$(loadinto).loadin(href, function() { });
		});

		$("body").on("submit", "#vend-index-search-form", function(e) {
			e.preventDefault();
		});

		$("body").on("keyup", ".vend-index-search", function() {
			var thisform = $(this).closest('form');
			var pagefunction = thisform.find('[name=function]').val();
			var loadinto = '#vend-results';
			var href = URI(thisform.attr('action')).addQuery('q', $(this).val())
												   .addQuery('function', pagefunction)
												   .toString();
			$(loadinto).loadin(href+' '+loadinto, function() {
			});
		});

		$('body').on('click', '.load-doc', function(e) {
			e.preventDefault();
			var button = $(this);
			var doc = button.data('doc');
			var href = config.urls.products.ii.json.ii_moveitemdoc + "?docnumber="+doc;
			$.getJSON(href, function(json) {
				if (!json.response.error) {
					var td = button.parent();
					td.find('.load-doc').remove();
					var href = "<a href='"+config.urls.orderfiles+json.response.file+"' class='btn btn-sm btn-success' target='_blank'><i class='fa fa-file-text' aria-hidden='true'></i> View Document</a>";
					$(href).appendTo(td);
				} else {
					swal({
						title: 'Error!',
						text: json.response.message,
						type: 'error',
					});
				}
			});
		});

		/*==============================================================
			ACTIONS FUNCTIONS
			FOR TASKS, LISTING
		=============================================================*/
		$("body").on("change", "#actions-panel .change-action-type, #actions-modal-panel .change-action-type", function() {
			var select = $(this);
			var actiontype = select.val();
			var regexhref = select.data('link');
			var href = regexhref.replace(/{replace}/g, actiontype);
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			$(loadinto).loadin(href, function() { });
		});

		$("body").on("change", "#actions-panel .change-actions-user, #actions-modal-panel .change-actions-user", function() {
			var select = $(this);
			var userID = select.val();
			var href = URI(select.data('link')).addQuery('assignedto', userID).toString();
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			showajaxloading();
			$(loadinto).loadin(href, function() {
				hideajaxloading();
			});
		});

		$("body").on("change", "#view-action-task-status", function(e) {
			e.preventDefault();
			var status = $(this).val();
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var href = URI($(this).data('url')).addQuery('tasks-status', status).toString();
			loadin(href, loadinto, function() { //ON PURPOSE to know it was reloaded
				if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
				init_bootstraptoggle();
			});
		});

		$("body").on("click", ".add-action", function(e) {
			e.preventDefault();
			var button = $(this);
			swal({
				title: 'What type of Action would you like to make?',
				input: 'select',
				buttonsStyling: false,
				type: 'question',
				confirmButtonClass: 'btn btn-sm btn-success',
				cancelButtonClass: 'btn btn-sm btn-danger',
				inputClass: 'form-control',
				inputOptions: {
					'task': 'Task',
					'note': 'Note'
				},
				inputPlaceholder: 'Select Action Type',
				showCancelButton: true,
				inputValidator: function (value) {
					return new Promise(function (resolve, reject) {
						if (value.length) {
							resolve();
						} else {
							reject('You need to select an Action Type')
						}
					});
				}
			}).then(function (result) {
				var regexhref = button.attr('href');
				var href = URI(regexhref).addQuery('type', result).addQuery('modal', 'modal').toString();
				var modal = button.data('modal');
				var loadinto =  modal+" .modal-content";
				$(loadinto).loadin(href, function() {
					$(modal).resizemodal('lg').modal();
				});
			}).catch(swal.noop);
		});

		$("body").on("click", ".complete-action", function(e) {
			e.preventDefault();
			var button = $(this);
			var url = button.attr('href');
			$.getJSON(url, function(json) {
				if (json.response.error) {
					swal({
						title: 'Error',
						text: json.response.message,
						type: 'error',
					}).catch(swal.noop);
				} else {
					button.closest('.modal').modal('hide');
					swal({
						title: 'Confirm task as complete?',
						html:
							'<b>ID:</b> ' + json.response.action.id + '<br>' +
							'<b>Description:</b> ' + json.response.action.textbody,
						type: 'question',
						showCancelButton: true,
						confirmButtonText: 'Confirm as Complete'
					}).then(function() {
						swal({
							title: "Leave Reflection Note?",
							text: "Enter note or leave blank",
							input: 'textarea',
							showCancelButton: true
						}).then(function (text) {
							if (text) {
								$.post(json.response.action.urls.completion, {reflectnote: text})
									.done(function(json) {
										$('.actions-refresh').click();
										$(config.modals.ajax).modal('hide');
										$.notify({
											title: ucfirst(json.response.notifytype)+"!",
											icon: json.response.icon,
											message: json.response.message
										},{
											element: "body",
											type: json.response.notifytype,
											timer: 1000,
										});
									});
							} else {
								$.get(json.response.action.urls.completion, function(json) {
									$('.actions-refresh').click();
									$(config.modals.ajax).modal('hide');
									$.notify({
										title: ucfirst(json.response.notifytype)+"!",
										icon: json.response.icon,
										message: json.response.message
									},{
										element: "body",
										type: json.response.notifytype,
										timer: 1000,
									});
								});
							}
							swal.close();
						}).catch(swal.noop);
					}).catch(swal.noop); //FOR CANCEL
				}
			});
		});

		$("body").on("click", ".reschedule-task", function(e) {
	        e.preventDefault();
	        var button = $(this);
	        var url = button.attr('href');
	        var modal = config.modals.ajax;
	        var loadinto = config.modals.ajax+" .modal-content";
	        $(loadinto).loadin(url, function() {
	            $(modal).resizemodal('lg').modal();
				init_datepicker();
	        });
	    });

		$("body").on("change", "#view-action-completion-status", function(e) {
			e.preventDefault();
			var select = $(this);
			var url = select.data('url');
			var completionstatus = select.val();
			var loadinto = select.data('loadinto');
			var focuson = select.data('focuson');
			var href = URI(url).addQuery('action-status', completionstatus).toString();
			$(loadinto).loadin(href, function() { });
		});

		$("body").on("submit", "#new-action-form", function(e) {
			e.preventDefault();
			var form = $(this);
			var modal = form.data('modal');
			var formid = "#"+$(this).attr('id');
			var action = form.attr('action');
			var elementreload = form.data('refresh');
			var isformcomplete = form.formiscomplete('tr');

			if (isformcomplete) {
				$(formid).postform({formdata: false, jsoncallback: true, action: false}, function(json) {
					$.notify({
						icon: json.response.icon,
						message: json.response.message,
					},{
						element: modal + " .modal-body",
						type: json.response.notifytype,
						placement: {
							from: "top",
							align: "center"
						},
						onClose: function() {
							wait(200, function() {
								$(elementreload + " .actions-refresh").click();
								$(modal).modal('hide');
							});
						}
					});
				});
			}
		});

		$('body').on("change", ".change-assignedto", function() {
			var select = $(this);
			$('#new-action-form').find('input[name="assignedto"]').val(select.val());
		});

	/*==============================================================
		EDIT LINE ITEM FUNCTIONS
	=============================================================*/
	$(".page").on("click", ".update-line", function(e) {
		e.preventDefault();
		showajaxloading();
		var url = URI($(this).attr('href')).addQuery('modal', 'modal').toString();
		var itemID = $(this).data('itemid');
		var custID = $(this).data('custid');
		var modal = config.modals.ajax;
		var loadinto = modal + " .modal-content";
		if ($.inArray(itemID, config.products.nonstockitems) > -1) {
			console.log('skipping item get');
			$(loadinto).loadin(url, function() {
				hideajaxloading();
				$(modal).resizemodal('xl').modal();
			});
		} else {
			edit_itempricing(itemID, custID,  function() {
				$(loadinto).loadin(url, function() {
					hideajaxloading();
					$(modal).resizemodal('xl').modal();
					set_childheightequaltoparent('.row.row-bordered', '.grid-item');
					$('.item-form').height($('.item-information').actual('height'));
				});
			});
		}
	});
});

/*==============================================================
	AJAX FUNCTIONS
=============================================================*/
	function generate_notavailablefunction() {
		var modal = $(config.modals.ajax);
		modal.find('.modal-body').html("<h4>Function not available</h4>");
		modal.resizemodal('lg').modal();
	}

	function wait(time, callback) {
		var timeoutID = window.setTimeout(callback, time);
	}

	function dplusrequest(url, callback) {
		console.log(url);
		$.get(url, function() {
			callback();
		});
	}

	function dplusrequesturl(geturl, callback) {
		$.get(geturl, function() {
			generateurl(function(url) {
				callback(url);
			});
		});
	}

	function generateurl(callback) {
		console.log(config.urls.json.getloadurl);
		$.getJSON(config.urls.json.getloadurl, function(json) {
			callback(json.response.url);
		});
	}

 	function showajaxloading() {
		var close = makeajaxclose("hideajaxloading()");
		var loadingdiv = "<div class='loading'>"+loadingwheel+"</div>";
		$('.modal').modal('hide');
		$("<div class='modal-backdrop tribute loading-bkgd fade in'></div>").html(close+loadingdiv).appendTo('body');
		listener.simple_combo("esc", function() { hideajaxloading(); });
	}

	function hideajaxloading() {
		$('body').find('.loading-bkgd').remove();
		listener.unregister_combo("esc");
	}

	function makeshadow() {
		$('body').find('.modal-backdrop').addClass('darkAmber').removeClass(config.modals.gradients.default).css({'z-index':'20'});;
	}

	function removeshadow() {
		$('body').find('.modal-backdrop').addClass(config.modals.gradients.default).removeClass('darkAmber').css({'z-index':'15'});;
	}

	function loadin(url, element, callback) {
		var parent = $(element).parent();
		$(element).remove();
		parent.load(url, function() { callback(); });
	}

	(function ( $ ) {
		// Pass an object of key/vals to override
		$.fn.serializeform = function(overrides) {
			// Get the parameters as an array
			var newParams = this.serializeArray();

			for(var key in overrides) {
				var newVal = overrides[key]
				// Find and replace `content` if there
				for (index = 0; index < newParams.length; ++index) {
					if (newParams[index].name == key) {
						newParams[index].value = newVal;
						break;
					}
				}
				// Add it if it wasn't there
				if (index >= newParams.length) {
					newParams.push({
						name: key,
						value: newVal
					});
				}
			}
			// Convert to URL-encoded string
			return $.param(newParams);
		}
	}(jQuery));

	$.fn.extend({
		postform: function(options, callback) { //{formdata: data/false, jsoncallback: true/false, action: true/false}
			var form = $(this);
			console.log('submitting ' + form.attr('id'));
			if (!options.action) {options.action = form.attr('action');}
			if (!options.formdata) {options.formdata = form.serialize();}
			if (options.jsoncallback) {
				$.post(options.action, options.formdata, function(json) {callback(json);});
			} else if (options.html) {
				$.post(options.action, options.formdata, function(html) {callback(html);});
			} else {
				$.post(options.action, options.formdata).done(function() {callback();});
			}
		},
		postformsync: function(options, callback) {
			var form = $(this);
			var action = form.attr('action');

			if (!options.formdata) {options.formdata = form.serialize(); }
			if (options.jsoncallback) {
				$.ajax({async: false, url: action, method: "POST", data: options.formdata}).done(callback(json));
			} else {
				$.ajax({async: false, url: action, method: "POST", data: options.formdata}).done(callback());
			}
		},
		loadin: function(href, callback) {
			var element = $(this);
			var parent = element.parent();
			console.log('loading ' + element.returnelementdescription() + " from " + href);
			parent.load(href, function() { init_datepicker(); init_timepicker(); callback(); });
		},
		returnelementdescription: function() {
			var element = $(this);
			var tag = element[0].tagName.toLowerCase();
			var classes = '';
			var id = '';
			if (element.attr('class')) {
				classes = element.attr('class').replace(' ', '.');
			}
			if (element.attr('id')) {
				id = element.attr('id');
			}
			var string = tag;
			if (classes) {
				if (classes.length) {
					string += '.'+classes;
				}
			}
			if (id) {
				if (id.length) {
					string += '#'+id;
				}
			}
			return string;
		},
		validateitemids: function(callback) {
            var custID = $(this).find('input[name="custID"]').val();
            var valid = true;
			var form = $(this);
			var formdata = form.serialize();
			var url = URI(config.urls.json.validateitems).query(formdata).toString();

			$.getJSON(url, function(json) {
				form.attr('data-invaliditems', json.invalid);
				form.find('.itemid').each(function() {
	                var field = $(this);
	                var itemID = $(this).val();
				    if (!json.items.valid[itemID]) {
						field.parent().addClass('has-error');
					}
	            });
				form.attr('data-checked', 'true');

				if (json.invalid) {
	                form.find('.response').createalertpanel('Double Check your itemIDs', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>', 'warning');
	            } else {
					form.find('.response').createalertpanel('All your items are valid, verify and submit', '', 'success');
	            }
			});
			callback();
        }
	});

	function get_paginationurl(form) {
		var showonpage = form.find('.results-per-page').val();
		var displaypage = form.attr('action');
		return URI(displaypage).addQuery('display', showonpage).toString();
	}

/*==============================================================
	TOOLBAR FUNCTIONS
=============================================================*/
	function showtoolbar() {
		var close = makeajaxclose("hidetoolbar()");
		$("<div class='modal-backdrop toolbar fade in'></div>").html(close).appendTo('body');
		$(config.toolbar.toolbar).removeClass('zoomOut').show().animatecss('bounceInLeft');
		$(config.toolbar.button).find('span').removeClass('glyphicon glyphicon-plus').addClass('glyphicon glyphicon-minus');
	}

	function hidetoolbar() {
		$('body').find('.modal-backdrop.toolbar.fade.in').remove();
		$(config.toolbar.toolbar).removeClass('bounceInLeft').hide(1000).animatecss('zoomOut');
		$(config.toolbar.button).find('span').removeClass('glyphicon glyphicon-minus').addClass('glyphicon glyphicon-plus');
	}

/*==============================================================
	URL FUNCTIONS
=============================================================*/
	function urlencode(str) {
		return encodeURIComponent(str);
	}

	var cleanparams = function(data) {
		var result = {};
		Object.keys(data).filter(function(key) {
			return Boolean(data[key]) && data[key].length;
		}).forEach(function(key) {
			result[key] = data[key];
		});
		return result;
	};

	var remove_emptyparams = function(data) {
		var result = {};
		Object.keys(data).filter(function(key) {
			return Boolean(data[key]) && data[key].length;
		}).forEach(function(key) {
			if (data[key] != '') {
				result[key] = data[key];
			}
		});
		return result;
	}

/*==============================================================
	EDIT ITEM FUNCTIONS
=============================================================*/
	function choose_itemwhse(itemID, whse) {
		var form = '#'+itemID+"-form";
		var whsefield = '.'+itemID+'-whse';
		var whserow = '.'+whse+"-row";
		$(form+" .item-whse-val").text(whse).parent().show();
		$(whsefield).val(whse);
		$('.warning').removeClass('warning');
		$(whserow).addClass('warning');
	}

	function edit_itempricing(itemID, custID, callback) {
		var url = config.urls.products.redir.getitempricing+"&itemID="+urlencode(itemID)+"&custID="+urlencode(custID);
		$.get(url, function() { callback(); });
	}

	 function ii_kitcomponents(itemID, qty, callback) {
		var url = config.urls.products.redir.ii_kit+"&itemID="+urlencode(itemID)+"&qty="+urlencode(qty);
		$.get(url, function() { callback(); });
	}

/*==============================================================
	REORDER FUNCTIONS
=============================================================*/
	function reorder(ordn) {
		//var url = URI(config.urls.cart.redir.reorder).addQuery('from', 'salesorder').addQuery('ordn', ordn);
		var url = URI(config.urls.cart+'redir/?action=reorder').addQuery('from', 'salesorder').addQuery('ordn', ordn).toString();
		var geturl = URI(config.urls.index+"ajax/json/cart/get-added-items/").addQuery('from', 'salesorder').addQuery('ordn', ordn).toString();
		sendreorder(url, geturl);
	}

	function sendreorder(requesturl, jsonurl) {
		dplusrequest(requesturl, function() {
			$.getJSON(jsonurl, function(json) {
				$.notify({
					icon: json.response.icon,
					message: json.response.message + "<br> (Click this Message to go to the cart.)",
					url: config.urls.cart,
					target: '_self'
				},{
					type: json.response.notifytype,
					url_target: '_self'
				});
			});
		});
	}

/*==============================================================
	STRING FUNCTIONS
=============================================================*/
	function validate_email(email) {
		var emailregex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/;
		return emailregex.test(email);
	}

	function format_phone(input) {
		// Strip all characters from the input except digits
		input = input.replace(/\D/g,'');

		// Trim the remaining input to ten characters, to preserve phone number format
		input = input.substring(0,10);

		// Based upon the length of the string, we add formatting as necessary
		var size = input.length;
		if (size == 0){
			input = input;
		} else if(size < 4){
			input = input;
		} else if(size < 7){
			input = input.substring(0,3)+'-'+input.substring(3,6);
		} else {
			input = input.substring(0,3)+'-'+input.substring(3,6)+'-'+input.substring(6,10);
		}
		return input;
	}

	function ucfirst(str) {
		var pieces = str.split(" ");
		for ( var i = 0; i < pieces.length; i++ ) {
			var j = pieces[i].charAt(0).toUpperCase();
			pieces[i] = j + pieces[i].substr(1);
		}
		return pieces.join(" ");
	}

	function getordinalsuffix(i) {
		var j = i % 10, k = i % 100;
		if (j == 1 && k != 11) { return i + "st"; }
		if (j == 2 && k != 12) { return i + "nd"; }
		if (j == 3 && k != 13) { return i + "rd"; }
		return i + "th";
	}

	Number.prototype.formatMoney = function(c, d, t) {
		var n = this,
		    c = isNaN(c = Math.abs(c)) ? 2 : c,
		    d = d == undefined ? "." : d,
		    t = t == undefined ? "," : t,
		    s = n < 0 ? "-" : "",
		    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
		    j = (j = i.length) > 3 ? j % 3 : 0;
		   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 };

/*==============================================================
	FORM FUNCTIONS
=============================================================*/
	function comparefieldvalues(field1, field2) {
		return ($(field1).val() == $(field2).val());
	}

	function disable_enterkey(e) {
		var key;
		if (window.event) {
			key = window.event.keyCode; //IE
		} else {
			key = e.which; //firefox
		}
	}

	function init_datepicker() {
		$('.datepicker').each(function(index) {
			$(this).datepicker({
				date: $(this).find('.date-input').val(),
				allowPastDates: true,
			});
		});
	}

	function init_timepicker() {
		$('.timepicker').timepicker({
			'scrollDefault': 'now',
			'timeFormat': 'h:i A'
		});
	}

	function init_bootstraptoggle() {
		$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info'});
	}

	$.fn.extend({
		formiscomplete: function(highightelement) {
			var form = $(this);
			var missingfields = new Array();
			form.find('.has-error').removeClass('has-error');
			form.find('.response').empty();
			form.find('.required').each(function() {
				if ($(this).val() === '') {
					var row = $(this).closest(highightelement);
					row.addClass('has-error');
					missingfields.push(row.find('.control-label').text());
				}
			});

			if (missingfields.length > 0) {
				var message = 'Please Check the following fields: <br>';
				for (var i = 0; i < missingfields.length; i++) {
					message += missingfields[i] + "<br>";
				}
				$('#'+form.attr('id') + ' .response').createalertpanel(message, "<span class='glyphicon glyphicon-warning-sign'></span> Error! ", "danger");
				$('html, body').animate({scrollTop: $('#'+form.attr('id') + ' .response').offset().top - 120}, 1000);
				return false;
			} else {
				return true;
			}
		}
	});

/*==============================================================
	CONTENT FUNCTIONS
=============================================================*/
	$.fn.extend({
		animatecss: function (animationName) {
			var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			this.addClass('animated ' + animationName).one(animationEnd, function() {
				$(this).removeClass('animated ' + animationName);
			});
			return $(this);
		},
		resizemodal: function (size) {
			$(this).children('.modal-dialog').removeClass('modal-xl').removeClass('modal-lg').removeClass('modal-sm').removeClass('modal-md').removeClass('modal-xs').addClass('modal-'+size);
			return $(this);
		},
		createalertpanel: function(alert_message, exclamation, alert_type) {
			var alertheader = '<div class="alert alert-'+alert_type+' alert-dismissible" role="alert">';
			var closebutton = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
			var message = '<strong>'+exclamation+'</strong> ' + alert_message
			var closeheader = '</div>';
			var thealert = alertheader + closebutton + message + closeheader;
			$(this).html(thealert);
		}
	});

	function setequalheight(container) {
		var height = 0;
		$(container).each(function() {
			if ($(this).actual( 'height' ) > height) {
				height = $(this).actual( 'height' );
			}
		});
		$(container).height(height);
	}

	function set_childheightequaltoparent(parent, child) {
		$(parent).each(function() {
			var parentheight = $(this).actual('height');
			$(this).find(child).height(parentheight);
		});
	}

	function makeajaxclose(onclick) {
		return '<div class="close"><a href="#" onclick="'+onclick+'"><i class="material-icons md-48 md-light"></i></a></div>';
	}

	function duplicateitem(list) {
		$('.duplicable-item:last').clone()
                          .find("input:text").val("").end()
                          .appendTo(list);
		$('.duplicable-item:last input:first').focus();

	}

	function fill_frommodal(field, value) {
		var modal = config.modals.ajax;
		$(field).val(value);
		$(modal).modal('hide');
		$('html, body').animate({scrollTop: $(field).offset().top - 80}, 1000);
	}
