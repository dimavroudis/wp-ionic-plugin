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

	$more_links = array();

	if ( isset( $_POST['more_link'] ) ) {
		$count_links = intval( $_POST['more_link'] );
		for ( $i = 0; $i < $count_links; $i++ ) {
			$index = $i + 1;
			$more_links[ $i ]['label'] = isset( $_POST[ 'more_link_' . $index . '_label' ] ) ? $_POST[ 'more_link_' . $index . '_label' ] : '';
			$more_links[ $i ]['url'] = isset( $_POST[ 'more_link_' . $index . '_url' ] ) ? $_POST[ 'more_link_' . $index . '_url' ] : '';
			$more_links[ $i ]['icon'] = isset( $_POST[ 'more_link_' . $index . '_icon' ] ) ? $_POST[ 'more_link_' . $index . '_icon' ] : '';
		}
	}

	$new_settings = array(
		'description' => isset( $_POST['introHomeTab'] ) ? $_POST['introHomeTab'] : '',
		'homeTab' => array(
			'featuredPosts' => isset( $_POST['featuredPosts'] ) ? $_POST['featuredPosts'] : [],
		),
		'archive' => array(
			'featuredCategories' => isset( $_POST['featuredCategories'] ) ? $_POST['featuredCategories'] : [],
		),
		'moreTab' => array(
			'pages' => isset( $_POST['pagesMoreTab'] ) ? $_POST['pagesMoreTab'] : [],
			'links' => $more_links,
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
		'archive' => array(
			'featuredCategories' => $_settings->archive->featuredCategories,
		),
		'moreTab' => array(
			'pages' => $_settings->moreTab->pages,
			'links' => $_settings->moreTab->links,
		),
		'comments' => $_settings->comments,
	);
}

?>
<form action="<?php echo esc_attr( str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ) ); ?>" method="post">

	<h1><?php esc_html_e( 'WP Ionic', 'wp-ionic' ); ?></h1>

	<fieldset>
		<h2 class="title">
			<?php esc_html_e( 'Home Tab', 'wp-ionic' ); ?>
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
					if ( count( $settings['homeTab']['featuredPosts'] ) > 0 ) {
						foreach ( $settings['homeTab']['featuredPosts'] as $selected_post ) {
							if ( $selected_post == $post->ID ) {
								$selected = 'selected';
							}
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
			<?php esc_html_e( 'More Tab Pages', 'wp-ionic' ); ?>
		</h2>
		<p>
			<?php esc_html_e( 'You can add pages to your app link Privacy and Policy, About Us etc, though the More tab.', 'wp-ionic' ); ?>
		</p>
		<div class="form-group">
			<label
				for="pagesMoreTab"><?php esc_html_e( 'Select pages that will be visible "More" tab', 'wp-ionic' ); ?></label>

			<select title="<?php esc_attr_e( 'Select pages for "More" tab', 'wp-ionic' ); ?>"
				data-placeholder="<?php esc_attr_e( 'Start typing the title of a page', 'wp-ionic' ); ?>"
				name="pagesMoreTab[]" class="select2" id="pagesMoreTab" multiple>

				<?php
				$pages = get_pages();
				foreach ( $pages as $page ) {
					$selected = '';
					if ( count( $settings['moreTab']['pages'] ) > 0 ) {
						foreach ( $settings['moreTab']['pages'] as $selected_page ) {
							if ( $selected_page == $page->ID ) {
								$selected = 'selected';
							}
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
			<?php esc_html_e( 'Social Media', 'wp-ionic' ); ?>
		</h2>
		<div class="form-group">
			<h3><?php esc_html_e( 'Select links that will be visible "More" tab', 'wp-ionic' ); ?></h3>
			<span class="label-details">
				<?php _e( 'Choose your icon from <a href="https://ionicons.com/">ionicons.com</a>. Clink the icon you want and copy the name from the <i>WEB COMPONENT CODE</i>. For example, for facebook <code>&lt;ion-icon name=&quot;logo-facebook&quot;&gt;&lt;/ion-icon&gt;</code> the name is <code>logo-facebook</code>. ', 'wp-ionic' ); ?>
			</span>
			<div class="repeater" data-name="more_link">
				<input type="hidden" class="repeater-count" name="more_link"
					value="<?php echo count( $settings['moreTab']['links'] ); ?>" />
				<?php foreach ( $settings['moreTab']['links'] as $key => $value ) : ?>
				<div class="repeater-group" id="more_link_<?php echo $key + 1; ?>">
					<button type="button" id="remove_more_link_<?php echo $key + 1; ?>"
						class="remove_repeater_group"><?php esc_html_e( 'Remove link', 'wp-ionic' ); ?></button>
					<div class="repeater-input">
						<label
							for="more_link_<?php echo $key + 1; ?>_label"><?php esc_html_e( 'Link Label', 'wp-ionic' ); ?></label>
						<input type="text" name="more_link_<?php echo $key + 1; ?>_label"
							value="<?php echo $value->label; ?>" required/>
					</div>
					<div class="repeater-input">
						<label
							for="more_link_<?php echo $key + 1; ?>_url"><?php esc_html_e( 'Link Url', 'wp-ionic' ); ?></label>
						<input type="url" name="more_link_<?php echo $key + 1; ?>_url" value="<?php echo $value->url; ?>" required/>
					</div>
					<div class="repeater-input">
						<label for="more_link_<?php echo $key + 1; ?>_icon">
							<?php esc_html_e( 'Link Icon', 'wp-ionic' ); ?>
						</label>
						<input type="text" name="more_link_<?php echo $key + 1; ?>_icon"
							value="<?php echo $value->icon; ?>" required/>
					</div>
				</div>
				<?php endforeach; ?>
				<button type="button" id="add_more_link"
					class="button button-primary add_repeater_group"><?php esc_html_e( 'Add link', 'wp-ionic' ); ?></button>
			</div>

		</div>

	</fieldset>

	<fieldset>

		<h2 class="title">
			<?php esc_html_e( 'News Tab', 'wp-ionic' ); ?>
		</h2>
		<div class="form-group">
			<label for="featuredCategories">
				<?php esc_html_e( 'Featured Categories', 'wp-ionic' ); ?>
				<span class="label-details">
					<?php esc_html_e( 'Leave empty if you want to display all the none-empty categories.', 'wp-ionic' ); ?>
				</span>
			</label>

			<select title="<?php esc_attr_e( 'Select categories for "News" tab', 'wp-ionic' ); ?>"
				data-placeholder="<?php esc_attr_e( 'Start typing the name of a category', 'wp-ionic' ); ?>"
				name="featuredCategories[]" class="select2" id="featuredCategories" multiple>

				<?php
				$categories = get_terms( array(
					'taxonomy' => 'category',
				) );
				foreach ( $categories as $category ) {
					$selected = '';
					if ( count( $settings['archive']['featuredCategories'] ) > 0 ) {
						foreach ( $settings['archive']['featuredCategories'] as $selected_category ) {
							if ( $selected_category == $category->term_id ) {
								$selected = 'selected';
							}
						}
					}
					$option = '<option value="' . $category->term_id . '" ' . $selected . '>';
					$option .= $category->name;
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
