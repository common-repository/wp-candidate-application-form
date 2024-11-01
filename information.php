<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 11/17/2015
 * Time: 4:42 PM
 */
?>
<?php
$destination_email = get_post_meta( $post->ID, '__candidate_apply_form_destination_email', true);
wp_nonce_field( 'candidate_information_save_meta_box_data', 'candidate_information_meta_box_nonce' );
?>
<div class="h20 clear"></div>
<div id="wp_fieldcontainer">
    <?php if($_REQUEST['post']){?>
        <div class="wp_asub_title"><span class="wpaf_tooltip trigger"
                                         onmouseover="OpenDiv('<?php echo APPLY_FORM_SHORTCODE_TOOLTIP; ?>');">?</span>
            <span class="wp_swtbtn"><label>Apply Form shortcode </label></span>
            <span class="wp_swtbtn"><label> [apply-form id="<?php echo $_REQUEST['post'];?>"] </label> </span>
        </div>
        <div class="h20 clear"></div>
    <?php }?>
    <?php /*Activation key box */ ?>
    <div id="wpaf_activation_maincontainer">
        <div class="h10 clear"></div>
        <div id="wpaf_activation_subcontainer">
            <table width=" ">
                <tbody>
                <tr>
                    <td width=" "><span class="wpaf_tooltip trigger"
                                        onmouseover="OpenDiv('<?php echo DESTINATION_EMAIL_TOOLTIP; ?>');">?</span><label
                            class="wp_formlabel">Destination Email:</label></td>
                    <td width=" ">

                        <input type="text" class="wp_textfield_script" id="destination_email"
                               name="setting[destination_email]" placeholder=""
                               value="<?php if (isset($destination_email)) {
                                   echo esc_attr($destination_email);
                               } ?>"/>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

    <?php /*End: Activation key */ ?>

    <!-- Add here -->
</div>
<div class="h20 clear"></div>
