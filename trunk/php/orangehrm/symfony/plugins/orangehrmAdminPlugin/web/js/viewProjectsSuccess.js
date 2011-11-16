$(document).ready(function() {
          
    $('#btnAdd').click(function() {
        window.location.replace(addProjectUrl);
    });
       
    $('#btnDelete').attr('disabled', 'disabled');

        
    $("#ohrmList_chkSelectAll").click(function() {
        if($(":checkbox").length == 1) {
            $('#btnDelete').attr('disabled','disabled');
        }
        else {
            if($("#ohrmList_chkSelectAll").is(':checked')) {
                $('#btnDelete').removeAttr('disabled');
            } else {
                $('#btnDelete').attr('disabled','disabled');
            }
        }
    });
    
    $(':checkbox[name*="chkSelectRow[]"]').click(function() {
        if($(':checkbox[name*="chkSelectRow[]"]').is(':checked')) {
            $('#btnDelete').removeAttr('disabled');
        } else {
            $('#btnDelete').attr('disabled','disabled');
        }
    });

    //Auto complete
    $("#searchProject_customer").autocomplete(customers, {
        formatItem: function(item) {
            return item.name;
        },
        matchContains:true
    }).result(function(event, item) {
        //$("#candidateSearch_candidateName").valid();
        });
    //Auto complete
    $("#searchProject_project").autocomplete(projects, {
        formatItem: function(item) {
            return item.name;
        },
        matchContains:true
    }).result(function(event, item) {
        //$("#candidateSearch_candidateName").valid();
        });
    //Auto complete
    $("#searchProject_projectAdmin").autocomplete(projectAdmins, {
        formatItem: function(item) {
            return item.name;
        },
        matchContains:true
    }).result(function(event, item) {
        //$("#candidateSearch_candidateName").valid();
        });
        
    $('.txtBox').one('focus', function() {
        if ($(this).hasClass("inputFormatHint")) {
            $(this).val("");
            $(this).removeClass("inputFormatHint");
        }
    });
    addTypeForHints()

    $('#btnReset').click(function(){
        window.location.replace(viewProjectUrl);
    })
    
    $('#btnSearch').click(function(){
        removeTypeForHints()
        $('#frmSearchProject').submit()
    })

    $('#btnDelete').click(function(){
        $('#frmList_ohrmListComponent').submit(function(){
            $('#deleteConfirmation').dialog('open');
            return false;
        });
    });

    $("#deleteConfirmation").dialog({
        autoOpen: false,
        modal: true,
        width: 325,
        height: 50,
        position: 'middle',
        open: function() {
            $('#dialogCancelBtn').focus();
        }
    });

    $('#frmList_ohrmListComponent').attr('name','frmList_ohrmListComponent');
    $('#dialogDeleteBtn').click(function() {
        document.frmList_ohrmListComponent.submit();
    });
    $('#dialogCancelBtn').click(function() {
        $("#deleteConfirmation").dialog("close");
    });
});

function addTypeForHints(){
    $('.txtBox').each(function(){
        if ($(this).val() == '') {
            $(this).addClass("inputFormatHint").val(lang_typeForHints);
        }
    });
}
function removeTypeForHints(){
    $('.txtBox').each(function(){
        if ($(this).hasClass("inputFormatHint")) {
            $(this).val("");
            $(this).removeClass("inputFormatHint");
        }
    });
}
