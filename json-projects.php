<?php
   /*
   Plugin Name: JSON Projects
   description: Keep your projects up to date. Add new projects to your website using a pre-default JSON template. This plugin has been built for educational purposes.
   Version: 1.0
   Author: Alex Chera
   Author URI: http://alexchera.com
   License: JSON Projects is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.
   */

// Enque the CSS in order to stylize the buttons
function add_my_stylesheet() 
{
    wp_enqueue_style( 'json_import_style', plugins_url( '/css/json_import_style.css', __FILE__ ) );
}

// Enque the JavaScript 
function add_my_script()
{
    wp_enqueue_script('json_import_script', plugins_url( '/js/json_import_script.js', __FILE__ ), array('jquery') );
}

add_action('admin_print_styles', 'add_my_stylesheet');
add_action('admin_print_scripts', 'add_my_script');

/* ---------------------------------------------- */


//The import button
add_action('admin_head-edit.php', 'importprojectsFromJsonButton');

if (!function_exists('importprojectsFromJsonButton')) {
    function importprojectsFromJsonButton()
    {
        global $current_screen;
        if('project' == $current_screen->post_type) {
            echo '<form id="form_json" action="'.admin_url('admin-post.php').'" method="post">';
            wp_nonce_field('json_button_clicked'); // Wordpress security
            echo '<input type="hidden" name="importSingle" />';
            echo '<input type="hidden" value="json_button" name="action" />';
            if (!file_exists(plugin_dir_path( __FILE__ )."projects.json")) {
                echo '<div class="tooltip">';
                echo '<input type="submit" value="Import projects" class="page-title-action disabled" disabled>';
                echo '<span class="tooltiptext">You need the <strong>projects.json</strong> file of this site</span>';
                echo '</div>';
            } else {
                echo '<div class="tooltip">';
                echo '<input type="submit" value="Import projects" class="page-title-action">';
                echo '<span class="tooltiptext">Will generate projects from <strong>projects.json</strong></span>';
                echo '</div>';
            }
            echo '</form>';
        } else {
            return;
        }
    }
}

/* ---------------------------------------------- */
// Import all buttons. This button is dedicated to import all projects from the export-all.json.
if (is_multisite() ) { 

add_action('admin_head-edit.php', 'importAllprojectsFromJsonButton');

}

if (!function_exists('importAllprojectsFromJsonButton')) {
    function importAllprojectsFromJsonButton()
    {
        global $current_screen;
        if('project' == $current_screen->post_type) {
            echo '<form id="formAll_json" action="'.admin_url('admin-post.php').'" method="post">';
            wp_nonce_field('jsonAll_button_clicked'); // Wordpress security
            echo '<input type="hidden" name="importAll" />';
            echo '<input type="hidden" value="jsonAll_button" name="action" />';
            if (!file_exists(plugin_dir_path( __FILE__ )."export-all.json")) {
                echo '<div class="tooltip">';
                echo '<input type="submit" value="Multisite import" class="page-title-action disabled" disabled>';
                echo '<span class="tooltiptext">You need the <strong>export-all.json</strong> file of this site</span>';
                echo '</div>';
            } else {
                echo '<div class="tooltip">';
                echo '<input type="submit" value="Multisite import" class="page-title-action">';
                echo '<span class="tooltiptext">Will generate projects from <strong>export-all.json</strong> file of this site</span>';
                echo '</div>';
            }
            echo '</form>';
        } else {
            return;
        }
    }
}

/* ---------------------------------------------- */

// Standalone import button. This button will import custom posts (projects) from a different JSON file
add_action('admin_head-edit.php', 'importOriginalprojectsFromJsonButton');

if (!function_exists('importOriginalprojectsFromJsonButton')) {
    function importOriginalprojectsFromJsonButton()
    {
        global $current_screen;
        if('project' == $current_screen->post_type) {
            echo '<form id="formOriginal_json" action="'.admin_url('admin-post.php').'" method="post">';
            wp_nonce_field('jsonOriginal_button_clicked'); // Wordpress security
            echo '<input type="hidden" name="importOriginal" />';
            echo '<input type="hidden" value="jsonOriginal_button" name="action" />';
            if (!file_exists(plugin_dir_path( __FILE__ )."standalone.json")) {
                echo '<div class="tooltip">';
                echo '<input type="submit" value="Import from standalone file" class="page-title-action disabled" disabled>';
                echo '<span class="tooltiptext"><strong>standalone.json</strong> file missing</span>';
                echo '</div>';
            } else {
                echo '<div class="tooltip">';
                echo '<input type="submit" value="Import from standalone file" class="page-title-action">';
                echo '<span class="tooltiptext">Will generate projects from <strong>standalone.json</strong> standalone file of this site</span>';
                echo '</div>';
            }
            echo '</form>';
        } else {
            return;
        }
    }
}


/* ---------------------------------------------- */
// Export all buttons. This button is dedicated to export all projects from every subsite
if (is_multisite() ) { 

add_action('admin_head-edit.php', 'exportAllprojectsToJsonButton');

}

if (!function_exists('exportAllprojectsToJsonButton')) {
    function exportAllprojectsToJsonButton() {
        echo '<form id="exportAll_json" action="'.admin_url('admin-post.php').'" method="post">';
        wp_nonce_field('json_exportAll_button_clicked'); // Wordpress security
        echo '<input type="hidden" name="exportAll" />';
        echo '<input type="hidden" value="json_exportAll_button" name="action" />';
        echo '<input type="submit" value="Multisite export" class="page-title-action" id="exportAllButton">';
        echo '</form>';
    }
}
/* ---------------------------------------------- */
// Export button. This button will export the existing projects to projects.json file
add_action('admin_head-edit.php', 'exportprojectsToJsonButton');

if (!function_exists('exportprojectsToJsonButton')) {
    function exportprojectsToJsonButton() {
        global $current_screen;
        if('project' == $current_screen->post_type) {
        echo '<form id="export_json" action="'.admin_url('admin-post.php').'" method="post">';
        wp_nonce_field('json_export_button_clicked'); // Wordpress security
        echo '<input type="hidden" name="exportSingle" />';
        echo '<input type="hidden" value="json_export_button" name="action" />';
    if (!file_exists(plugin_dir_path( __FILE__ )."projects.json")) {   
        echo '<div class="tooltip">';
        echo '<input type="submit" value="Export projects" class="page-title-action disabled" disabled>';
        echo '<span class="tooltiptext">You need the <strong>projects.json</strong> file of this site</span>';
        echo '</div>';
    } else {
        echo '<div class="tooltip">';
        echo '<input type="submit" value="Export projects" class="page-title-action">';
        echo '<span class="tooltiptext">Will exports projects to <strong>projects.json</strong></span>';
        echo '</div>';
    }
    echo '</form>';
        } else {
            return;
        }
    }
}
/* ---------------------------------------------- */
// This function shows where the JSON files are located.
add_action('admin_head-edit.php', 'pluginInfo');

if (!function_exists('pluginInfo')) {
    function pluginInfo() {
        echo '<div id="info">';
        echo '<p class="info-location">';
        echo  'The JSON files are located at <strong><a href="'.plugin_dir_url( __FILE__ ).$GLOBALS['file_name'].'">'
                    .plugin_dir_url( __FILE__ ).'
                    </strong>';
        echo '</p>';
        echo '</div>';
    }
}
/* ---------------------------------------------- */
// if any of the export buttons are triggered, the $file_name variable will have assigned a new value; each value
// representing the name of the JSON file 
    $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $current_url = $protocol.'://'.$_SERVER['HTTP_HOST'];
    global $current_url;
    if (isset($_POST['exportAll']) || isset($_POST['importAll'])) {
        $file_name = 'export-all.json';
    } elseif (isset($_POST['exportSingle'])) {
        $file_name = 'projects.json';
    } else {
        $file_name = 'projects.json';
    }
    global $file_name;


/* ---------------------------------------------- */
// this function is dedicated for multisite export. Stores the projects from each subsite as a multidimensional array
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

/* ---------------------------------------------- */
// retrieve all the projects from every subsite
function get_all_multisite_posts($args){
    $args = array(
        'post_type' => 'project',
        'post_status' => array('publish', 'draft'),
        'nopaging' => true,
        'meta_input' => [
            'project_id' => get_post_meta(get_the_ID(),'project_id', true),
        ],
    );
    if(!$args){
        return false;
    }
    $blog_posts = array();
    $sites = get_sites();
    if($sites){
        foreach ($sites as $site) {
            switch_to_blog($site->id);
            //   $posts = get_posts($args);
            $query = new WP_Query( $args );
          while ($query->have_posts()): $query->the_post();
          $posts[] = array(
                'project_id' => get_post_meta( get_the_ID(), 'project_id', true),
                'publish_state' => get_post_status( get_the_ID()),
                'date' => get_post_datetime( get_the_ID() ),
                'title' => get_the_title(),
                'content' => get_the_content(),
                'image' => get_the_post_thumbnail_url( get_the_ID()),
                'module' => get_post_meta(get_the_ID(),'module', true),
                'skill' => get_post_meta( get_the_ID(), 'skill', true),
                'software' => get_post_meta( get_the_ID(), 'software', true),
              // any extra field you might need
          );
          $posts = unique_multidim_array($posts, 'project_id');
      endwhile;
    //   $blog_posts[$site->blogname] = $posts;
       }
    }
    restore_current_blog();
    if($posts) {
        return $posts;
    }
    //    if($blog_posts){
    //    return $blog_posts;
    // }
 }

 /* ----------------------------------- */
 $terms = get_terms('module');
 foreach ( $terms as $term ) {
 echo $term->slug.' ';
 }

// retrieve all the projects
 function get_all_singlesite_posts($args) {
    $args = array(
        'post_type' => 'project',
        'post_status' => array('publish', 'draft'),
        'nopaging' => true
    );
    if(!$args){
       return false;
    }
    $query = new WP_Query( $args );
    $posts = array(); 
    while ($query->have_posts()): $query->the_post();
    $posts[] = array(
                'project_id' => get_post_meta( get_the_ID(), 'project_id', true),
                'publish_state' => get_post_status( get_the_ID()),
                'date' => get_post_datetime( get_the_ID() ),
                'title' => get_the_title(),
                'content' => get_the_content(),
                'image' => get_the_post_thumbnail_url( get_the_ID()),
                'module' => get_post_meta(get_the_ID(),'module', true),
                'skill' => get_post_meta( get_the_ID(), 'skill', true),
                'software' => get_post_meta( get_the_ID(), 'software', true),
              // any extra field you might need
          );
        endwhile;
        if($posts) {
            return $posts;
    }
 }
global $posts;

// writes and saves the info gathered from get_all_singlesite_posts or get_all_multisite_posts into a JSON file
 function export_projects_to_json() {
    if (isset($_POST['exportAll']) && check_admin_referer('json_exportAll_button_clicked')) {
        $posts = get_all_multisite_posts($args);
    }
    elseif (isset($_POST['exportSingle']) && check_admin_referer('json_export_button_clicked')) {
        $posts = get_all_singlesite_posts($args);
    }
    wp_reset_query();
    $data = json_encode($posts);
    $upload_dir = ABSPATH.'wp-content/plugins/json-projects';
    $save_path = $upload_dir.'/'.$GLOBALS['file_name'];
    $f = fopen($save_path, "w");
    fwrite($f, $data);
    fclose($f);

    $exportIds = [];
    $exportIds[] = $checkId;

    $redirectTo = $current_url.'/wp-admin/edit.php?
    post_type=project&
    json_export=true';

    if (count($exportIds) > 0) {
        $exports = implode(';', $exportIds);
        $redirectTo .= "&json_export_successes=$exports";
    }
    wp_redirect($redirectTo);
}
if (is_admin()) {
add_action('admin_post_json_export_button', 'export_projects_to_json');
add_action('admin_post_json_exportAll_button', 'export_projects_to_json');
    if (isset($_GET['json_export'])) {
        if (isset($_GET['json_export_successes'])) {
            $successes = explode(';', urldecode($_GET['json_export_successes']));
        } else {
            $successes = [];
        }
        if (count($successes) > 0) {
            add_action('admin_notices', function () {
                global $pagenow;
                return json_projects_notice('Projects exported succesfully', 'success');
            });
            add_action('admin_notices', function () {
                return json_projects_notice('Exported projects (JSON file) can be
                found at this location:
                <strong><a href="'.plugin_dir_url( __FILE__ ).$GLOBALS['file_name'].'">'
                .plugin_dir_url( __FILE__ ).$GLOBALS['file_name'].'
                </strong>', 'info');
            });
        }
    }
}


/* ---------------------------------------------- */
//shows information / errors
function json_projects_notice($message, $type = 'info') {
    ?>
    <div class="notice notice-<?php _e($type, 'sample-text-domain'); ?> is-dismissible">
        <p><?php _e($message, 'sample-text-domain'); ?></p>
    </div>
    <?php
}

/* ---------------------------------------------- */
// updates / inserts projects to single / multisite
function update_projects_from_json() {
    if (isset($_POST['importAll']) && check_admin_referer('jsonAll_button_clicked')) {
        $json = wp_remote_get(plugin_dir_url( __FILE__ )."export-all.json");
    }
    elseif(isset($_POST['importSingle']) && check_admin_referer('json_button_clicked')) {
        $json = wp_remote_get(plugin_dir_url( __FILE__ )."projects.json");
    }
    elseif(isset($_POST['importOriginal']) && check_admin_referer('jsonOriginal_button_clicked')) {
        $json = wp_remote_get(plugin_dir_url( __FILE__ )."standalone.json");
    }
    $body = wp_remote_retrieve_body($json);
    $mydecode = json_decode($body, true);

    $successIds = [];
    $errorIds = [];
    $duplicateIds = [];

    foreach ($mydecode as $project) {
            $title = sanitize_text_field($project['title']);
            $image = $project['image'];
            $content = $project['content'];
            $module = $project['module'];
            $skills = $project['skill'];
            $software = $project['software'];
            $id = $project['project_id'];
            $wp_filetype = wp_check_filetype( $image, null );

            $attachment_data = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name( $image ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            if ($project['publish_state'] == 'published') {
                $publishState = 'publish';
            } elseif ($project['publish_state'] == 'publish') {
                $publishState = 'publish';
            } else {
                $publishState = 'draft';
            }

            $get_page = new WP_Query([
                'post_type' => 'project',
                'post_status' => $publishState,
                'meta_key' => 'project_id',
                'meta_value' => $id,
            ]);

            $pages = $get_page->get_posts();
            $pageCount = count($pages);
            $get_terms_default_attributes = array (
                'taxonomy' => 'category');
                // var_dump($get_terms_default_attributes);
                $terms = get_terms( array(
                    'taxonomy' => 'category',
                    'parent'   => 0,
                    'hide_empty' => false
                ) );
            $category = get_term_by('slug', $terms[0]->slug, 'category');

            // Check if already exists
            // if no then generate
            if ($pageCount === 0) {

                $post_data = array(
                    'post_title' => $title,
                    'post_content' => $content,
                    'post_status' => $publishState,
                    'post_author' => 1,
                    'post_date' => date('Y-m-d H:i:s'),
                    'post_type' => 'project',
                );

                $post_data['tax_input'] = [
                    'category' => [$category->term_id],
                ];

                $post_data['meta_input'] = [
                    'project_id' => $id,
                    'version' => 1,
                    'module' => $module,
                    'image' => $image,
                    'skill' => $skills,
                    'software' => $software,
                    'publish_state' => $publishState,
                ];
                
                $result = wp_insert_post($post_data, true);

                $attach_id = wp_insert_attachment( $attachment_data, $image, $result );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                $attach_data = wp_generate_attachment_metadata( $attach_id, $image );
                wp_update_attachment_metadata( $attach_id, $attach_data );
                set_post_thumbnail( $result, $attach_id );
                
                if ($result === 0 || is_wp_error($result)) {
                    $errorIds[] = $id;
                } else {
                    $successIds[] = $id;
                }
                //if exists then update
            } 
            if ($pageCount === 1) {
                $post_data['tax_input'] = [
                    'category' => [$category->term_id],
                ];
                $version = get_post_meta($pages[0]->ID, 'version', true);
                $post_data = array();
                $post_data['ID'] = $pages[0]->ID;
                $post_data['post_title'] = $title;
                $post_data['post_content'] = $content;
                $post_data['post_status'] = $publishState;
                $post_data['meta_input'] = [
                    'version' => $version++,
                    'date' => date('Y-m-d H:i:s'),
                    'module' => $module,
                    'skill' => $skills,
                    'software' => $software,
                ];
                $result = wp_update_post($post_data);

                if ($result === 0 || is_wp_error($result)) {
                    $errorIds[] = $id;
                } else {
                    $successIds[] = $id;
                }
            } else {
                $duplicateIds[] = $id;
            }
        }

        $redirectTo = $current_url.'/wp-admin/edit.php?
            post_type=project&
            project_import=true';

        if (count($successIds) > 0) {
            $successes = implode(';', $successIds);
            $redirectTo .= "&project_import_successes=$successes";
        }

        if (count($errorIds) > 0) {
            $errors = implode(';', $errorIds);
            $redirectTo .= "&project_import_errors=$errors";
        }

        if (count($duplicateIds) > 0) {
            $duplicates = implode(';', $duplicateIds);
            $redirectTo .= "&project_import_duplicates=$duplicates";
        }

        wp_redirect($redirectTo);
    /* ---------------------------------------------- */
}

if (is_admin()) {
    add_action( 'admin_post_json_button', 'update_projects_from_json');
    add_action( 'admin_post_jsonAll_button', 'update_projects_from_json');
    add_action( 'admin_post_jsonOriginal_button', 'update_projects_from_json');

    if (isset($_GET['project_import'])) {
        if (isset($_GET['project_import_successes'])) {
            $successes = explode(';', urldecode($_GET['project_import_successes']));
        } else {
            $successes = [];
        }

        if (isset($_GET['project_import_errors'])) {
            $errors = explode(';', urldecode($_GET['project_import_errors']));
        } else {
            $errors = [];
        }

        if (isset($_GET['project_import_duplicates'])) {
            $duplicates = explode(';', urldecode($_GET['project_import_duplicates']));
        } else {
            $duplicates = [];
        }

        if (count($errors) > 0 || count($duplicates) > 0) {
            add_action('admin_notices', function () {
                return json_projects_notice('Import finished with errors, see below:', 'warning');
            });

            foreach ($errors as $error) {
                add_action('admin_notices', function () use ($error) {
                    return json_projects_notice("Unable to import project with ID: $error", 'error');
                });
            }

            foreach ($duplicates as $duplicate) {
                add_action('admin_notices', function () use ($duplicate) {
                    return json_projects_notice("Duplicate project ID: $duplicate", 'error');
                });
            }
        } elseif (count($successes) > 0) {
            add_action('admin_notices', function () {
                return json_projects_notice('Projects imported successfully', 'success');
            });
        } else {
            add_action('admin_notices', function () {
                return json_projects_notice('Nothing to import', 'info');
            });
        }
    }
}

/* ---------------------------------------------- */


if (! function_exists('custom_post_type')) {
    // Register Custom Post Type
    function custom_post_type()
    {
        $labels = array(
            'name'                  => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Projects', 'text_domain' ),
            'name_admin_bar'        => __( 'Project', 'text_domain' ),
            'archives'              => __( 'Project Archives', 'text_domain' ),
            'attributes'            => __( 'Project Attributes', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
            'all_items'             => __( 'All Projects', 'text_domain' ),
            'add_new_item'          => __( 'Add New Project', 'text_domain' ),
            'add_new'               => __( 'Add Project', 'text_domain' ),
            'new_item'              => __( 'New Project', 'text_domain' ),
            'edit_item'             => __( 'Edit Project', 'text_domain' ),
            'update_item'           => __( 'Update Project', 'text_domain' ),
            'view_item'             => __( 'View Project', 'text_domain' ),
            'view_items'            => __( 'View Projects', 'text_domain' ),
            'search_items'          => __( 'Search Projects', 'text_domain' ),
            'not_found'             => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
            'featured_image'        => __( 'Featured Image', 'text_domain' ),
            'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
            'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
            'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
            'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
            'items_list'            => __( 'Items list', 'text_domain' ),
            'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
            'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
        );
        $args = array(
            'label'                 => __( 'Project', 'text_domain' ),
            'description'           => __( 'Projects From JSON', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            // 'taxonomies'            => array( 'module', 'skills', 'software' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-format-aside',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'projects',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );
        register_post_type( 'project', $args );
    }
    add_action( 'init', 'custom_post_type', 0 );
}

/**
 * Removes some menus by page.
 */
function wpdocs_remove_menus(){

    remove_menu_page( 'edit.php' );                   //Posts
  }
  add_action( 'admin_init', 'wpdocs_remove_menus' );

?>