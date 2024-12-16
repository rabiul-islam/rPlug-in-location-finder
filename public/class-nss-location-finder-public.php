<?php
/**
    * @package Location Finder
    * @version 1.1.0
    */
    /*
    Plugin Name: Location Finder
    Plugin URI: #
    Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
    Author: Md Islam
    Version: 1.1.0
    Author URI: http://ma.tt/
    */
    // if accessed directly
    if (!defined('ABSPATH'))
    exit; 

    /**
    * Auto load widget elements
    */
    class Nss_Locator_Finder_AutoLoader {
        public static $instance = null;
        public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
            return self::$instance;
        }
        public function init() { 
            //add_action('init', array($this, 'location_finder_public_inc_file'));
          
            //assets
            add_action( 'wp_enqueue_scripts', array($this, 'location_finder_enqueue_styles' ) );
            add_action( 'wp_enqueue_scripts', array($this, 'location_finder_enqueue_scripts') );
            
            
            //shortcode
            add_shortcode( 'locator_finder_shortcode', array($this, 'locator_finder_shortcode_func') );
             
            //post count ajax
            add_action('wp_ajax_nopriv_nss_post_count_ajax_action', array($this, 'nss_post_count_ajax_function_callback')); 
            add_action('wp_ajax_nss_post_count_ajax_action', array($this, 'nss_post_count_ajax_function_callback'));
            
            //post division wise title ajax
            add_action('wp_ajax_nopriv_nss_division_post_title_ajax_action', array($this, 'nss_get_division_wise_post_title_ajax_function_callback')); 
            add_action('wp_ajax_nss_division_post_title_ajax_action', array($this, 'nss_get_division_wise_post_title_ajax_function_callback'));

           //ajax
            add_action('wp_ajax_nopriv_locator_ajax_action',  array($this, 'locator_data_pagination_ajax_function_callback')); 
            add_action('wp_ajax_locator_ajax_action',  array($this, 'locator_data_pagination_ajax_function_callback'));
        }
       
        //styel
        public function location_finder_enqueue_styles() { 
            wp_enqueue_style( 'nss-location-finder-stylesheet', plugin_dir_url( __FILE__ ) . 'css/nss-location-finder-stylesheet.css', array(), '1.1.1', 'all' ); 
            wp_enqueue_style('location-finder-pagination-script');
        }

        //assets
        public function location_finder_enqueue_scripts() { 
            wp_register_script('location-finder-pagination-script', plugin_dir_url( __FILE__ ) . 'js/pagination.js', array( 'jquery' ), '1.1.1', false );   
            wp_enqueue_script('location-finder-pagination-script');
            wp_register_script('location-finder-script', plugin_dir_url( __FILE__ ) . 'js/location-finder.js', array( 'jquery' ), '1.1.1', false );        
            wp_enqueue_script('location-finder-script');
            wp_localize_script('location-finder-script', 'location_finder_filter', array('ajax_url' => admin_url('admin-ajax.php'))); 
        } 

        //public shortcode
        public function locator_finder_shortcode_func( ) {  
            ob_start();
            require plugin_dir_path( __FILE__ ) . '/partials/location-finder-public-display.php';    
            return ob_get_clean();
        } 

        //total post count 
        //ajax data
        public function nss_post_count_ajax_function_callback(){  
          $activeCategory =  $_REQUEST['activeCategory']; 
          //for pagination
          //for data 
           $total_post_args = array(
              'post_type' => 'nss-locator',
              'posts_per_page' => 300,
              'tax_query' => array(
                 'relation' => 'OR',
                 array(
                    'taxonomy' => 'nss-division',
                    'field'    => 'term_id',
                    'terms'    => $activeCategory,
                 )
              ),
           );

           $total_post_args_query = new WP_Query( $total_post_args);
           $post_count =  $total_post_args_query->post_count;   
           echo $post_count; 
           die();
        }

        //division wise district thana
        //ajax data
        public function nss_get_division_wise_post_title_ajax_function_callback(){   
          $activeCategory =  $_REQUEST['activeCategory']; 
          $categories = get_categories(array( 'taxonomy' => 'nss-division', 'parent' => $activeCategory, 'orderby'=> 'title', 'order'=> 'ASC', )); 
          $total_count = sizeof($categories); 
          if($total_count > 0){ 
              foreach($categories as $cat){
                  echo '<option value="'.$cat->term_id.'">' .$cat->cat_name. '</option>';   
              }
          }else{
             echo '<option>No data found</option>';   
          }         
        die(); 
        }

    //onload data for locator  ajax data
    //ajax add action 
     public function locator_data_pagination_ajax_function_callback(){   
 
        $activeCategory =  $_REQUEST['activeCategory']; 
        $page = $_REQUEST['page'];   
        global $post;
          //for data 
           $args = array(
              'post_type' => 'nss-locator',
              'posts_per_page' => 9,
              'paged' => $page, 
              'tax_query' => array(
                 'relation' => 'OR',
                 array(
                    'taxonomy' => 'nss-division',
                    'field'    => 'term_id',
                    'terms'    => $activeCategory,
                 )
              ),
           );          

        $pagination_query = new WP_Query( $args);
        if( $pagination_query->have_posts() ) {
           $i = 1;
           while( $pagination_query->have_posts() ) { 
              $pagination_query->the_post(); 
              $img_src = [];
              $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
              if(!is_null($image)) {
                  $img_src = $image[0];
              }
              ?> 
              <div class="crownct_location_locator_post_wrap">
                <div class="crownct_location_locator_post">
                     <div class="nss_post_img">
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/logo.svg" alt="<?php the_title();?>"> 
                        <img src="<?php echo get_template_directory_uri();?>/assets/images/1_number.png" alt="<?php the_title();?>"> 
                     </div> 
                     <div class="post_details"> 
                      <a href="javascript:void(0);" title="<?php the_title();?>">Name: <?php the_title(); ?></a>
                      
                        <?php if(!empty(CFS()->get( 'locator_phone' ))){ ?>
                        <p>Phone: <?php echo CFS()->get( 'locator_phone' ); ?></p>
                        <?php } ?> 
                     </div> 
               
                    <div class="crown_card_red_border"></div> 
                  </div>
                </div> 
              <?php
            //if($i== $per_page) break; $i++;
            wp_reset_postdata();
            }
        }else{
           echo 'No data founds..';
        } 
        die(); 
        }
    }
    Nss_Locator_Finder_AutoLoader::instance()->init();