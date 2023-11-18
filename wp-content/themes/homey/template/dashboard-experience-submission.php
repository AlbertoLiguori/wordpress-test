<?php
/**
 * Template Name: Dashboard Add Experience
 */
if ( !is_user_logged_in() ) {
    wp_redirect(  home_url('/') );
}

if ( homey_is_renter() ) {
    wp_redirect(  home_url('/') );
}

global $current_user, $hide_fields, $homey_local, $wpdb;
wp_get_current_user();
$userID = $current_user->ID;

$user_email = $current_user->user_email;
$admin_email =  get_bloginfo('admin_email');
$panel_class = '';

$invalid_nonce = false;
$submitted_successfully = false;
$updated_successfully = false;
$dashboard_experiences = homey_get_template_link('template/dashboard-experiences.php');
$dashboard_submission = homey_get_template_link('template/dashboard-experience-submission.php');
$submitted_page_url = homey_get_template_link('template/dashboard-experience-submitted.php');
$hide_fields = homey_option('add_hide_fields');
$required_fields = homey_option('add_experience_required_fields');

$experience_mode = isset($_GET['mode']) ? $_GET['mode'] : '';
$experience_id = -1;

if( isset( $_POST['action'] ) ) {

    $submission_action = $_POST['action'];
    $tab = isset($_POST['current_tab']) ? $_POST['current_tab'] : '';

    $new_experience = array(
        'post_type' => 'experience'
    );

    $experience_id = apply_filters('experience_submission_filter', $new_experience);

    $experience_id = intval($experience_id);

    $args = array(
        'experience_title'  =>  get_the_title($experience_id),
        'experience_id'     =>  $experience_id
    );

    if( $submission_action == 'update_experience' ) {
        $return_url  = add_query_arg(
            array(
                'edit_experience' => $experience_id,
                'tab' => $tab,
                'message' => true,
            ),
            $dashboard_submission );
    } else {
        $return_url  = add_query_arg( 'experience_id', $experience_id, $submitted_page_url );
    }

    wp_redirect($return_url);
}

$status_for_experience = get_post_status($experience_id);

get_header();
$experience_limit_check = 0;
if( in_array('homey-membership/homey-membership.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
    //check before header to print message
    hm_exp_validity_check();//check if users membership is expired or not
    $experience_limit_check = hm_experience_limit_check($userID, $status_for_experience);
}


?>

    <section id="body-area">

        <div class="dashboard-page-title">
            <h1><?php if(isset($_GET['edit_experience'])){
                   echo __( 'Edit Experience', 'homey');
                }else{
                echo esc_html__(the_title('', '', false), 'homey');
            } ?>
            </h1>
        </div><!-- .dashboard-page-title -->

        <?php get_template_part('template-parts/dashboard/side-menu'); ?>

        <div class="user-dashboard-right dashboard-with-sidebar">
            <div class="dashboard-content-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="dashboard-area">

                                <?php if(isset($_GET['edit_experience']) && (isset($_GET['message']) && $_GET['message'] == 1)) { ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-hide="alert" aria-label="Close"><i class="homey-icon homey-icon-close"></i></button>
                                        <?php echo esc_attr($homey_local['list_updated']); ?>
                                    </div>
                                <?php } ?>

                                <?php if(isset($_GET['edit_experience']) && (isset($_GET['featured']) && $_GET['featured'] == 1)) { ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-hide="alert" aria-label="Close"><i class="homey-icon homey-icon-close"></i></button>
                                        <?php echo esc_attr($homey_local['list_upgrade_featured']); ?>
                                    </div>
                                <?php } ?>

                                <div class="validate-errors alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-hide="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo wp_kses(__( '<strong>Error!</strong> Please fill out the required fields.', 'homey' ), homey_allowed_html() ); ?>
                                </div>
                                <div class="validate-errors-gal alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-hide="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo wp_kses(__( '<strong>Error!</strong> Upload at least one image.', 'homey' ), homey_allowed_html() ); ?>
                                </div>

                                <?php
                                if (isset($_GET['edit_experience']) && !empty($_GET['edit_experience'])) {

                                    get_template_part('template-parts/dashboard/edit-experience/submit-form');

                                } else {
                                    if( 1==2 && ( homey_option('homey_site_mode') == 'both' && $experience_mode == '' )) {
                                        get_template_part('template-parts/dashboard/submit-experience/experience-mode');
                                    } else {
                                        get_template_part('template-parts/dashboard/submit-experience/submit-form');
                                    }

                                }
                                ?>

                            </div><!-- .dashboard-area -->
                        </div><!-- col-lg-12 col-md-12 col-sm-12 -->
                    </div>
                </div><!-- .container-fluid -->
            </div><!-- .dashboard-content-area -->

            <aside class="dashboard-sidebar">
                <?php get_template_part('template-parts/dashboard/sidebar-experience');?>
            </aside><!-- .dashboard-sidebar -->

        </div><!-- .user-dashboard-right -->

    </section><!-- #body-area -->

    <script>
        jQuery(".draft-experience-validation").on("click", function(){
            var allInput  = jQuery("#submit_experience_form").find('input');
            var allSelect = jQuery("#submit_experience_form").find('select');
            var isValid   = true;
            var validation_string = '';

            jQuery(allInput).each(function(i, itm){
                if(jQuery(itm).attr('required') == 'required' && jQuery(itm).val() == ''){
                    if(validation_string != ''){
                        validation_string += ', ';
                    }
                    validation_string += isElementValid(itm);
                }
            });

            jQuery(allSelect).each(function(i, itm){
                if(jQuery(itm).attr('required') =='required'){
                    if(jQuery(itm).attr('selected', 'selected') == ''){
                        if(validation_string != ''){
                            validation_string += ', ';
                        }
                        validation_string += isElementValid(itm);
                    }
                }
            });

            if(validation_string == '') {
                jQuery("#submit_experience_form").submit();
                return true;
            }
            jQuery(".validate-errors").show();
            jQuery(".validate-errors").text('<?php echo esc_html__('Please fill the following required fields.', 'homey'); ?>'+ validation_string);

            jQuery([document.documentElement, document.body]).animate({
                scrollTop: jQuery(".validate-errors").offset().top - 500
            }, 500);

            return validation_string;
        });

        function isElementValid(itm){
           if(typeof jQuery(itm).data('inputTitle') != 'undefined'){
                return jQuery(itm).data('inputTitle');
            }else{
                return '';
            }
        }

    </script>
<?php get_footer();?>
