<?php
/*
 * Plugin Name: Candidate Application Form
 * Plugin URI: http://responsecoordinator.com/?page_id=366
 * Description: Easily add a candidate application form to a job vacancy post, which allows the candidate to apply for the vacancy.
 * Version: 1.6
 * Author: <a href="http://flaxlandsconsulting.com">Flaxlands Consulting Ltd</a>. | To find out more about the full version of the plugin <a href="http://responsecoordinator.com/?page_id=366">click here</a>.
 */
if (!defined('ABSPATH')) exit;
$my_plugin = new Candidate_Application_Form();

class Candidate_Application_Form
{

    /* Name: apply_form_frontend_method
     Parameters:
     Use: To load the javascript files only on front end
    */


    function apply_form_frontend_method()
    {
        wp_register_style('jquery-ui', plugins_url('css/jquery-ui.css', __FILE__));
        wp_register_style('jquery.ui.theme', plugins_url('js/themes/base/jquery.ui.theme.css', __FILE__));
        wp_register_style('af-style-ic', plugins_url('css/style-ic.css', __FILE__));
        wp_register_style('af-mediaform', plugins_url('css/mediaform.css', __FILE__));
        wp_register_style('af-bootstrap', plugins_url('css/bootstrap.css', __FILE__));  //CRINCH
        wp_enqueue_style('af-bootstrap');   //CRINCH


        wp_enqueue_style('jquery-ui');
        wp_enqueue_style('jquery.ui.theme');
        wp_enqueue_style('af-style-ic');
        wp_enqueue_style('af-mediaform');

        wp_register_script("custom_plupload", plugins_url('js/custom_plupload.js', __FILE__), array('jquery'));
        wp_register_script("apply_form", plugins_url('js/apply_form.js', __FILE__), array('custom_plupload'));

        wp_localize_script('apply_form', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php'), 'script_in_use' => SCRIPT_IN_USE));
        wp_localize_script('custom_plupload', 'AF', array('DEBUG_MODE' => DEBUG_MODE));
        wp_localize_script('custom_plupload', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('plupload-all');
        wp_enqueue_script('custom_plupload');
        wp_enqueue_script('apply_form');

    }


    /* Name: apply_form_admin_enqueue
     Parameters:
     Use: To load the javascript files for the admin page
    */
    function apply_form_admin_enqueue($hook)
    {
        add_action('admin_notices', array(&$this, 'candidate_apply_form_admin_notice'));
        $retrieved_hook = array('settings_page_candidate-apply-form', 'post-new.php', 'post.php', 'edit.php');
        if (!in_array($hook, $retrieved_hook))
            return;
        /*added in admin*/
        wp_register_style('jquery-ui', plugins_url('css/jquery-ui.css', __FILE__));

        wp_register_style('jquery.ui.theme', plugins_url('js/themes/base/jquery.ui.theme.css', __FILE__));

        /*add style*/
        wp_register_style('af-style', plugins_url('css/admin/form-style.css', __FILE__));
        wp_register_style('af-font-awesome', plugins_url('font-awesome/css/form-awesome.min.css', __FILE__));
        wp_register_style('af-custom-scrollbar', plugins_url('css/jquery.mCustomScrollbar.css', __FILE__));
        wp_register_style('af-bootstrap', plugins_url('css/bootstrap.css', __FILE__));

        wp_enqueue_style('jquery-ui');
        wp_enqueue_style('jquery.ui.theme');
        wp_enqueue_style('af-style');
        wp_enqueue_style('af-custom-scrollbar');
        wp_enqueue_style('af-bootstrap');

        wp_register_script('af-scrollbar', plugins_url('js/jquery.mCustomScrollbar.concat.min.js', __FILE__), array('jquery'));
        wp_register_script("af-functions", plugins_url('js/functions.js', __FILE__), array('jquery'));
        wp_register_script("admin_apply_form", plugins_url('js/admin_apply_form.js', __FILE__), array('af-functions'));

        $enable = (isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == 'candidate-form') ? true : false;

        wp_localize_script('admin_apply_form', 'myCustomAjax', array('status' => $enable, 'version' => APPLY_FORM_EDITION, 'ajaxcustomurl' => admin_url('admin-ajax.php'), 'script_in_use_custom' => 'uploadfile.php'));

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-form');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('jquery-ui-sortable');

        /*end of new scripts*/

        /*localize field types*/
        //wp_localize_script( 'admin_apply_form', 'afAjax', array( 'FIELD_TYPE1' => FIELD_TYPE1,'FIELD_TYPE2' => FIELD_TYPE2,'FIELD_TYPE3' => FIELD_TYPE3,'FIELD_TYPE4' => FIELD_TYPE4,'FIELD_TYPE6' => FIELD_TYPE6,'FIELD_TYPE7' => FIELD_TYPE7));
        //CRINCH
        wp_localize_script('admin_apply_form', 'afAjax', array('FIELD_TYPE1' => FIELD_TYPE1, 'FIELD_TYPE2' => FIELD_TYPE2, 'FIELD_TYPE3' => FIELD_TYPE3, 'FIELD_TYPE4' => FIELD_TYPE4, 'FIELD_TYPE6' => FIELD_TYPE6, 'FIELD_TYPE7' => FIELD_TYPE7, 'FIELD_TYPE8' => FIELD_TYPE8, 'FIELD_TYPE9' => FIELD_TYPE9, 'FIELD_TYPE10' => FIELD_TYPE10, 'FIELD_TYPE11' => FIELD_TYPE11, 'FIELD_TYPE12' => FIELD_TYPE12, 'ajaxurl' => admin_url('admin-ajax.php')));

        //wp_localize_script( 'admin_apply_form', 'afTooltip', array( 'FIELD_TYPE_TOOLTIP' => FIELD_TYPE_TOOLTIP,'REQUIRED_TOOLTIP' => REQUIRED_TOOLTIP,'TITLE_OF_FIELD_TOOLTIP' => TITLE_OF_FIELD_TOOLTIP));
        //CRINCH
        wp_localize_script('admin_apply_form', 'afTooltip', array('FIELD_TYPE_TOOLTIP' => FIELD_TYPE_TOOLTIP, 'REQUIRED_TOOLTIP' => REQUIRED_TOOLTIP, 'NOTIFICATION_EMAIL_TOOLTIP' => NOTIFICATION_EMAIL_TOOLTIP, 'TITLE_OF_FIELD_TOOLTIP' => TITLE_OF_FIELD_TOOLTIP, 'TYPE_OF_FIELD_TOOLTIP_PDF' => TYPE_OF_FIELD_TOOLTIP_PDF, 'TITLE_OF_FIELD_TOOLTIP_PDF' => TITLE_OF_FIELD_TOOLTIP_PDF, 'EXPLANATION_OF_FIELD_TOOLTIP_PDF' => EXPLANATION_OF_FIELD_TOOLTIP_PDF, 'LOCATION_OF_FIELD_TOOLTIP_PDF' => LOCATION_OF_FIELD_TOOLTIP_PDF));

        wp_enqueue_script('af-scrollbar');
        wp_enqueue_script('af-functions');
        wp_enqueue_script('admin_apply_form');

        wp_enqueue_script('file-upload-js');

    }

    function startsWith($haystack, $needle)
    {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    function endsWith($haystack, $needle)
    {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }


    /* Name: on_ic_apply
     Parameters:
     Use:  js/apply_form.js sends a post to ic_apply. This function handles the ajax request and loads the scripts from the api_scripts folder as determined in the $script_in_use variable.
    */
    function on_ic_apply()
    {
        global $wpdb;
        $id = $_POST['post_id'];
        /*check for validation errors if any */
        $form_params = $_POST;
        $wpaf_setting = maybe_unserialize(get_post_meta($id, '__wpaf_setting', true));
        $decoded_setting = json_decode($wpaf_setting);
        if (isset($decoded_setting->scriptname)) {
            $scriptname = $decoded_setting->scriptname;
        }else{
            $scriptname = 'Apply_Form_email_script.php';
        }
        $file_path = IC_ROOT_DIR . "/api_scripts/" . $scriptname;
        if (isset($_POST['validation_mode'])) {
            $messages = array();
            $messages = $this->validation_errors($form_params, $id);

            if (isset($messages['invalid']) && !empty($messages['invalid'])) {
                $validation_msg = json_encode($messages);
                echo $validation_msg;
                die();

            } else if (isset($messages['file_response']) && !empty($messages['file_response'])) {
                unset($messages['invalid']);
                $validation_msg = json_encode($messages);
                echo $validation_msg;
                die();
            }
//            echo 1;
//            die();

        }

        if (isset($_POST['Confirm'])) {
            unset($_POST['Confirm']);
        }


        /*end of validation code */

        /* Add the Values from the script config section parameter to the list */

        if (isset($id)) {
            $wpaf_headers = maybe_unserialize(get_post_meta($id, '__wpaf_headers', true));
            $wpaf_parameters = maybe_unserialize(get_post_meta($id, '__wpaf_parameters', true));
            $wpaf_meta_value = maybe_unserialize(get_post_meta($id, '__wpaf_meta_value', true));

            $decoded_headers = json_decode($wpaf_headers);
            $decoded_parameters = json_decode($wpaf_parameters);
            $decoded_meta_value = json_decode($wpaf_meta_value);

            /*Query post meta table */
            $querystr = "SELECT group_concat(wp_postmeta.meta_key  separator '-wp-ai-ex- ') as meta_key_group, group_concat(wp_postmeta.meta_value  separator '-wp-ai-ex- ') as meta_value_group FROM wp_postmeta WHERE wp_postmeta.post_id = $id order by meta_id asc";


            $page_records = $wpdb->get_results($querystr, OBJECT);    /*get the meta list */


            /*Query post table */
            $wp_records = array();
            $querystr = "SELECT " . WPpostURL . "
                                          FROM wp_posts
                                          WHERE wp_posts.post_status = 'publish' 
                                          AND wp_posts.post_type = 'post'
                                          AND wp_posts.post_date < NOW()
                                          AND  wp_posts.ID = $id
                                          ORDER BY wp_posts.post_date DESC";


            $post_records = $wpdb->get_results($querystr, OBJECT);     /*gets details about the post */
            if (!empty($post_records)) {
                $result = $post_records['0'];
                $wp_records["WPpostURL"] = $result->guid;    /*todo: list of parameters to fetch as hardcoded values*/

            }

            /*add current page url to the hardcoded paramer list */
            if (isset($_POST['current_page_url'])) {
                $wp_records["Current Page URL"] = esc_url($_POST['current_page_url']);

                if (SCRIPT_IN_USE == 'Apply_Form_email_script.php') {
                    $_POST['AdvertURL'] = esc_url($_POST['current_page_url']);
                }
                unset($_POST['current_page_url']);
            }

            /*end -current page url code */

            $meta_key_str = $page_records[0]->meta_key_group;
            $meta_val_str = $page_records[0]->meta_value_group;
            $meta_key_arr = array();
            $meta_val_arr = array();
            $meta_key_arr = explode("-wp-ai-ex- ", $meta_key_str);
            $meta_val_arr = explode("-wp-ai-ex- ", $meta_val_str);
            $meta_arr = array();
            if (isset($meta_key_arr)) {
                foreach ($meta_key_arr as $mkey => $mval) {
                    $meta_arr[$mval] = $meta_val_arr[$mkey];
                }
            }

            if (isset($decoded_parameters)) {
                foreach ($decoded_parameters as $param_arr) {
                    $param_name_key = trim($param_arr->name);
                    if($this->startsWith( $param_arr->value, "{") && $this->endsWith( $param_arr->value, "}")) {
                        $parameter_rec = str_replace("{", "", "$param_arr->value");
                        $parameter_rec = str_replace("}", "", "$parameter_rec");
                        $post_arr["$param_name_key"] = $decoded_meta_value->$parameter_rec;
                    }else{
                        $post_arr["$param_name_key"] = $param_arr->value;
                    }
                    $param_value = trim($param_arr->value);

                    preg_match_all('/{.*?}/', $param_value, $matches);
                    $match_val = array_map('intval', $matches);
                    if ($match_val[0] == 1) {
                        $parameter_rec = str_replace("{", "", "$param_value");
                        $parameter_rec = str_replace("}", "", "$parameter_rec");

                        if (array_key_exists("$parameter_rec", $meta_arr)) {
                            $post_arr["$param_name_key"] = $meta_arr[$parameter_rec];
                        } else if (array_key_exists("$parameter_rec", $wp_records)) { /*Check for hardcoded array */
                            $post_arr["$param_name_key"] = $wp_records[$parameter_rec];      /*belongs to wp_post table for hardcoded values */
                        }


                    } else if (empty($param_name_key) && empty($param_name_value)) {
                        unset($post_arr["$param_name_key"]);   /*unset the  empty values from the array*/
                    }

                    /*Merge tag match on name field*/
                    preg_match_all('/{.*?}/', $param_name_key, $matches);
                    $match_val = array_map('intval', $matches);
                    if ($match_val[0] == 1) {
                        $parameter_name_rec = str_replace("{", "", "$param_name_key");
                        $parameter_name_rec = str_replace("}", "", "$parameter_name_rec");
                        if (array_key_exists("$parameter_name_rec", $meta_arr)) {
                            $new_key = $meta_arr["$parameter_name_rec"];
                            $temp_parameter = $post_arr["$param_name_key"];
                            unset($post_arr["$param_name_key"]);
                            $post_arr["$new_key"] = $temp_parameter;
                        } else if (array_key_exists("$parameter_name_rec", $wp_records)) { /*Check for hardcoded array */
                            $new_key = $wp_records[$parameter_name_rec];
                            $temp_parameter = $post_arr["$param_name_key"];
                            unset($post_arr["$param_name_key"]);
                            $post_arr["$new_key"] = $temp_parameter;
                        }
                    }
                    /*End: Merge tag match on value field*/

                }
            }

            $headers_array_new = array();

            $final_post_arr = $post_arr;            /*combination*/
            $header_counter = 0;    /*used to obtain if content-type other than application/json is used to overide default content type*/
            if (isset($decoded_headers)) {
                foreach ($decoded_headers as $head_arr) {
                    $name_key = trim($head_arr->name);
                    $uc_name_key = strtoupper($name_key);
                    $uc_name_value = strtoupper($head_arr->value);
                    if (($uc_name_key == 'CONTENT-TYPE') && ($uc_name_value != 'APPLICATION/JSON')) {
                        $header_counter++;
                    }

                    if($this->startsWith( $head_arr->value, "{") && $this->endsWith( $head_arr->value, "}")) {
                        $header_rec = str_replace("{", "", "$head_arr->value");
                        $header_rec = str_replace("}", "", "$header_rec");
                        $headers_array_new["$name_key"] = $decoded_meta_value->$header_rec;
                    }else{
                        $headers_array_new["$name_key"] = $head_arr->value;
                    }

                    /*Code: Replace merge tag with the Database value*/

                    $head_value = trim($head_arr->value);
                    preg_match_all('/{.*?}/', $head_value, $matches);
                    $match_val = array_map('intval', $matches);
                    if ($match_val[0] == 1) {
                        $header_rec = str_replace("{", "", "$head_value");
                        $header_rec = str_replace("}", "", "$header_rec");
                        if (array_key_exists("$header_rec", $meta_arr)) {
                            $headers_array_new["$name_key"] = $meta_arr[$header_rec];
                        } else if (array_key_exists("$header_rec", $wp_records)) { /*Check for hardcodede array */
                            $headers_array_new["$name_key"] = $wp_records[$header_rec];      /*belongs to wp_post table for hardcoded values */
                        }

                    } else if (empty($name_key) && empty($head_value)) {
                        unset($headers_array_new["$name_key"]);   /*unset the  empty values from the array*/

                    }


                    /*End Code: Replace merge tag with the Database value*/


                    /*Merge tag match on name field for headers*/
                    preg_match_all('/{.*?}/', $name_key, $matches);
                    $match_val = array_map('intval', $matches);
                    if ($match_val[0] == 1) {
                        $header_name_rec = str_replace("{", "", "$name_key");
                        $header_name_rec = str_replace("}", "", "$header_name_rec");

                        if (array_key_exists("$header_name_rec", $meta_arr)) {
                            $new_key = $meta_arr["$header_name_rec"];
                            $temp_header = $headers_array_new["$name_key"];
                            unset($headers_array_new["$name_key"]);
                            $headers_array_new["$new_key"] = $temp_header;
                        } else if (array_key_exists("$header_name_rec", $wp_records)) { /*Check for hardcoded array */
                            $new_key = $wp_records[$header_name_rec];
                            $temp_header = $headers_array_new["$name_key"];
                            unset($headers_array_new["$name_key"]);
                            $headers_array_new["$new_key"] = $temp_header;
                        }


                    }
                    /*End: Merge tag match on value field*/

                }
            }

            if ($header_counter == 0) { /*If not set by user, content-type is set to default i.e application/json*/
                $headers_array_new["Content-Type"] = "application/json";
            }

            $headers = array();

            $headers = $headers_array_new;
            $script_parameters = $final_post_arr;

            $_POST['headers'] = $headers;
            $_POST['script_parameters'] = $script_parameters;
            print_r($_POST['script_parameters']);
            $script_parameters = array();
            $headers = array();
        }
        /*End of code */
        $wpaf_setting = maybe_unserialize(get_post_meta($id, '__wpaf_setting', true));
        $wpaf_messages = maybe_unserialize(get_post_meta($id, '__wpaf_messages', true));
        $decoded_setting = json_decode($wpaf_setting);

        $decoded_messages = json_decode($wpaf_messages);
        if (isset($decoded_setting->success_setting)) {

            $success_setting = $decoded_setting->success_setting;
            $_POST['apply_success'] = $success_setting;
            if ($success_setting == 1) {
                $_POST['success_message'] = stripslashes(htmlspecialchars_decode($decoded_messages->success_msg, ENT_QUOTES));
            }
        }
        if (isset($decoded_setting->failure_setting)) {
            $failure_setting = $decoded_setting->failure_setting;
            $_POST['apply_failure'] = $failure_setting;
            if ($failure_setting == 1) {
                $_POST['failure_message'] = stripslashes(htmlspecialchars_decode($decoded_messages->failure_msg, ENT_QUOTES));
            }
        }


        $dest_email = get_post_meta($id, '__candidate_apply_form_destination_email', true);
        if ($dest_email) {
            $_POST['destination_email'] = $dest_email;
        }

        /*End of Script Config code*/


        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            include("$file_path");
            die();


        } else {  /* javascript is disabled, this feature is not being called for now*/
            include("$file_path");
            /*end of api post*/
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            die();
        }


        /** Set the correct status (so that the correct splash message is shown */
        // $_POST['_wp_http_referer'] = add_query_arg('status', $status, $_POST['_wp_http_referer']);

        /** Redirect the user back to where they came from */
        //  wp_redirect($_POST['_wp_http_referer']);

    }

    function add_meta_tags()
    {
        echo '<meta charset="utf-8">
        <meta name = "viewport" content = "width=device-width, maximum-scale = 1, minimum-scale=1" /><!--[if lt IE 9]> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->';
    }


    /* Name: apply_form
     Parameters:
     Use: The Apply to Job Form
     shortcode:  [apply-form]
    */

    function DownloadAttachment()
    {
        if (isset($_REQUEST['download-attachment'])) {
            $dir = FILE_UPLOAD_DIR;
            $file = sanitize_text_field($_REQUEST['file']);
            $this->downloadUrlToFile($dir, $file);
        }
    }

    private function downloadUrlToFile($url, $outFileName)
    {
        $content_type = '';
        $buffer = 1024;

        $buffer *= 1024;
        $bandwidth = 0;
        $speed = 1024;
        if (function_exists('ini_set'))
            @ini_set('display_errors', 0);

        @session_write_close();

        //if ( function_exists( 'apache_setenv' ) )
        //    @apache_setenv( 'no-gzip', 1 );

        if (function_exists('ini_set'))
            @ini_set('zlib.output_compression', 'Off');


        @set_time_limit(0);
        @session_cache_limiter('none');
        if (file_exists($url . $outFileName))
            $fsize = filesize($url . $outFileName);
        else
            $fsize = 0;
        nocache_headers();
        header("X-Robots-Tag: noindex, nofollow", true);
        header("Robots: none");
        header("Content-type: $content_type");
        header("Content-disposition: attachment;filename=\"{$outFileName}\"");
        header("Content-Transfer-Encoding: binary");
        if ((isset($_REQUEST['play']) && strpos($_SERVER['HTTP_USER_AGENT'], "Safari"))) {
            readfile($url . $outFileName);
            die();
        }

        $file = @fopen($url . $outFileName, "rb");

        if (isset($_SERVER['HTTP_RANGE']) && $fsize > 0) {
            list($bytes, $http_range) = explode("=", $_SERVER['HTTP_RANGE']);
            $set_pointer = intval(array_shift($tmp = explode('-', $http_range)));

            $new_length = $fsize - $set_pointer;

            header("Accept-Ranges: bytes");
            header("HTTP/1.1 206 Partial Content");

            header("Content-Length: $new_length");
            header("Content-Range: bytes $http_range$fsize/$fsize");

            fseek($file, $set_pointer);
        } else {

            header("Content-Length: " . $fsize);
        }
        $packet = 1;


        if ($file) {
            while (!(connection_aborted() || connection_status() == 1) && $fsize > 0) {
                if ($fsize > $buffer) {
                    echo fread($file, $buffer);
                } else {
                    echo fread($file, $fsize);
                }
                ob_flush();
                flush();
                $fsize -= $buffer;
                $bandwidth += $buffer;
                if ($speed > 0 && ($bandwidth > $speed * $packet * 1024)) {
                    sleep(1);
                    $packet++;
                }
            }
            //add_action('wpdm_download_completed', $package);
            @fclose($file);
        }
        die();
    }

    public function apply_form($atts)
    {
        $post_id = $atts['id'];
        $post_status = get_post_status($post_id);
        if ($post_status == 'trash') {
            echo 'The short code is disabled';
            return false;
        }
        ob_start();
        add_action('wp_head', 'add_meta_tags'); ?>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="<?php echo plugins_url('js/html5shiv.js', __FILE__ ); ?>"></script>
        <script type="text/javascript" src="<?php echo plugins_url('js/css3-mediaqueries.js', __FILE__ ); ?>"></script>
        <script type="text/javascript" src="<?php echo plugins_url('js/respond.js', __FILE__ ); ?>"></script>
        <![endif]-->
        <?php


        /* Start - Adding User defined style to the Apply to Job Form */

        $wpaf_popup_params = maybe_unserialize(get_post_meta($post_id, '__wpaf_response_popup', true));
        $wpaf_apply_button = maybe_unserialize(get_post_meta($post_id, '__wpaf_apply_button', true));

        if (!empty($wpaf_popup_params)) {
            $decoded_popup_params = json_decode($wpaf_popup_params);
            $popup_width = $decoded_popup_params->width;
            $popup_height = $decoded_popup_params->height;
            $popup_textcolour = $decoded_popup_params->colour;
            $popup_bgcolour = $decoded_popup_params->bgcolour;
            $popup_style = $decoded_popup_params->style;
        }

        if (!empty($wpaf_apply_button)) {
            $decoded_apply_button = json_decode($wpaf_apply_button);
            $apply_btn_width = $decoded_apply_button->width;
            $apply_btn_height = $decoded_apply_button->height;
            $apply_btn_margin = $decoded_apply_button->margin;
            $apply_btn_margin_left = $decoded_apply_button->margin_left;
            $apply_btn_margin_right = $decoded_apply_button->margin_right;
            $apply_btn_margin_top = $decoded_apply_button->margin_top;
            $apply_btn_margin_bottom = $decoded_apply_button->margin_bottom;
            $apply_btn_padding_left = $decoded_apply_button->padding_left;
            $apply_btn_padding_right = $decoded_apply_button->padding_right;
            $apply_btn_padding_top = $decoded_apply_button->padding_top;
            $apply_btn_padding_bottom = $decoded_apply_button->padding_bottom;
            $apply_btn_style = $decoded_apply_button->style;
            $apply_btn_float_val = $decoded_apply_button->float_val;
        }

        ?>

        <style type="text/css">
            .wpaf_dialog_setting {
                font-family: inherit !important;
                font-size: inherit !important;
                /*  position: fixed !important;
    top: 10% !important;                 */
            <?php if(!empty($popup_style)){ echo $popup_style; }  ?>
            }

            .wpaf_dialog_setting .ui-button {
                font-family: inherit !important;
                font-size: inherit !important;
            }

            /*  .wpaf_dialog_setting  .ui-dialog-titlebar{ } -- for title  */

            .wpaf_dialog_setting .dialog p, .wpaf_dialog_setting .dialog span {
            <?php  if(!empty($popup_textcolour)){
              echo 'color:'.$popup_textcolour.' !important;';
              } ?><?php  if(!empty($popup_bgcolour)){
              echo 'background-color:'.$popup_bgcolour.' !important;';
              } ?>
            }

            /*background - color */
            .dialog {
            <?php  if(!empty($popup_bgcolour)){
              echo 'background-color:'.$popup_bgcolour.' !important;';
              } ?>
            }

            .applybtn {
            <?php  if(!empty($apply_btn_width)){
         echo 'width: '.$apply_btn_width.'px !important;';
      }if(!empty($apply_btn_height)){
         echo 'height: '.$apply_btn_height.'px !important;';
      }
     if(!empty($apply_btn_margin_left)){
         echo 'margin-left: '.$apply_btn_margin_left.'px;';
      }
      if(!empty($apply_btn_margin_right)){
         echo 'margin-right: '.$apply_btn_margin_right.'px;';
      }
      if(!empty($apply_btn_margin_top)){
        echo 'margin-top: '.$apply_btn_margin_top.'px;';
      }
      if(!empty($apply_btn_margin_bottom)){
       echo 'margin-bottom: '.$apply_btn_margin_bottom.'px;';
       }
      if(!empty($apply_btn_padding_left)){
         echo 'padding-left: '.$apply_btn_padding_left.'px !important;';
      }
      if(!empty($apply_btn_padding_right)){
         echo 'padding-right: '.$apply_btn_padding_right.'px !important;';
      }
      if(!empty($apply_btn_padding_top)){
         echo 'padding-top : '.$apply_btn_padding_top.'px !important;';
      }
      if(!empty($apply_btn_padding_bottom)){
         echo 'padding-bottom : '.$apply_btn_padding_bottom.'px !important;';
      }

      if(!empty($apply_btn_float_val)){
         echo 'float : '.$apply_btn_float_val.' !important;';
      }
      if(!empty($apply_btn_style)){
          echo $apply_btn_style;
      }  ?>
            }

            /***FOR INPUT FILE STYLING***/
            .fileUploadd {
                position: relative;
                overflow: hidden;
                margin: 10px;
            }

            .fileUploadd input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }


        </style>
        <?php /* End -Adding User defined style to the Apply to Job Form */ ?>

        <div class="form_id">
            <div class="container_form">
                <div class="msg_div">
                    <?php /* $this->splash_message(); */ ?>
                </div>
                <form class="af_clss" enctype="multipart/form-data" method="post">
                    <div class="wp_title"> Apply for this job:</div>
                    <?php
                    $wpaf_field_title = maybe_unserialize(get_post_meta(intval($post_id), '__wpaf_field_title', true));

                    if (!empty($wpaf_field_title)) {
                        $af_fields = json_decode($wpaf_field_title);
                    }
                    //echo '<pre>';print_r($af_fields);die;
                    if (isset($af_fields)) {
//CRINCH
                        $ASIF_FIELD_MARK = 0;
                        foreach ($af_fields as $fld) {
                            $compulsory = '';
                            $parameter = $fld->field;
                            $param = explode(':', $parameter);
                            $title = $fld->title;
                            //CRINCH - block with if condition
                            $final_string_new = '';
                            if (strpos($fld->title, '@@') !== false) {
                                $param_custom_new = explode('@@', $fld->title);
                                $fld->title = $param_custom_new[0];
                                $title = $param_custom_new[0];
                                $final_string_new = $param_custom_new[1];
                                $final_string_new = str_replace('{', '', $final_string_new);
                                $final_string_new = str_replace('}', '', $final_string_new);
                            }
                            if (isset($param[0])) {
                                if ($param[1] == 1) {
                                    $compulsory = '<span style="color:red;">*</span>';
                                }
                                /* Notification check */
                                if ($param[2] == 1) {
                                    //$compulsory .= '<span style="color:Green;">*</span>';
                                }

                                ?>
                                <div>
                                    <?php
                                    if (strcasecmp($param[0], FIELD_TYPE11) == 0 || (strcasecmp($param[0], FIELD_TYPE12) == 0) && $fld->show_title_field != '1') {

                                    } else {
                                        ?><label
                                            class="wp_labeltxt "> <?php echo esc_html($title) . $compulsory . ':'; ?> </label><?php
                                    }

                                    if (strcasecmp($param[0], FIELD_TYPE12) == 0) {    /*email input */ ?>
                                        <div>
                                            <a href="<?php echo esc_url(home_url() . '/?download-attachment=yes&file=' . $fld->pdf_file); ?>"><input
                                                    type="button" style="<?php echo $fld->pdf_file_button_styling; ?>"
                                                    value="<?php echo esc_attr($fld->pdf_file_button_text); ?>"></a>
                                        </div>
                                        <div class="clear h20"></div>
                                    <?php } ?>
                                    <?php
                                    if (strcasecmp($param[0], FIELD_TYPE10) == 0) {    /*EditAble PDF */

                                        $title_for_field_id_form = str_replace(" ", "_", $title);
                                        $custom_plugin_name_form = plugin_basename(__FILE__);
                                        $custom_plugin_name_form = str_replace("apply_form.php", "", $custom_plugin_name_form);
                                        $custom_plugin_dir_path_form = $custom_plugin_name_form;
                                        $custom_plugin_name_form = str_replace("-", "_", $custom_plugin_name_form);
                                        $upload_dir_arr = wp_upload_dir();
                                        $upload_dir = $upload_dir_arr['basedir'];
                                        if ($fld->explanation_text_location == 'onform') {
                                            ?>
                                            <div id="<?php echo esc_attr($title_for_field_id_form); ?>"
                                                 class="PDF_ON_FORM"
                                                 style="min-height:120px;">
                                                <div>
                                                    <p style="font-size:12px;color:green;"><?php echo esc_attr(urldecode($fld->explanation_text)); ?></p>
                                                </div>
                                                <div>
                                                    <div class="custom_design"
                                                         style="float: left;margin-right:0px;margin-top:5px;"><a
                                                        <!--                                                            href="-->
                                                        <?php //echo bloginfo('url') . '/wp-content/plugins/' . $custom_plugin_dir_path_form . 'downloadpdffile.php?fileUrl=' . $upload_dir . '/' . $custom_plugin_name_form . '&fileName=' . $final_string_new; ?><!--"-->
                                                        href="<?php echo esc_url(home_url() . '/?download-attachment=yes&file=' . $final_string_new); ?>
                                                        "
                                                        <!--                                                        download="--><?php //echo bloginfo('url') . '/wp-content/plugins/' . $custom_plugin_dir_path_form . 'downloadpdffile.php?fileUrl=' . $upload_dir . '/' . $custom_plugin_name_form . '&fileName=' . $final_string_new; ?>
                                                        download="<?php echo home_url() . '/?download-attachment=yes&file=' . esc_attr($final_string_new); ?>
                                                        "><img
                                                            src="<?php echo esc_url(CAF_BASE_URL . '/images/download_img_resize.jpeg'); ?>"
                                                            width="160px" height="80px"><!--<input type="button" value="Download PDF">-->
                                                        </a></div>
                                                    <!--<div class="PDF_BLOCK_ON_FORM" style="float: left;width:300px;padding-left:5px">-->
                                                    <div class="PDF_BLOCK_ON_FORM"
                                                         style="float:left;width:190px;padding-left:4px">
                                                        <div id="CUSTOM_PDF_BLOCK_ON_FORM" style="font-size:10px;">
                                                            <div class="uploader_class"
                                                                 style="float:left;height:45px;padding:5px;">
                                                                <div class="container_class"
                                                                     style="margin:0px;display:inline-block;">
                                                                    <!--<a class ="multiple_select" title = "Select images" alt = "Select images" tabindex="5" href="javascript:;">UPLOAD PDF</a>-->
                                                                    <a class="multiple_selectt" title="Select images"
                                                                       alt="Select images" tabindex="5"
                                                                       href="javascript:;">
                                                                        <!--<img src="http://localhost/wordpress_original/wp-content/plugins/candidate-application-form/images/imgo1.jpeg" width="120px">--><img
                                                                            src="<?php echo esc_url(CAF_BASE_URL . '/images/upload_img_resize.jpeg'); ?>"
                                                                            width="160px"></a>
                                                                    <a style="display:none;" class="multiple_upldprev"
                                                                       title="Upload &amp; Preview"
                                                                       alt="Upload &amp; Preview" tabindex="6"
                                                                       href="javascript:;">UPLOAD PDF</a>
                                                                </div>
                                                                <span class="span_error_class error"></span>
                                                                <input type="hidden" class="uploaded_file_path_class"
                                                                       name="file_upload_path[<?php echo esc_attr($title); ?>]">
                                                                <input type="hidden" class="original_filename_class"
                                                                       name="filename_original[<?php echo esc_attr($title); ?>]">
                                                                <input type="hidden" class="filename_type"
                                                                       name="filename_type[<?php echo esc_attr($title); ?>]"
                                                                       value="1"/>
                                                            </div>
                                                            <div style="font-size: 12px;clear:both;padding-left:10px;"
                                                                 class="no_file_chosen">No file chosen (<span
                                                                    style="color:red">PDF Only</span>)
                                                            </div>
                                                            <!--<div style="font-size: 12px;clear:both;padding-left:10px;float:left" class="no_file_chosen">fil ename</div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }

                                        if ($fld->explanation_text_location == 'onpopup') {
                                            $custom_plugin_name = plugin_basename(__FILE__);
                                            $custom_plugin_name = str_replace("apply_form.php", "", $custom_plugin_name);
                                            $custom_plugin_dir_path = $custom_plugin_name;
                                            $custom_plugin_name = str_replace("-", "_", $custom_plugin_name);
                                            //print $final_string_new;
                                            $file_pdf_name = str_replace('uploadedpdffiles/', '', $final_string_new);
                                            $file_pdf_name = str_replace('.pdf', '', $file_pdf_name);
                                            //print $file_pdf_name;
                                            $title_for_field_id = str_replace(" ", "_", $title);
                                            $title_for_PDF_Hidden_field_id = str_replace(" ", "", $title);
                                            //echo $fld->explanation_text_location;
                                            ?>

                                            <!--CRINCH 30March2015-->
                                            <div class="openDialogForPDFMain">
                                                <div>
                                                    <p style="font-size:12px;color:green;"><?php echo esc_html(urldecode($fld->explanation_text)); ?></p>
                                                </div>
                                                <!--<input type="hidden" name="customPdfFilePath[]" id="<?php echo $title_for_field_id . '_customPdfFilePath'; ?>" value="<?php echo $upload_dir . "wp-content/uploads/" . $custom_plugin_name . $final_string_new; ?>">-->
                                                <input type="hidden" name="customPdfFilePath"
                                                       id="<?php echo esc_attr($title_for_field_id . '_customPdfFilePath'); ?>"
                                                       value="<?php //echo 'wp-content/plugins/candidate-application-form/downloadpdffile.php?fileUrl='.$upload_dir."wp-content/uploads/".$custom_plugin_name."&fileName=".$final_string_new;
                                                       ?><?php echo esc_attr(home_url() . '/?download-attachment=yes&file=' . $final_string_new); ?>">
                                                <input type="hidden" name="customPdfFilePathh"
                                                       id="<?php echo esc_attr($title_for_field_id . '_customPdfFilePathh'); ?>"
                                                       value="<?php echo esc_attr($upload_dir . "/" . $custom_plugin_name . $final_string_new); ?>">
                                                <input type="button" class="openDialogForPDF"
                                                       id="<?php echo esc_attr($title_for_field_id); ?>"
                                                       value="Click here to open fillable PDF">
                                                <span style="font-size:12px;color:green;"
                                                      id="<?php echo esc_attr($title_for_field_id . '_mentiondfileuploaded'); ?>"
                                                      class="remove_me"></span>
                                            </div>
                                            <input type="hidden" name="userPdfUploadFileNewName[]"
                                                   id="<?php echo esc_attr($title_for_field_id . '_userPdfUploadFileNewName'); ?>"
                                                   value="<?php echo esc_attr($custom_plugin_name . md5(time() . $title_for_field_id . $ASIF_FIELD_MARK)); ?>">
                                            <div><input type="hidden"
                                                        id="<?php echo esc_attr($title_for_PDF_Hidden_field_id); ?>_uploadornot"
                                                        name="<?php //echo $title_for_PDF_Hidden_field_id;
                                                        ?><?php echo esc_attr($title_for_field_id); ?>" value=""
                                                        class="inputclass makemeempty"></div>
                                            <!-- CRINCH VERSION 2 -->
                                            <!--<input type="hidden" id="<?php echo $title_for_field_id . '_explntion_text_popup'; ?>" name="<?php echo $title_for_field_id . '_explntion_text_popup'; ?>" class="pdf_explanation_text_for_popup" value="<?php echo $fld->explanation_text; ?>">-->
                                            <input type="hidden"
                                                   id="<?php echo esc_attr($title_for_field_id . '_explntion_text_popup'); ?>"
                                                   name="pdf_explntion_text_popup"
                                                   class="pdf_explanation_text_for_popup"
                                                   value="<?php echo esc_attr($fld->explanation_text); ?>">
                                            <!--END CRINCH 26March2015-->
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <?php
                                if (strcasecmp($param[0], FIELD_TYPE1) == 0) {    /*text input */ ?>
                                    <div><input type="text" name="<?php echo esc_attr($title); ?>" class="inputclass"/>
                                    </div>
                                <?php } else if (strcasecmp($param[0], FIELD_TYPE2) == 0) {    /*upload input */ ?>
                                    <div>
                                        <div class="uploader_class" style="float:left;">
                                            <div class="container_class" style="margin:0px;display:inline-block;">
                                                <a class="multiple_select" title="Select images" alt="Select images"
                                                   tabindex="5" href="javascript:;">Choose File</a>
                                                <a style="display:none;" class="multiple_upldprev"
                                                   title="Upload &amp; Preview" alt="Upload &amp; Preview" tabindex="6"
                                                   href="javascript:;">Upload CV File</a>
                                            </div>
                                            <span class="span_error_class error"></span>
                                            <input type="hidden" class="uploaded_file_path_class"
                                                   name="file_upload_path[<?php echo esc_attr($title); ?>]">
                                            <input type="hidden" class="original_filename_class"
                                                   name="filename_original[<?php echo esc_attr($title); ?>]">
                                            <input type="hidden" class="filename_type"
                                                   name="filename_type[<?php echo esc_attr($title); ?>]" value="1"/>
                                        </div>
                                    </div>
                                    <!-- START OF CRINCH CUSTOM BLOCK OF CODE -->
                                <?php }
                                if (strcasecmp($param[0], FIELD_TYPE8) == 0) {    /*DropDOwn */
                                    $myCustomArray = explode(',', $final_string_new);
                                    ?>
                                    <div>
                                        <select id='<?php echo esc_attr($fld->title); ?>'
                                                name='<?php echo esc_attr($fld->title); ?>'
                                                class="inputclass">
                                            <?php
                                            for ($io = 0; $io < count($myCustomArray); $io++) {
                                                $selected = '';
                                                $output = $myCustomArray[$io];
                                                if (strpos($myCustomArray[$io], '[') !== false) {
                                                    $selected = "selected='selected'";
                                                    $output = explode('[', $output);
                                                    $output = $output[0];
                                                }
                                                ?>
                                                <option
                                                    value="<?php echo esc_attr($output); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($output); ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                <?php }
                                if (strcasecmp($param[0], FIELD_TYPE9) == 0) {    /*CheckBox */
                                    $myCustomArrayCheckBox = explode(',', $final_string_new);
                                    ?>
                                    <?php
                                    for ($io = 0; $io < count($myCustomArrayCheckBox); $io++) {
                                        $checked = '';
                                        $outputCheckbox = $myCustomArrayCheckBox[$io];
                                        if (strpos($myCustomArrayCheckBox[$io], '[') !== false) {
                                            $checked = "checked='checked'";
                                            $outputCheckbox = explode('[', $outputCheckbox);
                                            $outputCheckbox = $outputCheckbox[0];
                                        }
                                        ?>
                                        <div style='font-size:12px;'>
                                            <!--<input type="checkbox" name="<?php echo $outputCheckbox; ?>" value="<?php echo $outputCheckbox; ?>" <?php echo $checked; ?>>&nbsp; <?php echo $outputCheckbox; ?></div>-->
                                            <input type="checkbox"
                                                   name="inputtypecheckbox<?php echo esc_attr($title); ?>[]"
                                                   value="<?php echo esc_attr($outputCheckbox); ?>" <?php echo $checked; ?>>&nbsp; <?php echo esc_html($outputCheckbox); ?>
                                        </div>
                                        <!-- END OF CRINCH CUSTOM BLOCK OF CODE -->
                                    <?php
                                    } ?>

                                <?php }
                                if (strcasecmp($param[0], FIELD_TYPE3) == 0) {    /*longtext */ ?>
                                    <div><textarea name="<?php echo esc_attr($title); ?>" class="inputclass"></textarea>
                                    </div>
                                <?php }
                                if (strcasecmp($param[0], FIELD_TYPE4) == 0) {   /*numeric/integer */ ?>
                                    <div><input type="text" name="<?php echo esc_attr($title); ?>" class="inputclass"/>
                                    </div>

                                <?php } else if (strcasecmp($param[0], FIELD_TYPE6) == 0) {    /*upload other */ ?>
                                    <div>
                                        <div class="uploader_class" style="float:left;">
                                            <div class="container_class" style="margin:0px;display:inline-block;">
                                                <a class="multiple_select" title="Select images" alt="Select images"
                                                   tabindex="5" href="javascript:;">Choose File</a>
                                                <a style="display:none;" class="multiple_upldprev"
                                                   title="Upload &amp; Preview" alt="Upload &amp; Preview" tabindex="6"
                                                   href="javascript:;">Upload Other File</a>
                                            </div>
                                            <span class="span_error_class error"></span>
                                            <input type="hidden" class="uploaded_file_path_class"
                                                   name="file_upload_path[<?php echo esc_attr($title); ?>]">
                                            <input type="hidden" class="original_filename_class"
                                                   name="filename_original[<?php echo esc_attr($title); ?>]">
                                            <input type="hidden" class="filename_type"
                                                   name="filename_type[<?php echo esc_attr($title); ?>]" value="2"/>
                                        </div>
                                    </div>
                                <?php }
                                if (strcasecmp($param[0], FIELD_TYPE7) == 0) {    /*email input */ ?>
                                    <div>
                                        <input type="text" name="<?php echo esc_attr($title); ?>" class="inputclass"/>
                                    </div>
                                    <div class="clear h20"></div>
                                    <div>
                                        <label
                                            class="wp_labeltxt ">Confirm <?php echo esc_html($title) . $compulsory; ?>
                                            : </label>
                                    </div>
                                    <div>
                                        <input type="text" name="Confirm[<?php echo esc_attr($title); ?>]"
                                               class="inputclass"/>
                                        <?php /* Notification check */
                                        if ($param[2] == 1) { ?>
                                            <input type="hidden" name="notification_emails[]"
                                                   value="<?php echo esc_attr($title); ?>"/>
                                        <?php } ?>
                                    </div>
                                <?php }
                                if (strcasecmp($param[0], FIELD_TYPE11) == 0) {

                                    ?>
                                    <div>
                                        <p style="<?php echo $fld->html_styling; ?>"><?php echo esc_attr(str_replace("a*^!", "'", $fld->text_to_display)); ?></p>
                                    </div>
                                    <div class="clear h20"></div>
                                <?php } ?>
                                <div class="clear h20"></div>
                            <?php }
                            $ASIF_FIELD_MARK = $ASIF_FIELD_MARK + 1;
                        }
                    }
                    ?>

                    <div class="wp_applybtn">
                        <?php
                        $http_str = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                        $Path = $_SERVER['REQUEST_URI'];
                        $URI = $http_str . '://' . $_SERVER['SERVER_NAME'] . $Path;

                        ?>
                        <input type="hidden" value="<?php echo esc_attr($URI); ?>" name="current_page_url"/>
                        <input type="hidden" value="0" id="total_file_size"/>
                        <?php
                        $nonce = wp_create_nonce("submit_ic-application_nonce");
                        $link = admin_url("admin-ajax.php?action=submit_ic-application&post_id=$post_id&nonce=" . $nonce);
                        echo '<input name="submit_save" type="button" class="applybtn btn apply_form" value="Apply" data-nonce="' . esc_attr($nonce) . '" data-post_id="' . esc_attr($post_id) . '"  />'; ?>

                    </div>
                    <div class="dialog" title="Basic dialog">
                        <?php if (DEBUG_MODE == 'on') { ?>
                            <span class="dialogcls">Please wait while sending details to server..</span>
                        <?php } else if (DEBUG_MODE == 'off') {

                            /*fetch wait msg from setting page */
                            $wpaf_setting = maybe_unserialize(get_post_meta($post_id, '__wpaf_setting', true));

                            $wpaf_messages = maybe_unserialize(get_post_meta($post_id, '__wpaf_messages', true));

                            $decoded_setting = json_decode($wpaf_setting);
                            $decoded_messages = json_decode($wpaf_messages);

                            if (isset($decoded_setting->wait_setting) && $decoded_setting->wait_setting == 1) {
                                $wait_msg = $decoded_messages->wait_msg;
                            }
                            if (isset($wait_msg)) { ?>
                                <span class="dialogcls"><?php echo $wait_msg ?></span>

                            <?php } else { ?>
                                <span class="dialogcls">Please wait..</span>

                            <?php
                            }
                        } ?>
                    </div>

                </form>
            </div>
            <!--CRINCH 26March2015-->
            <div id="dialogCrinch" title="Basic dialog Crinch">
            </div>
            <!--END CRINCH 26March2015-->
        </div>

        <!--End of responsive form design-->
        <script type="text/javascript">
            jQuery(document).ready(function () {

                /*CRINCH 26March2015*/
                jQuery(".openDialogForPDF").click(function () {

                    //CRINCH
                    jQuery('input:file').live('change', function () {
                        //jQuery("#uploadFile").val(jQuery(this).val());
                        //jQuery("#showPDFfileUploaded").html(jQuery(this).val());
                        //jQuery("div#showPDFfileOnly").hide('slow');

                        var fileName_check = jQuery(this).val();
                        var fileName_check_extension = fileName_check.split('.').pop().toLowerCase();
                        var fileName_chrome = fileName_check.split("\\").pop().toLowerCase();

                        if (fileName_check_extension == 'pdf') {
                            jQuery("div#showPDFfileOnly").css('color', 'black');
                            jQuery("div#showPDFfileOnly").html(fileName_chrome);
                            //jQuery("div#showPDFfileOnly").show('slow');
                        } else {
                            jQuery("div#showPDFfileOnly").css('color', 'red');
                            jQuery("div#showPDFfileOnly").html('Invalid file, PDF Only');
                            //jQuery("div#showPDFfileOnly").show('slow');
                        }

                    });

                    var use_id = this.id;
                    var mystring = use_id;
                    mystringg = mystring.split('_').join('');
                    showHideUploadPDFInputField = "style='display:none'";
                    var custom_pdf_file_path = jQuery('#' + use_id + '_customPdfFilePath').val();
                    var custom_pdf_file_path_new = jQuery('#' + use_id + '_customPdfFilePathh').val();
                    var custom_pdf_file_new_name = jQuery('#' + use_id + '_userPdfUploadFileNewName').val();
                    var current_file_path_change_to_new_id = use_id + '_userPdfUploadFileNewName';
                    custom_pdf_file_path = custom_pdf_file_path.split('|');
                    custom_pdf_file_path = custom_pdf_file_path[0];
                    var custom_pdf_file_name = jQuery('#' + use_id + '_customPdfFilePath').val();
                    //var pdf_text_message = "Please download the PDF by clicking the 'Download' link below. Once downloaded, open the file, fill in the appropriate details, save your file with a new name then click 'Upload' to re-upload the PDF document.";

                    var pdf_text_message_default = "Please download the PDF by clicking the 'Download' link below. Once downloaded, open the file, fill in the appropriate details, save your file with a new name then click 'Upload' to re-upload the PDF document.";

                    //CRINCH VERSION 2
                    var pdf_text_message_temp = jQuery('#' + use_id + '_explntion_text_popup').val();
                    pdf_text_message_temp = pdf_text_message_temp.replace("%2C", ",");
                    pdf_text_message_temp = pdf_text_message_temp.replace("%2C", ",");
                    pdf_text_message_temp = pdf_text_message_temp.replace("%2C", ",");
                    var pdf_text_message = decodeURI(pdf_text_message_temp);
                    jQuery("#dialogCrinch").dialog("open");
                    //jQuery("#dialogCrinch").append("<form id='form_dialog_pdf' method='post' enctype='multipart/form-data'><table class='wpaf_dialog_table'><tr><td><p style='font-size:12px;color:green;'>"+decodeURI(pdf_text_message)+"<br /><a id='download_pdf_link' style='font-size:12px;color:red;' onclick = 'show_dialog_pdf_input_field();' href='"+custom_pdf_file_path+"' download='"+custom_pdf_file_name+"'><input type='button' value='Download PDF'></a></p></td></tr><tr id='pdf_upload_dialog_row'><td align='center'><input name='file' id='dialog_fileupload' type='file' size='15' multiple/><div class='spinner' style='float:left;font-size:14px;color:green;display:none;'>Uploading....</div><div id='showPDFfileOnly'style='font-size:10px;'>No file chosen (<span style='color:red'>PDF Only</span>)</div><input type='hidden' name='new_pdf_file_name' id='new_pdf_file_name' value='"+custom_pdf_file_new_name+"'></td></tr></table><input type='hidden' id='PDFUPLOADEDORNOT' value='"+mystringg+"_uploadornot'><input type='hidden' id='PDFUPLOADEDORNOT_NEW' value='"+custom_pdf_file_path_new+"'><input type='hidden' id='PDFUPLOADEDORNOT_PROGRESS' value='"+mystring+"'><input type='hidden' id='Chambeli' value='"+current_file_path_change_to_new_id+"'></form>");
                    //jQuery("#dialogCrinch").append("<form id='form_dialog_pdf' method='post' enctype='multipart/form-data'><table class='wpaf_dialog_table'><tr><td><div><p style='font-size:12px;color:green;'>"+decodeURI(pdf_text_message)+"</p></div><div><div style='float:left;width:140px;'><a id='download_pdf_link' style='font-size:12px;color:red;' onclick = 'show_dialog_pdf_input_field();' href='"+custom_pdf_file_path+"' download='"+custom_pdf_file_name+"'><input type='button' value='Download PDF'></a></div><div style='width:287px;float:left;padding-left:4px;'><input name='file' id='dialog_fileupload' type='file' size='15' multiple/><div class='spinner' style='float:left;font-size:14px;color:green;display:none;'>Uploading....</div><div id='showPDFfileOnly' style='font-size:10px;'>No file chosen (<span style='color:red'>PDF Only</span>)</div></div></div><input type='hidden' name='new_pdf_file_name' id='new_pdf_file_name' value='"+custom_pdf_file_new_name+"'></td></tr></table><input type='hidden' id='PDFUPLOADEDORNOT' value='"+mystringg+"_uploadornot'><input type='hidden' id='PDFUPLOADEDORNOT_NEW' value='"+custom_pdf_file_path_new+"'><input type='hidden' id='PDFUPLOADEDORNOT_PROGRESS' value='"+mystring+"'><input type='hidden' id='Chambeli' value='"+current_file_path_change_to_new_id+"'></form>");
                    jQuery("#dialogCrinch").append("<form id='form_dialog_pdf' method='post' enctype='multipart/form-data'><table class='wpaf_dialog_table'><tr><td><div><p style='font-size:12px;color:green;'>" + decodeURI(pdf_text_message) + "</p></div><div id='main_popup_button_div'><div style='float:left;padding-top:3px;margin-left:15px;'><a id='download_pdf_link' style='font-size:12px;color:red;' onclick = 'show_dialog_pdf_input_field();' href='" + custom_pdf_file_path + "' download='" + custom_pdf_file_name + "'><img src='<?php echo esc_url(CAF_BASE_URL . '/images/download_img_resize.jpeg');?>' width='160px' height='36px'></a></div><div style='float:left;padding-top:0px;margin-left:0px;cursor:pointer;'><div class='fileUploadd' style='float:left;margin:5px;cursor:pointer;'><span style='height:36px;width:160px;cursor:pointer;'><img style='cursor:pointer;' width='160px' height='36px' src='<?php echo esc_url(CAF_BASE_URL . '/images/upload_img_resize.jpeg') ;?>'></span><input id='dialog_fileupload' type='file' class='upload' style='height:38px;cursor:pointer;' multiple/></div><div class='spinner' style='float:left;font-size:14px;color:green;display:none;'>Uploading....</div></div><div id='showPDFfileOnly' style='font-size:10px;margin-left:185px;float:left;color:black'>No file chosen (<span style='color:red'>PDF Only</span>)</div></div><div id='showPDFfileUploaded' style='font-size:10px;margin-left:185px;float:left;font-size:12px;'></div><input type='hidden' name='new_pdf_file_name' id='new_pdf_file_name' value='" + custom_pdf_file_new_name + "'></td></tr></table><input type='hidden' id='PDFUPLOADEDORNOT' value='" + mystringg + "_uploadornot'><input type='hidden' id='PDFUPLOADEDORNOT_NEW' value='" + custom_pdf_file_path_new + "'><input type='hidden' id='PDFUPLOADEDORNOT_PROGRESS' value='" + mystring + "'><input type='hidden' id='Chambeli' value='" + current_file_path_change_to_new_id + "'></form>");
                });

                /*END CRINCH 26March2015*/

                <!--CRINCH 26March2015-->
                jQuery("#dialogCrinch").dialog({
                    autoOpen: false,
                    title: "Download and Upload PDF",
                    modal: true,
                    minHeight: 300,
                    minWidth: 500,
                    buttons: {
                        Ok: function (evt) {

                            // get DOM element for button
                            var buttonDomElement = evt.target;
                            //jQuery("div.spinner").show('fast');
                            //var dialog_pdf_upload_file_name = jQuery('#userPdfUploadFileNewName').val();
                            var chambeli_val = jQuery('#Chambeli').val();
                            var dialog_pdf_upload_file_name = jQuery('#new_pdf_file_name').val();
                            if (dialog_pdf_upload_file_name == '') {
                                alert('Please refresh your page and Try Again!');
                                return false;
                            }
                            var fd_dialog_pdf_upload = new FormData();
                            var final_string_dialogPDF = '';
                            var file_dialog_pdf_upload = jQuery('#dialog_fileupload').prop('files')[0];
                            if (!file_dialog_pdf_upload) {
                                alert('Please try again and select PDF file!');
                                return false;
                            }
                            if (file_dialog_pdf_upload.name == '') {
                                alert('Please try again and select PDF file!');
                                return false;
                            }
                            var ext = jQuery('#dialog_fileupload').val().split('.').pop().toLowerCase();
                            if (ext != 'pdf') {
                                alert('Please try again and select PDF file only!');
                                return false;
                            }
                            fd_dialog_pdf_upload.append("file", file_dialog_pdf_upload);
                            fd_dialog_pdf_upload.append("name", file_dialog_pdf_upload.name);
                            fd_dialog_pdf_upload.append("newname", dialog_pdf_upload_file_name);
                            fd_dialog_pdf_upload.append("caption", 'asifarif');
                            fd_dialog_pdf_upload.append('action', 'crinch_custom_file_upload_dialog');
                            var break_whole_loop_dialogPDF = false;
                            jQuery.ajax({
                                type: 'POST',
                                url: myAjax.ajaxurl,
                                data: fd_dialog_pdf_upload,
                                contentType: false,
                                processData: false,
                                async: false,
                                beforeSend: function () {
                                    jQuery('div.spinner').show('fast');
                                    jQuery(buttonDomElement).parent().attr('disabled', true);
                                },
                                complete: function () {
                                    var delay1 = 1000;
                                    setTimeout(function () {
                                        jQuery('div.spinner').html('Uploaded!');
                                        jQuery(buttonDomElement).parent().attr("disabled", false);
                                    }, delay1);
                                },
                                success: function (dialogPDFUploadResponse) {
                                    //CRINCH -
                                    var pdf_text_field_upload_or_not_id = jQuery('#PDFUPLOADEDORNOT').val();
                                    putPathOfPDFFile = jQuery('#PDFUPLOADEDORNOT_NEW').val();
                                    fileUploadProgress = jQuery('#PDFUPLOADEDORNOT_PROGRESS').val();

                                    //new block
                                    var delay = 1000;
                                    setTimeout(function () {
                                        jQuery('div.spinner').hide('slow');
                                        jQuery("#dialogCrinch").dialog('close');
                                        jQuery('#form_dialog_pdf').remove();
                                        jQuery("#dialogCrinch").html('');
                                    }, delay);
                                    jQuery('div.spinner').html('Uploading...');
                                    setTimeout(function () {
                                        jQuery('#' + fileUploadProgress + '_mentiondfileuploaded').html("Thanks, File Uploaded!");
                                    }, delay);
                                    //new block

                                    var json = jQuery.parseJSON(dialogPDFUploadResponse);
                                    jQuery(json).each(function (i, val) {
                                        if (break_whole_loop_dialogPDF) {
                                            return false;
                                        }
                                        jQuery.each(val, function (k, v) {
                                            if (k == 'error') {
                                                break_whole_loop_dialogPDF = true;
                                                return false;
                                            }
                                            if (k == 'filePath' && v != '') {
                                                stringToRemove = putPathOfPDFFile.split('/').pop();
                                                putPathOfPDFFile2 = putPathOfPDFFile.replace(stringToRemove, v);
                                                jQuery('#' + pdf_text_field_upload_or_not_id).val("FILEUPLOADED|" + putPathOfPDFFile2);
                                                jQuery('#' + chambeli_val).val(v);
                                                final_string_dialogPDF = val[k];
                                                break_whole_loop_dialogPDF = true;
                                                return false;
                                            }
                                        });
                                    });
                                },
                                error: function (returnval) {
                                    alert('Sorry, there is REQUEST problem: ' + returnval);
                                    return false;
                                }
                            });	//end of ajax request
                            if (final_string_dialogPDF == '') {
                                alert('PDF file uploading problem!');
                                return false;
                            }
                            //jQuery(this).dialog("close");
                            //jQuery('#form_dialog_pdf').remove();
                        }
                    },
                    close: function (event, ui) {
                        jQuery("#dialogCrinch").html('');
                    }

                });

                <!--END CRINCH 26March2015-->


                jQuery(".dialog").dialog({
                    autoOpen: false,
                    title: "Application Status",
                    modal: true,
                    minHeight: 49,
                    minWidth: 500,
                    <?php
              if(!empty($popup_width)){  ?>
                    width: <?php echo $popup_width; ?>,
                    <?php }if(!empty($popup_height)){  ?>
                    height: <?php echo $popup_height; ?>, <?php } ?>
                    dialogClass: "wpaf_dialog_setting",
                    buttons: {
                        Ok: function () {
                            jQuery(this).dialog("close");
                            jQuery('.dialog p').remove();
                            jQuery(".af_clss")[0].reset();
                            jQuery(".makemeempty").val("");  //CRINCH - april 30
                            jQuery("span.remove_me").html("");  //CRINCH - april 30
                            jQuery(".span_error_class").each(function () {
                                var elm_id = jQuery(this).attr("id");
                                jQuery("#" + elm_id).empty();
                            });
                            jQuery(".wp_af_validation_error").empty();
                        }
                    }
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }

    private function define_constants()
    {
        $caf_file_upload_dir = wp_upload_dir();
        $this->define_constant('FILE_UPLOAD_DIR', $caf_file_upload_dir['basedir'] . '/candidate_application_form/');
        $this->define_constant("CAF_BASE_URL", plugins_url("/wp-candidate-application-form/"));

//        if (APPLY_FORM_EDITION == 'free') {
//            $this->define_constant('EMPTY_TRASH_DAYS', 0);
//        }
    }

    /*
     * Create new defined value
     */
    function define_constant($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /*
     * register new custom post type
     */
    public function register_custom_post_type()
    {
        $labels = array(
            'name' => 'All Forms',
            'singular_name' => 'Form',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Form',
            'edit_item' => 'Edit Form',
            'new_item' => 'New Form',
            'all_items' => 'All Forms',
            'view_item' => 'View Form',
            'search_items' => 'Search Form',
            'not_found' => 'No Form found',
            'not_found_in_trash' => 'No Form found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'Candidate Application Forms'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'candidate-form'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => '',
            'supports' => array('title')
        );

        register_post_type('candidate-form', $args);
    }

    /* Name: __construct
     Parameters:
     Use: To declare which function is called on a given action, this is the first function that gets called
    */
    function __construct()
    {
        $this->define_constants();
        define('IC_ROOT_DIR', str_replace('\\', '/', dirname(__FILE__)));
        $upload_dir = wp_upload_dir();
        $upload_loc = $upload_dir['basedir'] . "/candidate_application_form";

        if (is_dir($upload_loc)) {
            $uploads_base_dir = $upload_dir['basedir'];
            define('UPLOADS_CANDIDATE_APPLICATION_FORM', str_replace('\\', '/', $uploads_base_dir));
        }

        define("WPpostURL", "guid");


        /*todo : Query needs to written here to fetch debug mode value from database */
//          define('DEBUG_MODE','on');
        define('DEBUG_MODE', 'off');

        /*Error messages */
        define("REQUIRED_ERROR_MSG", "Please fill the required field.");
        //CRINCH
        define("REQUIRED_ERROR_MSG_PDF", "Please Download and Upload required PDF Document.");

        define("INVALID_EMAIL_MSG", "Invalid Email address.");
        define("EMAIL_DO_NOT_MATCH_MSG", "Email ids do not match");
        define("INVALID_NUMERIC_MSG", "Invalid number.");

        /*Tooltips*/
        define("APPLY_FORM_SHORTCODE_TOOLTIP", 'This is the apply form shortcode name\/value. You can place this shortcode on any WordPress page, post or widget. The apply form will auto-populate into that area when a user navigates to the page or post which contains the shortcode.');
        define("UPGRADE_ACTIVATION_KEY_TOOLTIP", 'Enter your &ldquo;Upgrade Activation Key&ldquo; value to upgrade from the free version to the commercial version (see www.responsecoordinator.com/Candidate-Apply-Form.html for feature differences)');
        define("ACTIVATION_EMAIL_TOOLTIP", 'Enter the Activation email address you used to request an Activation Key from Flaxlands Consulting Ltd');
        define("DESTINATION_EMAIL_TOOLTIP", 'Enter the email destination the plugin should use to send completed candidate applications.');
        define("AVAILABLE_FIELDS_TOOLTIP", 'Use the &ldquo;Available Fields&ldquo; section to create and add new fields which then become available to add to the Apply Form.');
        define("APPLY_FORM_FIELDS_TOOLTIP", 'Configure the list of fields on the Apply Form by dragging fields from the Available Fields Section into this section.');
        define("SCRIPT_CONFIG_TOOLTIP", 'This section allows you to configure the transmission method and parameters used to send the candidate application data. For example you can use this section to configure an interface between the Apply Form and your Applicant Tracking Software.');
        define("SCRIPT_NAME_TOOLTIP", 'The variables configured in this section are passed to one of a number of possible communication programs used to send data to different Applicant Tracking Systems (ATS). This field contains the name of the script. Where there is not already a script for your (ATS) please contact www.flaxlandsconsulting.com.');
        define("HEADER_VARIABLES_TOOLTIP", 'Configure the header variables you will need to send within an HTTP request to the API of your Applicant Tracking System.');
        define("PARAMETER_VALUES_TOOLTIP", 'Configure the content variables you will need to send within an HTTP request to the API of your Applicant Tracking System. ');
        define("AVAILABLE_VARIABLES_TOOLTIP", 'The Available Variables section displays a list of variables where values are derived from the custom fields on the WordPress posts database. There are also a few other static variables which can be used to configure the HTTP requests made to API&rsquo;s.');
        define("APPLY_BUTTON_APPEARANCE_TOOLTIP", 'In this section you can configure styling options for the Apply button on the apply form.');
        define("RESPONSE_POPUP_APPEARANCE_TOOLTIP", 'In this section you can configure styling options for the response pop-up window that is displayed when the Candidate clicks the Apply Button.');
        define("MESSAGES_TOOLTIP", 'The &ldquo;Messages&ldquo; section allows you to configure the messages that are shown to the candidate in the Response Pop-up window during the application process.');
        define("FIELD_TYPE_TOOLTIP", 'Choose the data type for the new Apply Form Field.');
        define("REQUIRED_TOOLTIP", 'Tick this box if you need the field to always contain data before allowing the form to be submitted.');
        define("NOTIFICATION_EMAIL_TOOLTIP", 'Tick this box if you need send email notification to cadidate as well.');
        define("TITLE_OF_FIELD_TOOLTIP", 'Type the full label name of the new field. It is normal for the label to describe the value you want the candidate to input.');


        //crinch 04-05-2015
        define("TYPE_OF_FIELD_TOOLTIP_PDF", 'Type the full label name of the new field. It is normal for the label to describe the value you want the candidate to input.');
        define("TITLE_OF_FIELD_TOOLTIP_PDF", 'Upload the PDF file you wish to provide users to download.');
        define("EXPLANATION_OF_FIELD_TOOLTIP_PDF", 'This text will be displayed next to the download button to explain to users how the process works.');
        define("LOCATION_OF_FIELD_TOOLTIP_PDF", 'This option determines whether the download button, explanation text and upload button are shown on a form or in a pop-up.');


        /*Check edition */
        $wpaf_setting = get_option('wpaf_setting');
        $decoded_setting = json_decode($wpaf_setting);
        if (isset($decoded_setting->activation_key)) {
            $activation_key = $decoded_setting->activation_key;
        }
        if (isset($decoded_setting->activation_email)) {
            $activation_email_address = $decoded_setting->activation_email;
        }

        /*Some Difficut Logical Arithmetic*/
        $SD54SS = md5($activation_email_address);
        $CC12NM = "8f213a31b3d5f921fb6ff6c0333af826";
        $RT99IO = $SD54SS . $CC12NM;
        $GG13DS = md5($RT99IO);
        $AS33ER = md5($SD54SS . $CC12NM);
        if ($GG13DS != $activation_key) {
            define('APPLY_FORM_EDITION', 'free');
            register_activation_hook(IC_ROOT_DIR . '/apply_form.php', array(&$this, 'af_insert_wp_options_table'));
        }
        register_activation_hook(IC_ROOT_DIR . '/apply_form.php', array(&$this, 'candidate_create_upload_folder'));

        /*end of check for edition*/

        $scriptname = "";
        if (isset($decoded_setting->scriptname)) {
            $scriptname = $decoded_setting->scriptname;

        } else {
            $scriptname = "Apply_Form_email_script.php";
        }
        define('SCRIPT_IN_USE', $scriptname);

        /*constants for field types */
        define('FIELD_TYPE1', "TEXT");
        define('FIELD_TYPE2', "UPLOAD_CV");
        define('FIELD_TYPE3', "LONGTEXT");
        define('FIELD_TYPE4', "NUMERIC");
        define('FIELD_TYPE6', "UPLOAD_OTHER");
        define('FIELD_TYPE7', "EMAIL");
        define('FIELD_TYPE8', "DROPDOWN");
        define('FIELD_TYPE9', "CHECKBOX");
        define('FIELD_TYPE10', "EDITABLEPDF");
        define('FIELD_TYPE11', "DISPLAY_TEXT");
        define('FIELD_TYPE12', "DOWNLOAD_FILE");

        add_filter('plugin_row_meta', array(&$this, 'set_plugin_meta'), 10, 2);

        add_action("init", array($this, "register_custom_post_type"));

        add_action("wp_ajax_save_activation_settings", array(&$this, 'activation_setting'));
        add_action("wp_ajax_nopriv_save_activation_settings", array(&$this, 'activation_setting'));

        add_action("wp_ajax_submit_ic-application", array(&$this, 'on_ic_apply'));
        add_action("wp_ajax_nopriv_submit_ic-application", array(&$this, 'on_ic_apply'));

        //CRINCH - for ajax file upload
        add_action("wp_ajax_crinch_custom_file_upload", array(&$this, 'on_crinch_file_upload'));
        add_action("wp_ajax_nopriv_crinch_custom_file_upload", array(&$this, 'on_crinch_file_upload'));

        //CRINCH - for ajax DIALOG PDF file upload - FRONT END
        add_action("wp_ajax_crinch_custom_file_upload_dialog", array(&$this, 'on_crinch_file_upload_dialog'));
        add_action("wp_ajax_nopriv_crinch_custom_file_upload_dialog", array(&$this, 'on_crinch_file_upload_dialog'));

        /*file upload*/
        add_action("wp_ajax_candidate_file_upload", array(&$this, 'on_file_upload'));
        add_action("wp_ajax_nopriv_candidate_file_upload", array(&$this, 'on_file_upload'));

        /*add_action( 'init', array(&$this,'my_script_enqueuer'));  */
        add_action('wp_enqueue_scripts', array(&$this, 'apply_form_frontend_method')); /*only for frontend */

        add_filter('widget_text', 'do_shortcode'); /* this code activates the plugin in the widget area*/
        add_shortcode('apply-form', array(&$this, 'apply_form'), 10, 1);

        /*actions for admin form */

        /* if(APPLY_FORM_EDITION != 'free'){   */
        add_action('admin_enqueue_scripts', array($this, 'apply_form_admin_enqueue'));
        /* }  */


        add_action('init', array($this, 'DownloadAttachment'));

        add_action('add_meta_boxes', array($this, 'candidate_add_meta_box'));
        add_action('save_post', array($this, 'candidate_apply_form_save_meta_box_data'));
        add_action('save_post', array($this, 'candidate_settings_save_meta_box_data'));

        add_filter('manage_candidate-form_posts_columns', array($this, 'add_new_shortcode_columns'));
        add_action('manage_candidate-form_posts_custom_column', array($this, 'manage_shortcode_columns'), 10, 2);
        add_action('admin_head', array($this, 'candidate_application_form_custom_css'));

        add_action('admin_init', array($this, 'admin_init'));

    }

    /*
     * Save ajax request for activation credential
     */
    public function activation_setting()
    {
        $settings = $_REQUEST['setting'];
        $activation_key = $settings['activation_key'];
        $activation_email_address = $settings['activation_email'];
        $SD54SS = md5($activation_email_address);
        $CC12NM = "8f213a31b3d5f921fb6ff6c0333af826";
        $RT99IO = $SD54SS . $CC12NM;
        $GG13DS = md5($RT99IO);
        $AS33ER = md5($SD54SS . $CC12NM);
        $disabled = '';
        $matchODLE = 0;
        if ($GG13DS == $activation_key) {
            $jsonSetting = json_encode($settings);
            update_option('wpaf_setting', $jsonSetting);
            echo admin_url('edit.php?post_type=candidate-form');
        } else {
            echo 'fail';
        }
        die();
    }

    /*
     * Initialization of admin to create a hacking system to show activation credential
     */
    public function admin_init()
    {
        $url = $this->current_page_url();
        $search = 'edit.php?';
        $search1 = 'post-new.php?';

        $wpaf_setting = get_option('wpaf_setting');
        $decoded_setting = json_decode($wpaf_setting);

        if (isset($decoded_setting->activation_key)) {
            $activation_key = $decoded_setting->activation_key;
        }
        if (isset($decoded_setting->activation_email)) {
            $activation_email_address = $decoded_setting->activation_email;
        }

        /*Some Difficult Logical Arithmetic*/
        $SD54SS = md5($activation_email_address);
        $CC12NM = "8f213a31b3d5f921fb6ff6c0333af826";
        $RT99IO = $SD54SS . $CC12NM;
        $GG13DS = md5($RT99IO);
        $AS33ER = md5($SD54SS . $CC12NM);
        $disabled = '';
        $matchODLE = 0;

        if ($GG13DS != $activation_key && isset($_REQUEST['post']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'trash') {
            wp_safe_redirect(admin_url('/edit.php?post_type=candidate-form'));
            die();
        }

        $count_posts = wp_count_posts('candidate-form')->publish;
        if (APPLY_FORM_EDITION != 'free') {

        }
        if (!isset($decoded_setting->activation_email) && !isset($decoded_setting->activation_key) && strpos($url, $search1) !== false && $_REQUEST['post_type'] == 'candidate-form' && $count_posts == 1) {
            wp_safe_redirect(admin_url('/edit.php?post_type=candidate-form'));
        }

        if (!isset($decoded_setting->activation_email) && !isset($decoded_setting->activation_key) && strpos($url, $search) !== false && isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == 'candidate-form' && $GG13DS != $activation_key) {
            $count_posts = wp_count_posts('candidate-form')->publish;
            if ($count_posts == 1) {
                ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function (event) {
                        var div = document.createElement('div');

                        div.id = 'wpaf_activation_maincontainer';

                        div.innerHTML = '<div class="updated notice is-dismissible"><p>To unlock all the features of the "Candidate Application Form" you must activate it. To find out more, <strong><a target="_blank" href="http://responsecoordinator.com/?page_id=366">click here</a></strong> </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div><form method="post" id="activation-form">\
                    <input type="hidden" name="action" value="save_activation_settings" />\
                    <div class="h10 clear"></div>\
                    <div id="wpaf_activation_subcontainer">\
                    <table width=" ">\
                    <tbody>\
                    <tr>\
                    <td width=" "><label\
                    class="wp_formlabel">Activation Code:</label></td>\
                    <td width=" ">\
                    <input type="text" class="wp_textfield_script" name="setting[activation_key]"\
                    placeholder="" value=""/>\
                    </td>\
                    </tr>\
                    <tr>\
                    <td width=" "><label\
                    class="wp_formlabel">Activation Email:</label></td>\
                    <td width=" ">\
                    <input type="text" class="wp_textfield_script" id="activation_email"\
                    name="setting[activation_email]" placeholder=""\
                    value=""/>\
                    </td>\
                    </tr>\
                    <tr>\
                    <td></td>\
                    <td><input type="submit" class="wp_intbutton button button-primary button-large" value="Save"/><span id="message-div" class="hide-element">Please wait....</span></td>\
                    </tr>\
                    </tbody>\
                    </table>\
                    </div>\
                    </form>\
                    </div>';

                        var elt = document.getElementById("wpbody-content")
                            .getElementsByClassName("wrap")[0].getElementsByTagName('h1')[0];

                        elt.innerHTML = 'Candidate Application Forms ' + elt.children[0].outerHTML;

                        var element = document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].getElementsByClassName("page-title-action")[0];
//                        element.href = '#';

                        var att = document.createAttribute("onclick");       // Create a "class" attribute
                        att.value = "return false";                           // Set the value of the class attribute
                        element.setAttributeNode(att);
                        document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].insertBefore(div, document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].getElementsByClassName("subsubsub")[0]);
                    });

                </script>
            <?php
            } else {
                ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function (event) {
                        var div = document.createElement('div');

                        div.id = 'wpaf_activation_maincontainer';

                        div.innerHTML = '<div class="updated notice is-dismissible"><p>To unlock all the features of the "Candidate Application Form" you must activate it. To find out more, <strong><a href="http://responsecoordinator.com/?page_id=366">click here</a></strong> </p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div><form method="post" id="activation-form">\
                    <input type="hidden" name="action" value="save_activation_settings" />\
                    <div class="h10 clear"></div>\
                    <div id="wpaf_activation_subcontainer">\
                    <table width=" ">\
                    <tbody>\
                    <tr>\
                    <td width=" "><label\
                    class="wp_formlabel">Activation Code:</label></td>\
                    <td width=" ">\
                    <input type="text" class="wp_textfield_script" name="setting[activation_key]"\
                    placeholder="" value=""/>\
                    </td>\
                    </tr>\
                    <tr>\
                    <td width=" "><label\
                    class="wp_formlabel">Activation Email:</label></td>\
                    <td width=" ">\
                    <input type="text" class="wp_textfield_script" id="activation_email"\
                    name="setting[activation_email]" placeholder=""\
                    value=""/>\
                    </td>\
                    </tr>\
                    <tr>\
                    <td></td>\
                    <td><input type="submit" class="wp_intbutton button button-primary button-large" value="Save"/><span id="message-div" class="hide-element">Please wait....</span></td>\
                    </tr>\
                    </tbody>\
                    </table>\
                    </div>\
                    </form>\
                    </div>';

                        var h1 = document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].getElementsByTagName('h1')[0];
                        h1.firstChild.nodeValue = 'Candidate Application Forms ';

                        document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].insertBefore(div, document.getElementById("wpbody-content").getElementsByClassName("wrap")[0].getElementsByClassName("subsubsub")[0]);
                    });

                </script>
            <?php
            }
        }
    }

    /*
     * Returns current page url
     */
    private
    function current_page_url()
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"])) {
            if ($_SERVER["HTTPS"] == "on") {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    /*
     * Adding font awesome icon to admin menu
     */
    public
    function candidate_application_form_custom_css()
    {
        echo "<style type='text/css' media='screen'>
       #adminmenu .menu-icon-candidate-form div.wp-menu-image:before {
            content: '\\f337'; // this is where you enter the dashicon font code
        }
     </style>";
    }

    /*
     * Add new column to show shortcode
     */
    public
    function add_new_shortcode_columns($columns)
    {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = _x('Title', 'column name');
        $new_columns['short-code'] = __('Short code');
        $new_columns['author'] = __('Author');
        $new_columns['date'] = _x('Date', 'column name');
        return $new_columns;
    }

    /*
     * Add additional column for custom post type admin view page
     */
    public
    function manage_shortcode_columns($column_name, $id)
    {
        global $wpdb;
        switch ($column_name) {
            case 'short-code':
                echo '[apply-form id="' . $id . '"]';
                break;

            default:
                break;
        }
    }

    /*
     * Save custom post type values
     * param $post_id id of a post
     */
    public
    function candidate_settings_save_meta_box_data($post_id)
    {
        if (!isset($_POST['candidate_settings_meta_box_nonce']) && !isset($_POST['candidate_information_meta_box_nonce']) && !isset($_POST['candidate_script_configuration_meta_box_data']) && !isset($_POST['candidate_apply_button_meta_box_data']) && !isset($_POST['candidate_response_pop_up_meta_box_data'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['candidate_settings_meta_box_nonce'], 'candidate_settings_save_meta_box_data') && !wp_verify_nonce($_POST['candidate_information_meta_box_nonce'], 'candidate_information_save_meta_box_data') && !wp_verify_nonce($_POST['candidate_script_configuration_meta_box_nonce'], 'candidate_script_configuration_meta_box_data') && !wp_verify_nonce($_POST['candidate_apply_meta_meta_box_nonce'], 'candidate_apply_button_meta_box_data') && !wp_verify_nonce($_POST['candidate_response_pop_up_meta_box_nonce'], 'candidate_response_pop_up_meta_box_data')) {
            return;
        }

        $wpaf_setting = maybe_unserialize(get_post_meta($post_id, '__wpaf_setting', true));


        if (isset($_POST['setting'])) {
            if (is_array($_POST['setting'])) {
                if (APPLY_FORM_EDITION == 'free') {
                    $_POST['setting']['scriptname'] = "Apply_Form_email_script.php";
                }
                $settings = $_POST['setting'];
                $jsonSetting = json_encode($settings);
            }
        }

        if (isset($_POST['messages'])) {
            $message_values = $_POST['messages'];
            if (is_array($message_values)) {
                foreach ($message_values as $key => $value) {
                    $message_values[$key] = htmlspecialchars(sanitize_text_field($value), ENT_QUOTES);
                    //      $message_values[$key] =  htmlentities($value,ENT_QUOTES);
                }
                $jsonMessages = json_encode($message_values);
                unset($_POST['messages']);
            }
        }


        if (APPLY_FORM_EDITION != 'free') {
            $wpaf_apply_button = maybe_unserialize(get_post_meta($post_id, '__wpaf_apply_button', true));
            $wpaf_response_popup = maybe_unserialize(get_post_meta($post_id, '__wpaf_response_popup', true));
            $wpaf_headers = maybe_unserialize(get_post_meta($post_id, '__wpaf_headers', true));
            $wpaf_parameters = maybe_unserialize(get_post_meta($post_id, '__wpaf_parameters', true));
            $wpaf_messages = maybe_unserialize(get_post_meta($post_id, '__wpaf_messages', true));
            $wpaf_meta_value = maybe_unserialize(get_post_meta($post_id, '__wpaf_meta_value', true));

            if (isset($_POST['header'])) {
                if (is_array($_POST['header'])) {
                    $jsonHeader = json_encode($_POST['header']);
                    unset($_POST['header']);
                }
            }
            if (isset($_POST['parameter'])) {
                if (is_array($_POST['parameter'])) {
                    $jsonParameter = json_encode($_POST['parameter']);
                    unset($_POST['parameter']);
                }
            }
            if (isset($_POST['meta_value'])) {
                if (is_array($_POST['meta_value'])) {
                    $jsonMetaValue = json_encode($_POST['meta_value']);
                    unset($_POST['meta_value']);
                }
            }
            if (isset($_POST['apply_button'])) {
                /* $apply_button = array_walk($_POST['apply_button'], '_clean');    */
                $apply_button = $_POST['apply_button'];
                if (is_array($apply_button)) {
                    foreach ($apply_button as $key => $value) {
                        $apply_button[$key] = htmlspecialchars(sanitize_text_field($value), ENT_QUOTES);
                    }
                    $jsonApplyButton = json_encode($apply_button);
                }
            }

            if (isset($_POST['response_popup'])) {
                $response_popup = $_POST['response_popup'];
                if (is_array($response_popup)) {
                    foreach ($response_popup as $key => $value) {
                        $response_popup[$key] = htmlspecialchars(sanitize_text_field($value), ENT_QUOTES);
                    }
                    $jsonPopupResponse = json_encode($response_popup);
                }
            }

            if ($wpaf_response_popup === false) {
                add_post_meta($post_id, '__wpaf_response_popup', $jsonPopupResponse);
            } else {
                update_post_meta($post_id, '__wpaf_response_popup', $jsonPopupResponse);
            }

            if ($wpaf_apply_button === false) {
                add_post_meta($post_id, '__wpaf_apply_button', $jsonApplyButton);
            } else {
                update_post_meta($post_id, '__wpaf_apply_button', $jsonApplyButton);
            }

            if ($wpaf_headers === false) {
                add_post_meta($post_id, '__wpaf_headers', $jsonHeader);
            } else {
                update_post_meta($post_id, '__wpaf_headers', $jsonHeader);
            }

            if ($wpaf_parameters === false) {
                add_post_meta($post_id, '__wpaf_parameters', $jsonParameter);
            } else {
                update_post_meta($post_id, '__wpaf_parameters', $jsonParameter);
            }

            if ($wpaf_meta_value === false) {
                add_post_meta($post_id, '__wpaf_meta_value', $jsonMetaValue);
            } else {
                update_post_meta($post_id, '__wpaf_meta_value', $jsonMetaValue);
            }

        }


        if ($wpaf_messages === false) {
            add_post_meta($post_id, '__wpaf_messages', $jsonMessages);
        } else {
            update_post_meta($post_id, '__wpaf_messages', $jsonMessages);
        }

        if ($wpaf_setting === false) {
            add_post_meta($post_id, '__wpaf_setting', $jsonSetting);
        } else {
            update_post_meta($post_id, '__wpaf_setting', $jsonSetting);
        }
    }

    /*
     * Save custom post type values
     * param $post_id id of a post
     */
    public function candidate_apply_form_save_meta_box_data($post_id)
    {
        if (!isset($_POST['candidate_application_form_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['candidate_application_form_meta_box_nonce'], 'candidate_application_form_save_meta_box_data')) {
            return;
        }

        $jsonFormField = array();
        $jsonAvailableField = array();

        if (isset($_POST['af_field'])) {
            $af_fields = $_POST['af_field'];
            $af_titles = $_POST['af_title'];
            //CRINCH,Added this new below line
            $af_options = $_POST['af_options'];

            //CRINCH - VERSION2
            $af_explanation_text = $_POST['af_explanation_text'];
            $af_explanation_text_location = $_POST['af_explanation_text_location'];

            $af_html_styling = $_POST['af_html_styling'];
            $af_text_to_display = $_POST['af_text_to_display'];

            $af_show_field_title = $_POST['af_show_title_field'];
            $af_pdf_file = $_POST['af_pdf_file'];
            $af_pdf_button_styling = $_POST['af_pdf_file_button_styling'];
            $af_pdf_button_text = $_POST['af_pdf_file_button_text'];

            //
            $form_fields = array(array());
            $j = 0;
            if (is_array($af_fields)) {
                foreach ($af_fields as $key => $value) {
                    $form_fields[$j]['field'] = sanitize_text_field($value);
                    //CRINCH
                    //$form_fields[$j]['title'] = $af_titles[$key];
                    if ($af_options[$key] != '') {
                        $form_fields[$j]['title'] = sanitize_text_field($af_titles[$key]) . '@@{' . sanitize_text_field($af_options[$key]) . '}';
                    } else {
                        $form_fields[$j]['title'] = sanitize_text_field($af_titles[$key]);
                    }
                    //CRINCH - VERSION2
                    $form_fields[$j]['explanation_text'] = sanitize_text_field($af_explanation_text[$key]);
                    $form_fields[$j]['explanation_text_location'] = sanitize_text_field($af_explanation_text_location[$key]);

                    $form_fields[$j]['html_styling'] = sanitize_text_field($af_html_styling[$key]);
                    $form_fields[$j]['text_to_display'] = sanitize_text_field($af_text_to_display[$key]);

                    $form_fields[$j]['show_title_field'] = sanitize_text_field($af_show_field_title[$key]);
                    $form_fields[$j]['pdf_file'] = sanitize_text_field($af_pdf_file[$key]);
                    $form_fields[$j]['pdf_file_button_styling'] = sanitize_text_field($af_pdf_button_styling[$key]);
                    $form_fields[$j]['pdf_file_button_text'] = sanitize_text_field($af_pdf_button_text[$key]);

                    $j++;

                }
            }

            $jsonFormField = json_encode($form_fields);
            unset($_POST['af_field']);
            unset($_POST['af_title']);
            //CRINCH
            unset($_POST['af_options']);
            //CRINCH - VERSION 2
            unset($_POST['af_explanation_text']);
            unset($_POST['af_explanation_text_location']);

        }


        /*add new */
        if (isset($_POST['av_field'])) {
            $av_fields = $_POST['av_field'];
            $av_titles = $_POST['av_title'];
            //CRINCH,Added this new below line
            $av_options = $_POST['av_options'];
            //CRINCH - VERSION2
            $av_explanation_text = $_POST['av_explanation_text'];
            $av_explanation_text_location = $_POST['av_explanation_text_location'];

            $av_html_styling = $_POST['av_html_styling'];
            $av_text_to_display = $_POST['av_text_to_display'];

            $av_show_field_title = $_POST['av_show_title_field'];
            $av_pdf_file = $_POST['av_pdf_file'];
            $av_pdf_button_styling = $_POST['av_pdf_file_button_styling'];
            $av_pdf_button_text = $_POST['av_pdf_file_button_text'];

            $available_fields = array(array());
            $j = 0;
            $data = '';
            if (is_array($av_fields)) {
                foreach ($av_fields as $key => $value) {
                    $available_fields[$j]['field'] = sanitize_text_field($value);
                    //CRINCH
                    //$available_fields[$j]['title'] = $av_titles[$key];
                    if ($av_options[$key] != '') {
                        $available_fields[$j]['title'] = sanitize_text_field($av_titles[$key]) . '@@{' . sanitize_text_field($av_options[$key]) . '}';
                    } else {
                        $available_fields[$j]['title'] = sanitize_text_field($av_titles[$key]);
                    }
                    //CRINCH - VERSION2
                    $available_fields[$j]['explanation_text'] = sanitize_text_field($av_explanation_text[$key]);
                    $available_fields[$j]['explanation_text_location'] = sanitize_text_field($av_explanation_text_location[$key]);

                    $available_fields[$j]['html_styling'] = sanitize_text_field($av_html_styling[$key]);
                    $available_fields[$j]['text_to_display'] = sanitize_text_field($av_text_to_display[$key]);

                    $available_fields[$j]['show_title_field'] = sanitize_text_field($av_show_field_title[$key]);
                    $available_fields[$j]['pdf_file'] = sanitize_text_field($av_pdf_file[$key]);
                    $available_fields[$j]['pdf_file_button_styling'] = sanitize_text_field($av_pdf_button_styling[$key]);
                    $available_fields[$j]['pdf_file_button_text'] = sanitize_text_field($av_pdf_button_text[$key]);

                    $j++;
                }
            }

            $jsonAvailableField = json_encode($available_fields);
            unset($_POST['av_field']);
            unset($_POST['av_title']);
            //CRINCH
            unset($_POST['av_options']);
            //CRINCH - VERSION 2
            unset($_POST['av_explanation_text']);
            unset($_POST['av_explanation_text_location']);

            unset($_POST['av_html_styling']);
            unset($_POST['av_text_to_display']);
        }

        if (isset($_REQUEST['setting'])) {
            $setting = $_REQUEST['setting'];
            $destination_email = $setting['destination_email'];
            update_post_meta($post_id, '__candidate_apply_form_destination_email', $destination_email);
        }

        update_post_meta($post_id, '__wpaf_field_title', $jsonFormField);
        update_post_meta($post_id, '__wpaf_available_field_title', $jsonAvailableField);
    }

    /*
     * Create new metaboxes for candidate-form custom post type
     */
    public function candidate_add_meta_box($post_type)
    {
        add_meta_box(
            'candidate_information_meta',
            'Information',
            array($this, 'create_candidate_information'),
            'candidate-form',
            'advanced',
            'high'
        );

        add_meta_box(
            'candidate_apply_form_meta',
            'Form Field Configuration',
            array($this, 'create_candidate_af_meta_box'),
            'candidate-form',
            'advanced',
            'high'
        );

        add_meta_box(
            'candidate_script_config_meta',
            'Script Configuration',
            array($this, 'create_candidate_script_configuration'),
            'candidate-form',
            'advanced',
            'high'
        );

        add_meta_box(
            'candidate_apply_button_config_meta',
            'Apply Button Appearance',
            array($this, 'create_candidate_apply_button'),
            'candidate-form',
            'advanced',
            'high'
        );

        add_meta_box(
            'candidate_response_popup_meta',
            'Response Pop-Up Appearance',
            array($this, 'create_candidate_response_pop_up'),
            'candidate-form',
            'advanced',
            'high'
        );

        add_meta_box(
            'candidate_message_meta',
            'Messages',
            array($this, 'create_candidate_message_settings'),
            'candidate-form',
            'advanced',
            'high'
        );

    }

    public function create_candidate_response_pop_up($post)
    {
        require_once('response-pop-up.php');
    }

    public function create_candidate_apply_button($post)
    {
        require_once('apply-button-configuration.php');
    }

    public function create_candidate_script_configuration($post)
    {
        require_once('script-configuration.php');
    }

    public function create_candidate_information($post)
    {
        require_once('information.php');
    }

    /*
     * Metabox for enter destination email and to set form fields
     * param $post indicates object of current post
     */
    public function create_candidate_af_meta_box($post)
    {
        require_once('metabox.php');
    }

    /*
     * Metabox for customiza other settings like "Script Config", "Apply Button Appearance", "Response Pop-Up Appearance" & "Messages"
     * param $post indicates object of current post
     */
    public function create_candidate_message_settings($post)
    {
        require_once('message-settings.php');
    }


    /**
     * Write a custom message at the top of an admin options page (if necessary)
     */
    private function splash_message()
    {

        /** Check that there is a status for a splash message to be displayed */
        if (!$_REQUEST['status']) :
            return false;
        endif;

        /** Work out the class of the splash message */
        $message_classes[1] = 'updated';
        $message_classes[99] = 'error';
        $message_class = $message_classes[sanitize_text_field($_REQUEST['status'])];

        $this->set_splash_messages();
        $message = $this->messages_splash[sanitize_text_field($_REQUEST['status'])];

        /** Display the message splash */
        echo '<div id="message" class="' . $message_class . ' below-h2">';
        echo '<p>' . $message . '</p>';
        echo '</div>';

    }

    /**
     * Set the splash messages available for this plugin
     */
    private
    function set_splash_messages()
    {

        $this->messages_splash = array(
            0 => '', // Unused. Messages start at index 1.
            1 => __('Data saved successfully'),
            99 => __('An unknown error occured, please try again.')
        );

    }

    /* Name: filter_output
     Parameters: $value
     Use: replaces double quote with single quote
   */


    public
    function filter_output($value)
    {
        $value = htmlspecialchars_decode($value, ENT_QUOTES);
        $value = str_replace('\"', '\'', $value);
        $value = str_replace("\'", "'", $value);
        return $value;
    }

    /* Name: validation_errors
     Parameters: $form_vars
     Use: validates the form fields on the apply form
   */

    public
    function validation_errors($form_vars, $id)
    {
        $message = array();
        $message['invalid'] = array();
        $wpaf_field_title = maybe_unserialize(get_post_meta(intval($id), '__wpaf_field_title', true));

        if (!empty($wpaf_field_title)) {
            $af_fields = json_decode($wpaf_field_title);
        }

        if (isset($af_fields)) {
            foreach ($af_fields as $fld) {
                $compulsory = '';
                $parameter = $fld->field;

                $param = explode(':', $parameter);
                $title = $fld->title;
                /*replace space with underscore*/
                if (isset($param[0])) {

                    //CRINCH
                    if (strpos($fld->title, '@@') !== false) {
                        $param_custom_new = explode('@@', $fld->title);
                        $fld->title = $param_custom_new[0];
                        $title = $param_custom_new[0];
                        //$title = str_replace(" ","",$title);
                        $title = str_replace(" ", "_", $title);
                    }

                    if (($param[1] == 1) && isset($form_vars[$title]) && empty($form_vars[$title])) {
                        //$message['invalid'][$title] = REQUIRED_ERROR_MSG;   // CRINCH - COMMENTED

                        //CRINCH
                        if ($param[0] == 'EditablePDF') {
                            $message['invalid'][$title] = REQUIRED_ERROR_MSG_PDF;
                        } else {
                            $message['invalid'][$title] = REQUIRED_ERROR_MSG;
                        }

                        /*Check validation for confirm email if type is email */
                        if (($param[0] == 'Email') && isset($form_vars['Confirm'])) {
                            foreach ($form_vars['Confirm'] as $confirm_key => $confirm_value) {
                                if ($confirm_key == $title) {
                                    if (($param[1] == 1) && empty($confirm_value)) {
                                        $message['invalid']["Confirm[$confirm_key]"] = REQUIRED_ERROR_MSG;
                                    }
                                }


                            }
                        }


                    } else if (($param[0] == 'Email')) { /*Check if email address is valid*/
                        if (('' != $form_vars[$title]) && !$this->wpaf_is_email($form_vars[$title])) {
                            $message['invalid'][$title] = INVALID_EMAIL_MSG;
                        }
                        if (isset($form_vars['Confirm'])) {   /*check the confirm email*/
                            /*check values are same in both the text boxes*/
                            foreach ($form_vars['Confirm'] as $confirm_key => $confirm_value) {
                                if ($confirm_key == $title) {
                                    /*check for required field in confirm email*/
                                    if ($confirm_key == $title) {
                                        if (($param[1] == 1) && empty($confirm_value)) {
                                            $message['invalid']["Confirm[$confirm_key]"] = REQUIRED_ERROR_MSG;
                                        } else if ($confirm_value != $form_vars[$title]) {
                                            $message['invalid']["Confirm[$confirm_key]"] = EMAIL_DO_NOT_MATCH_MSG;
                                        }
                                    }

                                }


                            }


                        }

                    }

                    /*for file uploads*/
                    if (($param[1] == 1) && ($param[0] == 'Upload_CV' || $param[0] == 'Upload_Other' || $param[0] == 'EditablePDF') && isset($form_vars['file_upload_path'])) {


                        foreach ($form_vars['file_upload_path'] as $file_key => $file_value) {

                            if ($title == $file_key) {
                                if (empty($file_value)) {
                                    //$message['file_response']["file_upload_path[$file_key]"] = REQUIRED_ERROR_MSG;
                                    //CRINCH VERSION 2
                                    if ($param[0] == 'EditablePDF')
                                        $message['file_response']["file_upload_path[$file_key]"] = REQUIRED_ERROR_MSG_PDF;
                                    else
                                        $message['file_response']["file_upload_path[$file_key]"] = REQUIRED_ERROR_MSG;
                                }
                            }
                        }

                    }

                    /*end of file upload check*/

                    /*check for numeric fields*/
                    if (($param[0] == 'Numeric')) {
                        if (('' != $form_vars[$title]) && !$this->wpaf_is_numeric($form_vars[$title])) {
                            $message['invalid'][$title] = INVALID_NUMERIC_MSG;
                        }
                    }

                }
            }

        }

        return $message;
    }

    /* Name: wpaf_is_email
     Parameters: $email
     Use: validates email field
   */

    public
    function wpaf_is_email($email)
    {
        $result = is_email($email);
        return $result;
    }

    /* Name: wpaf_is_numeric
     Parameters: $number
     Use: validates numeric field
   */

    public
    function wpaf_is_numeric($number)
    {
        $result = is_numeric($number);
        return $result;
    }

    /* Name: af_insert_wp_options_table
     Parameters:
     Use: inserts records while activating the plugin
   */

    public function af_insert_wp_options_table()
    {
        $form_fields = array(array());
        $setting = array();
        $form_fields[0]['field'] = "Text:1";
        $form_fields[0]['title'] = "FirstName";
        $form_fields[1]['field'] = "Text:1";
        $form_fields[1]['title'] = "LastName";
        $form_fields[2]['field'] = "Text:1";
        $form_fields[2]['title'] = "Landline";
        $form_fields[3]['field'] = "Text:1";
        $form_fields[3]['title'] = "Mobile";
        $form_fields[4]['field'] = "Email:1";
        $form_fields[4]['title'] = "EmailAddress";
        $form_fields[5]['field'] = "LongText:0";
        $form_fields[5]['title'] = "AdditionalInfo";
        $form_fields[6]['field'] = "Upload_CV:1";
        $form_fields[6]['title'] = "CV Upload";

        $jsonFormField = array();
        $jsonFormField = json_encode($form_fields);

        $wpaf_field_title = get_option('wpaf_field_title');

        if ($wpaf_field_title === false) {
            add_option('wpaf_field_title', $jsonFormField);
        } else {
            update_option('wpaf_field_title', $jsonFormField);
        }

        $setting['scriptname'] = "Apply_Form_email_script.php";
        $wpaf_setting = get_option('wpaf_setting');
        $jsonSetting = array();
        $jsonSetting = json_encode($setting);
        if ($wpaf_setting === false) {
            add_option('wpaf_setting', $jsonSetting);
        } else {
            update_option('wpaf_setting', $jsonSetting);
        }

    }


    /* Name: candidate_create_upload_folder
     Parameters:
     Use: create candidate_application_form folder in wp-content/uploads directory
   */

    public
    function candidate_create_upload_folder()
    {
        $upload_dir = wp_upload_dir();
        $upload_loc = $upload_dir['basedir'] . "/candidate_application_form";
        if (!is_dir($upload_loc)) {
            wp_mkdir_p($upload_loc);
        }

    }

    /* Name: set_plugin_meta
     Parameters:  $links, $file
     Use: add link for license value in the installed plugin page
   */

    public
    function set_plugin_meta($links, $file)
    {
        $plugin = plugin_basename(__FILE__);
        if ($file == $plugin) {
            if (APPLY_FORM_EDITION != 'free') {
                return array_merge($links, array(sprintf('FULL', $plugin, __('myplugin'))));
            } else {
                return array_merge($links, array(sprintf('GPLv2 (or later)', $plugin, __('myplugin'))));
            }
        }
        return $links;
    }

    /* Name: candidate_apply_form_admin_notice
     Parameters:
     Use: checks if the plugin is activated correctly
   */


    public
    function candidate_apply_form_admin_notice()
    {
        $uploads = wp_upload_dir();
        if (!@is_dir($uploads['basedir'] . '/candidate_application_form') or !@is_writable($uploads['basedir'] . '/candidate_application_form')) {
            echo '<div class="error"><p>For Candidate_Application_Form Plugin to function properly, uploads/candidate_application_form  folder is required and must be writable. Please deactivate the plugin, set proper permissions to the uploads folder and activate the plugin again.</p></div>';
        }

    }

    /* Name: on_file_upload
     Parameters:
     Use: used to upload files to candidate_application_form.
   */
    function on_file_upload()
    {
        $file_path = IC_ROOT_DIR . "/upload.php";
        $upload_dir = wp_upload_dir();
        $base_dir = $upload_dir['basedir'];
        define('UPLOAD_BASE_DIR', $base_dir);
        include("$file_path");
        die();

    }

    //CRINCH
    function on_crinch_file_upload()
    {
        $file_path = IC_ROOT_DIR . "/uploadfile.php";
        $upload_dir = wp_upload_dir();
        $base_dir = $upload_dir['basedir'];
        define('CRINCH_PDF_UPLOAD_DIR', plugin_dir_path(__FILE__));
        define('UPLOAD_BASE_DIR', $base_dir);
        include("$file_path");
        die();
    }

    //CRINCH
    function on_crinch_file_upload_dialog()
    {
        //$file_path = IC_ROOT_DIR."/uploaddialogPDFfile.php";
        $file_path = IC_ROOT_DIR . "/uploadfile.php";
        $upload_dir = wp_upload_dir();
        $base_dir = $upload_dir['basedir'];
        define('CRINCH_PDF_UPLOAD_DIR', plugin_dir_path(__FILE__));
        define('UPLOAD_BASE_DIR', $base_dir);
        include("$file_path");
        die();
    }


}

?>
