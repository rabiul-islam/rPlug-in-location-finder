<?php
//service category image
add_action( 'transactions_sectors_add_form_fields', 'lnk_add_category_image_sectors', 10, 2 );
function lnk_add_category_image_sectors ( $taxonomy ) {
?>
    <div class="form-field term-group">

        <label for="sectors_image_id"><?php _e('Image', 'taxt-domain'); ?></label>
        <input type="hidden" id="sectors_image_id" name="sectors_image_id" class="custom_media_url" value="">

        <div id="image_wrapper"></div>

        <p>
            <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e( 'Add Image', 'taxt-domain' ); ?>">
            <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e( 'Remove Image', 'taxt-domain' ); ?>">
        </p>

    </div>
<?php
}
//save image
add_action( 'created_transactions_sectors', 'save_category_image_sectors', 10, 2 );
function save_category_image_sectors ( $term_id, $tt_id ) {
    if( isset( $_POST['sectors_image_id'] ) && '' !== $_POST['sectors_image_id'] ){
     $image = $_POST['sectors_image_id'];
     add_term_meta( $term_id, 'category_sectors_image_id', $image, true );
    }
}
//update
add_action( 'transactions_sectors_edit_form_fields', 'update_category_image_sectors', 10, 2 );
function update_category_image_sectors ( $term, $taxonomy ) { ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="sectors_image_id"><?php _e( 'Image', 'taxt-domain' ); ?></label>
        </th>
        <td>

            <?php $sectors_image_id = get_term_meta ( $term -> term_id, 'sectors_image_id', true ); ?>
            <input type="hidden" id="sectors_image_id" name="sectors_image_id" value="<?php echo $sectors_image_id; ?>">

            <div id="image_wrapper">
            <?php if ( $sectors_image_id ) { ?>
               <?php echo wp_get_attachment_image ( $sectors_image_id, 'thumbnail' ); ?>
            <?php } ?>

            </div>

            <p>
                <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e( 'Add Image', 'taxt-domain' ); ?>">
                <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e( 'Remove Image', 'taxt-domain' ); ?>">
            </p>

        </div></td>
    </tr>
<?php
}
add_action( 'edited_transactions_sectors', 'updated_category_image_sectors', 10, 2 );
function updated_category_image_sectors ( $term_id, $tt_id ) {
    if( isset( $_POST['sectors_image_id'] ) && '' !== $_POST['sectors_image_id'] ){
        $image = $_POST['sectors_image_id'];
        update_term_meta ( $term_id, 'sectors_image_id', $image );
    } else {
        update_term_meta ( $term_id, 'sectors_image_id', '' );
    }
}
add_action( 'admin_enqueue_scripts', 'load_media_sectors' );
function load_media_sectors() {
    wp_enqueue_media();
}
add_action( 'admin_footer', 'add_custom_script_sectors' );
function add_custom_script_sectors() {
    ?> <script>jQuery(document).ready( function($) {
            function taxonomy_media_upload(button_class) {
                var custom_media = true,
                original_attachment = wp.media.editor.send.attachment;
                $('body').on('click', button_class, function(e) {
                    var button_id = '#'+$(this).attr('id');
                    var send_attachment = wp.media.editor.send.attachment;
                    var button = $(button_id);
                    custom_media = true;
                    wp.media.editor.send.attachment = function(props, attachment){
                        if ( custom_media ) {
                            $('#sectors_image_id').val(attachment.id);
                            $('#image_wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                            $('#image_wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
                        } else {
                            return original_attachment.apply( button_id, [props, attachment] );
                        }
                    }
                    wp.media.editor.open(button);
                    return false;
                });
            }
            taxonomy_media_upload('.taxonomy_media_button.button'); 
            $('body').on('click','.taxonomy_media_remove',function(){
                $('#sectors_image_id').val('');
                $('#image_wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });

            $(document).ajaxComplete(function(event, xhr, settings) {
                var queryStringArr = settings.data.split('&');
                if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
                    var xml = xhr.responseXML;
                    $response = $(xml).find('term_id').text();
                    if($response!=""){
                        $('#image_wrapper').html('');
                    }
                }
            });
        });</script> <?php 
}

add_filter( 'manage_edit-category_columns', 'display_image_column_heading_sectors' ); 
function display_image_column_heading_sectors( $columns ) {
    $columns['category_image'] = __( 'Image', 'taxt-domain' );
    return $columns;
}

add_action( 'manage_category_custom_column', 'display_image_column_value_sectors' , 10, 3); 
function display_image_column_value_sectors( $columns, $column, $id ) {
    if ( 'category_image' == $column ) {
    	$sectors_image_id = esc_html( get_term_meta($id, 'sectors_image_id', true) );
    	
        $columns = wp_get_attachment_image ( $sectors_image_id, array('50', '50') );
    }
    return $columns;
}