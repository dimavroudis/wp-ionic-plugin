<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mavrou.gr
 * @since      1.0.0
 *
 * @package    Wp_Ionic
 * @subpackage Wp_Ionic/admin/partials
 */

if ( isset( $_POST['nonce_wp_ionic_submitSettings'] ) && wp_verify_nonce( $_POST['nonce_wp_ionic_submitSettings'], 'wp_ionic_submitSettings' ) ) {

	$new_settings = array(
		'description' => isset( $_POST['introHomeTab'] ) ? $_POST['introHomeTab'] : '',
		'homeTab' => array(
			'featuredPosts' => isset( $_POST['featuredPosts'] ) ? $_POST['featuredPosts'] : [],
		),
		'moreTab' => array(
			'pages' => isset( $_POST['pagesMoreTab'] ) ? $_POST['pagesMoreTab'] : [],
		),
		'comments' => isset( $_POST['enableComments'] ) ? 'enabled' : 'disabled',
	);

	$updated = update_option( 'wp_ionic_settings',  wp_json_encode( $new_settings ) );
}


$_settings = json_decode( get_option( 'wp_ionic_settings' ) );

if ( $_settings ) {
	$settings = array(
		'description' => $_settings->description,
		'homeTab' => array(
			'featuredPosts' => $_settings->homeTab->featuredPosts,
		),
		'moreTab' => array(
			'pages' => $_settings->moreTab->pages,
		),
		'comments' => $_settings->comments,
	);
}

?>
<form action="<?php echo esc_attr( str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ) ); ?>" method="post">

	<h1><?php esc_html_e( 'WP Ionic', 'wp-ionic' ); ?></h1>

	<fieldset>
		<h2 class="title">
			<?php esc_html_e( 'Home Tab Content', 'wp-ionic' ); ?>
		</h2>
		<p>
			<?php esc_html_e( 'Home tab is the default page when somebody launches the app.', 'wp-ionic' ); ?>
		</p>

		<div class="form-group">
			<label for="introHomeTab">
				<?php esc_html_e( 'Into Text', 'wp-ionic' ); ?>
			</label>
			<textarea row="6" name="introHomeTab"
				id="introHomeTab"><?php echo esc_html( $settings['description'] ); ?></textarea>
		</div>
		<div class="form-group">
			<label for="featuredPosts">
				<?php esc_html_e( 'Select featured posts', 'wp-ionic' ); ?>
				<span class="label-details">
					<?php esc_html_e( 'Featured post will be presented under the into text as a slider', 'wp-ionic' ); ?>
				</span>
			</label>

			<select title="<?php esc_attr_e( 'Select pages for featured slider', 'wp-ionic' ); ?>"
				data-placeholder="<?php esc_attr_e( 'Start typing the title of a post', 'wp-ionic' ); ?>"
				name="featuredPosts[]" class="select2" id="featuredPosts" multiple>

				<?php
				$posts = get_posts(
					array(
						'numberposts' => -1,
					)
				);
				foreach ( $posts as $post ) {
					$selected = '';
					foreach ( $settings['homeTab']['featuredPosts'] as $selected_post ) {
						if ( $selected_post == $post->ID ) {
							$selected = 'selected';
						}
					}

					$option = '<option value="' . $post->ID . '" ' . $selected . '>';
					$option .= $post->post_title;
					$option .= '</option>';
					echo $option;
				}
				?>

			</select>
		</div>

	</fieldset>
	<fieldset>

		<h2 class="title">
			<?php esc_html_e( 'More Tab Content', 'wp-ionic' ); ?>
		</h2>
		<p>
			<?php esc_html_e( 'More Tab is the section of the app you can add list of pages like "About us", "Privacy Policy" etc.', 'wp-ionic' ); ?>
		</p>
		<div class="form-group">
			<label for="pagesMoreTab"><?php esc_html_e( 'Select pages for "More" tab', 'wp-ionic' ); ?></label>

			<select title="<?php esc_attr_e( 'Select pages for "More" tab', 'wp-ionic' ); ?>"
				data-placeholder="<?php esc_attr_e( 'Start typing the title of a page', 'wp-ionic' ); ?>"
				name="pagesMoreTab[]" class="select2" id="pagesMoreTab" multiple>

				<?php
				$pages = get_pages();
				foreach ( $pages as $page ) {
					$selected = '';
					foreach ( $settings['moreTab']['pages'] as $selected_page ) {
						if ( $selected_page == $page->ID ) {
							$selected = 'selected';
						}
					}
					$option = '<option value="' . $page->ID . '" ' . $selected . '>';
					$option .= $page->post_title;
					$option .= '</option>';
					echo $option;
				}
				?>

			</select>
		</div>

	</fieldset>
	<fieldset>
		<h2 class="title">
			<?php esc_html_e( 'Comments', 'wp-ionic' ); ?>
		</h2>
		<div class="form-group">
			<label for="enableComments">
				<input name="enableComments" id="enableComments" type="checkbox" value="enabled"
					<?php echo 'enabled' === $settings['comments'] ? 'checked' : ''; ?>>
				<?php esc_html_e( 'Enable anonymous Comments', 'wp-ionic' ); ?>
			</label>
		</div>
	</fieldset>

	<?php wp_nonce_field( 'wp_ionic_submitSettings', 'nonce_wp_ionic_submitSettings' ); ?>

	<div class="form-group">
		<button type="submit" name="submitSettings" id="submit"
			class="button button-primary"><?php esc_html_e( 'Update Settings', 'wp-ionic' ); ?></button>
	</div>
</form>
