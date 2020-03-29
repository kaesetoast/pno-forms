<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Pno_Forms
 * @subpackage Pno_Forms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pno_Forms
 * @subpackage Pno_Forms/admin
 * @author     Your Name <email@example.com>
 */
class Pno_Forms_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $pno_forms    The ID of this plugin.
	 */
	private $pno_forms;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $pno_forms       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pno_forms, $version ) {

		$this->pno_forms = $pno_forms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pno_Forms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pno_Forms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->pno_forms, plugin_dir_url( __FILE__ ) . 'css/pno-forms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pno_Forms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pno_Forms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->pno_forms, plugin_dir_url( __FILE__ ) . '../node_modules/vue/dist/vue.min.js', [], $this->version, false );
		wp_enqueue_script( $this->pno_forms . '-vue', plugin_dir_url( __FILE__ ) . 'js/pno-forms-admin.js', [], $this->version, false );

	}

	public function pno_forms_options() {
		?>
			<div id="pnoFormsOptions" class="wrap">
				<h1>PNO Forms Settings</h1>
				<form action="options.php" method="POST">
					<?php
					settings_fields('pno_forms_options');
					do_settings_sections('pno_forms_options');
					submit_button();
					?>
				</form>
			</div>
		<?php
	}

	public function pno_forms_menu() {
		add_menu_page('PNO Forms Options', 'PNO Forms', 'manage_options', 'pno_forms_options', [$this, 'pno_forms_options']);
	}


	public function pno_forms_admin_init() {
		register_setting('pno_forms_options', 'pno_forms_options');
		add_settings_section('pno_forms_settings_new_form_section', 'Create a new form', [$this, 'pno_forms_render_new_form_section'], 'pno_forms_options');
		add_settings_field('pno_forms_forms', 'Stick the dick', [$this, 'pno_forms_render_new_form_field_forms'], 'pno_forms_options', 'pno_forms_settings_new_form_section');

		register_setting('pno_forms_options', 'pno_forms_options');
		add_settings_section('pno_forms_settings_main_section', 'Penis Section', [$this, 'pno_forms_render_existing_forms_section'], 'pno_forms_options');
		add_settings_field('pno_forms_forms', 'Stick the dick', [$this, 'pno_forms_render_existing_forms_field_forms'], 'pno_forms_options', 'pno_forms_settings_main_section');
	}

	public function pno_forms_render_existing_forms_section() {
		echo 'What dis?';
	}

	public function pno_forms_render_new_form_section() {
		echo 'What dis?';
	}

	public function pno_forms_render_new_form_field_forms() {
		?>
		<div v-if="showNewForm">
			<?php
			$options = get_option('pno_forms_options');
			if ($options && $options['pno_forms_forms']) {
				$nextIndex = count($options['pno_forms_forms']);
			} else {
				$nextIndex = 0;
			}
			?>
			<input type='text' name='pno_forms_options[pno_forms_forms][<?php echo $nextIndex; ?>][name]'>
		</div>
		<div v-else>
			<button type="button" class="button button-primary" @click="showNewForm = true">
				Add new form
			</button>
		</div>
		<?php
	}

	public function pno_forms_render_existing_forms_field_forms() {
		$options = get_option('pno_forms_options');
		if ($options['pno_forms_forms']) {
			foreach ($options['pno_forms_forms'] as $key => $form) {
				?>
				<div class="pno-panel" ref="pnoFormPanel<?php echo $key; ?>">
					<h2 class="title"><?php echo $form['name'] ?></h2>
					<div class="row-actions">
						<span class="trash">
							<a
								href="#"
								@click="deleteForm('pnoFormPanel<?php echo $key; ?>')"
								class="submitdelete"
								aria-label="Delete form"
							>
								Delete
							</a>
						</span>
					</div>
					<div class="pno-panel__content">
						<label>
							<span>Name</span>
							<input type='text' name='pno_forms_options[pno_forms_forms][<?php echo $key; ?>][name]' value='<?php echo $form['name'] ?>'>
						</label>
						<label>
							<span>Recipient Email</span>
							<input type='text' name='pno_forms_options[pno_forms_forms][<?php echo $key; ?>][sendTo]' value='<?php echo $form['sendTo'] ?>'>
						</label>
						<div class="pno-well">
							[pno_form <?php echo $key; ?>]
						</div>
					</div>
				</div>
				<?php
			}
		}
	}

}