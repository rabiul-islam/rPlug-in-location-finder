 
    <div class="nss_location_finder_wrapper" > 
       <div class="nss_location_finder_filter_panel">
                <div class="nss_select_warp">
                <select class="nss_division">
                    <option>Division</option>
                 <?php
                 global $cat;
                 $cat_args=array( 
                 'taxonomy' => 'nss-division',
                 'parent' => 0, 
                 //'include_children' => false,
                 'hierarchical' => 0, 
                 'orderby' =>  'menu_order', 
                 'order' => 'ASC'
                 );
                 $categories = get_categories($cat_args); 
                 foreach ($categories as $key=>$category) { if($key == 0) { $default_cat_id = $category->term_id; } ?>  
                   <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option> 
                 <?php } ?>  
               </select> 
            </div>
            <div class="nss_select_warp">
               <div class="align-items-center spinner">   
                     <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
               </div>
               <select class="nss_district">
                 <option>District </option> 
              </select>
            </div>
            <div class="nss_select_warp">
               <div class="align-items-center spinner">   
                     <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
               </div>
               <select class="nss_thana">
                 <option>Thana/Upazila</option> 
              </select>
            </div> 
    
       </div> 
       
          <?php 
          //total count
          $args = array(      
              'post_type' => 'nss-locator',
              'post_status' => 'publish',  
              'order' => 'ASC', 
              'posts_per_page' => 300, 
                'tax_query' => array(
                 array(
                    'taxonomy' => 'nss-division',
                    'field'    => 'term_id',
                    'terms'    => $default_cat_id,
                 )
                ),
          ); 
          $post = new WP_Query($args); 
          $post_count = $post->post_count;//pagination 1 post hide  
          ?> 
          <div class="containers" data-ref="containers">
             <div class="row data-container" id="results"></div>    
          </div> 
          <div id="location-finder-pagination-list" class="pagination"></div> <!--pagination Elements close--> 
       
       </div><!--wrap-->
   
    
    <script type="text/javascript">
    
     //onload data
     // categoryWisePaginationFunc(<?php echo $post_count.', '.$default_cat_id; ?>); 
    
    function categoryWisePaginationFunc(post_count, activeCategory){  
        var container = jQuery('#location-finder-pagination-list');
        //var activeCategory = jQuery('.nss_location_finder_filter_panel select').val(); 
    
            var sources = function () {
            var result = [];  
            for (var i = 1; i < post_count ; i++) {
            result.push(i);
            } 
            return result;
        }();
    
        var options = { 
            pageSize: 9, 
            dataSource: sources,
                callback: function (response, pagination) { 
                var page = jQuery('.active').attr('data-num'); 
               if (typeof page === "undefined") {
              
                var page = 1;
               }
                //  alert(page);
                jQuery.ajax({ 
                    url: location_finder_filter.ajax_url,   
                    type: "POST", 
                    data: {
                        action:"locator_ajax_action",
                        activeCategory: activeCategory,
                        page:page, 
                    },
                    success: function(response){ 
                         //pagination data onload 
                         //console.log(response);
                         container.prev().html(response); 
                         //jQuery('#results').html(response);
                    },error: function(errorThrown){
                        //console.log(errorThrown);
                    } 
                });
    
            }
        };
    
        jQuery.pagination(container, options); 
        container.addHook('beforeInit', function () {
          window.console && console.log('beforeInit...');
        });
        container.pagination(options);
    
        container.addHook('beforePageOnClick', function () {
          window.console && console.log('beforePageOnClick...');
          //return false
        }); 
    } 
    
    //district
    jQuery('.nss_location_finder_filter_panel .nss_division').on('change',function(){ 
         
        var activeCategory = jQuery(this).val(); 
        //ajax value 
        jQuery.ajax({ 
        url: location_finder_filter.ajax_url,   
        type: "POST", 
        data: {
            action:"nss_division_post_title_ajax_action",
            activeCategory: activeCategory,
        },
        beforeSend: function(){ 
         jQuery(".spinner").show();  
        },
        success: function(response){  
           jQuery(".spinner").hide();  
           jQuery('.nss_district').html(response);   
           jQuery('.containers').html("");   
           jQuery('.nss_thana').html("");  
           jQuery('.nss_district').prepend("<option selected='selected'>District/Zila</option>");
           jQuery('.nss_thana').prepend("<option selected='selected'>Thana/Upazila</option>"); 
        } 
       }); 
      });
    
    //thana
    jQuery('.nss_location_finder_filter_panel .nss_district').on('change',function(){  
        var activeCategory = jQuery(this).val();  
        //ajax value 
        jQuery.ajax({ 
        url: location_finder_filter.ajax_url,   
        type: "POST", 
        data: {
            action:"nss_division_post_title_ajax_action",
            activeCategory: activeCategory,
        },
        beforeSend: function(){ 
         jQuery(".spinner").show();  
        }, 
        success: function(response){
            jQuery(".spinner").hide(); 
            //console.log(response);  
           jQuery('.nss_thana').html(response);  
           jQuery('.nss_thana').prepend("<option selected='selected'>Thana/Upazila</option>");   
        } 
       }); 
     });
     
     
     
    //select on change
    jQuery('.nss_location_finder_filter_panel select.nss_thana').on('change',function(){ 
        var activeCategory = jQuery(this).val();  
        jQuery.ajax({ 
        url: location_finder_filter.ajax_url,   
        type: "POST", 
        data: {
            action:"nss_post_count_ajax_action",
            activeCategory: activeCategory,
        }, 
        success: function(response){    
           // console.log(response);  
           categoryWisePaginationFunc(response, activeCategory);//paginate data func
        } 
       }); 
    
    });   
     
    
     </script>