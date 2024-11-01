<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 11/14/2015
 * Time: 11:37 AM
 */
?>
<?php
global $wpdb;
$wpaf_setting = maybe_unserialize(get_post_meta($post->ID, '__wpaf_setting', true));
$default_option = get_option('wpaf_setting');
$default_setting = json_decode($default_option);
$decoded_setting = json_decode($wpaf_setting);

if (isset($default_setting->activation_key)) {
    $activation_key = $default_setting->activation_key;
}
if (isset($default_setting->activation_email)) {
    $activation_email_address = $default_setting->activation_email;
}
$dest_email = get_post_meta($post->ID, '__candidate_apply_form_destination_email', true);
$destination_email_address = $dest_email ? $dest_email : '';

/*Some Difficult Logical Arithmetic*/
$SD54SS = md5($activation_email_address);
$CC12NM = "8f213a31b3d5f921fb6ff6c0333af826";
$RT99IO = $SD54SS . $CC12NM;
$GG13DS = md5($RT99IO);
$AS33ER = md5($SD54SS . $CC12NM);
$disabled = '';
$matchODLE = 0;
if ($GG13DS == $activation_key) {
    $matchODLE = 1;
} else {
    $matchODLE = 0;
    $disabled = "disabled = 'disabled'";
}
wp_nonce_field('candidate_settings_save_meta_box_data', 'candidate_settings_meta_box_nonce');
?>
<div class="h20 clear"></div>
<div id="new_candidate_settings_form">
    <div class="response_msg">
        <?php
        /*settings*/
        if (isset($decoded_setting->wait_setting)) {
            $wait_setting = $decoded_setting->wait_setting;
        }
        if (isset($decoded_setting->success_setting)) {
            $success_setting = $decoded_setting->success_setting;
        }
        if (isset($decoded_setting->failure_setting)) {
            $failure_setting = $decoded_setting->failure_setting;
        }


        /*messages */
        $wpaf_messages = maybe_unserialize(get_post_meta($post->ID, '__wpaf_messages', true));
        $decoded_message = json_decode($wpaf_messages);

        if (isset($decoded_message->wait_msg)) {
            $wait_msg = $this->filter_output($decoded_message->wait_msg);
        }
        if (isset($decoded_message->success_msg)) {
            $success_msg = $this->filter_output($decoded_message->success_msg);
        }
        if (isset($decoded_message->failure_msg)) {
            $failure_msg = $this->filter_output($decoded_message->failure_msg);
        }

        ?>
        <div id="message_box">
            <table>

                <tr>
                    <td scope="col"><label>Wait:</label></td>
                    <td scope="col"><input class="wp_afadmin_radio" type="radio" id="wait_setting_1"
                                           name="setting[wait_setting]"
                                           value="1" <?php if (isset($wait_setting) && ($wait_setting == 1)) {
                            echo "checked";
                        } ?> <?php echo $disabled;?> />On
                        <input class="wp_afadmin_radio" type="radio" id="wait_setting_2"
                               name="setting[wait_setting]"
                               value="0" <?php if (isset($wait_setting) && ($wait_setting == 0)) {
                            echo "checked";
                        } else if (!isset($wait_setting)) {
                            echo "checked";
                        } ?> <?php echo $disabled;?> />Off
                    </td>
                </tr>
                <tr>
                    <td scope="col"></td>
                    <td class="wp_afadmin_msgtable" scope="col"><input type="text" id="wait_setting_msg"
                                                                       class="wp_textfield_input"
                                                                       name="messages[wait_msg]"
                                                                       placeholder="Please wait.."
                                                                       value="<?php if (isset($wait_msg)) {
                                                                           echo esc_attr($wait_msg);
                                                                       } ?>" <?php echo $disabled;?> />
                        <!-- <span id="wait_error" style="color:red;"></span>      -->
                    </td>
                </tr>

                <tr>
                    <td scope="col" class="wp_afadmin_tdwidth"><label>Success:</label></td>
                    <td scope="col"><input class="wp_afadmin_radio" type="radio" id="success_setting_1"
                                           name="setting[success_setting]"
                                           value="1" <?php if (isset($success_setting) && ($success_setting == 1)) {
                            echo "checked='true'";
                        } ?> <?php echo $disabled;?> />On
                        <input class="wp_afadmin_radio" type="radio" id="success_setting_2"
                               name="setting[success_setting]"
                               value="0" <?php if (isset($success_setting) && ($success_setting == 0)) {
                            echo "checked='true'";
                        } else if (!isset($success_setting)) {
                            echo "checked";
                        } ?> <?php echo $disabled;?> />Off
                    </td>
                </tr>
                <tr>
                    <td scope="col"></td>
                    <td class="wp_afadmin_msgtable" scope="col"><input type="text"
                                                                       class="wp_textfield_input"
                                                                       id="success_setting_msg"
                                                                       name="messages[success_msg]"
                                                                       placeholder="The application process has completed successfully"
                                                                       value="<?php if (isset($success_msg)) {
                                                                           echo esc_attr($success_msg);
                                                                       } ?>" <?php echo $disabled;?> />
                        <span id="success_error" style="color:red;"></span></td>
                </tr>


                <tr>
                    <td scope="col"><label>Failure:</label></td>
                    <td scope="col"><input class="wp_afadmin_radio" type="radio" id="failure_setting_1"
                                           name="setting[failure_setting]"
                                           value="1" <?php if (isset($failure_setting) && ($failure_setting == 1)) {
                            echo "checked='true'";
                        } ?> <?php echo $disabled;?> />On
                        <input class="wp_afadmin_radio" type="radio" name="setting[failure_setting]"
                               id="failure_setting_2"
                               value="0" <?php if (isset($failure_setting) && ($failure_setting == 0)) {
                            echo "checked='true'";
                        } else if (!isset($failure_setting)) {
                            echo "checked";
                        } ?> <?php echo $disabled;?> />Off
                    </td>
                </tr>
                <tr>
                    <td scope="col"></td>
                    <td class="wp_afadmin_msgtable" scope="col"><input type="text"
                                                                       class="wp_textfield_input"
                                                                       id="failure_setting_msg"
                                                                       name="messages[failure_msg]"
                                                                       placeholder="There was a failure during the application"
                                                                       value="<?php if (isset($failure_msg)) {
                                                                           echo esc_attr($failure_msg);
                                                                       } ?>" <?php echo $disabled;?> />
                        <span id="failure_error" style="color:red;"></span>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>
<div class="h20 clear"></div>
