$(document).ready(function() {
    
    if ($("#leaveList_txtEmployee").val() == '' || $("#leaveList_txtEmployee").val() == lang_typeHint) {
        $("#leaveList_txtEmployee").addClass("inputFormatHint").val(lang_typeHint);
    }

    $("#leaveList_txtEmployee").one('focus', function() {

        if ($(this).hasClass("inputFormatHint")) {
            $(this).val("");
            $(this).removeClass("inputFormatHint");
        }
    });


    //Auto complete
    $("#leaveList_txtEmployee").autocomplete(data, {
        formatItem: function(item) {
            return item.name;
        }
        ,
        matchContains:true
    }).result(function(event, item) {
        $('#leaveList_txtEmpID').val(item.id);
    });

    $("#leaveList_txtEmployee").change(function(){
        autoFill('leaveList_txtEmployee', 'leaveList_txtEmpID', data);
    });

    function autoFill(selector, filler, data) {
        $("#" + filler).val(0);
        if($("#" + selector).val().trim() == "") {
            $("#" + filler).val("");
        }

        $.each(data, function(index, item){
            if(item.name.toLowerCase() == $("#" + selector).val().toLowerCase()) {
                $("#" + filler).val(item.id);
                return true;
            }
        });
    }
    
    var validator = $("#frmFilterLeave").validate({

        rules: {
            'leaveList[calFromDate]' : {
                valid_date: function() {
                    return {
                        format:datepickerDateFormat,
                        required:false
                    }
                }
            },
            'leaveList[calToDate]' : {
                valid_date: function() {
                    return {
                        format:datepickerDateFormat,
                        required:false
                    }
                },
                date_range: function() {
                    return {
                        format:datepickerDateFormat,
                        fromDate:$('#calFromDate').val()
                    }
                }
            }
        },
        messages: {
            'leaveList[calFromDate]' : {
                valid_date: lang_invalidDate
            },
            'leaveList[calToDate]' : {
                valid_date: lang_invalidDate ,
                date_range: lang_dateError
            }

        },
        errorPlacement: function(error, element) {
            error.appendTo(element.prev('label'));
        }

    });

    // disabling dialog by default
    $("#commentDialog").dialog({
        autoOpen: false,
        width: 350,
        height: 300
    });

    //open when the pencil mark got clicked
    $('.dialogInvoker').click(function() {
        $('#ajaxCommentSaveMsg').html('').removeAttr('class');
        $("#leaveComment").attr("disabled","disabled");
        //removing errors message in the comment box
        $("#commentError").html("");

        $("#commentSave").attr("value", lang_edit);

        /* Extracting the request id */
        var id = $(this).parent().siblings('input[id^="hdnLeaveRequest_"]').val();
        if (!id) {
            id = $(this).parent().siblings('input[id^="hdnLeave_"]').val();
        }
        var comment = $('#hdnLeaveComment-' + id).val();

        $('#leaveId').val(id);
        $('#leaveComment').val(comment);
        $('#leaveOrRequest').val('request');

        $('#commentDialog').dialog('open');
    });
    
    //closes the dialog
    $("#commentCancel").click(function() {
        $("#commentDialog").dialog('close');
    });

    //on clicking on save button
    $("#commentSave").click(function() {
        if($("#commentSave").attr("value") == lang_edit) {
            $("#leaveComment").removeAttr("disabled");
            $("#commentSave").attr("value", lang_save);
            return;
        }

        if($('#commentSave').attr('value') == lang_save) {
            $('#commentError').html('');
            var comment = $('#leaveComment').val().trim();
            if(comment.length > 250) {
                $('#commentError').html(lang_length_exceeded_error);
                return;
            }

            /* Setting the comment in the label */
            var commentLabel = trimComment(comment);

            /* If there is no-change between original and updated comments then don't show success message */
            if($('#hdnLeaveComment-' + $("#leaveId").val()).val().trim() == comment) {
                $('#commentDialog').dialog('close');
                return;
            }

            /* We set updated comment for the hidden comment field */
            $('#hdnLeaveComment-' + $('#leaveId').val()).val(comment);

            /* Posting the comment */
            var url = commentUpdateUrl;
            var data = 'leaveRequestId=' + $('#leaveId').val() + '&leaveComment=' + encodeURIComponent(comment);

            /* This is specially for detailed view */
            if($('#leaveOrRequest').val() == 'leave') {
                data = 'leaveId=' + $('#leaveId').val() + '&leaveComment=' + encodeURIComponent(comment);
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function(flag) {
                    $('#ajaxCommentSaveMsg').removeAttr('class').html('');
                    $('.messageBalloon_success').remove();

                    if(flag == 1) {
                        var id = $('#leaveId').val();
                        $('#commentContainer-' + id).html(commentLabel);
                        $('#hdnLeaveComment-' + id).val(comment);
                        $('#ajaxCommentSaveMsg').attr('class', 'messageBalloon_success')
                        .html(lang_comment_successfully_saved);
                    }
                }
            });

            $("#commentDialog").dialog('close');
            return;
        }
    });

    $('#btnSearch').click(function() {
        $('#frmFilterLeave input.inputFormatHint').val('');
        $('#frmFilterLeave').submit();
    });


    $('#btnReset').click(function(event) {        
        window.location = resetUrl;
        event.preventDefault();
        return false;
    });

});
    

function trimComment(comment) {
    if (comment.length > 35) {
        comment = comment.substr(0, 35) + '...';
    }
    return comment;
}