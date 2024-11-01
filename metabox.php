<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 11/8/2015
 * Time: 11:28 AM
 */
?>
<?php

$wpaf_new_fields = maybe_unserialize(get_post_meta( $post->ID, '__wpaf_available_field_title', true));

$wpaf_fields = maybe_unserialize(get_post_meta( $post->ID, '__wpaf_field_title', true));

if (!empty($wpaf_new_fields)) {
    $decoded_new_fields = json_decode($wpaf_new_fields);
}
if (!empty($wpaf_fields)) {
    $decoded_form_fields = json_decode($wpaf_fields);
}
$wpaf_field_title = get_option('wpaf_field_title');
$decoded_field_title = json_decode($wpaf_field_title);
wp_nonce_field( 'candidate_application_form_save_meta_box_data', 'candidate_application_form_meta_box_nonce' );
?>
<div class="h20 clear"></div>
<div id="new_candidate_form">
    <div id="fixed-form" class="hide-element">
        <p style="color: red;">Field name already exists. Please change your field name.</p>
    </div>

    <!-- start: Copy link div -->
    <div id="div_eLink" class="redClass" style="min-width: 510px; max-width:600px;">
        <span id="spn_eLink"></span>
    </div>
    <!-- end: Copy link div -->

    <div id="avail_fields">
        <label class="wp_a_fields">
                            <span class="wpaf_tooltip trigger"
                                  onmouseover="OpenDiv('<?php echo AVAILABLE_FIELDS_TOOLTIP; ?>');">?</span>Available
            Fields </label>

        <div class="h10 clear"></div>

        <div id="wp_ai_flds" class="section_border">
            <ul>
                <li style="display:none;" class=""></li>
                <?php
                if (isset($decoded_new_fields)) {
                    foreach ($decoded_new_fields as $new_field) {

                        $compulsory = '';
                        $parameter = $new_field->field;
                        $param = explode(':', $parameter);
                        $field_title = '';
                        if ($param[0] == 'display_text') {
                            $field_title = 'Display Text';
                        } else if ($param[0] == 'download_file') {
                            $field_title = 'Download File';
                        } else {
                            $field_title = $param[0];
                        }

                        //CRINCH - VERSION 2
                        $explanation_text = $new_field->explanation_text;
                        $explanation_text_location = $new_field->explanation_text_location;

                        $html_styling = $new_field->html_styling;
                        $text_to_display = $new_field->text_to_display;

                        //CRINCH
                        $final_string_new = '';
                        if (strpos($new_field->title, '@@') !== false) {
                            $param_custom_new = explode('@@', $new_field->title);
                            $new_field->title = $param_custom_new[0];
                            $final_string_new = $param_custom_new[1];
                            $final_string_new = str_replace('{', '', $final_string_new);
                            $final_string_new = str_replace('}', '', $final_string_new);
                        }
                        //END CRICNH

                        if ($param[1] == 1) {
                            $compulsory = '<span style="color:red;">*</span>';
                        }
                        ?>
                        <!-- edit this below line - crinch -->
                        <!--<li class='available_fields'><label><?php echo $compulsory . " " . $field_title . ":" . $new_field->title; ?></label><input name='av_field[]' class='temp_cls1' type='hidden'  value='<?php echo $param[0] . ":" . $param[1]; ?>' /><input name='av_title[]' class='temp_cls2' type='hidden' value='<?php echo $new_field->title; ?>'></li>  -->
                        <li class='available_fields'>
                            <label><?php echo $compulsory . " " . esc_html($field_title) . ":" . esc_html($new_field->title); ?></label><input
                                name='av_field[]' class='temp_cls1' type='hidden'
                                value='<?php echo esc_attr($param[0]) . ":" . esc_attr($param[1]) . ":" . esc_attr($param[2]); ?>'/><input
                                name='av_title[]' class='temp_cls2' type='hidden'
                                value='<?php echo esc_attr($new_field->title); ?>'>
                            <input name='av_options[]'
                                   class='temp_cls3'
                                   type='hidden'
                                   value='<?php echo esc_attr($final_string_new); ?>'>
                            <input
                                name='av_explanation_text[]' class='temp_cls4' type='hidden'
                                value='<?php echo esc_attr($explanation_text); ?>'>
                            <input
                                name='av_explanation_text_location[]' class='temp_cls5' type='hidden'
                                value='<?php echo esc_attr($explanation_text_location); ?>'>
                            <input
                                name='av_html_styling[]' class='temp_cls6' type='hidden'
                                value='<?php echo esc_attr($html_styling); ?>'>
                            <input
                                name='av_text_to_display[]' class='temp_cls7' type='hidden'
                                value='<?php echo esc_attr($text_to_display); ?>'>
                            <input
                                name='av_show_title_field[]' class='temp_cls8' type='hidden'
                                value='<?php echo esc_attr($new_field->show_title_field); ?>'>
                            <input
                                name='av_pdf_file[]' class='temp_cls9' type='hidden'
                                value='<?php echo esc_attr($new_field->pdf_file); ?>'>
                            <input
                                name='av_pdf_file_button_styling[]' class='temp_cls10' type='hidden'
                                value='<?php echo esc_attr($new_field->pdf_file_button_styling); ?>'>
                            <input
                                name='av_pdf_file_button_text[]' class='temp_cls11' type='hidden'
                                value='<?php echo esc_attr($new_field->pdf_file_button_text); ?>'></li>
                    <?php
                    }
                }

                ?>
            </ul>



            <input id="add_new_button" type="button" class="ui-button wp_apply_button"
                   value="Add New Field" name="submit_field" <?php if (APPLY_FORM_EDITION == 'free') {
                echo "disabled = 'disabled'";
            } ?> />

            <?php
            if (APPLY_FORM_EDITION == 'free') {
                echo "<br /><br />You must activate the plugin to edit form fields. To find out more, <a target='_blank' href='http://responsecoordinator.com/?page_id=366'>click here</a>";
            }

            ?>


        </div>
    </div>


    <div id="apply_fields">
        <label class="wp_apply_fields"><span class="wpaf_tooltip trigger"
                                             onmouseover="OpenDiv('<?php echo APPLY_FORM_FIELDS_TOOLTIP; ?>');">?</span>Apply
            Form Fields</label>

        <div class="h10 clear"></div>
        <div id="wp_apply_flds" class="section_border">
            <ul>
                <li style="display:none;" class=""></li>
                <?php
                if (isset($decoded_form_fields)) {


                    foreach ($decoded_form_fields as $af_field) {
                        $compulsory = '';
                        $parameter = $af_field->field;
                        $param = explode(':', $parameter);
                        $field_title = '';
                        if ($param[0] == 'display_text') {
                            $field_title = 'Display Text';
                        } else if ($param[0] == 'download_file') {
                            $field_title = 'Download File';
                        } else {
                            $field_title = $param[0];
                        }
                        //CRINCH - VERSION 2
                        $explanation_text = $af_field->explanation_text;
                        $explanation_text_location = $af_field->explanation_text_location;
                        $final_string = '';
                        if (strpos($af_field->title, '@@') !== false) {
                            $param_custom = explode('@@', $af_field->title);
                            $af_field->title = $param_custom[0];
                            $final_string = $param_custom[1];
                            $final_string = str_replace('{', '', $final_string);
                            $final_string = str_replace('}', '', $final_string);
                        }
                        //END CRICNH
                        if ($param[1] == 1) {
                            $compulsory = '<span style="color:red;">*</span>';
                        }

                        $html_styling = $af_field->html_styling;
                        $text_to_display = $af_field->text_to_display;
                        ?>
                        <!-- edit this below line - crinch -->
                        <!--<li class='available_fields ui-draggable'><label><?php echo $compulsory . " " . $param[0] . ":" . $af_field->title; ?></label><input name='af_field[]' class='temp_cls1' type='hidden'  value='<?php echo $param[0] . ":" . $param[1]; ?>' /><input name='af_title[]' class='temp_cls2' type='hidden' value='<?php echo $af_field->title; ?>'></li>  -->
                        <li class='available_fields ui-draggable'>
                            <label><?php echo $compulsory . " " . esc_html($field_title) . ":" . esc_html($af_field->title); ?></label><input
                                name='af_field[]' class='temp_cls1' type='hidden'
                                value='<?php echo esc_attr($param[0]) . ":" . esc_attr($param[1]) . ":" . esc_attr($param[2]); ?>'/><input
                                name='af_title[]' class='temp_cls2' type='hidden'
                                value='<?php echo esc_attr($af_field->title); ?>'><input
                                name='af_options[]'
                                class='temp_cls3'
                                type='hidden'
                                value='<?php echo esc_attr($final_string); ?>'><input
                                name='af_explanation_text[]' class='temp_cls4' type='hidden'
                                value='<?php echo esc_attr($explanation_text); ?>'><input
                                name='af_explanation_text_location[]' class='temp_cls5' type='hidden'
                                value='<?php echo esc_attr($explanation_text_location); ?>'><input
                                name='af_html_styling[]' class='temp_cls6' type='hidden'
                                value='<?php echo esc_attr($html_styling); ?>'>
                            <input
                                name='af_text_to_display[]' class='temp_cls7' type='hidden'
                                value='<?php echo esc_attr($text_to_display); ?>'>
                            <input
                                name='af_show_title_field[]' class='temp_cls8' type='hidden'
                                value='<?php echo esc_attr($af_field->show_title_field); ?>'>
                            <input
                                name='af_pdf_file[]' class='temp_cls9' type='hidden'
                                value='<?php echo esc_attr($af_field->pdf_file); ?>'>
                            <input
                                name='af_pdf_file_button_styling[]' class='temp_cls10' type='hidden'
                                value='<?php echo esc_attr($af_field->pdf_file_button_styling); ?>'>
                            <input
                                name='af_pdf_file_button_text[]' class='temp_cls11' type='hidden'
                                value='<?php echo esc_attr($af_field->pdf_file_button_text); ?>'>
                        </li>
                    <?php }
                }
                else if(isset($decoded_field_title)){
                    foreach ($decoded_field_title as $af_field) {
                        $compulsory = '';
                        $parameter = $af_field->field;
                        $param = explode(':', $parameter);
                        $field_title = '';
                        if ($param[0] == 'display_text') {
                            $field_title = 'Display Text';
                        } else if ($param[0] == 'download_file') {
                            $field_title = 'Download File';
                        } else {
                            $field_title = $param[0];
                        }
                        //CRINCH - VERSION 2
                        $explanation_text = $af_field->explanation_text;
                        $explanation_text_location = $af_field->explanation_text_location;
                        $final_string = '';
                        if (strpos($af_field->title, '@@') !== false) {
                            $param_custom = explode('@@', $af_field->title);
                            $af_field->title = $param_custom[0];
                            $final_string = $param_custom[1];
                            $final_string = str_replace('{', '', $final_string);
                            $final_string = str_replace('}', '', $final_string);
                        }
                        //END CRICNH
                        if ($param[1] == 1) {
                            $compulsory = '<span style="color:red;">*</span>';
                        }

                        $html_styling = $af_field->html_styling;
                        $text_to_display = $af_field->text_to_display;
                        ?>
                        <!-- edit this below line - crinch -->
                        <!--<li class='available_fields ui-draggable'><label><?php echo $compulsory . " " . $param[0] . ":" . $af_field->title; ?></label><input name='af_field[]' class='temp_cls1' type='hidden'  value='<?php echo $param[0] . ":" . $param[1]; ?>' /><input name='af_title[]' class='temp_cls2' type='hidden' value='<?php echo $af_field->title; ?>'></li>  -->
                        <li class='available_fields ui-draggable'>
                            <label><?php echo $compulsory . " " . esc_html($field_title) . ":" . esc_html($af_field->title); ?></label><input
                                name='af_field[]' class='temp_cls1' type='hidden'
                                value='<?php echo esc_attr($param[0]) . ":" . esc_attr($param[1]) . ":" . esc_attr($param[2]); ?>'/><input
                                name='af_title[]' class='temp_cls2' type='hidden'
                                value='<?php echo esc_attr($af_field->title); ?>'><input
                                name='af_options[]'
                                class='temp_cls3'
                                type='hidden'
                                value='<?php echo esc_attr($final_string); ?>'><input
                                name='af_explanation_text[]' class='temp_cls4' type='hidden'
                                value='<?php echo esc_attr($explanation_text); ?>'><input
                                name='af_explanation_text_location[]' class='temp_cls5' type='hidden'
                                value='<?php echo esc_attr($explanation_text_location); ?>'><input
                                name='af_html_styling[]' class='temp_cls6' type='hidden'
                                value='<?php echo esc_attr($html_styling); ?>'>
                            <input
                                name='af_text_to_display[]' class='temp_cls7' type='hidden'
                                value='<?php echo esc_attr($text_to_display); ?>'>
                            <input
                                name='af_show_title_field[]' class='temp_cls8' type='hidden'
                                value='<?php echo esc_attr($af_field->show_title_field); ?>'>
                            <input
                                name='af_pdf_file[]' class='temp_cls9' type='hidden'
                                value='<?php echo esc_attr($af_field->pdf_file); ?>'>
                            <input
                                name='af_pdf_file_button_styling[]' class='temp_cls10' type='hidden'
                                value='<?php echo esc_attr($af_field->pdf_file_button_styling); ?>'>
                            <input
                                name='af_pdf_file_button_text[]' class='temp_cls11' type='hidden'
                                value='<?php echo esc_attr($af_field->pdf_file_button_text); ?>'>
                        </li>
                    <?php }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<div id="dialog" title="Basic dialog">
</div>

<div id="edit_dialog" title="Basic dialog">
</div>
<div class="h20 clear"></div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(window).load(function () {
            <?php  if(APPLY_FORM_EDITION != 'free'){ ?>
            jQuery("#wp_ai_flds").mCustomScrollbar({
                scrollButtons: {
                    enable: true
                },

            });
            //ajax demo fn
            jQuery("a[rel='load-content']").click(function (e) {
                e.preventDefault();
                var $this = jQuery(this),
                    url = $this.attr("href");
                $this.addClass("loading");
                jQuery.get(url, function (data) {
                    $this.removeClass("loading");
                    jQuery("#wp_ai_flds .mCSB_container").html(data); //load new content inside .mCSB_container
                    jQuery("#wp_ai_flds").mCustomScrollbar("update"); //update scrollbar according to newly loaded content
                    jQuery("#wp_ai_flds").mCustomScrollbar("scrollTo", "top", {scrollInertia: 200}); //scroll to top
                });
            });
            jQuery("a[rel='append-content']").click(function (e) {
                e.preventDefault();
                var $this = jQuery(this),
                    url = $this.attr("href");
                $this.addClass("loading");
                jQuery.get(url, function (data) {
                    $this.removeClass("loading");
                    jQuery("#wp_ai_flds .mCSB_container").append(data); //append new content inside .mCSB_container
                    jQuery("#wp_ai_flds").mCustomScrollbar("update"); //update scrollbar according to newly appended content
                    jQuery("#wp_ai_flds").mCustomScrollbar("scrollTo", "h2:last", {
                        scrollInertia: 2500,
                        scrollEasing: "easeInOutQuad"
                    }); //scroll to appended content
                });
            });

            <?php } ?>


            jQuery("#wp_apply_flds").mCustomScrollbar({
                scrollButtons: {
                    enable: true
                }
            });
            //ajax demo fn
            jQuery("a[rel='load-content']").click(function (e) {
                e.preventDefault();
                var $this = jQuery(this),
                    url = $this.attr("href");
                $this.addClass("loading");
                jQuery.get(url, function (data) {
                    $this.removeClass("loading");
                    jQuery("#wp_apply_flds .mCSB_container").html(data); //load new content inside .mCSB_container
                    jQuery("#wp_apply_flds").mCustomScrollbar("update"); //update scrollbar according to newly loaded content
                    jQuery("#wp_apply_flds").mCustomScrollbar("scrollTo", "top", {scrollInertia: 200}); //scroll to top
                });
            });
            jQuery("a[rel='append-content']").click(function (e) {
                e.preventDefault();
                var $this = jQuery(this),
                    url = $this.attr("href");
                $this.addClass("loading");
                jQuery.get(url, function (data) {
                    $this.removeClass("loading");
                    jQuery("#wp_apply_flds .mCSB_container").append(data); //append new content inside .mCSB_container
                    jQuery("#wp_apply_flds").mCustomScrollbar("update"); //update scrollbar according to newly appended content
                    jQuery("#wp_apply_flds").mCustomScrollbar("scrollTo", "h2:last", {
                        scrollInertia: 2500,
                        scrollEasing: "easeInOutQuad"
                    }); //scroll to appended content
                });
            });
        });
    });

</script>
<!--script for headers and parameters-->
<?php if (APPLY_FORM_EDITION != 'free') { ?>
    <script type="text/javascript">
        function removeFn(id) {
            var elm = "#" + id;
            jQuery(elm).parent().remove();

        }

        jQuery(document).ready(function () {
            var scntDivheader = jQuery('#wp_adheaderintvw');
            var i = jQuery('#wp_adheaderintvw p').size();
            jQuery('#button_head').click(function () {
                jQuery('<p class="selected"><input class="header_cls" type="text" name="header[' + i + '][name]" value="" placeholder="name" />  <input type="text"  name="header[' + i + '][value]" value="" placeholder="value" /><span class="remintv" id="remScnt_' + i + '" style="cursor:pointer " onclick="removeFn(this.id);" ></span></p>').appendTo(scntDivheader);
                i++;

            });


            /*Add parameter*/
            var scntDiv = jQuery('.wp_dropinputint');
            var j = jQuery('.wp_dropinputint p').size();
            jQuery('#wp_addparameter').click(function () {
                jQuery('<p class="selected"><input type="text" class="parameter_cls" name="parameter[' + j + '][name]" value="" placeholder="name" />  <input type="text"   name="parameter[' + j + '][value]" value="" placeholder="value" /> <span id="parameter_' + j + '" class="wp_reminv" style="cursor:pointer " onclick="remFn(this.id);"></span></p>').appendTo(scntDiv);
                j++;

            });


            var scntPara = jQuery('.wp_dropinputint');
            jQuery("#wp_dropdivint").sortable({
                revert: true
            });

            jQuery(".wp_addinputint").draggable({
                connectToSortable: "#wp_dropdivint",
                connectToSortable: "#wp_adheaderintvw",
                helper: "clone",
                revert: "invalid",


            });


            jQuery("#wp_dropdivint, #wp_adheaderintvw").droppable({
                accept: ".wp_addinputint",
                drop: function (event, ui) {
                    if (jQuery(this).attr("id") == 'wp_dropdivint') {
                        var li_text = jQuery(ui.draggable).text();
                        var li_arr = new Array();
                        li_arr = li_text.split(":");
                        if (li_arr[0] == "Custom Field") {
                            var formatted_li = jQuery.trim(li_arr[1]);
                            var parameter_val_field = '{' + formatted_li + '}';
                            jQuery(".wp_dropinputint").append("<p class='selected'><input type='text' class='parameter_cls' name='parameter[" + j + "][name]' value='" + li_text + "' placeholder='name' /> <input type='text'  name='parameter[" + j + "][value]' value='" + parameter_val_field + "' placeholder='value' /> <span  id='parameter_" + j + "' class='wp_reminv' style='cursor:pointer ' onclick='remFn(this.id);'></span></p>");
                            j++;
                        } else {
                            var para_val = jQuery.trim(jQuery(ui.draggable).children('span').text());
                            var formatted_para_val = '{' + para_val + '}';
                            var para_name = jQuery.trim(jQuery(ui.draggable).clone()
                                .children()
                                .remove()
                                .end()
                                .text());

                            jQuery(".wp_dropinputint").append("<p class='selected'><input type='text' class='parameter_cls' name='parameter[" + j + "][name]' value='" + para_name + "' placeholder='name' /> <input type='text'  name='parameter[" + j + "][value]' value='" + formatted_para_val + "' placeholder='value' /> <span  id='parameter_" + j + "' class='wp_reminv' style='cursor:pointer ' onclick='remFn(this.id);'></span></p>");
                            j++;
                        }


                    } else if (jQuery(this).attr("id") == 'wp_adheaderintvw') {
                        var li_text = jQuery(ui.draggable).text();
                        var li_arr = new Array();
                        li_arr = li_text.split(":");

                        if ((li_arr[0] == "Custom Field") || (li_arr[0] == "Form")) {
                            var formatted_li = jQuery.trim(li_arr[1]);
                            var header_val_field = '{' + formatted_li + '}';

                            jQuery("#wp_adheaderintvw").append("<p class='selected'><input type='text' class='header_cls' name='header[" + i + "][name]' value='" + li_text + "' placeholder='name' /> <input type='text'  name='header[" + i + "][value]' value='" + header_val_field + "' placeholder='value' /> <span  id='remScnt_" + i + "' class='remintv' style='cursor:pointer ' onclick='removeFn(this.id);'></span></p>");
                            i++;

                        } else {
                            var header_val = jQuery.trim(jQuery(ui.draggable).children('span').text());
                            var formatted_header_val = '{' + header_val + '}';
                            var header_name = jQuery.trim(jQuery(ui.draggable).clone()
                                .children()
                                .remove()
                                .end()
                                .text());

                            jQuery("#wp_adheaderintvw").append("<p class='selected'><input type='text' class='header_cls' name='header[" + i + "][name]' value='" + header_name + "' placeholder='name' /> <input type='text'  name='header[" + i + "][value]' value='" + formatted_header_val + "' placeholder='value' /> <span  id='remScnt_" + i + "' class='remintv' style='cursor:pointer ' onclick='removeFn(this.id);'></span></p>");
                            i++;

                        }

                    }


                },

            });

        });


        function remFn(id) {
            var elm = "#" + id;
            jQuery(elm).parent().remove();

        }


    </script>
<?php } ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(window).load(function () {
            jQuery("#wp_ai_parvariable").mCustomScrollbar({
                scrollButtons: {
                    enable: true
                }
            });
            <?php if(APPLY_FORM_EDITION != 'free'){  ?>

            //ajax demo fn
            jQuery("a[rel='load-content']").click(function (e) {
                e.preventDefault();
                var $this = jQuery(this),
                    url = $this.attr("href");
                $this.addClass("loading");
                jQuery.get(url, function (data) {
                    $this.removeClass("loading");
                    jQuery("#wp_ai_parvariable .mCSB_container").html(data); //load new content inside .mCSB_container
                    jQuery("#wp_ai_parvariable").mCustomScrollbar("update"); //update scrollbar according to newly loaded content
                    jQuery("#wp_ai_parvariable").mCustomScrollbar("scrollTo", "top", {scrollInertia: 200}); //scroll to top
                });
            });
            jQuery("a[rel='append-content']").click(function (e) {
                e.preventDefault();
                var $this = jQuery(this),
                    url = $this.attr("href");
                $this.addClass("loading");
                jQuery.get(url, function (data) {
                    $this.removeClass("loading");
                    jQuery("#wp_ai_parvariable .mCSB_container").append(data); //append new content inside .mCSB_container
                    jQuery("#wp_ai_parvariable").mCustomScrollbar("update"); //update scrollbar according to newly appended content
                    jQuery("#wp_ai_parvariable").mCustomScrollbar("scrollTo", "h2:last", {
                        scrollInertia: 2500,
                        scrollEasing: "easeInOutQuad"
                    }); //scroll to appended content
                });
            });
            <?php } ?>

        });
    });
    <?php if(APPLY_FORM_EDITION != 'free'){  ?>


    function checkHeaderDuplicates() {
        var headObj = new Array();
        var results = new Array();
        var sorted_arr = new Array();
        var cnter = 0;
        jQuery("input[class=header_cls]").each(function () {
            var hValue = jQuery(this).val();
            headObj[cnter] = hValue;
            cnter++;
        });


        var sorted_arr = headObj.sort();
        for (var headI = 0; headI < headObj.length - 1; headI++) {
            if (sorted_arr[headI + 1] == sorted_arr[headI]) {
                results.push(sorted_arr[headI]);
            }


        }
        if (results.length > 0) {
            return 1;
        }

        return 0;

    }

    function checkParameterDuplicates() {
        var paramObj = new Array();
        var resultsParam = new Array();
        var sorted_arr_param = new Array();
        var cnter = 0;
        jQuery("input[class=parameter_cls]").each(function () {
            var pValue = jQuery(this).val();
            paramObj[cnter] = pValue;
            cnter++;

        });

        var sorted_arr_param = paramObj.sort();
        for (var paramI = 0; paramI < paramObj.length - 1; paramI++) {
            if (sorted_arr_param[paramI + 1] == sorted_arr_param[paramI]) {
                resultsParam.push(sorted_arr_param[paramI]);
            }


        }
        if (resultsParam.length > 0) {
            return 1;
        }

        return 0;

    }


    <?php } ?>


</script>
<!--end script for headers and parameters -->


<script type="text/javascript">

    <?php if(APPLY_FORM_EDITION != 'free'){  ?>
    jQuery(document).ready(function () {

        jQuery("#dialog").dialog({
            autoOpen: false,
            title: "Add new field",
            modal: true,
            minHeight: 300,
            minWidth: 500,
            buttons: {
                Ok: function () {
                    jQuery(this).dialog("close");
                    jQuery('#form_dialog').remove();
                    /*Initialize find on the new elements: code same as find li code on load*/

                    jQuery("#wp_ai_flds").find('li').each(function () {
                        jQuery(this).unbind("click");
                    });

                    jQuery("#wp_ai_flds").find('li').each(function () {
                        jQuery(this).click(function () {
                            //CRINCH
                            var showHideUploadPDFField_runtime = "style='display:none'";
                            var showHideAddOptionLink_runtime = "style='display:none'";
                            //CRINCH - VERSION2
                            var showHideUploadPDFFieldExplanation_runtime = "style='display:none'";
                            var showHideUploadPDFFieldExplanationLoaction_runtime = "style='display:none'";
                            var dynamicOptionsTrs_runtime = '';
                            //end CRINCH

                            jQuery("#edit_dialog").dialog("open");

                            var av_field = jQuery(this).find('.temp_cls1').val();
                            var av_title = jQuery(this).find('.temp_cls2').val();
                            //CRINCH
                            var av_options = jQuery(this).find('.temp_cls3').val();
                            //CRINCH - VERSION 2
                            //CRINCH - VERSION 2
                            var av_explanation_text = decodeURI(jQuery(this).find('.temp_cls4').val());
                            var av_explanation_text_location = jQuery(this).find('.temp_cls5').val();

                            var av_title = jQuery(this).find('.temp_cls2').val();
                            var exploded_field = av_field.split(":");

                            //CRINCH - BELOW LINE UPDATE
                            //var text_selected = longtext_selected = upload_selected = numeric_selected = '';
                            var text_selected = longtext_selected = upload_selected = numeric_selected = dropdown_selected = checkbox_selected = editablePDF_selected = '';

                            var required = '';
                            if (exploded_field[0] == "Text") {
                                text_selected = "selected='selected'";
                                showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "style='display:none'";
                            }
                            else if (exploded_field[0] == "Upload") {
                                upload_selected = "selected='selected'";
                                showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "style='display:none'";
                            }
                            else if (exploded_field[0] == "Long Text") {
                                longtext_selected = "selected='selected'";
                                showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "style='display:none'";
                            }
                            else if (exploded_field[0] == "Numeric") {
                                numeric_selected = "selected='selected'";
                                showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "style='display:none'";
                            }
                            else if (exploded_field[0] == "Dropdown") {  //CRINCH
                                dropdown_selected = "selected='selected'";
                                //showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "style='display:none'";
                                showHideAddOptionLink_runtime = '';
                                if (av_options != '') {
                                    dynamicOptionsTrs_runtime = makeDynamicOptions_runtime(exploded_field[0], av_options);
                                }

                            }
                            else if (exploded_field[0] == "Checkbox") {  //CRINCH
                                //showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "style='display:none'";
                                checkbox_selected = "selected='selected'";
                                showHideAddOptionLink_runtime = '';
                                dynamicOptionsTrs_runtime = makeDynamicOptions_runtime(exploded_field[0], av_options);

                            }
                            else if (exploded_field[0] == "EditablePDF") {  //CRINCH
                                editablePDF_selected = "selected='selected'";
                                showHideAddOptionLink_runtime = "style='display:none'";
                                showHideUploadPDFField_runtime = "";
                                //CRINCH - VERSION2
                                showHideUploadPDFFieldExplanation_runtime = "";
                                showHideUploadPDFFieldExplanationLoaction_runtime = "";
                                dynamicOptionsTrs_runtime = makeDynamicOptions_runtime_editable(exploded_field[0], av_options, av_explanation_text, av_explanation_text_location);
                            }

                            if (exploded_field[1] == "1") {
                                required = "checked='checked'";
                            }

                            //CRINCH - BELOW LINE UDPATED
                            /*var option_str = "<option value='Text' "+text_selected+">Text</option><option value='Upload' "+upload_selected+">Upload</option><option value='LongText' "+longtext_selected+">Long Text</option><option value='Numeric' "+numeric_selected+">Numeric</option>";*/

                            //01april - CRINCH -done
                            var option_str = "<option value='Text' " + text_selected + ">Text</option><option value='Upload' " + upload_selected + ">Upload</option><option value='LongText' " + longtext_selected + ">Long Text</option><option value='Numeric' " + numeric_selected + ">Numeric</option><option value='Dropdown' " + dropdown_selected + ">Dropdown</option><option value='Checkbox' " + checkbox_selected + ">Checkbox</option><option value='EditablePDF' " + editablePDF_selected + ">Editable PDF</option>";


                            jQuery(this).attr('id', 'pointer');      //set a id called pointer

                            //CRINCH - BELOW LINE UPDATED
                            /*jQuery("#edit_dialog").append("<form id='form_dialog'><table class='wpaf_dialog_table'><tr><td width='22px'><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\""+afTooltip.FIELD_TYPE_TOOLTIP+"\");'>?</span></td><td width='110px'><span class='dialog_flds'>Field Type:</span></td><td><select id='new_field' name='new_field' style='width:180px;'>"+option_str+"</select></td></tr><tr><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\""+afTooltip.REQUIRED_TOOLTIP+"\");'>?</span></td><td><span class='dialog_flds'>Required:</span></td><td><input id='required_field' type='checkbox' name='required_field' value='1' "+required+"></td></tr><tr><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\""+afTooltip.TITLE_OF_FIELD_TOOLTIP+"\");'>?</span></td><td><span class='dialog_flds'>Title of field:</span></td><td><input type='text' name='field_title' id='field_title' value='"+av_title+"' /></td></tr></table></form>"); */
                            //jQuery("#edit_dialog").append("<form id='form_dialog'><table class='wpaf_dialog_table'><tr><td width='22px'><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\""+afTooltip.FIELD_TYPE_TOOLTIP+"\");'>?</span></td><td width='110px'><span class='dialog_flds'>Field Type:</span></td><td><select onchange='DeleteItemOnDropDownSelection(); return false;' name='new_field' id='new_field' style='width:180px;'>"+option_str+"</select></td></tr><tr><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\""+afTooltip.REQUIRED_TOOLTIP+"\");'>?</span></td><td><span class='dialog_flds'>Required:</span></td><td><input id='required_field' type='checkbox' name='required_field' value='1' "+required+"></td></tr><tr><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\""+afTooltip.TITLE_OF_FIELD_TOOLTIP+"\");'>?</span></td><td><span class='dialog_flds'>Title of field:</span></td><td><input type='text' name='field_title' id='field_title' value='"+av_title+"' /></td></tr><tr id='asifarif-0' class='checkme'><td colspan='3'></td></tr>"+dynamicOptionsTrs_runtime+"<tr "+showHideAddOptionLink_runtime+" id='linkToCreateDynamicOption'><td align='center' colspan='3'><button type='button' id='asif_arif' class='asif_arif' onclick = 'event_add_audience_custom(); return false;'><span class='ui-button-text trigger'>Add OPtion</span></button></td></tr><tr "+showHideUploadPDFField_runtime+" id='showHideUploadPDFFieldID'><td align='center' colspan='3'><input name='file' id='fileupload' type='file' size='15' multiple/><div id='showPDFfileOnly'style='color:red;font-size:10px;'>Only PDF files!</div><div ='response'></div></td></tr></table></form>");
                            jQuery("#edit_dialog").append("<form id='form_dialog'><table class='wpaf_dialog_table'><tr><td width='22px'><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.FIELD_TYPE_TOOLTIP + "\");'>?</span></td><td width='110px'><span class='dialog_flds'>1Field Type:</span></td><td><select onchange='DeleteItemOnDropDownSelection(); return false;' name='new_field' id='new_field' style='width:180px;'>" + option_str + "</select></td></tr><tr><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.REQUIRED_TOOLTIP + "\");'>?</span></td><td><span class='dialog_flds'>Required:</span></td><td><input id='required_field' type='checkbox' name='required_field' value='1' " + required + "></td></tr><tr><td><span class='wpaf_tooltip trigger'  onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP + "\");'>?</span></td><td><span class='dialog_flds'>Title of field:</span></td><td><input type='text' name='field_title' id='field_title' value='" + av_title + "' /></td></tr><tr id='asifarif-0' class='checkme'><td colspan='3'></td></tr>" + dynamicOptionsTrs_runtime + "<tr " + showHideAddOptionLink_runtime + " id='linkToCreateDynamicOption'><td align='center' colspan='3'><button type='button' id='asif_arif' class='asif_arif' onclick = 'event_add_audience_custom(); return false;'><span class='ui-button-text trigger'>Add OPtion</span></button></td></tr></table></form>");


                        });
                    });

                    /*end of initialization */


                }
            },
            close: function (event, ui) {
            }

        });
        /*initialize edit dialog*/
        jQuery("#edit_dialog").dialog({
            autoOpen: false,
            title: "Edit field",
            modal: true,
            minHeight: 300,
            minWidth: 500,
            buttons: {
                Ok: function () {
                    jQuery(this).dialog("close");
                    jQuery('#form_dialog').remove();
                }
            },

            close: function (event, ui) {
                jQuery('#form_dialog').remove();
            }

        });


    });

    <?php } ?>
    /* tooltip functions -- start */
    function OpenDiv(val) {
        document.getElementById('div_eLink').style.display = 'block';
        document.getElementById('spn_eLink').innerHTML = val;

        jQuery(document).ready(function () {
            var moveLeft = 5;
            var moveDown = -270;
            jQuery('.trigger').hover(function (e) {
                jQuery('#div_eLink').show();
            });
            jQuery('.trigger').mousemove(function (e) {
                jQuery("#div_eLink").css('margin-left', '54px');
                jQuery("#div_eLink").css('top', e.pageY + moveDown);

            });
            jQuery('.trigger').mouseout(function (e) {
                hideDiv();
            });
        });
    }
    /* Close  div  */
    function hideDiv() {
        document.getElementById('div_eLink').style.display = 'none';
    }


    /* tooltip functions -- end */


    //CRINCH


    function DeleteCustom(id) { //crinch
        var par = jQuery('.wpaf_dialog_table tbody tr#' + id);
        par.remove();
    }
    ;

    function DeleteItemOnDropDownSelection() { //crinch
        var getClass = 'checkme';
        var field_type_custom_value = jQuery('#new_field').val();
        if (field_type_custom_value == 'Checkbox' || field_type_custom_value == 'Dropdown') {
            jQuery('.wpaf_dialog_table tbody tr#linkToCreateDynamicOption').show();
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldID').hide();
            //CRINCH - VERSION 2
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldExplanation').hide();
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldExplanationLoaction').hide();
        } else if (field_type_custom_value == 'EditablePDF') {
            jQuery('.wpaf_dialog_table tbody tr#linkToCreateDynamicOption').hide();
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldID').show();
            //CRINCH - VERSION 2
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldExplanation').show();
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldExplanationLoaction').show();
        } else {
            jQuery('.wpaf_dialog_table tbody tr#linkToCreateDynamicOption').hide();
            jQuery('.wpaf_dialog_table tbody tr#asifarif-1').hide();
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldID').hide();
            //CRINCH - VERSION 2
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldExplanation').hide();
            jQuery('.wpaf_dialog_table tbody tr#showHideUploadPDFFieldExplanationLoaction').hide();
        }

        jQuery("." + getClass).each(function () {
            if (this.id == 'asifarif-0') {
                return;
            }
            DeleteCustom(this.id);
            /*if(field_type_custom_value=='Checkbox' || field_type_custom_value=='Dropdown'){
             jQuery('.wpaf_dialog_table tbody tr#'+this.id).show();
             }else{
             jQuery('.wpaf_dialog_table tbody tr#'+this.id).hide();

             }*/
        });
    }
    function makeDynamicOptions_runtime_editable(field_type, field_option_str, pdf_explanation_text_edit, pdf_explanation_text_location_edit) {
        pdf_explanation_text_edit = pdf_explanation_text_edit.replace("%2C", ",");
        pdf_explanation_text_edit = pdf_explanation_text_edit.replace("%2C", ",");
        pdf_explanation_text_edit = pdf_explanation_text_edit.replace("%2C", ",");


        var plugin_dir_link = field_option_str;
        plugin_dir_link = plugin_dir_link.replace("uploadedpdffiles/", "");
        var href_file_link = "<span style='color:red;font-size:11px;'>" + plugin_dir_link + "</span>";
        //var return_str_runtime = "<tr id='showHideUploadPDFFieldID'><td>"+href_file_link+"</td><td align='center' colspan='2'><input name='file' id='fileupload' type='file' size='15' multiple/><input type='hidden' name='alreadySelectedPdf' id='alreadySelectedPdf' value='"+field_option_str+"'><div id='showPDFfileOnly' style='color:red;font-size:10px;'>Only PDF files!</div></td></tr>";
        //CRINCH - VERSION 2
        var pdf_file_text_selection_edit_checked_popup = '';
        var pdf_file_text_selection_edit_checked_onform = '';
        if (pdf_explanation_text_location_edit == 'onpopup') {
            pdf_file_text_selection_edit_checked_popup = 'checked';
        } else if (pdf_explanation_text_location_edit == 'onform') {
            pdf_file_text_selection_edit_checked_onform = 'checked';
        } else {
            pdf_file_text_selection_edit_checked_popup = 'checked';
        }
        var return_str_runtime = "<tr id='showHideUploadPDFFieldID'><td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.TITLE_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td><td><span class='dialog_flds'>PDF File:</span></td><td align='left'>(Previous Selected File):" + href_file_link + "<input name='file' id='fileupload' type='file' size='15' multiple/><div id='showPDFfileOnly'style='color:red;font-size:10px;'>Only PDF file!</div><div ='response'></div></td></tr><tr id='showHideUploadPDFFieldExplanation'><td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td><td><span class='dialog_flds'>Explanation Text:</span></td><td align='left'><textarea rows='4' cols='18' id='pdf_file_explanation' name='pdf_file_explanation'>" + decodeURI(pdf_explanation_text_edit) + "</textarea></td></tr><tr id='showHideUploadPDFFieldExplanationLoaction'><td><span class='wpaf_tooltip trigger' onmouseover = 'OpenDiv(\"" + afTooltip.EXPLANATION_OF_FIELD_TOOLTIP_PDF + "\");'>?</span></td><td><span class='dialog_flds'>Text Location:</span></td><td align='left'>On Form<input type='radio' id='pdf_file_location' name='pdf_file_location' value='onform' " + pdf_file_text_selection_edit_checked_onform + ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On PopUp<input type='radio' id='pdf_file_location' name='pdf_file_location' value='onpopup' " + pdf_file_text_selection_edit_checked_popup + "><input type='hidden' name='alreadySelectedPdf' id='alreadySelectedPdf' value='" + field_option_str + "'></td></tr>";
        return return_str_runtime;
    }
    function makeDynamicOptions_runtime(field_type, field_option_str) {
        var return_str_runtime = '';
        var input_old_field_option_str_runtime = field_option_str;
        var old_field_option_arr_runtime = input_old_field_option_str_runtime.split(",");
        for (var i_runtime = 1; i_runtime <= old_field_option_arr_runtime.length; i_runtime++) {
            var maxId_runtime = i_runtime;
            var field_title_str_runtime = old_field_option_arr_runtime[i_runtime - 1];
            var select_radio_button_runtime = '';
            if (field_title_str_runtime.match(/(^.*\[|\].*$)/g, '')) {
                var select_radio_button_runtime = 'checked';
                var field_title_control_selection_runtime = field_title_str_runtime.split("[");
                field_title_str_runtime = field_title_control_selection_runtime[0];
            }
            if (field_type == 'Checkbox') {
                var dynamic_checkbox_radio_control_runtime = "<input class='inputclass' type='checkbox' name='fieldOPtionDefaultCheckBox[]' id='fieldOPtionDefaultCheckBox-" + maxId_runtime + "' " + select_radio_button_runtime + " value='" + maxId_runtime + "'><span style='font-size:11px;'>Default Selected</span>";
            } else if (field_type == 'Dropdown') {
                var dynamic_checkbox_radio_control_runtime = "<input class='inputclass' type='radio' name='fieldOPtionDefaultRadioButton[]' id='fieldOPtionDefaultRadioButton-" + maxId_runtime + "' " + select_radio_button_runtime + "  value='" + maxId_runtime + "'><span style='font-size:11px;'>Default Selection</span>";
            } else {
                var dynamic_checkbox_radio_control_runtime = "&nbsp";
            }
            var return_str_runtime = return_str_runtime + "<tr class='checkme' id='asifarif-" + maxId_runtime + "'>" +
                "<td><span style='color:red;font-size:11px;cursor:pointer;' class='btnDelete' onclick='customDeleteRowFromAvailableFieldsOnUpdate_runtime(" + maxId_runtime + "); return false;'>Delete</span></td>" +
                "<td colspan='2'>&nbsp; <span style='font-size:15px;'>Options " + maxId_runtime + "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='fieldOptions[]' id='" + maxId_runtime + "' type='text' value='" + field_title_str_runtime + "'/>&nbsp;&nbsp;" + dynamic_checkbox_radio_control_runtime + "</td>" +
                "</tr>";
        }
        return return_str_runtime;
    }

    function customDeleteRowFromAvailableFieldsOnUpdate_runtime(id) {
        DeleteCustom_runtime(id);
    }
    function DeleteCustom_runtime(id) { //crinch
        var par = jQuery('.wpaf_dialog_table tbody tr#asifarif-' + id);
        par.remove();
    }
    ;


</script>