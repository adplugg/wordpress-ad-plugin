<?php
/**
 * Class to create the adplugg widget.
 *
 * @package AdPlugg
 * @since 1.0
 */

/**
 * AdPlugg_Widget class.
 */
class AdPlugg_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'adplugg',
			'description' => 'A widget for displaying ads.',
		);
		parent::__construct(
			'adplugg',
			'AdPlugg',
			$widget_options
		);
	}

	/**
	 * Widget form creation. Displays the form in the widget admin.
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {

		// Check values.
		$title   = ( ( $instance ) && ( isset( $instance['title'] ) ) )
					? $instance['title'] : '';
		$zone    = ( ( $instance ) && ( isset( $instance['zone'] ) ) )
					? $instance['zone'] : '';
		$width   = ( ( $instance ) && ( isset( $instance['width'] ) ) )
					? $instance['width'] : '';
		$height  = ( ( $instance ) && ( isset( $instance['height'] ) ) )
					? $instance['height'] : '';
		$default = ( ( $instance ) && ( isset( $instance['default'] ) ) )
					? $instance['default'] : 0;

		// This is used below to set the title of the widget that is displayed
		// within the admin. It is passed to widgets.js based on the '-title' id
		// suffix.
		$widget_title = ( '' !== $zone ) ? $zone : '';

		// Render the form.
		// Note: we always render all fields but sometimes hide certain fields
		// via css (admin.css) if they aren't relevant to the widget area.
		?>
			<p>
				<a href="https://www.adplugg.com?utm_source=wpplugin&utm_campaign=widget-l1" target="_blank" title="Configure at adplugg.com">Configure at adplugg.com</a>
				|
				<a href="#" onclick="jQuery( '#contextual-help-link' ).trigger( 'click' ); return false;" title="Help">Help</a>
			</p>
			<fieldset class="adplugg-widget-fieldset">
				<legend class="adplugg-widget-optional-legend">Optional Settings</legend>
				<legend class="adplugg-widget-legend">Settings</legend>
				<?php // ------ title ------ ?>
				<div class="adplugg-widget-field-title">
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>'">Title:</label>
					<input type="hidden" id="widget-title" value="<?php echo esc_attr( $widget_title ); ?>">
					<?php echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '" />'; ?>
					<small>Enter a title for the widget.</small><br/>
				</div>
				<?php // ------ zone ------ ?>
				<div class="adplugg-widget-field-zone">
					<label for="<?php echo esc_attr( $this->get_field_id( 'zone' ) ); ?>">Zone:</label>
					<?php echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'zone' ) ) . '" name="' . esc_attr( $this->get_field_name( 'zone' ) ) . '" type="text" value="' . esc_attr( $zone ) . '" />'; ?>
					<small>Enter the zone machine name.</small><br/>
				</div>
				<?php // ------ width ------ ?>
				<div class="adplugg-widget-field-width">
					<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>">Width:</label>
					<?php echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'width' ) ) . '" name="' . esc_attr( $this->get_field_name( 'width' ) ) . '" type="text" value="' . esc_attr( $width ) . '" />'; ?>
					<small>Enter the width.</small><br/>
				</div>
				<?php // ------ height ------ ?>
				<div class="adplugg-widget-field-height">
					<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">Height:</label>
					<?php echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'height' ) ) . '" name="' . esc_attr( $this->get_field_name( 'height' ) ) . '" type="text" value="' . esc_attr( $height ) . '" />'; ?>
					<small>Enter the height.</small><br/>
				</div>
				<?php // ------ default ------ ?>
				<div class="adplugg-widget-field-default">
					<label for="<?php echo esc_attr( $this->get_field_id( 'default' ) ); ?>">
						<?php echo '<input type="checkbox" id="' . esc_attr( $this->get_field_id( 'default' ) ) . '" name="' . esc_attr( $this->get_field_name( 'default' ) ) . '" value="1" ' . checked( 1, $default, false ) . '" />'; ?>
						Default
					</label><br/>
					<small>Check to make this zone the default.</small><br/>
				</div>
		<?php
	}

	/**
	 * Widget update. Called when widget admin form is submitted.
	 *
	 * @param array $new_instance An array containing the new widget values.
	 * @param array $old_instance An array containing the old widget values.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['zone']   = sanitize_key( $new_instance['zone'] );
		$instance['width']  = sanitize_key( $new_instance['width'] );
		$instance['height'] = sanitize_key( $new_instance['height'] );

		$default             = ( ( isset( $new_instance['default'] ) ) && ( 1 === intval( $new_instance['default'] ) ) ) ? 1 : 0;
		$instance['default'] = $default;

		return $instance;
	}

	/**
	 * Widget frontend display.
	 *
	 * @param array $args An array of widget arguments.
	 * @param array $instance An array of our widget values.
	 */
	public function widget( $args, $instance ) {

		// ------ Set up the variables --- //
		$title          = ( isset( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : null;
		$zone           = ( isset( $instance['zone'] ) ) ? $instance['zone'] : null;
		$zone_attribute = ( $zone ) ? ' data-adplugg-zone="' . esc_attr( $zone ) . '"' : '';
		$width          = ( isset( $instance['width'] ) ) ? $instance['width'] : 300;
		$height         = ( isset( $instance['height'] ) ) ? $instance['height'] : 250;
		$default        = ( ( isset( $instance['default'] ) ) && ( 1 === intval( $instance['default'] ) ) ) ? 1 : 0;

		// ------ Render the Widget ------ //
		if ( ( isset( $args['id'] ) ) && ( 'facebook_ia_header_ads' === $args['id'] ) ) {
			if ( AdPlugg_Options::is_access_code_installed() ) {
				// ------------- FACEBOOK INSTANT ARTICLES FEED ----------//
				// Configure variables.
				$post_url      = $GLOBALS['adplugg_fbia_canonical_url'];
				$host          = rawurlencode( wp_parse_url( $post_url, PHP_URL_HOST ) );
				$path          = rawurlencode( wp_parse_url( $post_url, PHP_URL_PATH ) );
				$zone_param    = ( isset( $zone ) ) ? '&zn=' . rawurlencode( $zone ) : '';
				$iframe_src    = 'http://' . ADPLUGG_ADHTMLSERVER . '/serve/' . AdPlugg_Options::get_active_access_code() . '/html/1.1/index.html?hn=' . $host . '&bu=' . $path . $zone_param;
				$default_class = ( $default ) ? ' op-ad-default' : '';

				// Output ad tags.
				echo '<figure class=\"op-ad' . esc_attr( $default_class ) . "\">\n";
				echo '<iframe src="' . esc_attr( $iframe_src ) . '" height="' . esc_attr( $height ) . '" width="' . esc_attr( $width ) . '"></iframe>' . "\n";
				echo "</figure>\n";
			}
		} else {
			// --------------------- NORMAL OUTPUT -------------------//
			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			// Render the title (if there is one).
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}

			// Add the AdPlugg tag.
			echo '<div class="adplugg-tag"' . $zone_attribute . '></div>'; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

	}

}
