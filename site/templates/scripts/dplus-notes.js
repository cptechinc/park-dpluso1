$(function() {
    var formfields = {
        form1: '#note1', form2: '#note2', form3: '#note3', form4: '#note4', form5: '#form5', type: '.type', key1: '.key1', key2: '.key2', recnbr: '.recnbr'
    }
    
    $("body").on("click", ".dplusnote", function(e) {
        e.preventDefault();
        $('.bg-warning').removeClass('bg-warning');
        var button = $(this);
        var geturl = button.attr('href');
        var form = button.data('form');
        $.getJSON(geturl, function(json) {
            var note = json.note;
            
            for (var i = 1; i < 6; i++) {
                $('#note'+i).bootstrapToggle(togglearray[note["form"+i]]);
            }
            
            $(form + ' .note').val(note.notefld);
            $(form + ' .action').val('edit-note');
            $(form + ' .recnbr').val(note.recno);
            button.addClass('bg-warning');
        });
    });
    
    $("body").on("submit", "#notes-form", function(e)  {
        e.preventDefault();
        var form = $(this);
        var validateurl = URI(config.urls.json.dplusnotes).addQuery('key1', $(formfields.key1).val())
                                                          .addQuery('key2', $(formfields.key2).val())
                                                          .addQuery('type', $(formfields.type).val()).toString();
        var formid = "#"+form.attr('id');
        var formvalues = new dplusquotenotevalues(formfields);
        var formcombo = formvalues.form1 + formvalues.form2 + formvalues.form3 + formvalues.form4 + formvalues.form5;
        var loadinto = config.modals.ajax+" .modal-body";
        var loadurl = form.find('.notepage').val();
        var currentrecnbr = form.find('.recnbr').val();
        var existingrecnbr = 0;
        
        $.getJSON(validateurl, function(json) {
            if (json.notes.length > 0) {
                $(json.notes).each(function(index, note) {
                    var notecombo = note.form1 + note.form2 + note.form3 + note.form4 + note.form5;
                    
                    if (formcombo == notecombo) {
                        existingrecnbr = note.recno;
                        return false;
                    } else {
                        if (note.recno == currentrecnbr) {
                            console.log('recno = ' + currentrecnbr);
                            currentrecnbr = false;
                            form.find('.recnbr').val('');
                        }
                    }
                });
            }

            if (existingrecnbr != currentrecnbr) {
                var onclick = '$(".rec'+existingrecnbr+'").click()';
                var button = "<button type='button' class='btn btn-primary salesnote' onclick='"+onclick+"'>Click to Edit note</button>";
                $('#notes-form .response').createalertpanel('This note already exists <br> '+button, 'Error!', 'warning');
            } else {
                var recnbr = 1;
                if (currentrecnbr) {
                    recnbr = currentrecnbr;
                    form.find('.action').val('edit-note');
                } else {
                    form.find('.action').val('add-note');
                }
                
                form.postform({}, function() { 
                    wait(1000, function() {
                        $(loadinto).loadin(loadurl, function() {
                             $.notify({
                                icon: "&#xE8CD;",
                                message: "Your note has been saved",
                            },{
                                type: "success",
                                icon_type: 'material-icon',
                                 onShown: function() {
                                     $(".rec"+recnbr).click()
                                 },
                            });
                        });
                    });
                });
            }
        });
    });
});

function find_recnbr(notes, formcombo) {
    var recnbr = 0;
    if (notes.length > 0) {
        $(notes).each(function(index, note) {
            var notecombo = note.form1 + note.form2 + note.form3 + note.form4 + note.form5;
            if (formcombo == notecombo) {
                return note.recno;
            }
        });
    }
    return recnbr;
}
