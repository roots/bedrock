<?php
/**
 * EasySocialShareButtons Hook
 * @version 1.0
 * @author appscreo
 */
add_filter( 'mycred_setup_hooks', 'register_essb_hook_in_mycred' );

function register_essb_hook_in_mycred( $installed ) {

	$installed['essb'] = array(
			'title'       => __( 'Points for click on share buttons via the Easy Social Share Buttons for WordPress plugin', 'essb' ),
			'description' => __( 'This hook awards / deducts points for click on share buttons via the Easy Social Share Buttons for WordPress plugin.', 'essb' ),
			'callback'    => array( 'myCRED_Hook_ESSB' )
	);
	return $installed;

}

if ( class_exists( 'myCRED_Hook' ) ) :
class myCRED_Hook_ESSB extends myCRED_Hook {

	/**
	 * Construct
	 */
	function __construct( $hook_prefs, $type = 'mycred_default' ) {
		parent::__construct( array(
				'id'       => 'essb',
				'defaults' => array(
						'creds'  => 1,
						'log'    => '%plural% for click on share button: %service%, %link_title%',
						'limit'  => 0
				)
		), $hook_prefs, $type );
		
		add_filter('mycred_all_references', array($this, 'add_reference'), 10, 1);
	}

	public function add_reference($references) {
		$references['essb_clicks'] = __('Social Sharing (Easy Social Share Buttons)', 'essb');
		return $references;
	}
	
	public function run() {

		add_action( 'essb_after_sharebutton_click', array($this, 'click_on_share_button'));
		add_filter( 'mycred_parse_tags_sharebutton',      array( $this, 'parse_custom_tags' ), 10, 2 );

	}

	public function parse_custom_tags( $content, $log_entry ) {
	
		$data = maybe_unserialize( $log_entry->data );
		$content = str_replace( '%url%', $data['link_url'], $content );
		$content = str_replace( '%id%',  $data['link_id'], $content );
		if ( isset( $data['link_title'] ) ) {
			$content = str_replace( '%title%',  $data['link_title'], $content );
			$content = str_replace( '%link_title%',  '<a href="'.$data['link_url'].'" target="_blank">'.$data['link_title'].'</a>', $content );
		}
		if ( isset( $data['link_service'] ) )
			$content = str_replace( '%service%',  '<b>'.$data['link_service'].'</b>', $content );
	
		return $content;
	
	}
	/**
	 * New View Ajax
	 * @since 1.0
	 * @version 1.0
	 */
	public function click_on_share_button() {

		$post_id = intval( $_REQUEST['post_id'] );
		$service = isset($_REQUEST['service']) ? $_REQUEST['service'] : '';

		$post = get_post( $post_id );
		if ( isset( $post->ID ) )
			$this->process_click( $post, $service );

	}

	/**
	 * Process View
	 * @since 1.0
	 * @version 1.0
	 */
	protected function process_click( $post, $service = '' ) {

		// Check for exclusions
		$user_id = get_current_user_id();
		
		//if ( $this->core->exclude_user( $post->post_author ) ) return;

		$data = array(
				'ref_type'   => 'sharebutton',
				'link_url'   => get_permalink($post->ID),
				'link_id'    => $post->ID,
				'link_title' => $post->post_title,
				'link_service' => $service
		);
		// Payout if not over limit
		if ( ! $this->over_hook_limit( '', 'essb_clicks', $user_id ) )
			$this->core->add_creds(
					'essb_clicks',
					$user_id,
					$this->prefs['creds'],
					$this->prefs['log'],
					$post->ID,
					$data,
					$this->mycred_type
			);

	}

	/**
	 * Preference for this Hook
	 * @since 1.0
	 * @version 1.0
	 */
	public function preferences() {

		$prefs = $this->prefs;

		?>
<label class="subheader" for="<?php echo $this->field_id( 'creds' ); ?>"><?php _e( 'Points', 'essb' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( 'creds' ); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo $this->core->format_number( $prefs['creds'] ); ?>" size="8" /></div>
	</li>
	<li>
		<label for="<?php echo $this->field_id( 'limit' ); ?>"><?php _e( 'Limit', 'essb' ); ?></label>
		<?php echo $this->hook_limit_setting( $this->field_name( 'limit' ), $this->field_id( 'limit' ), $prefs['limit'] ); ?>
	</li>
	<li class="empty">&nbsp;</li>
	<li>
		<label for="<?php echo $this->field_id( 'log' ); ?>"><?php _e( 'Log template', 'essb' ); ?></label>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( 'log' ); ?>" id="<?php echo $this->field_id( 'log' ); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="long" /></div>
		<span class="description">Available template tags: %url% (url of post), %id% (post ID), %title% (post title), %service% (service), %link_title% (post title with assigned link)</span>
	</li>
</ol>
<?php

		}

		/**
		 * Sanitise Preferences
		 * @since 1.0
		 * @version 1.0
		 */
		public function sanitise_preferences( $data ) {

			if ( isset( $data['limit'] ) && isset( $data['limit_by'] ) ) {
				$limit = sanitize_text_field( $data['limit'] );
				if ( $limit == '' ) $limit = 0;
				$data['limit'] = $limit . '/' . $data['limit_by'];
				unset( $data['limit_by'] );
			}

			return $data;

		}

	}
endif;