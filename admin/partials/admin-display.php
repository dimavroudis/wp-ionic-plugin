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

$this->save_settings();

$settings = $this->get_settings();

?>

<form action="<?php echo esc_attr(str_replace('%7E', '~', $_SERVER['REQUEST_URI'])); ?>" method="post">

	<h1><?php esc_html_e('WP Ionic', 'wp-ionic'); ?></h1>

	<fieldset>
		<h2 class="title">
			<?php esc_html_e('Home Tab', 'wp-ionic'); ?>
		</h2>

		<div class="form-group">
			<label for="description">
				<?php esc_html_e('Intro Text', 'wp-ionic'); ?>
			</label>
			<textarea row="6" name="description" id="description"><?php echo isset($settings['description']) ? esc_textarea($settings['description']) : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="featured_posts">
				<?php esc_html_e('Select featured posts', 'wp-ionic'); ?>
				<span class="label-details">
					<?php esc_html_e('Featured post will be presented under the intro text as a slider', 'wp-ionic'); ?>
				</span>
			</label>

			<select title="<?php esc_attr_e('Select pages for featured slider', 'wp-ionic'); ?>" data-placeholder="<?php esc_attr_e('Start typing the title of a post', 'wp-ionic'); ?>" name="featured_posts[]" class="select2" id="featured_posts" multiple>

				<?php
				$posts = get_posts(
					array(
						'numberposts' => -1,
					)
				);
				if (isset($settings['featured_posts'])) {
					foreach ($posts as $post) {
						$selected = '';
						if (count($settings['featured_posts']) > 0) {
							foreach ($settings['featured_posts'] as $selected_post) {
								if ($selected_post == $post->ID) {
									$selected = 'selected';
								}
							}
						}
					}
				?>
					<option value="<?php echo esc_attr($post->ID); ?>" <?php echo esc_attr($selected); ?>>
						<?php echo esc_html($post->post_title); ?>
					</option>
				<?php } ?>

			</select>
		</div>

	</fieldset>
	<fieldset>

		<h2 class="title">
			<?php esc_html_e('More Tab', 'wp-ionic'); ?>
		</h2>
		<div class="form-group">
			<label for="featured_pages">
				<?php esc_html_e('Select featured pages', 'wp-ionic'); ?>
				<span class="label-details">
					<?php esc_html_e('Featured pages will be presented in the more tab and will open inside the app', 'wp-ionic'); ?>
				</span>
			</label>

			<select title="<?php esc_attr_e('Select pages for "More" tab', 'wp-ionic'); ?>" data-placeholder="<?php esc_attr_e('Start typing the title of a page', 'wp-ionic'); ?>" name="featured_pages[]" class="select2" id="featured_pages" multiple>

				<?php
				$pages = get_pages();
				foreach ($pages as $page) {
					$selected = '';
					if (count($settings['featured_pages']) > 0) {
						foreach ($settings['featured_pages'] as $selected_page) {
							if ($selected_page == $page->ID) {
								$selected = 'selected';
							}
						}
					}
				?>
					<option value="<?php echo esc_attr($page->ID); ?>" <?php echo esc_attr($selected); ?>>
						<?php echo esc_html($page->post_title); ?>
					</option>
				<?php } ?>

			</select>
		</div>

		<h3 class="label">
			<?php esc_html_e('Add your social media accounts', 'wp-ionic'); ?>
		</h3>
		<div class="form-group">
			<span class="label-details">
				<?php _e('Choose your icon from <a href="https://ionicons.com/" target="_blank">ionicons.com</a>. Clink the icon you want and copy the name from the <i>WEB COMPONENT CODE</i>. For example, for facebook the <i>WEB COMPONENT CODE</i> is <code>&lt;ion-icon name=&quot;logo-facebook&quot;&gt;&lt;/ion-icon&gt;</code> and the name is <code>logo-facebook</code>. ', 'wp-ionic'); ?>
			</span>
			<div class="repeater" data-name="more_link">
				<?php
				foreach ($settings['links'] as $key => $value) :
					$keys[] = $key;
				?>
					<div class="repeater-group" id="'more_link_<?php echo esc_attr($key); ?>" data-index="<?php echo esc_attr($key); ?>">
						<button type="button" id="remove_more_link_<?php echo esc_attr($key); ?>" class="remove_repeater_group"><?php esc_html_e('Remove link', 'wp-ionic'); ?></button>
						<div class="repeater-input">
							<label for="more_link_<?php echo esc_attr($key); ?>_label"><?php esc_html_e('Link Label', 'wp-ionic'); ?></label>
							<input type="text" name="more_link_<?php echo esc_attr($key); ?>_label" id="more_link_<?php echo esc_attr($key); ?>_label" value="<?php echo esc_attr($value['label']); ?>" required />
						</div>
						<div class="repeater-input">
							<label for="more_link_<?php echo esc_attr($key); ?>_icon">
								<?php esc_html_e('Link Icon', 'wp-ionic'); ?>
							</label>
							<input type="text" name="more_link_<?php echo esc_attr($key); ?>_icon" id="more_link_<?php echo esc_attr($key); ?>_icon" value="<?php echo esc_attr($value['icon']); ?>" required />
						</div>
						<div class="repeater-input">
							<label for="more_link_<?php echo esc_attr($key); ?>_url"><?php esc_html_e('Link Url', 'wp-ionic'); ?></label>
							<input type="url" name="more_link_<?php echo esc_attr($key); ?>_url" id="more_link_<?php echo esc_attr($key); ?>_url" value="<?php echo esc_attr($value['url']); ?>" required />
						</div>
					</div>
				<?php endforeach; ?>
				<button type="button" id="add_more_link" class="button add_repeater_group"><?php esc_html_e('Add link', 'wp-ionic'); ?></button>
				<input type="hidden" class="repeater-count" name="more_link" value="<?php echo esc_attr(isset($keys) ? implode(',', $keys) : ''); ?>" />
			</div>

		</div>

	</fieldset>

	<fieldset>

		<h2 class="title">
			<?php esc_html_e('News Tab', 'wp-ionic'); ?>
		</h2>
		<div class="form-group">
			<label for="featured_categories">
				<?php esc_html_e('Featured Categories', 'wp-ionic'); ?>
				<span class="label-details">
					<?php esc_html_e('Leave empty if you want to display all the none-empty categories.', 'wp-ionic'); ?>
				</span>
			</label>

			<select title="<?php esc_attr_e('Select categories for "News" tab', 'wp-ionic'); ?>" data-placeholder="<?php esc_attr_e('Start typing the name of a category', 'wp-ionic'); ?>" name="featured_categories[]" class="select2" id="featured_categories" multiple>

				<?php
				$categories = get_terms(array(
					'taxonomy' => 'category',
				));
				foreach ($categories as $category) {
					$selected = '';
					if (count($settings['featured_categories']) > 0) {
						foreach ($settings['featured_categories'] as $selected_category) {
							if ($selected_category == $category->term_id) {
								$selected = 'selected';
							}
						}
					}
				?>
					<option value="<?php echo esc_attr($category->term_id); ?>" <?php echo esc_attr($selected); ?>>
						<?php echo esc_html($category->name); ?>
					</option>
				<?php } ?>

			</select>
		</div>

	</fieldset>

	<fieldset>
		<h2 class="title">
			<?php esc_html_e('Comments', 'wp-ionic'); ?>
		</h2>
		<div class="form-group">
			<label for="comments">
				<input name="comments" id="comments" type="checkbox" value="enabled" <?php echo 'enabled' === $settings['comments'] ? 'checked' : ''; ?>>
				<?php esc_html_e('Enable anonymous Comments', 'wp-ionic'); ?>
			</label>
		</div>
	</fieldset>

	<?php wp_nonce_field('wp_ionic_submitSettings', 'nonce_wp_ionic_submitSettings'); ?>

	<div class="form-group">
		<button type="submit" name="submitSettings" id="submit" class="button button-primary"><?php esc_html_e('Update Settings', 'wp-ionic'); ?></button>
	</div>
</form>