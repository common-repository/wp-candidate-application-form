<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 11/17/2015
 * Time: 4:43 PM
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
wp_nonce_field('candidate_script_configuration_meta_box_data', 'candidate_script_configuration_meta_box_nonce');
?>
<div class="h20 clear"></div>
<div>
    <?php
    /*$wpaf_setting =  get_option('wpaf_setting');     */
    $wpaf_headers = maybe_unserialize(get_post_meta( $post->ID, '__wpaf_headers', true));
    $wpaf_parameters = maybe_unserialize(get_post_meta($post->ID, '__wpaf_parameters', true));

//    $decoded_setting = json_decode($wpaf_setting);

    $decoded_headers = json_decode($wpaf_headers);
    $decoded_parameters = json_decode($wpaf_parameters);

    if (APPLY_FORM_EDITION == 'free') {
        $scriptname = 'Apply_Form_email_script.php';
        $readonly = 'readOnly';
    } else {
        if (isset($decoded_setting->scriptname)) {
            $scriptname = $decoded_setting->scriptname;
        }
    }

    ?>
    <div id="intervw_form">

        <table width=" ">
            <tbody>
            <tr>
                <td width=" "><label class="wp_formlabel"><span class="wpaf_tooltip trigger"
                                                                onmouseover="OpenDiv('<?php echo SCRIPT_NAME_TOOLTIP; ?>');">?</span>Script
                        Name:</label></td>
                <td width=" ">

                    <input type="text" class="wp_textfield_script" name="setting[scriptname]" placeholder=""
                           value="<?php if (isset($scriptname)) {
                               echo esc_attr($scriptname);
                           }else{ echo 'Apply_Form_email_script.php';} ?>" <?php if (isset($readonly)) {
                        echo $readonly;
                    } ?> />

                </td>
            </tr>
            <tr>
                <td width="" height=" "><label><span class="wpaf_tooltip trigger"
                                                     onmouseover="OpenDiv('<?php echo HEADER_VARIABLES_TOOLTIP; ?>');">?</span>Header
                        Variables:</label></td>
                <td width="">

                    <div id="wp_adheaderintvw">
                        <?php if (!empty($decoded_headers)) {
                            $i = 0;
                            foreach ($decoded_headers as $head_arr) { ?>
                                <p>
                                    <input class="header_cls" type="text"
                                           name="header[<?php echo $i; ?>][name]" placeholder="name"
                                           value="<?php echo esc_attr($head_arr->name); ?>"/>
                                    <input type="text" name="header[<?php echo $i; ?>][value]"
                                           value="<?php echo esc_attr($head_arr->value); ?>"
                                           placeholder="value"/>
                                                <span id="remScnt_<?php echo esc_attr($i); ?>" class="remintv"
                                                      style="cursor:pointer " onclick="removeFn(this.id);"> </span>
                                </p>


                                <?php $i++;
                            }

                        } ?>


                    </div>

                    <input id="button_head" type="button" value="Add Another Header" name="submit_header"
                           onClick="" <?php if (APPLY_FORM_EDITION == 'free') {
                        echo "disabled = 'disabled'";
                    } ?>  />

                </td>
            </tr>
            <tr>
                <td width=""><label style="width:176px;"><span class="wpaf_tooltip trigger"
                                                               onmouseover="OpenDiv('<?php echo PARAMETER_VALUES_TOOLTIP; ?>');">?</span>Parameter
                        Variables:</label></td>
                <td width="">
                    <div id="wp_dropdivint">
                        <div class="wp_dropinputint">

                            <?php if (!empty($decoded_parameters)) {
                                $j = 0;
                                foreach ($decoded_parameters as $param_arr) {
                                    ?>
                                    <p>
                                        <input class="parameter_cls" type="text"
                                               name="parameter[<?php echo esc_attr($j); ?>][name]"
                                               placeholder="name"
                                               value="<?php echo esc_attr($param_arr->name); ?>"/>
                                        <input type="text"
                                               name="parameter[<?php echo esc_attr($j); ?>][value]"
                                               value="<?php echo esc_attr($param_arr->value); ?>"
                                               placeholder="value"/>
                                                    <span id="parameter_<?php echo esc_attr($j); ?>" class="wp_reminv"
                                                          style="cursor:pointer " onclick="remFn(this.id);"> </span>
                                    </p>
                                    <?php
                                    $j++;
                                }
                            }
                            ?>

                        </div>

                    </div>
                    <input type="button" value="Add Another Parameter" id="wp_addparameter"
                           name="submit_header" onClick=""  <?php if (APPLY_FORM_EDITION == 'free') {
                        echo "disabled = 'disabled'";
                    } ?>   />

                </td>
            </tr>
            </tbody>
        </table>

        <div id="wp_intpara_container">
            <label class="intclass"><span class="wpaf_tooltip trigger"
                                          onmouseover="OpenDiv('<?php echo AVAILABLE_VARIABLES_TOOLTIP; ?>');">?</span>Available
                Variables</label>
            <?php
            /*obtain list of dynamic varibles */
            $querystr = "select post_id from wp_pmxi_posts limit 1";
            $pmxi_post = $wpdb->get_results($querystr, OBJECT);
            if (!empty($pmxi_post)) {
                $post_arr = $pmxi_post[0];
                $post_id = $post_arr->post_id;
                $querystr = "SELECT wp_postmeta.meta_key, wp_postmeta.meta_value
                      FROM wp_postmeta
                      WHERE wp_postmeta.post_id = $post_id";


                $post_meta = $wpdb->get_results($querystr, OBJECT);

            }

            ?>
            <div id="wp_ai_parvariable">
                <ul>
                    <li class=" wp_addinputint">PostId from Wordpress Post created In Import<span
                            style="display:none;">WPpostURL</span></li>
                    <li class=" wp_addinputint">Custom Field: Current Page URL</li>
                    <?php
                    if (isset($post_meta)) {
                        foreach ($post_meta as $key => $result) { ?>
                            <input type="hidden"
                                   name="meta_value[<?php echo $result->meta_key; ?>]"
                                   value="<?php echo $result->meta_value; ?>" />
                            <li class=" wp_addinputint">Custom Field: <?php echo esc_html($result->meta_key); ?></li>
                        <?php
                        }
                    }
                    ?>

                </ul>
            </div>
        </div>


    </div>
    <?php /* Start: Apply Button */ ?>
</div>
<div class="h10 clear"></div>