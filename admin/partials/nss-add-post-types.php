<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://selise.ch/
 * @since      1.0.0
 *
 * @package    Lankabangla_Transactions
 * @subpackage Lankabangla_Transactions/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
<h1>Add/edit Post Types Settings</h1>

    <form method="post" action="#" novalidate="novalidate">
        <div class="main">
            <thead>
                <tr>
                    <th><a href="admin.php?page=nss-location-finder-settings">Add/Edit Post Types</a></th>
                    <th><a href="admin.php?page=nss-location-finder-settings">Add/Edit Taxonomy</a></th>
                </tr>
            </thead>
                <table class="form-table cptui-table">
                        <tbody>
                            <tr valign="top"><th scope="row"><label for="name">Post Type Slug</label> <span class="required">*</span></th><td><input type="text" id="name" name="nss_custom_post_type_name" value="" maxlength="20" aria-required="true" required="true"><br><p class="cptui-field-description description">The post type name/slug. Used for various queries for post type content.</p><p class="cptui-slug-details">Slugs should only contain alphanumeric, latin characters. Underscores should be used in place of spaces. Set "Custom Rewrite Slug" field to make slug use dashes for URLs.</p></td></tr>

                            <tr valign="top"><th scope="row"><label for="label">Plural Label</label> <span class="required">*</span></th><td><input type="text" id="label" name="nss_custom_post_type_plural_label" value="" aria-required="true" required="true" placeholder="(e.g. Movies)"><span class="visuallyhidden">(e.g. Movies)</span><br><p class="cptui-field-description description">Used for the post type admin menu item.</p></td></tr>

                            <tr valign="top"><th scope="row"><label for="singular_label">Singular Label</label> <span class="required">*</span></th><td><input type="text" id="singular_label" name="nss_custom_post_type_name_singular_label" value="" aria-required="true" required="true" placeholder="(e.g. Movie)"><span class="visuallyhidden">(e.g. Movie)</span><br><p class="cptui-field-description description">Used when a singular label is needed.</p></td>
                            </tr>                     
                        </tbody>
                    </table>                         
                </div>

        <p class="submit">
        <input type="submit" name="nss_add_post_types_submit" id="submit" class="button button-primary" value="Save Changes">
        </p>

    </form>

</div>