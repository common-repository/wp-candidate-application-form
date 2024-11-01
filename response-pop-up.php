<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 11/17/2015
 * Time: 4:44 PM
 */
?>
<?php
global $wpdb;
$wpaf_setting = maybe_unserialize(get_post_meta($post->ID, '__wpaf_setting', true));
$wpaf_response = maybe_unserialize(get_post_meta($post->ID, '__wpaf_response_popup', true));
$default_option = get_option('wpaf_setting');
$default_setting = json_decode($default_option);
$decoded_setting = json_decode($wpaf_setting);
$decoded_response_popup = json_decode($wpaf_response);

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
wp_nonce_field('candidate_response_pop_up_meta_box_data', 'candidate_response_pop_up_meta_box_nonce');
?>
<div class="h20 clear"></div>
<div>
    <div id="response_popup">
        <?php
        if (APPLY_FORM_EDITION != 'free') {
            if (isset($decoded_response_popup->width)) {
                $response_popup_width = $this->filter_output($decoded_response_popup->width);
            }
            if (isset($decoded_response_popup->height)) {
                $response_popup_height = $this->filter_output($decoded_response_popup->height);
            }
            if (isset($decoded_response_popup->colour)) {
                $response_popup_colour = $this->filter_output($decoded_response_popup->colour);
            }
            if (isset($decoded_response_popup->bgcolour)) {
                $response_popup_bgcolour = $this->filter_output($decoded_response_popup->bgcolour);
            }
            if (isset($decoded_response_popup->style)) {
                $response_popup_style = $this->filter_output($decoded_response_popup->style);
            }
            if (isset($decoded_response_popup->position)) {
                $response_popup_position = $this->filter_output($decoded_response_popup->position);
            }

        }


        ?>

        <div id="response_popup_appearance">
            <table width=" ">
                <tr>
                    <td><label>Width:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium" name="response_popup[width]"
                               placeholder="300" onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($response_popup_width)) {
                                   echo esc_attr($response_popup_width);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>

                    <td>
                        <label style="margin-right:-15px;">Height:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium" name="response_popup[height]"
                               placeholder="300" onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($response_popup_height)) {
                                   echo esc_attr($response_popup_height);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                </tr>
                <tr>
                    <td><label>Text Colour:</label></td>
                    <td colspan="3"><input type="text" class="wp_textfield_input_mid"
                                           name="response_popup[colour]" placeholder="#000000"
                                           value="<?php if (isset($response_popup_colour)) {
                                               echo esc_attr($response_popup_colour);
                                           } ?>" <?php echo $disabled; ?> /></td>
                </tr>
                <tr>
                    <td><label>Background:</label></td>
                    <td colspan="3"><input type="text" class="wp_textfield_input_mid"
                                           name="response_popup[bgcolour]" placeholder="#000000"
                                           value="<?php if (isset($response_popup_bgcolour)) {
                                               echo esc_attr($response_popup_bgcolour);
                                           } ?>" <?php echo $disabled; ?> /></td>
                </tr>

                <tr>
                    <td><label>Style:</label></td>
                    <td colspan="3"><input type="text" class="wp_textfield_input"
                                           name="response_popup[style]"
                                           placeholder="border-width: 1px; border-radius: 5px;"
                                           value="<?php if (isset($response_popup_style)) {
                                               echo esc_attr($response_popup_style);
                                           } ?>" <?php echo $disabled; ?> /></td>
                </tr>

            </table>
        </div>

    </div>
    <?php /*Default Messages  */ ?>
    <!--Message-->

</div>
<div class="h10 clear"></div>