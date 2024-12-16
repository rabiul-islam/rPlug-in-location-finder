<?php
/**
 *
 * Custom Post Type Class
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class Nss_location_finder_custom_post {
  private $textdomain;
  private $nss_custom_posts;
    public function __construct( $textdomain) {
        $this->textdomain = $textdomain;
        $this->nss_custom_post_types = array();
        add_action('init', array($this, 'register_custom_post'));
    }

    public function nss_custom_post_types( $type, $singular_label, $plural_label, $settings = array() ) {
        $default_settings = array(
            'labels' => array(
                'name' => __($plural_label, $this->textdomain),
                'singular_name' => __($singular_label, $this->textdomain),
                'add_new_item' => __('Add New '.$singular_label, $this->textdomain),
                'edit_item'=> __('Edit '.$singular_label, $this->textdomain),
                'new_item'=>__('New '.$singular_label, $this->textdomain),
                'view_item'=>__('View '.$singular_label, $this->textdomain),
                'search_items'=>__('Search '.$plural_label, $this->textdomain),
                'not_found'=>__('No '.$plural_label.' found', $this->textdomain),
                'not_found_in_trash'=>__('No '.$plural_label.' found in trash', $this->textdomain),
                'parent_item_colon'=>__('Parent '.$singular_label, $this->textdomain),
                'menu_name' => __($plural_label,$this->textdomain)
            ),
            'public'=>true,
            'has_archive' => true,
            'menu_icon' => '',
            'menu_position'=>20,
            'supports'=>array(
                'title',
                'editor',
                'thumbnail',
                'excerpt'
            ),
            'rewrite' => array(
                'slug' => sanitize_title_with_dashes($plural_label)
            ),
            'capability_type' => 'post',
        );
        $this->nss_custom_post_types[$type] = array_merge($default_settings, $settings);
    }

    public function register_custom_post() {
        foreach($this->nss_custom_post_types as $key=>$value) {
            register_post_type($key, $value);
            flush_rewrite_rules( false );
        }
    }
}
/*init*/
$tmgc_post = new Nss_location_finder_custom_post('twentytwenty');
 
if(isset($_POST['nss_add_post_types_submit'])){  

    //lnkb-downloads post type

    $nss_custom_post_type_name = $_POST['nss_custom_post_type_name'];
    $nss_custom_post_type_plural_label = $_POST['nss_custom_post_type_plural_label']; 
    $nss_custom_post_type_name_singular_label = $_POST['nss_custom_post_type_name_singular_label']; 

    
    $tmgc_post->nss_custom_post_types($nss_custom_post_type_name, $nss_custom_post_type_plural_label, $nss_custom_post_type_name_singular_label, array('menu_icon' => 'dashicons-download'));
     
    
    $get_post_types = get_option('nss_custom_post_types'); 
    $maybe_unserialize = maybe_unserialize($get_post_types);   

    if(!empty($get_post_types)){           
       //$result = array_merge($maybe_unserialize, $nss_custom_post_type_name);    
       //update_option('nss_custom_post_types', serialize($result));
    }else{
        add_option('nss_custom_post_types',  serialize($nss_custom_post_type_name), '', 'yes');  
    }

}

$tmgc_post->nss_custom_post_types('nss-locator', 'Sales Locator', 'Crown Locator', array('menu_icon' => 'dashicons-setting')); 



  