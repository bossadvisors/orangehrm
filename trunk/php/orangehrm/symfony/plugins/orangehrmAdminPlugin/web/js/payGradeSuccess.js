$(document).ready(function() {
   
    $('#btnSave').click(function() {  
        
        if($('#btnSave').val() == lang_edit){
            $('#payGrade_name').removeAttr('disabled');
            $('#btnSave').val(lang_save);
            
        } else if ($('#btnSave').val() == lang_save){
            $('#payGrade_payGradeId').val(payGradeId);
            $('#frmPayGrade').submit();
        }        
    });
    
    //auto complete
    $("#payGradeCurrency_currencyName").autocomplete(currencies, {
        formatItem: function(item) {
            return item.name;
        },
        matchContains:true
    }).result(function(event, item) {
        $('.curName').html("");
        $('#payGradeCurrency_currencyName').removeClass("error");
    });
    
    $('#btnCancel').click(function() {
        window.location.replace(viewPayGradesUrl);
    });
                
    if(payGradeId > 0){
        $('#payGrade_name').attr('disabled','disabled');
        $('#btnSave').val(lang_edit);
        $('#payGradeCurrency_payGradeId').val(payGradeId);
        $('#payGradeHeading').text(lang_editPayGrade);
    }
    
    
    ///// JQuery for currency list
    
    $('#btnAddCurrency').click(function() {  
        $('#addPaneCurrency').show();
        $('#actionButtons').show();
        $('#addDeleteBtnDiv').hide();
        $('.checkboxCurr').hide();
        validatorCurr.resetForm();
        $('#currencyHeading').text(lang_addCurrency);
        $('#payGradeCurrency_currencyName').each(function(){
            if($(this).parent().css('display') == 'block') {
                if ($(this).val() == '' || $(this).val() == lang_typeHint) {
                    $(this).addClass("inputFormatHint").val(lang_typeHint);
                }
            }
        });
   
        $('#payGradeCurrency_currencyName').one('focus', function() {
        
            if ($(this).hasClass("inputFormatHint")) {
                $(this).val("");
                $(this).removeClass("inputFormatHint");
            }

        });
    });
    
    $('#cancelButton').click(function(){
        $('#addPaneCurrency').hide();
        $('#actionButtons').hide();
        $('#addDeleteBtnDiv').show();
        $('#currencyHeading').text(lang_assignedCurrency);
        $('.checkboxCurr').show();
        validatorCurr.resetForm();
    });
    
    $('#btnSaveCurrency').click(function(){
        if ($('#payGradeCurrency_currencyName').val() == lang_typeHint) {
            $('#payGradeCurrency_currencyName').val("");
        }
        $('#frmCurrency').submit();
    });
    
    $('.editLink').click(function(event) {
		
        event.preventDefault();
        
        validatorCurr.resetForm();
        var row = $(this).closest("tr");
        var curId = row.find('input.checkboxCurr:first').val();
        var curName = row.find('a.editLink').text();
        var minSal = row.find("td:nth-child(3)").text();
        var maxSal = row.find("td:nth-child(4)").text();

        $('#payGradeCurrency_currencyId').val(curId);
        $('#payGradeCurrency_currencyName').val(curId+" - "+curName);
        $('#payGradeCurrency_minSalary').val(minSal);
        $('#payGradeCurrency_maxSalary').val(maxSal);
        $('#currencyHeading').text(lang_editCurrency);
        
        $('#addPaneCurrency').show();
        $('#actionButtons').show();
        $('.checkboxCurr').hide();
        $('#addDeleteBtnDiv').hide();
    });
    
    //if check all button clicked
    $("#currencyCheckAll").click(function() {
        $("table#tblCurrencies tbody input.checkboxCurr").removeAttr("checked");
        if($("#currencyCheckAll").attr("checked")) {
            $("table#tblCurrencies tbody input.checkboxCurr").attr("checked", "checked");
        }
    });

    //remove tick from the all button if any checkbox unchecked
    $("table#tblCurrencies tbody input.checkboxCurr").click(function() {
        $("#currencyCheckAll").removeAttr('checked');
        if($("table#tblCurrencies tbody input.checkboxCurr").length == $("table#tblCurrencies tbody input.checkboxCurr:checked").length) {
            $("#currencyCheckAll").attr('checked', 'checked');
        }
    });
    
    $('#btnDeleteCurrency').click(function() {

        var checked = $('#frmDelCurrencies input:checked').length;

        if (checked > 0) {
            $('#frmDelCurrencies').submit();
        }
    });

    $.validator.addMethod("uniquePayGradeName", function(value, element, params) {
        var temp = true;
        var currentName;
        var id = $('#payGrade_payGradeId').val();
        var vcCount = payGradeList.length;
        for (var j=0; j < vcCount; j++) {
            if(id == payGradeList[j].id){
                currentName = j;
            }
        }
        var i;
        vcName = $.trim($('#payGrade_name').val()).toLowerCase();

        for (i=0; i < vcCount; i++) {
            arrayName = payGradeList[i].name.toLowerCase();
            if (vcName == arrayName) {
                temp = false
                break;
            }
        }
        if(currentName != null){
            if(vcName == payGradeList[currentName].name.toLowerCase()){
                temp = true;
            }
        }
		
        return temp;
    });
    
    var validator = $("#frmPayGrade").validate({

        rules: {
            'payGrade[name]' : {
                required:true,
                maxlength: 50,
                uniquePayGradeName: true
            }
        },
        messages: {
            'payGrade[name]' : {
                required: lang_NameRequired,
                maxlength: lang_exceed50Charactors,
                uniquePayGradeName: lang_uniquePayGradeName
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.next('div.errorHolder'));

        }

    });
    
    $.validator.addMethod("currencyValidation", function(value, element, params) {
        
        var curCount = currencyList.length;
        var isValid = false;
        var curName = $('#payGradeCurrency_currencyName').val();
        var inputName = $.trim(curName).toLowerCase();
        if(inputName != ""){
            var i;
            for (i=0; i < curCount; i++) {
                var arrayName = currencyList[i].name.toLowerCase();
                if (inputName == arrayName) {
                    isValid =  true;
                    break;
                }
            }
        }
        return isValid;
    });
    
    $.validator.addMethod("validSalaryRange", function(value, element, params) {
        
        var isValid = true;
        var minSalry = parseInt($('#payGradeCurrency_minSalary').val(), 10);
        var maxSalry = parseInt($('#payGradeCurrency_maxSalary').val(), 10);

        if(minSalry > maxSalry && maxSalry != "") {
            isValid = false;
        }
        return isValid;
    });
    
    $.validator.addMethod("uniqueName", function(value, element, params) {
        var temp = true;
        var currentName;
        var id = $('#payGradeCurrency_currencyId').val();
        var vcCount = assignedCurrencyList.length;
        for (var j=0; j < vcCount; j++) {
            if(id == assignedCurrencyList[j].id){
                currentName = j;
            }
        }
        var i;
        vcName = $.trim($('#payGradeCurrency_currencyName').val()).toLowerCase();

        for (i=0; i < vcCount; i++) {
            arrayName = assignedCurrencyList[i].name.toLowerCase();
            if (vcName == arrayName) {
                temp = false
                break;
            }
        }
        if(currentName != null){
            if(vcName == assignedCurrencyList[currentName].name.toLowerCase()){
                temp = true;
            }
        }
		
        return temp;
    });
    
    var validatorCurr = $("#frmCurrency").validate({

        rules: {
            'payGradeCurrency[currencyName]' : {
                required:true,
                maxlength: 50,
                currencyValidation: true,
                uniqueName: true
            },
            'payGradeCurrency[minSalary]' : {
                number: true,
                maxlength: 50
            },
            'payGradeCurrency[maxSalary]' : {
                number:true,
                maxlength: 50,
                validSalaryRange: true
            }
        },
        messages: {
            'payGradeCurrency[currencyName]' : {
                required: lang_currencyRequired,
                maxlength: lang_exceed50Charactors,
                currencyValidation: lang_validCurrency,
                uniqueName: lang_currencyAlreadyExist
            },
            'payGradeCurrency[minSalary]' : {
                number: lang_salaryShouldBeNumeric,
                maxlength: lang_exceed50Charactors
            },
            'payGradeCurrency[maxSalary]' : {
                number: lang_salaryShouldBeNumeric,
                maxlength: lang_exceed50Charactors,
                validSalaryRange: lang_validSalaryRange
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.next('div.errorHolder'));

        }

    });
});
