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
$destination_email_address = $dest_email?$dest_email:'';

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
wp_nonce_field('candidate_apply_button_meta_box_data', 'candidate_apply_meta_meta_box_nonce');
?>
<div>
    <div id="apply_btnoption">
            <?php

            if (APPLY_FORM_EDITION != 'free') {
                $wpaf_apply_button = maybe_unserialize(get_post_meta( $post->ID, '__wpaf_apply_button', true));
                $wpaf_response_popup = maybe_unserialize(get_post_meta($post->ID, '__wpaf_response_popup', true));
                $decoded_apply_button = json_decode($wpaf_apply_button);
                $decoded_response_popup = json_decode($wpaf_response_popup);


                /*filter out the values for single and double quote */
                if (isset($decoded_apply_button->style)) {
                    $applybtn_style = $this->filter_output($decoded_apply_button->style);
                }

                if (isset($decoded_apply_button->width)) {
                    $applybtn_width = $this->filter_output($decoded_apply_button->width);
                }
                if (isset($decoded_apply_button->height)) {
                    $applybtn_height = $this->filter_output($decoded_apply_button->height);
                }

                if (isset($decoded_apply_button->position)) {
                    $applybtn_position = $this->filter_output($decoded_apply_button->position);
                }

                if (isset($decoded_apply_button->margin_left)) {
                    $applybtn_margin_left = $this->filter_output($decoded_apply_button->margin_left);
                }
                if (isset($decoded_apply_button->margin_right)) {
                    $applybtn_margin_right = $this->filter_output($decoded_apply_button->margin_right);
                }
                if (isset($decoded_apply_button->margin_top)) {
                    $applybtn_margin_top = $this->filter_output($decoded_apply_button->margin_top);
                }
                if (isset($decoded_apply_button->margin_bottom)) {
                    $applybtn_margin_bottom = $this->filter_output($decoded_apply_button->margin_bottom);
                }

                if (isset($decoded_apply_button->padding_right)) {
                    $applybtn_padding_right = $this->filter_output($decoded_apply_button->padding_right);
                }
                if (isset($decoded_apply_button->padding_left)) {
                    $applybtn_padding_left = $this->filter_output($decoded_apply_button->padding_left);
                }
                if (isset($decoded_apply_button->padding_top)) {
                    $applybtn_padding_top = $this->filter_output($decoded_apply_button->padding_top);
                }
                if (isset($decoded_apply_button->padding_bottom)) {
                    $applybtn_padding_bottom = $this->filter_output($decoded_apply_button->padding_bottom);
                }
                if (isset($decoded_apply_button->float_val)) {
                    $applybtn_float_val = $this->filter_output($decoded_apply_button->float_val);
                }
            }

            ?>

        <div class="h10 clear"></div>

        <div id="apply_form_appearance">
            <table>
                <tr>
                    <td><label>Width:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium" name="apply_button[width]"
                               placeholder="100" onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_width)) {
                                   echo esc_attr($applybtn_width);
                               } ?>"   <?php echo $disabled; ?> />&nbsp;px
                    </td>
                    <td><label style="">Height:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium" name="apply_button[height]"
                               placeholder="30" onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_height)) {
                                   echo esc_attr($applybtn_height);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px

                    </td>
                </tr>

                <tr>
                    <td><label class="wp_afadmin_labelwidth">Margin-Left:</label></td>
                    <td><input type="text" class=" wp_textfield_input_medium"
                               name="apply_button[margin_left]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_margin_left)) {
                                   echo esc_attr($applybtn_margin_left);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                    <td><label>Margin-Right:</label></td>
                    <td><input type="text" class=" wp_textfield_input_medium"
                               name="apply_button[margin_right]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_margin_right)) {
                                   echo esc_attr($applybtn_margin_right);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>

                </tr>
                <tr>
                    <td><label>Margin-Top:</label></td>
                    <td><input type="text" class=" wp_textfield_input_medium"
                               name="apply_button[margin_top]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_margin_top)) {
                                   echo esc_attr($applybtn_margin_top);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                    <td><label>Margin-Bottom:</label></td>
                    <td><input type="text" class=" wp_textfield_input_medium"
                               name="apply_button[margin_bottom]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_margin_bottom)) {
                                   echo esc_attr($applybtn_margin_bottom);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>

                </tr>

                <tr>
                    <td><label>Padding-Left:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium"
                               name="apply_button[padding_left]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_padding_left)) {
                                   echo esc_attr($applybtn_padding_left);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                    <td><label>Padding-Right:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium"
                               name="apply_button[padding_right]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_padding_right)) {
                                   echo esc_attr($applybtn_padding_right);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                </tr>

                <tr>
                    <td><label>Padding-Top:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium"
                               name="apply_button[padding_top]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_padding_top)) {
                                   echo esc_attr($applybtn_padding_top);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                    <td><label>Padding-Bottom:</label></td>
                    <td><input type="text" class="wp_textfield_input_medium"
                               name="apply_button[padding_bottom]" placeholder="0"
                               onkeypress="javascript: return isNumberKey(event);"
                               value="<?php if (isset($applybtn_padding_bottom)) {
                                   echo esc_attr($applybtn_padding_bottom);
                               } ?>" <?php echo $disabled; ?> />&nbsp;px
                    </td>
                </tr>
                <tr>
                    <td><label>Float:</label></td>
                    <td colspan="3">
                        <?php
                        $selected_left = '';
                        $selected_right = '';
                        if (isset($applybtn_float_val) && ($applybtn_float_val == 'left')) {
                            $selected_left = "selected='selected'";
                        } else if (isset($applybtn_float_val) && ($applybtn_float_val == 'right')) {
                            $selected_right = "selected='selected'";
                        }
                        ?>
                        <select name="apply_button[float_val]" id="select"
                                class="wp_selectclass" <?php echo $disabled; ?> >
                            <option></option>
                            <option value="left" <?php echo esc_attr($selected_left); ?>>Left</option>
                            <option value="right" <?php echo esc_attr($selected_right); ?>>Right</option>
                        </select></td>
                </tr>
                <tr>
                    <td scope="col"><label>Style:</label></td>
                    <td scope="col" colspan="3"><input type="text" class="wp_textfield_input"
                                                       name="apply_button[style]"
                                                       placeholder="border-width: 1px !important; border-radius: 5px !important;"
                                                       value="<?php if (isset($applybtn_style)) {
                                                           echo esc_attr($applybtn_style);
                                                       } ?>" <?php echo $disabled; ?> /></td>
                </tr>
            </table>
        </div>
    </div>

    <?php /* End: Apply Button */ ?>
</div>
<div class="h10 clear"></div>