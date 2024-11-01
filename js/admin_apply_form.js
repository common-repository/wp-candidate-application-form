/*File: admin_apply_form.js
 Use:  On click of the apply button on the Apply to Job form a ajax request is triggered to send a post to the on_ic_apply function in apply_form.php. The action in the data parameters determine the function which will be called.
 */


jQuery(document).ready(function () {

    //jQuery('#wpbody #wpbody-content .wrap h1').text('Candidate Application Forms');

    if(myCustomAjax.status) {
        jQuery('#wpbody #wpbody-content .wrap h1')[0].childNodes[0].nodeValue = 'Candidate Application Forms ';
    }

    jQuery('#activation-form').submit(function(e){
        e.preventDefault();
        jQuery('#message-div').removeClass('hide-element');
        jQuery(this).ajaxSubmit({
            url: afAjax.ajaxurl,
            success: function(res){
                if(res == 'fail'){
                    jQuery('#message-div').addClass('red-text');
                    jQuery('#message-div').text('Sorry, wrond activation credential');

                }else{
                    jQuery('#wpaf_activation_maincontainer').remove();
                    jQuery('#wpbody-content .wrap .updated').remove();
                    jQuery('#wpbody-content .wrap .page-title-action').removeAttr('onclick');
                    var element = document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].getElementsByClassName("page-title-action")[0];
                    //element.href = res;
                    //element.setAttributeNode('onclick');
                }
            }
        });

        return false;
    });
    jQuery(".available_fields").draggable({
        connectToSortable: "#wp_apply_flds,#wp_ai_flds",
        helper: "clone",
        revert: "valid",
        opacity: 0.35,
        zIndex: 100000,
        appendTo: "body"
    });

    if(myCustomAjax.version != 'free') {

        jQuery("#wp_apply_flds").droppable({
            accept: ".available_fields",
            drop: function (event, ui) {
                var drag_element = (ui.draggable).clone();

                jQuery(drag_element).find('.temp_cls1').attr('name', 'af_field[]');
                jQuery(drag_element).find('.temp_cls2').attr('name', 'af_title[]');
                jQuery(drag_element).find('.temp_cls3').attr('name', 'af_options[]'); //crinch
                jQuery(drag_element).find('.temp_cls4').attr('name', 'af_explanation_text[]'); //crinch
                jQuery(drag_element).find('.temp_cls5').attr('name', 'af_explanation_text_location[]'); //crinch
                jQuery(drag_element).find('.temp_cls6').attr('name', 'af_html_styling[]'); //crinch
                jQuery(drag_element).find('.temp_cls7').attr('name', 'af_text_to_display[]'); //crinch

                jQuery(drag_element).find('.temp_cls8').attr('name', 'af_show_title_field[]'); //crinch
                jQuery(drag_element).find('.temp_cls9').attr('name', 'af_pdf_file[]'); //crinch
                jQuery(drag_element).find('.temp_cls10').attr('name', 'af_pdf_file_button_styling[]'); //crinch
                jQuery(drag_element).find('.temp_cls11').attr('name', 'af_pdf_file_button_text[]'); //crinch

                jQuery(drag_element).insertAfter("#wp_apply_flds #mCSB_2 .mCSB_container ul li:last-child");

                jQuery("#wp_apply_flds").mCustomScrollbar("update");
                jQuery(ui.helper).remove(); //destroy clone
                jQuery(ui.draggable).remove(); //remove from list

                jQuery(".available_fields").draggable({
                    connectToSortable: "#wp_ai_flds",
                    helper: "clone",
                    revert: "valid",
                    opacity: 0.35,
                    zIndex: 100000,
                    appendTo: "body"
                });

                jQuery("#wp_ai_flds").droppable({
                    accept: ".available_fields",
                    drop: function (event, ui) {
                        jQuery((ui.draggable).clone()).insertAfter("#wp_ai_flds #mCSB_1 .mCSB_container ul li:last-child");

                        /*jQuery(this).find('.post_fields').remove();  */
                        jQuery(this).find('.temp_cls1').attr('name', 'av_field[]');
                        jQuery(this).find('.temp_cls2').attr('name', 'av_title[]');
                        jQuery(this).find('.temp_cls3').attr('name', 'av_options[]'); //crinch
                        jQuery(this).find('.temp_cls4').attr('name', 'av_explanation_text[]'); //crinch
                        jQuery(this).find('.temp_cls5').attr('name', 'av_explanation_text_location[]'); //crinch
                        jQuery(this).find('.temp_cls6').attr('name', 'av_html_styling[]'); //crinch
                        jQuery(this).find('.temp_cls7').attr('name', 'av_text_to_display[]'); //crinch

                        jQuery(this).find('.temp_cls8').attr('name', 'av_show_title_field[]'); //crinch
                        jQuery(this).find('.temp_cls9').attr('name', 'av_pdf_file[]'); //crinch
                        jQuery(this).find('.temp_cls10').attr('name', 'av_pdf_file_button_styling[]'); //crinch
                        jQuery(this).find('.temp_cls11').attr('name', 'av_pdf_file_button_text[]'); //crinch


                        /*Initialize find on the new elements: code same as find li code on load dragged after being dropped once*/

                        jQuery("#wp_ai_flds").find('li').each(function () {
                            jQuery(this).unbind("click");
                        });

                        jQuery("#wp_ai_flds").find('li').each(function () {
                            jQuery(this).click(function () {
                                /*   alert('in droppable - 1');   */
                                jQuery(this).updateDialog(this);

                            });
                        });

                        /*end of initialization */


                        jQuery("#wp_ai_flds").mCustomScrollbar("update");
                        jQuery(ui.helper).remove(); //destroy clone
                        jQuery(ui.draggable).remove(); //remove from list
                        jQuery(".available_fields").draggable({
                            connectToSortable: "#wp_ai_flds",
                            helper: "clone",
                            revert: "valid",
                            opacity: 0.35,
                            zIndex: 100000,
                            appendTo: "body"
                        });


                    }
                });


            },

        });

        /*new droppable*/
        jQuery("#wp_ai_flds").droppable({
            accept: ".available_fields",
            drop: function (event, ui) {
                jQuery((ui.draggable).clone()).insertAfter("#wp_ai_flds #mCSB_1 .mCSB_container ul li:last-child");

                /*jQuery(this).find('.post_fields').remove();  */
                jQuery(this).find('.temp_cls1').attr('name', 'av_field[]');
                jQuery(this).find('.temp_cls2').attr('name', 'av_title[]');
                jQuery(this).find('.temp_cls3').attr('name', 'av_options[]');  //crinch
                jQuery(this).find('.temp_cls4').attr('name', 'av_explanation_text[]'); //crinch
                jQuery(this).find('.temp_cls5').attr('name', 'av_explanation_text_location[]'); //crinch

                jQuery(this).find('.temp_cls8').attr('name', 'av_show_title_field[]'); //crinch
                jQuery(this).find('.temp_cls9').attr('name', 'av_pdf_file[]'); //crinch
                jQuery(this).find('.temp_cls10').attr('name', 'av_pdf_file_button_styling[]'); //crinch
                jQuery(this).find('.temp_cls11').attr('name', 'av_pdf_file_button_text[]'); //crinch

                /*Initialize find on the new elements: code same as find li code on load*/

                jQuery("#wp_ai_flds").find('li').each(function () {
                    jQuery(this).unbind("click");
                });

                jQuery("#wp_ai_flds").find('li').each(function () {
                    jQuery(this).click(function () {
                        /* alert('in droppable - 2');*/
                        jQuery(this).updateDialog(this);
                    });
                });

                /*end of initialization */


                jQuery("#wp_ai_flds").mCustomScrollbar("update");
                jQuery(ui.helper).remove(); //destroy clone
                jQuery(ui.draggable).remove(); //remove from list


                jQuery(".available_fields").draggable({
                    connectToSortable: "#wp_ai_flds",
                    helper: "clone",
                    revert: "valid",
                    opacity: 0.35,
                    zIndex: 100000,
                    appendTo: "body"
                });


            }
        });
        /*end droppable*/
    }
//custom - crinch
    /*jQuery( "#add_new_button" ).dialog( "option", "buttons", [{ text: "Upload", click: function()
     { jQuery("add_new_buttonadd_new_button" ). append('<form action="../test/test_upload.php" method="POST" name="getnamefile"><input type="file" id="uploadfile" name="uploadfile"><input type="submit" id="Submit" name= "Submit" value="Upload"></form>');}
     }]);*/
//
    jQuery("#add_new_button").click(function () {
        //ADDING NEW FIELDS
        var showHideAddOptionLink = "style='display:none'";
        var showHideUploadPDFField = "style='display:none'";
        //CRINCH - VERSION2
        var showHideUploadPDFFieldExplanation = "style='display:none'";
        var showHideUploadPDFFieldExplanationLoaction = "style='display:none'";

        var showHideHTMLStylingField = "style='display:none'";
        var showHideTextToDisplayField = "style='display:none'";

        var showHideUploadPDFShowTitleField = "style='display:none'";
        var showHideUploadPDFFieldDownloadFIle = "style='display:none'";
        var showHideUploadPDFButtonStyling = "style='display:none'";
        var showHideUploadPDFDownloadText = "style='display:none'";

        var pdf_text_message_default = "Please download the PDF by clicking the 'Download' link below. Once downloaded, open the file, fill in the appropriate details, save your file with a new name then click 'Upload' to re-upload the PDF document.";
        var text_to_display = "";

        jQuery("#dialog").dialog("open");
        //01april - CRINCH done
        jQuery("#dialog").append("<form id='form_dialog' method='post' enctype='multipart/form-data'>" +
        "<table class='wpaf_dialog_table'>" +
        "<tr>" +
        "<td width='22px'>" +
        "<span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.FIELD_TYPE_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td width='110px'><span class='dialog_flds'>Field Type:</span></td>" +
        "<td>" +
        "<select onchange='notification_select(this); DeleteItemOnDropDownSelection(); showViewDisplay(this); showHideDownloadDisplay(this); return false;' id='new_field' name='new_field' style='width:180px;'>" +
        "<option value='Text'>Text</option><option value='Upload_CV'>Upload - CV</option>" +
        "<option value='Upload_Other'>Upload - Other</option>" +
        "<option value='LongText'>Long Text</option>" +
        "<option value='Numeric'>Numeric</option>" +
        "<option value='Email'>Email</option>" +
        "<option value='Dropdown'>Dropdown</option>" +
        "<option value='Checkbox'>Checkbox</option>" +
        //"<option value='EditablePDF'>Editable PDF</option>" +
        "<option value='display_text'>Display Text</option>" +
        "<option value='download_file'>Download File</option>" +
        "</select>" +
        "</td>" +
        "</tr>" +
        "<tr id='required_checkbox'>" +
        "<td>" +
        "<span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td>" +
        "<span class='dialog_flds'>Required:</span>" +
        "</td>" +
        "<td>" +
        "<input id='required_field' type='checkbox' name='required_field' value='1'>" +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>" +
        "<span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td>" +
        "<span class='dialog_flds'>Title of field:</span>" +
        "</td>" +
        "<td>" +
        "<input type='text' name='field_title' id='field_title' />" +
        "</td>" +
        "</tr>" +
        "<tr id='notification_tr' style='display:none;'>" +
        "<td>" +
        "<span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.NOTIFICATION_EMAIL_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td colspan='2'>" +
        "<span class='dialog_flds'>Send candidate notification email:</span>&nbsp;<input id='notification_field' type='checkbox' name='notification_field' value='1'></td>" +
        "</tr>" +
        "<tr id='asifarif-0' class='checkme'>" +
        "<td colspan='3'></td>" +
        "</tr>" +
        "<tr " + showHideAddOptionLink + " id='linkToCreateDynamicOption'>" +
        "<td align='center' colspan='3'>" +
        "<button type='button' id='asif_arif' class='asif_arif' onclick = 'event_add_audience_custom(); return false;'>" +
        "<span class='ui-button-text trigger'>Add OPtion</span>" +
        "</button>" +
        "</td>" +
        "</tr>" +
        //"<tr " + showHideUploadPDFField + " id='showHideUploadPDFFieldID'>" +
        //"<td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td>" +
        //"<td><span class='dialog_flds'>PDF File:</span></td><td align='left'>" +
        //"<input name='file' id='fileupload' type='file' size='15' multiple/>" +
        //"<div id='showPDFfileOnly'style='color:red;font-size:10px;'>Only PDF file!</div><div ='response'></div>" +
        //"</td>" +
        //"</tr>" +
        //"<tr " + showHideUploadPDFFieldExplanation + " id='showHideUploadPDFFieldExplanation'>" +
        //"<td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td>" +
        //"<td><span class='dialog_flds'>Explanation Text:</span></td>" +
        //"<td align='left'><textarea rows='4' cols='18' id='pdf_file_explanation' name='pdf_file_explanation'>" + decodeURI(pdf_text_message_default) + "</textarea></td></tr><tr " + showHideUploadPDFFieldExplanationLoaction + " id='showHideUploadPDFFieldExplanationLoaction'>" +
        //"<td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td>" +
        //"<td><span class='dialog_flds'>Text Location:</span></td><td align='left'>On Form<input type='radio' id='pdf_file_location' name='pdf_file_location' value='onform'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On PopUp<input type='radio' id='pdf_file_location' name='pdf_file_location' value='onpopup' checked></td>" +
        //"</tr>" +
        "<tr " + showHideHTMLStylingField + " id='showHideHTMLStyling'>" +
        "<td>" +
        "<span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td>" +
        "<span class='dialog_flds'>HTML Styling</span></td><td><input id='html_styling' type='text' name='html_styling' value=''></td>" +
        "</tr>" +
        "<tr " + showHideTextToDisplayField + " id='showHideTextToDisplay'>" +
        "<td>" +
        "<span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td>" +
        "<span class='dialog_flds'>Text to Display</span></td>" +
        "<td align='left'><textarea rows='4' cols='18' id='text_to_display' name='pdf_file_explanation'>" + decodeURI(text_to_display) + "</textarea></td>" +
        "</tr>" +
        "<tr " + showHideUploadPDFShowTitleField + " id='showHideUploadPDFShowTitleField'>" +
        "<td>" +
        "<span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span>" +
        "</td>" +
        "<td colspan='2'>" +
        "<span class='dialog_flds'>Show title of field on form?:</span>&nbsp;" +
        "<input id='pdf_download_show_field_name' type='checkbox' name='pdf_download_show_field_name' value='1'>" +
        "</td>" +
        "</tr>" +
        "<tr " + showHideUploadPDFFieldDownloadFIle + " id='showHideUploadPDFFieldDownloadFIle'>" +
        "<td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td>" +
        "<td><span class='dialog_flds'>File:</span></td><td align='left'>" +
        "<input name='file' id='pdffileupload' type='file' size='15' multiple/>" +
        "<div ='response'></div>" +
        "</td>" +
        "</tr>" +
        "<tr " + showHideUploadPDFButtonStyling + " id='showHideUploadPDFButtonStyling'>" +
        "<td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td>" +
        "<td colspan='2'><span class='dialog_flds'>Download button styling:</span>&nbsp;&nbsp;" +
        "<input type='text' id='pdf_file_button_styling' name='pdf_file_button_styling' value=''></td></tr>" +
        "<tr " + showHideUploadPDFDownloadText + " id='showHideUploadPDFDownloadText'>" +
        "<td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td>" +
        "<td colspan='2'><span class='dialog_flds'>Download button text:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' id='pdf_file_button_text' name='pdf_file_button_text' value='Download File'></td>" +
        "</tr>" +
        "</table>" +
        "</form>");
    });

    jQuery("#wp_ai_flds").find('li').each(function () {
        jQuery(this).click(function () {
            /* alert('in droppable - 3');*/
            jQuery(this).updateDialog(this);

        });
    });
    //CRINCH - custom code
    jQuery("#dialog").on("dialogclose", function (event, ui) {
        if (event.cancelable) {
            jQuery("#dialog").html('');
        } else {
            //custom, crinch
            var field_title = jQuery('#field_title').val();
            var current_value = new Array();
            jQuery("#wp_ai_flds .temp_cls2").each(function() {
                current_value.push(jQuery(this).val());
            });
            if(jQuery.inArray(field_title, current_value) != -1){
                jQuery('#fixed-form').removeClass('hide-element');
            }else{
                jQuery('#fixed-form').addClass('hide-element');

                var final_string = '';
                var new_field_type = jQuery('#new_field').val();
                //version2
                var pdf_explanation_text = '';
                var pdf_explanation_text_location = '';

                var html_styling = '';
                var text_to_display = '';

                var show_title_of_field = '';
                var download_pdf_path = '';
                var download_button_styling = '';
                var download_button_text = '';

                if (new_field_type == 'display_text') {
                    html_styling = jQuery('#html_styling').val();
                    text_to_display = jQuery('#text_to_display').val();
                }

                text_to_display = text_to_display.replace(/'/g, 'a*^!');

                if (new_field_type == 'download_file') {
                    //pdf_explanation_text_temp = jQuery('#pdf_file_explanation').val();
                    //var pdf_explanation_text = escape(pdf_explanation_text_temp);
                    //pdf_explanation_text_location = jQuery('#pdf_file_location:checked').val();
                    //if (jQuery('#field_title').val() == '') {
                    //    alert('Please enter FIELD title');
                    //    return false;
                    //}

                    show_title_of_field = jQuery('#pdf_download_show_field_name:checked').val();
                    download_button_styling = jQuery('#pdf_file_button_styling').val();
                    download_button_text = jQuery('#pdf_file_button_text').val();

                    if (show_title_of_field == 1) {
                    } else {
                        show_title_of_field = 0;
                    }

//
                    event.preventDefault;
                    var fd = new FormData();
                    var file = jQuery('#pdffileupload').prop('files')[0];
                    if (!file) {
                        alert('Please try again and select file!');
                        return false;
                    }
                    if (file.name == '') {
                        alert('Please try again and select file!');
                        return false;
                    }
                    var ext = jQuery('#pdffileupload').val().split('.').pop().toLowerCase();
                    //if (ext != 'pdf') {
                    //    alert('Please try again and select PDF file only!');
                    //    return false;
                    //}
                    fd.append("file", file);
                    fd.append("name", file.name);
                    fd.append("caption", 'asifarif');
                    fd.append('action', 'crinch_custom_file_upload');
                    var json_response_error = false;
                    var json_response_file_uploaded_path = '';
                    var break_whole_loop = false;
                    jQuery.ajax({
                        type: 'POST',
                        url: myCustomAjax.ajaxcustomurl,
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (response) {
                            //var break_whole_loop = false;
                            var json = jQuery.parseJSON(response);
                            jQuery(json).each(function (i, val) {
                                if (break_whole_loop) {
                                    return false;
                                }
                                jQuery.each(val, function (k, v) {
                                    if (k == 'error') {
                                        break_whole_loop = true;
                                        return false;
                                    }
                                    if (k == 'filePath' && v != '') {
                                        download_pdf_path = val[k];
                                        break_whole_loop = true;
                                        return false;
                                    }
                                });
                            });
                        },
                        error: function (returnval) {
                            alert('Sorry, there is REQUEST problem: ' + returnval);
                            return false;
                        }
                    });
                    if (download_pdf_path == '') {
                        alert('File uploading problem!');
                        return false;
                    }
                }

                //if (new_field_type == 'EditablePDF') {
                //    pdf_explanation_text_temp = jQuery('#pdf_file_explanation').val();
                //    var pdf_explanation_text = escape(pdf_explanation_text_temp);
                //    pdf_explanation_text_location = jQuery('#pdf_file_location:checked').val();
                //    if (jQuery('#field_title').val() == '') {
                //        alert('Please enter FIELD title');
                //        return false;
                //    }
                //
                //    event.preventDefault;
                //    var fd = new FormData();
                //    var file = jQuery('#fileupload').prop('files')[0];
                //    if (!file) {
                //        alert('Please try again and select PDF file!');
                //        return false;
                //    }
                //    if (file.name == '') {
                //        alert('Please try again and select PDF file!');
                //        return false;
                //    }
                //    var ext = jQuery('#fileupload').val().split('.').pop().toLowerCase();
                //    if (ext != 'pdf') {
                //        alert('Please try again and select PDF file only!');
                //        return false;
                //    }
                //    fd.append("file", file);
                //    fd.append("name", file.name);
                //    fd.append("caption", 'asifarif');
                //    fd.append('action', 'crinch_custom_file_upload');
                //    var json_response_error = false;
                //    var json_response_file_uploaded_path = '';
                //    var break_whole_loop = false;
                //    jQuery.ajax({
                //        type: 'POST',
                //        url: myCustomAjax.ajaxcustomurl,
                //        data: fd,
                //        contentType: false,
                //        processData: false,
                //        async: false,
                //        success: function (response) {
                //            //var break_whole_loop = false;
                //            var json = jQuery.parseJSON(response);
                //            jQuery(json).each(function (i, val) {
                //                if (break_whole_loop) {
                //                    return false;
                //                }
                //                jQuery.each(val, function (k, v) {
                //                    if (k == 'error') {
                //                        break_whole_loop = true;
                //                        return false;
                //                    }
                //                    if (k == 'filePath' && v != '') {
                //                        final_string = val[k];
                //                        break_whole_loop = true;
                //                        return false;
                //                    }
                //                });
                //            });
                //        },
                //        error: function (returnval) {
                //            alert('Sorry, there is REQUEST problem: ' + returnval);
                //            return false;
                //        }
                //    });
                //    if (final_string == '') {
                //        alert('PDF file uploading problem!');
                //        return false;
                //    }
                //}

                if (new_field_type == 'Dropdown') {
                    //var final_string = '';
                    var drop_down_default_selection_value = '';

                    // get selected radrio button value
                    var selected_radio_button_val = jQuery("#form_dialog input[type='radio']:checked").val();
                    var ii = 1;
                    // new field options value
                    jQuery('input[name^="fieldOptions"]').each(function () {
                        drop_down_default_selection_value = '';
                        //if(ii == selected_radio_button_val){
                        if (jQuery('#fieldOPtionDefaultRadioButton-' + this.id).is(":checked")) {
                            drop_down_default_selection_value = '[selected]';
                            final_string = final_string + jQuery(this).val() + drop_down_default_selection_value + ',';
                        } else {
                            final_string = final_string + jQuery(this).val() + ',';
                        }
                        drop_down_default_selection_value = '';
                        ii++;
                    });
                    final_string = final_string.substring(0, final_string.length - 1);
                }

                if (new_field_type == 'Checkbox') {
                    //var final_string = '';
                    var checkbox_checked_value = '';

                    // get selected radrio button value
                    //var selected_checkbox_button_val = jQuery("#form_dialog input[type='checkbox']:checked").val();
                    var jj = 1;
                    // new field options value
                    jQuery('input[name^="fieldOptions"]').each(function () {
                        checkbox_checked_value = '';
                        //if(jQuery('#fieldOPtionDefaultCheckBox-' + jj).is(":checked")){
                        if (jQuery('#fieldOPtionDefaultCheckBox-' + this.id).is(":checked")) {
                            checkbox_checked_value = '[checked]';
                            final_string = final_string + jQuery(this).val() + checkbox_checked_value + ',';
                        } else {
                            final_string = final_string + jQuery(this).val() + ',';
                        }
                        checkbox_checked_value = '';
                        jj++;
                    });
                    final_string = final_string.substring(0, final_string.length - 1);
                }

                //new field options radio button value

                var new_field = jQuery('#new_field').val();
                var required_field = jQuery('#required_field:checked').val();
                var notification_field = jQuery('#notification_field:checked').val();
                var field_title = jQuery('#field_title').val();
                var compulsory = '';

                if (required_field == 1) {
                    compulsory += '<span style="color:red;">*</span>';
                } else {
                    required_field = 0;
                }
                if (notification_field != 1) {
                    notification_field = 0;
                }


                //jQuery("<li class='available_fields'><label>"+compulsory+" "+new_field+":"+field_title+" </label><input name='av_field[]' class='temp_cls1' type='hidden'  value='"+new_field+":"+required_field+"' /><input name='av_title[]' class='temp_cls2' type='hidden' value='"+field_title+"'></li>").insertAfter("#mCSB_1 .mCSB_container ul li:last-child");
                var final_level = '';
                if(new_field == 'display_text'){
                    final_level = 'Display Text';
                }else if(new_field == 'download_file'){
                    final_level = 'Download File';
                }else{
                    final_level = new_field;
                }
                if (new_field == 'Dropdown' || new_field == 'Checkbox') {
                    jQuery("<li class='available_fields'><label>" + compulsory + " " + final_level + ":" + field_title + " </label><input name='av_field[]' class='temp_cls1' type='hidden'  value='" + new_field + ":" + required_field + ":" + notification_field + "' /><input name='av_title[]' class='temp_cls2' type='hidden' value='" + field_title + "'><input name='av_options[]' class='temp_cls3' type='hidden' value='" + final_string + "'></li>").insertAfter("#mCSB_1 .mCSB_container ul li:last-child");
                } else {
                    jQuery("<li class='available_fields'><label>" + compulsory + " " + final_level + ":" + field_title + " </label><input name='av_field[]' class='temp_cls1' type='hidden'  value='" + new_field + ":" + required_field + "' /><input name='av_title[]' class='temp_cls2' type='hidden' value='" + field_title + "'><input name='av_options[]' class='temp_cls3' type='hidden' value='" + final_string + "'><input name='av_explanation_text[]' class='temp_cls4' type='hidden' value='" + pdf_explanation_text + "'><input name='av_explanation_text_location[]' class='temp_cls5' type='hidden' value='" + pdf_explanation_text_location + "'><input name='av_html_styling[]' class='temp_cls6' type='hidden' value='" + html_styling + "'><input name='av_text_to_display[]' class='temp_cls7' type='hidden' value='" + text_to_display + "'><input name='av_show_title_field[]' class='temp_cls8' type='hidden' value='" + show_title_of_field + "'><input name='av_pdf_file[]' class='temp_cls9' type='hidden' value='" + download_pdf_path + "'><input name='av_pdf_file_button_styling[]' class='temp_cls10' type='hidden' value='" + download_button_styling + "'><input name='av_pdf_file_button_text[]' class='temp_cls11' type='hidden' value='" + download_button_text + "'></li>").insertAfter("#mCSB_1 .mCSB_container ul li:last-child");
                }

                jQuery("#wp_ai_flds").mCustomScrollbar("update");

                /*Add drag and drop feature to the Available parameter */
                jQuery(".available_fields").draggable({
                    connectToSortable: "#wp_apply_flds",
                    helper: "clone",
                    revert: "valid",
                    opacity: 0.35,
                    zIndex: 100000,
                    appendTo: "body"
                });


                /////////Droppable /////
                jQuery("#wp_apply_flds").droppable({
                    accept: ".available_fields",
                    drop: function (event, ui) {
                        var drag_element = (ui.draggable).clone();

                        jQuery(drag_element).find('.temp_cls1').attr('name', 'af_field[]');
                        jQuery(drag_element).find('.temp_cls2').attr('name', 'af_title[]');
                        jQuery(drag_element).find('.temp_cls3').attr('name', 'af_options[]');  //crinch
                        jQuery(drag_element).find('.temp_cls4').attr('name', 'af_explanation_text[]'); //crinch
                        jQuery(drag_element).find('.temp_cls5').attr('name', 'af_explanation_text_location[]'); //crinch
                        jQuery(drag_element).find('.temp_cls6').attr('name', 'af_html_styling[]'); //crinch
                        jQuery(drag_element).find('.temp_cls7').attr('name', 'af_text_to_display[]'); //crinch
                        jQuery(drag_element).find('.temp_cls8').attr('name', 'af_show_title_field[]'); //crinch
                        jQuery(drag_element).find('.temp_cls9').attr('name', 'af_pdf_file[]'); //crinch
                        jQuery(drag_element).find('.temp_cls10').attr('name', 'af_pdf_file_button_styling[]'); //crinch
                        jQuery(drag_element).find('.temp_cls11').attr('name', 'af_pdf_file_button_text[]'); //crinch

                        jQuery(drag_element).insertAfter("#wp_apply_flds #mCSB_2 .mCSB_container ul li:last-child");

                        jQuery("#wp_apply_flds").mCustomScrollbar("update");
                        jQuery(ui.helper).remove(); //destroy clone
                        jQuery(ui.draggable).remove(); //remove from list

                        jQuery(".available_fields").draggable({
                            connectToSortable: "#wp_ai_flds",
                            helper: "clone",
                            revert: "valid",
                            opacity: 0.35,
                            zIndex: 100000,
                            appendTo: "body"
                        });

                        jQuery("#wp_ai_flds").droppable({
                            accept: ".available_fields",
                            drop: function (event, ui) {
                                jQuery((ui.draggable).clone()).insertAfter("#wp_ai_flds #mCSB_1 .mCSB_container ul li:last-child");

                                /*jQuery(this).find('.post_fields').remove();  */
                                jQuery(this).find('.temp_cls1').attr('name', 'av_field[]');
                                jQuery(this).find('.temp_cls2').attr('name', 'av_title[]');
                                jQuery(this).find('.temp_cls3').attr('name', 'av_options[]');  //crinch
                                jQuery(this).find('.temp_cls4').attr('name', 'av_explanation_text[]'); //crinch
                                jQuery(this).find('.temp_cls5').attr('name', 'av_explanation_text_location[]'); //crinch
                                jQuery(this).find('.temp_cls6').attr('name', 'av_html_styling[]'); //crinch
                                jQuery(this).find('.temp_cls7').attr('name', 'av_text_to_display[]'); //crinch
                                jQuery(this).find('.temp_cls8').attr('name', 'av_show_title_field[]'); //crinch
                                jQuery(this).find('.temp_cls9').attr('name', 'av_pdf_file[]'); //crinch
                                jQuery(this).find('.temp_cls10').attr('name', 'av_pdf_file_button_styling[]'); //crinch
                                jQuery(this).find('.temp_cls11').attr('name', 'av_pdf_file_button_text[]'); //crinch

                                /*Initialize find on the new elements: code same as find li code on load***/

                                jQuery("#wp_ai_flds").find('li').each(function () {
                                    jQuery(this).unbind("click");
                                });

                                jQuery("#wp_ai_flds").find('li').each(function () {
                                    jQuery(this).click(function () {
                                        /*   alert('in droppable - 4');*/
                                        jQuery(this).updateDialog(this);

                                    });
                                });

                                /*end of initialization */


                                jQuery("#wp_ai_flds").mCustomScrollbar("update");
                                jQuery(ui.helper).remove(); //destroy clone
                                jQuery(ui.draggable).remove(); //remove from list
                                jQuery(".available_fields").draggable({
                                    connectToSortable: "#wp_ai_flds",
                                    helper: "clone",
                                    revert: "valid",
                                    opacity: 0.35,
                                    zIndex: 100000,
                                    appendTo: "body"
                                });


                            }
                        });


                    },

                });
            }

        }

    });


    jQuery("#edit_dialog").on("dialogclose", function (event, ui) {
        /***************EDIT FIELDS WITHOUT PAGE REFRESHING AND WHEN YOU CILCK OK ON EDIT DIALOG*********************************/
        if (event.cancelable) {
            jQuery("#dialog").html('');
        } else {
            var field_title = jQuery('#field_title').val();
            var old_field_title = jQuery('#verify_field_title').val();
            var current_value = new Array();
            jQuery("#wp_ai_flds .temp_cls2").each(function() {
                current_value.push(jQuery(this).val());
            });
            if( field_title != old_field_title && jQuery.inArray(field_title, current_value) != -1 ){
                jQuery('#fixed-form').removeClass('hide-element');
            }else{
                jQuery('#fixed-form').addClass('hide-element');

                var new_field = jQuery('#new_field').val();
                var required_field = jQuery('#required_field:checked').val();
                var notification_field = jQuery('#notification_field:checked').val();
                var field_title = jQuery('#field_title').val();
                var compulsory = '';
                //CRINCH - VERSION2
                var pdf_explanation_text_edit = '';
                var pdf_explanation_text_location_edit = '';

                //custom, crinch
                var final_string_edit = '';
                var new_field_type_edit = jQuery('#new_field').val();

                var html_styling = '';
                var text_to_display = '';

                if (new_field_type_edit == 'display_text') {
                    html_styling = jQuery('#html_styling').val();
                    text_to_display = jQuery('#text_to_display').val();
                    text_to_display = text_to_display.replace(/'/g, 'a*^!');
                }

                var show_title_of_field = '';
                var download_pdf_path = '';
                var download_button_styling = '';
                var download_button_text = '';
                var existing_pdf = '';

                var already_selected_file_path = jQuery('#alreadySelectedPdf').val();
                if (already_selected_file_path != '' && new_field_type_edit != 'EditablePDF') {
                    var fd_edit_only_delete_file = new FormData();
                    fd_edit_only_delete_file.append("name", 'nofile');
                    fd_edit_only_delete_file.append("delteOldFile", already_selected_file_path);
                    fd_edit_only_delete_file.append("caption", 'asifarif');
                    fd_edit_only_delete_file.append('action', 'crinch_custom_file_upload');
                    jQuery.ajax({
                        type: 'POST',
                        url: myCustomAjax.ajaxcustomurl,
                        data: fd_edit_only_delete_file,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (response_edit) {
                        },
                        error: function (returnval_edit) {
                        }
                    });
                }
                if (new_field_type_edit == 'download_file') {
                    existing_pdf = jQuery('#existing_pdf_file').text();

                    show_title_of_field = jQuery('#pdf_download_show_field_name:checked').val();
                    download_button_styling = jQuery('#pdf_file_button_styling').val();
                    download_button_text = jQuery('#pdf_file_button_text').val();

                    if (show_title_of_field == 1) {
                    } else {
                        show_title_of_field = 0;
                    }

//
                    event.preventDefault;
                    var fd = new FormData();
                    var file = jQuery('#pdffileupload').prop('files')[0];
                    //if (!file && !existing_pdf) {
                    //    alert('Please try again and select PDF file!');
                    //    return false;
                    //}
                    //if (file.name == '' && !existing_pdf) {
                    //    alert('Please try again and select PDF file!');
                    //    return false;
                    //}
                    var ext = jQuery('#pdffileupload').val().split('.').pop().toLowerCase();
                    //if (ext != 'pdf') {
                    //    alert('Please try again and select PDF file only!');
                    //    return false;
                    //}
                    if (file) {
                        fd.append("file", file);
                        fd.append("name", file.name);
                        fd.append("caption", 'asifarif');
                        fd.append('action', 'crinch_custom_file_upload');
                        var json_response_error = false;
                        var json_response_file_uploaded_path = '';
                        var break_whole_loop = false;
                        jQuery.ajax({
                            type: 'POST',
                            url: myCustomAjax.ajaxcustomurl,
                            data: fd,
                            contentType: false,
                            processData: false,
                            async: false,
                            success: function (response) {
                                //var break_whole_loop = false;
                                var json = jQuery.parseJSON(response);
                                jQuery(json).each(function (i, val) {
                                    if (break_whole_loop) {
                                        //return false;
                                    }
                                    jQuery.each(val, function (k, v) {
                                        if (k == 'error') {
                                            break_whole_loop = true;
                                            //return false;
                                        }
                                        if (k == 'filePath' && v != '') {
                                            download_pdf_path = val[k];
                                            break_whole_loop = true;
                                            //return false;
                                        }
                                    });
                                });
                            },
                            error: function (returnval) {
                                //alert('Sorry, there is REQUEST problem: ' + returnval);
                                //return false;
                            }
                        });
                    }

                }

                if (new_field_type_edit == 'Dropdown') {
                    //var final_string = '';
                    var drop_down_default_selection_value_edit = '';
                    var selected_radio_button_val_edit = jQuery("#form_dialog input[type='radio']:checked").val();
                    var ii_edit = 1;
                    jQuery('input[name^="fieldOptions"]').each(function () {
                        drop_down_default_selection_value_edit = '';
                        if (this.id == selected_radio_button_val_edit) {
                            //if(jQuery('#fieldOPtionDefaultRadioButton-' + this.id).is(":checked")){
                            drop_down_default_selection_value_edit = '[selected]';
                            final_string_edit = final_string_edit + jQuery(this).val() + drop_down_default_selection_value_edit + ',';
                        } else {
                            final_string_edit = final_string_edit + jQuery(this).val() + ',';
                        }
                        drop_down_default_selection_value_edit = '';
                        ii_edit++;
                    });
                    final_string_edit = final_string_edit.substring(0, final_string_edit.length - 1);
                }
                if (new_field_type_edit == 'Checkbox') {
                    var checkbox_checked_value_edit = '';
                    var jj_edit = 1;
                    jQuery('input[name^="fieldOptions"]').each(function () {
                        checkbox_checked_value_edit = '';
                        //if(jQuery('#fieldOPtionDefaultCheckBox-' + jj_edit).is(":checked")){
                        if (jQuery('#fieldOPtionDefaultCheckBox-' + this.id).is(":checked")) {
                            checkbox_checked_value_edit = '[checked]';
                            final_string_edit = final_string_edit + jQuery(this).val() + checkbox_checked_value_edit + ',';
                        } else {
                            final_string_edit = final_string_edit + jQuery(this).val() + ',';
                        }
                        checkbox_checked_value_edit = '';
                        jj_edit++;
                    });
                    final_string_edit = final_string_edit.substring(0, final_string_edit.length - 1);
                }

                if (required_field == 1) {
                    compulsory += '<span style="color:red;">*</span>';
                } else {
                    required_field = 0;
                }
                if (notification_field != 1) {
                    notification_field = 0;
                }
                if (!download_pdf_path) {
                    download_pdf_path = existing_pdf;
                }

                var final_level = '';
                if (new_field_type_edit == 'display_text') {
                    final_level = 'Display Text';
                } else if (new_field_type_edit == 'download_file') {
                    final_level = 'Download File';
                } else {
                    final_level = new_field_type_edit;
                }

                //CRINCH - updated below line
                /*jQuery('#pointer').html("<label>"+compulsory+" "+new_field+":"+field_title+" </label><input name='av_field[]' class='temp_cls1' type='hidden'  value='"+new_field+":"+required_field+"' /><input name='av_title[]' class='temp_cls2' type='hidden' value='"+field_title+"'>");*/
                jQuery('#pointer').html("<label>" + compulsory + " " + final_level + ":" + field_title + " </label><input name='av_field[]' class='temp_cls1' type='hidden'  value='" + new_field + ":" + required_field + ":" + notification_field + "' /><input name='av_title[]' class='temp_cls2' type='hidden' value='" + field_title + "'><input name='av_options[]' class='temp_cls3' type='hidden' value='" + final_string_edit + "'><input name='av_explanation_text[]' class='temp_cls4' type='hidden' value='" + pdf_explanation_text_edit + "'><input name='av_explanation_text_location[]' class='temp_cls5' type='hidden' value='" + pdf_explanation_text_location_edit + "'><input name='av_html_styling[]' class='temp_cls6' type='hidden' value='" + html_styling + "'><input name='av_text_to_display[]' class='temp_cls7' type='hidden' value='" + text_to_display + "'><input name='av_show_title_field[]' class='temp_cls8' type='hidden' value='" + show_title_of_field + "'><input name='av_pdf_file[]' class='temp_cls9' type='hidden' value='" + download_pdf_path + "'><input name='av_pdf_file_button_styling[]' class='temp_cls10' type='hidden' value='" + download_button_styling + "'><input name='av_pdf_file_button_text[]' class='temp_cls11' type='hidden' value='" + download_button_text + "'>");

                jQuery('#pointer').removeAttr('id');

                jQuery("#wp_ai_flds").mCustomScrollbar("update");

                /*Add drag and drop feature to the Available parameter */
                jQuery(".available_fields").draggable({
                    connectToSortable: "#wp_apply_flds",
                    helper: "clone",
                    revert: "valid",
                    opacity: 0.35,
                    zIndex: 100000,
                    appendTo: "body"
                });

                /////////Droppable /////
                jQuery("#wp_apply_flds").droppable({
                    accept: ".available_fields",
                    drop: function (event, ui) {
                        var drag_element = (ui.draggable).clone();

                        jQuery(drag_element).find('.temp_cls1').attr('name', 'af_field[]');
                        jQuery(drag_element).find('.temp_cls2').attr('name', 'af_title[]');
                        jQuery(drag_element).find('.temp_cls3').attr('name', 'af_options[]');  //crinch
                        jQuery(drag_element).find('.temp_cls4').attr('name', 'af_explanation_text[]'); //crinch
                        jQuery(drag_element).find('.temp_cls5').attr('name', 'af_explanation_text_location[]'); //crinch
                        jQuery(drag_element).find('.temp_cls6').attr('name', 'af_html_styling[]'); //crinch
                        jQuery(drag_element).find('.temp_cls7').attr('name', 'af_text_to_display[]'); //crinch

                        jQuery(drag_element).find('.temp_cls8').attr('name', 'af_show_title_field[]'); //crinch
                        jQuery(drag_element).find('.temp_cls9').attr('name', 'af_pdf_file[]'); //crinch
                        jQuery(drag_element).find('.temp_cls10').attr('name', 'af_pdf_file_button_styling[]'); //crinch
                        jQuery(drag_element).find('.temp_cls11').attr('name', 'af_pdf_file_button_text[]'); //crinch

                        jQuery(drag_element).insertAfter("#wp_apply_flds #mCSB_2 .mCSB_container ul li:last-child");

                        jQuery("#wp_apply_flds").mCustomScrollbar("update");
                        jQuery(ui.helper).remove(); //destroy clone
                        jQuery(ui.draggable).remove(); //remove from list

                        jQuery(".available_fields").draggable({
                            connectToSortable: "#wp_ai_flds",
                            helper: "clone",
                            revert: "valid",
                            opacity: 0.35,
                            zIndex: 100000,
                            appendTo: "body"
                        });

                        jQuery("#wp_ai_flds").droppable({
                            accept: ".available_fields",
                            drop: function (event, ui) {
                                jQuery((ui.draggable).clone()).insertAfter("#wp_ai_flds #mCSB_1 .mCSB_container ul li:last-child");
                                jQuery(this).find('.temp_cls1').attr('name', 'av_field[]');
                                jQuery(this).find('.temp_cls2').attr('name', 'av_title[]');
                                jQuery(this).find('.temp_cls3').attr('name', 'av_options[]');
                                //CRINCH - VERSION 2
                                jQuery(this).find('.temp_cls4').attr('name', 'av_explanation_text[]'); //crinch
                                jQuery(this).find('.temp_cls5').attr('name', 'av_explanation_text_location[]'); //crinch
                                jQuery(this).find('.temp_cls6').attr('name', 'av_html_styling[]'); //crinch
                                jQuery(this).find('.temp_cls7').attr('name', 'av_text_to_display[]'); //crinch

                                jQuery(this).find('.temp_cls8').attr('name', 'av_show_title_field[]'); //crinch
                                jQuery(this).find('.temp_cls9').attr('name', 'av_pdf_file[]'); //crinch
                                jQuery(this).find('.temp_cls10').attr('name', 'av_pdf_file_button_styling[]'); //crinch
                                jQuery(this).find('.temp_cls11').attr('name', 'av_pdf_file_button_text[]'); //crinch

                                /*Initialize find on the new elements: code same as find li code on load*/

                                jQuery("#wp_ai_flds").find('li').each(function () {
                                    jQuery(this).unbind("click");
                                });

                                jQuery("#wp_ai_flds").find('li').each(function () {
                                    jQuery(this).click(function () {
                                        /*    alert('in droppable - 5');*/
                                        jQuery(this).updateDialog(this);

                                    });
                                });

                                /*end of initialization */

                                jQuery("#wp_ai_flds").mCustomScrollbar("update");
                                jQuery(ui.helper).remove(); //destroy clone
                                jQuery(ui.draggable).remove(); //remove from list
                                jQuery(".available_fields").draggable({
                                    connectToSortable: "#wp_ai_flds",
                                    helper: "clone",
                                    revert: "valid",
                                    opacity: 0.35,
                                    zIndex: 100000,
                                    appendTo: "body"
                                });

                            }
                        });

                    },

                });
                //    this is end
            };
        //    end this is end
        }
    });

    /*function used to update the dialog box parameters*/
    jQuery.fn.updateDialog = function (evt) {
        /***************EDIT FIELDS WITHOUT PAGE REFRESHING*********************************/
        //CRINCH
        var showHideAddOptionLink = "style='display:none'";
        var showHideUploadPDFField = "style='display:none'";

        var showHideUploadPDFFieldExplanation = "style='display:none'";
        var showHideUploadPDFFieldExplanationLoaction = "style='display:none'";

        var text_to_display = '';

        var existing_pdf = '';

        var dynamicOptionsTrs = '';
        //end CRINCH
        jQuery("#edit_dialog").dialog("open");
        var av_field = jQuery(evt).find('.temp_cls1').val();
        var av_title = jQuery(evt).find('.temp_cls2').val();
        var av_options = jQuery(evt).find('.temp_cls3').val();
        //CRINCH - VERSION 2
        var av_explanation_text = jQuery(evt).find('.temp_cls4').val();
        var av_explanation_text_location = jQuery(evt).find('.temp_cls5').val();

        var av_html_styling = jQuery(evt).find('.temp_cls6').val();
        var av_text_to_display = jQuery(evt).find('.temp_cls7').val();

        av_text_to_display = av_text_to_display.replace(/a\*\^!/g, "'");

        var av_show_title_field = jQuery(evt).find('.temp_cls8').val();
        var av_pdf_file = jQuery(evt).find('.temp_cls9').val();
        var av_pdf_file_button_styling = jQuery(evt).find('.temp_cls10').val();
        var av_pdf_file_button_text = jQuery(evt).find('.temp_cls11').val();

        //important - CRINCH
        var exploded_field = av_field.split(":");
        //CRINCH
        //var text_selected = longtext_selected = upload_selected = numeric_selected =  upload_other_selected = email_selected = '' ;
        var text_selected = longtext_selected = upload_selected = numeric_selected = upload_other_selected = email_selected = dropdown_selected = checkbox_selected = editablePDF_selected = display_text_selected = download_file_selected = '';
        var required = '';
        var notification_field_chk = '';

        var sel_field = exploded_field[0].toUpperCase();

        if (sel_field == afAjax.FIELD_TYPE1) {
            text_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE2) {
            upload_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE3) {
            longtext_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE4) {
            numeric_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE6) {
            upload_other_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE7) {
            email_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE8) { //CRINCH
            dropdown_selected = "selected='selected'";
            showHideAddOptionLink = '';
            if (av_options != '') {
                dynamicOptionsTrs = makeDynamicOptions(sel_field, av_options);
                //makeDynamicOptions(sel_field, av_options);
            }
        }
        else if (sel_field == afAjax.FIELD_TYPE9) { //CRINCH
            checkbox_selected = "selected='selected'";
            dynamicOptionsTrs = makeDynamicOptions(sel_field, av_options);
            showHideAddOptionLink = '';
        }
        else if (sel_field == afAjax.FIELD_TYPE10) { //CRINCH
            editablePDF_selected = "selected='selected'";
            showHideAddOptionLink = "style='display:none'";
            dynamicOptionsTrs = makeDynamicOptions_runtime_editable(sel_field, av_options, av_explanation_text, av_explanation_text_location);
        }
        else if (sel_field == afAjax.FIELD_TYPE11) { //CRINCH
            display_text_selected = "selected='selected'";
        }
        else if (sel_field == afAjax.FIELD_TYPE12) { //CRINCH
            download_file_selected = "selected='selected'";
        }

        if (exploded_field[1] == "1") {
            required = "checked='checked'";
        }

        if (exploded_field[2] == "1") {
            notification_field_chk = "checked='checked'";
        }

//START FROM HERE.....VERSINO 2
        //CRINCH - 01april - done
        var option_str = "<option value='Text' " + text_selected + ">Text</option><option value='Upload_CV' " + upload_selected + ">Upload - CV</option><option value='Upload_Other' " + upload_other_selected + ">Upload - Other</option><option value='LongText' " + longtext_selected + ">LongText</option><option value='Numeric' " + numeric_selected + ">Numeric</option><option value='Email' " + email_selected + ">Email</option><option value='Dropdown' " + dropdown_selected + ">Dropdown</option><option value='Checkbox' " + checkbox_selected + ">Checkbox</option><option value='display_text' " + display_text_selected + ">Display Text</option><option value='download_file' " + download_file_selected + ">Download File</option>";
        jQuery(evt).attr('id', 'pointer');      //set a id called pointer

        //CRINCH 
        var notification_var_style = 'display:none;';
        if (sel_field == afAjax.FIELD_TYPE7) {
            notification_var_style = '';
        }
        notification_var = "<tr id='notification_tr' style='" + notification_var_style + "'><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.NOTIFICATION_EMAIL_TOOLTIP + "\");'>?</span></td><td colspan='2'><span class='dialog_flds'>Send candidate notification email:</span>&nbsp;<input id='notification_field' type='checkbox' name='notification_field' value='1' " + notification_field_chk + "></td></tr>";

        var showHideHTMLStylingField = "style='display:none'";
        var showHideTextToDisplayField = "style='display:none'";
        var showHideRequireCheckBox = "";
        if (sel_field == afAjax.FIELD_TYPE11) {
            showHideHTMLStylingField = '';
            showHideTextToDisplayField = '';
            showHideRequireCheckBox = "style='display:none'";
        } else {
            showHideRequireCheckBox = "";
        }

        display_text_var = "<tr " + showHideHTMLStylingField + " id='showHideHTMLStyling'><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span></td><td><span class='dialog_flds'>HTML Styling</span></td><td><input id='html_styling' type='text' name='html_styling' value='" + av_html_styling + "'></td></tr><tr " + showHideTextToDisplayField + " id='showHideTextToDisplay'><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span></td><td><span class='dialog_flds'>Text to Display</span></td><td align='left'><textarea rows='4' cols='18' id='text_to_display' name='pdf_file_explanation'>" + decodeURI(av_text_to_display) + "</textarea></td></tr>";

        var showHideUploadPDFShowTitleField = "style='display:none'";
        var showHideUploadPDFFieldDownloadFIle = "style='display:none'";
        var showHideUploadPDFButtonStyling = "style='display:none'";
        var showHideUploadPDFDownloadText = "style='display:none'";
        var showHideRequireCheckBox = "";
        var checked_show_file_title = "";
        if (sel_field == afAjax.FIELD_TYPE12) {
            showHideUploadPDFShowTitleField = '';
            showHideUploadPDFFieldDownloadFIle = '';
            showHideUploadPDFButtonStyling = '';
            showHideUploadPDFDownloadText = '';
            showHideRequireCheckBox = "style='display:none'";
            if (av_show_title_field == 1) {
                checked_show_file_title = "checked=checked";
            }
        } else {
            showHideRequireCheckBox = "";
        }

        download_file_var = "<tr " + showHideUploadPDFShowTitleField + " id='showHideUploadPDFShowTitleField'><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span></td><td colspan='2'><span class='dialog_flds'>Show title of field on form?:</span>&nbsp;<input id='pdf_download_show_field_name' type='checkbox' name='pdf_download_show_field_name' value='" + av_show_title_field + "' " + checked_show_file_title + "></td></tr><tr " + showHideUploadPDFFieldDownloadFIle + " id='showHideUploadPDFFieldDownloadFIle'><td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td><td><span class='dialog_flds'>File:</span></td><td align='left'><input value='" + av_pdf_file + "' name='file' id='pdffileupload' type='file' size='15' multiple/><div id='existing_pdf_file' style='color:green;font-size:10px;'>" + av_pdf_file + "</div><div ='response'></div></td></tr><tr " + showHideUploadPDFButtonStyling + " id='showHideUploadPDFButtonStyling'><td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td><td colspan='2'><span class='dialog_flds'>Download button styling:</span>&nbsp;&nbsp;<input type='text' id='pdf_file_button_styling' name='pdf_file_button_styling' value='" + av_pdf_file_button_styling + "'></td></tr><tr " + showHideUploadPDFDownloadText + " id='showHideUploadPDFDownloadText'><td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td><td colspan='2'><span class='dialog_flds'>Download button text:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' id='pdf_file_button_text' name='pdf_file_button_text' value='" + av_pdf_file_button_text + "'></td></tr>";

        jQuery("#edit_dialog").append("<form id='form_dialog'><input type='hidden' id='verify_field_title' value='" + av_title + "' />" +
        "<table class='wpaf_dialog_table'>" +
        "<tr>" +
        "<td width='22px'><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.FIELD_TYPE_TOOLTIP + "\");'>?</span></td>" +
        "<td width='110px'><span class='dialog_flds'>Field Type:</span></td><td><select onchange='notification_select(this); DeleteItemOnDropDownSelection(); return false;' id='new_field' name='new_field' style='width:180px;'>" + option_str + "</select>" +
        "</td>" +
        "</tr>" +
        "<tr " + showHideRequireCheckBox + ">" +
        "<td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span></td>" +
        "<td><span class='dialog_flds'>Required:</span></td>" +
        "<td><input id='required_field' type='checkbox' name='required_field' value='1' " + required + "></td>" +
        "</tr>" +
        "<tr>" +
        "<td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP + "\");'>?</span></td>" +
        "<td><span class='dialog_flds'>Title of field:</span></td>" +
        "<td><input type='text' name='field_title' id='field_title' value='" + av_title + "' /></td>" +
        "</tr>" + notification_var + display_text_var + download_file_var + "<tr id='asifarif-0' class='checkme'><td colspan='3'></td></tr>" + dynamicOptionsTrs + "<tr " + showHideAddOptionLink + " id='linkToCreateDynamicOption'>" +
        "<td align='center' colspan='3'>" +
        "<button type='button' id='asif_arif' class='asif_arif' onclick = 'event_add_audience_custom(); return false;'><span class='ui-button-text trigger'>Add OPtion</span></button></td>" +
        "</tr>" +
        "</table></form>");

    };

});

function showViewDisplay(thisvar) {
    if (thisvar.value == 'display_text') {
        jQuery('#showHideHTMLStyling').show();
        jQuery('#showHideTextToDisplay').show();
        jQuery('#required_checkbox').hide();
    } else {
        jQuery('#showHideHTMLStyling').hide();
        jQuery('#showHideTextToDisplay').hide();
        jQuery('#required_checkbox').show();
    }
};

function showHideDownloadDisplay(thisvar) {
    if (thisvar.value == 'download_file') {
        jQuery('#showHideUploadPDFShowTitleField').show();
        jQuery('#showHideUploadPDFFieldDownloadFIle').show();
        jQuery('#showHideUploadPDFButtonStyling').show();
        jQuery('#showHideUploadPDFDownloadText').show();
        jQuery('#required_checkbox').hide();
    } else {
        jQuery('#showHideUploadPDFShowTitleField').hide();
        jQuery('#showHideUploadPDFFieldDownloadFIle').hide();
        jQuery('#showHideUploadPDFButtonStyling').hide();
        jQuery('#showHideUploadPDFDownloadText').hide();
        //jQuery('#required_checkbox').show();
    }
};

//CRINCH
function makeDynamicOptions(field_type, field_option_str) {

    var return_str = '';
    var input_old_field_option_str = field_option_str;
    var old_field_option_arr = input_old_field_option_str.split(",");
    for (var i = 1; i <= old_field_option_arr.length; i++) {
        var maxId = i;
        var field_title_str = old_field_option_arr[i - 1];
        var select_radio_button = '';
        if (field_title_str.match(/(^.*\[|\].*$)/g, '')) {
            var select_radio_button = 'checked';
            var field_title_control_selection = field_title_str.split("[");
            field_title_str = field_title_control_selection[0];
        }
        if (field_type == 'CHECKBOX') {
            var dynamic_checkbox_radio_control = "<input class='inputclass' type='checkbox' name='fieldOPtionDefaultCheckBox[]' id='fieldOPtionDefaultCheckBox-" + maxId + "' " + select_radio_button + "  value='" + maxId + "'><span style='font-size:11px;'>Default Selected</span>";
        } else if (field_type == 'DROPDOWN') {
            var dynamic_checkbox_radio_control = "<input class='inputclass' type='radio' name='fieldOPtionDefaultRadioButton[]' id='fieldOPtionDefaultRadioButton-" + maxId + "' " + select_radio_button + "  value='" + maxId + "'><span style='font-size:11px;'>Default Selection</span>";
        } else {
            var dynamic_checkbox_radio_control = "&nbsp";
        }

        var return_str = return_str + "<tr class='checkme' id='asifarif-" + maxId + "'>" +
            "<td><span style='color:red;font-size:11px;cursor:pointer;' class='btnDelete' onclick='customDeleteRowFromAvailableFieldsOnUpdate(" + maxId + "); return false;'>Delete</span></td>" +
            "<td colspan='2'>&nbsp; <span style='font-size:15px;'>Options " + maxId + "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='fieldOptions[]' id='" + maxId + "' type='text' value='" + field_title_str + "'/>&nbsp;&nbsp;" + dynamic_checkbox_radio_control + "</td>" +
            "</tr>";
    }
    return return_str;
}
function customDeleteRowFromAvailableFieldsOnUpdate(id) {
    DeleteCustomNew(id);
}
function makeDynamicOptionsNew(field_type, field_option_str) {
    var return_str = '';
    var input_old_field_option_str = field_option_str;
    var old_field_option_arr = input_old_field_option_str.split(",");
    var maxId = 1;
    //document.write("<br /> Element " + i + " = " + mySplitResult[i]);
    if (field_type == 'CHECKBOX') {
        var dynamic_checkbox_radio_control = "<input class='inputclass' type='checkbox' name='fieldOPtionDefaultCheckBox[]' id='fieldOPtionDefaultCheckBox-" + maxId + "' ><span style='font-size:11px;'>Default Selected</span>";
    } else if (field_type == 'DROPDOWN') {
        var dynamic_checkbox_radio_control = "<input class='inputclass' type='radio' name='fieldOPtionDefaultRadioButton[]' id='fieldOPtionDefaultRadioButton-" + maxId + "'  value='" + maxId + "'><span style='font-size:11px;'>Default Selection</span>";
    } else {
        var dynamic_checkbox_radio_control = "&nbsp";
    }
    //var field_title_str = old_field_option_arr[i];
    var field_title_str = 'Option1';
    jQuery(".wpaf_dialog_table tbody tr.checkme:last").after(
        "<tr class='checkme' id='asifarif-" + maxId + "'>" +
        "<td><span style='color:red;font-size:11px;cursor:pointer;' class='btnDelete'>Delete</span></td>" +
        "<td colspan='2'>&nbsp; <span style='font-size:15px;'>Options " + maxId + "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='fieldOptions[]' type='text' value='" + field_title_str + "'/>&nbsp;&nbsp;" + dynamic_checkbox_radio_control + "</td>" +
        "</tr>");

    jQuery(".btnDelete").bind("click", Delete);
}


function Delete() { //crinch
    var par = jQuery(this).parent().parent(); //tr
    par.remove();
};

function DeleteCustom(id) { //crinch
    var par = jQuery('.wpaf_dialog_table tbody tr#' + id);
    par.remove();
};
function DeleteCustomNew(id) { //crinch
    var par = jQuery('.wpaf_dialog_table tbody tr#asifarif-' + id);
    par.remove();
};

function notification_select(thisvar) {
    if (thisvar.value == 'Email') {
        jQuery('#notification_tr').show();
    } else {
        jQuery('#notification_tr').hide();
    }
};

function DeleteItemOnDropDownSelection() { //crinch
    var getClass = 'checkme';
    var field_type_custom_value = jQuery('#new_field').val();
    if (field_type_custom_value == 'Checkbox' || field_type_custom_value == 'Dropdown') {
        jQuery('.wpaf_dialog_table tbody tr#linkToCreateDynamicOption').show();
    } else {
        jQuery('.wpaf_dialog_table tbody tr#linkToCreateDynamicOption').hide();
    }

    jQuery("." + getClass).each(function () {
        if (this.id == 'asifarif-0') {
            return;
        }
        DeleteCustom(this.id);
    });

};

function event_add_audience_custom() {
    var maxId = 0;
    var getClass = 'checkme';
    jQuery("." + getClass).each(function () {
        var id = jQuery(this).attr('id').split('-')[1];
        if (id > maxId)
            maxId = id;
    });
    maxId = parseInt(maxId) + 1;

    var field_type_custom_value = jQuery('#new_field').val();

    if (field_type_custom_value == 'Checkbox') {
        var dynamic_checkbox_radio_control = "<input class='inputclass' type='checkbox' name='fieldOPtionDefaultCheckBox[]' id='fieldOPtionDefaultCheckBox-" + maxId + "' ><span style='font-size:11px;'>Default Selected</span>";
    } else if (field_type_custom_value == 'Dropdown') {
        var dynamic_checkbox_radio_control = "<input class='inputclass' type='radio' name='fieldOPtionDefaultRadioButton[]' id='fieldOPtionDefaultRadioButton-" + maxId + "'  value='" + maxId + "'><span style='font-size:11px;'>Default Selection</span>";
    } else {
        var dynamic_checkbox_radio_control = "&nbsp";
        return false;
    }
    if (field_type_custom_value == 'Checkbox') {
        var dynamic_checkbox_radio_control = "<input class='inputclass' type='checkbox' name='fieldOPtionDefaultCheckBox[]' id='fieldOPtionDefaultCheckBox-" + maxId + "' ><span style='font-size:11px;'>Default Selected</span>";
    } else if (field_type_custom_value == 'Dropdown') {
        var dynamic_checkbox_radio_control = "<input class='inputclass' type='radio' name='fieldOPtionDefaultRadioButton[]' id='fieldOPtionDefaultRadioButton-" + maxId + "'  value='" + maxId + "'><span style='font-size:11px;'>Default Selection</span>";
    } else {
        var dynamic_checkbox_radio_control = "&nbsp";
        return false;
    }


    /*jQuery("."+getClass).each(function() {
     var id = jQuery(this).attr('id').split('-')[1];
     if( id > maxId)
     maxId = id;
     });
     maxId = parseInt(maxId)+1;*/

    jQuery(".wpaf_dialog_table tbody tr.checkme:last").after(
        "<tr class='checkme' id='asifarif-" + maxId + "'>" +
        "<td><span style='color:red;font-size:11px;cursor:pointer;' class='btnDelete'>Delete</span></td>" +
        "<td colspan='2'>&nbsp; <span style='font-size:15px;'>Options " + maxId + "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='fieldOptions[]' id='" + maxId + "' type='text'/>&nbsp;&nbsp;" + dynamic_checkbox_radio_control + "</td>" +
        "</tr>");

    jQuery(".btnDelete").bind("click", Delete);
    return false;
}
