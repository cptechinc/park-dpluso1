function ajaxloadedmodal(button) {
    this.modal = button.data('modal');
    this.url = button.attr('href');
    this.loadinto = button.data('modal')+" .modal-content";
    if (button.data('modalsize')) {
        this.modalsize = button.data('modalsize');
    } else {
        this.modalsize = 'lg';
    }
}

function itemform(thisform) {
	this.thisform = thisform;
	this.formID = '#'+thisform.attr('id');
	this.itemID = thisform.find('input[name="itemID"]').val();
	this.qty = parseInt(thisform.find('input[name="qty"]').val());
	this.desc = thisform.find('input[name="desc"]').val();
}

function dplusquotenotevalues(form, quotetf) { // DEPRECATED 1/9/2018 DELETE BY 2/9/2018
    this.form1 = 'N';
    this.form2 = 'N';
    this.form3 = 'N';
    this.form4 = 'N';
    this.form5 = 'N';

    if ($(form.form1).prop('checked')) { this.form1 = 'Y'; }
    if ($(form.form2).prop('checked')) { this.form2 = 'Y'; }
    if ($(form.form3).prop('checked')) { this.form3 = 'Y'; }
    if ($(form.form4).prop('checked')) { this.form4 = 'Y'; }
    if ($(form.form5).prop('checked')) { this.form5 = 'Y'; }
}

function dplusqnotevalues(form) {
    this.form1 = 'N';
    this.form2 = 'N';
    this.form3 = 'N';
    this.form4 = 'N';
    this.form5 = 'N';
    
    if ($(form.form1).prop('checked')) { this.form1 = 'Y'; }
    if ($(form.form2).prop('checked')) { this.form2 = 'Y'; }
    if ($(form.form3).prop('checked')) { this.form3 = 'Y'; }
    if ($(form.form4).prop('checked')) { this.form4 = 'Y'; }
    if ($(form.form5).prop('checked')) { this.form5 = 'Y'; }
}

function PreviewColumn(colnumber, length, label, data, example) {
	this.colnumber = colnumber;
	this.length = length;
	this.label = label;
	this.data = data;
	this.example = example;
}

function JsContento() {
    this.open = function(element, attr) {
        var attributes = this.parseattributes(attr);
        return '<'+element+' '+attributes+'>';
    },
    this.close = function (element) {
        return '</'+element+'>';
    },
    this.openandclose = function(element, attr, content) {
        return this.open(element, attr) + content + this.close(element);
    },
    this.parseattributes = function(attr) {
        if (attr.trim() != '') {
            var array = attr.split('|');
            var attributes = '';
            
            for (var i = 0; i < array.length; i++) {
                var attribute = array[i].split('=');
                attributes += attribute[0] + '="' + attribute[1] + '" ';
            }
            return attributes.trim();
        } else {
            return '';
        }
    }
}

function SwalError(error, title, msg, html) {
    this.error = error;
    this.title = title;
    this.msg = msg;
    this.html = html;
}
