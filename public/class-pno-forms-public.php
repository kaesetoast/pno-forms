<?php

require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once __DIR__ . '/../includes/submissions.php';

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Pno_Forms
 * @subpackage Pno_Forms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Pno_Forms
 * @subpackage Pno_Forms/public
 * @author     Your Name <email@example.com>
 */
class Pno_Forms_Public {

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
	 * @param      string    $pno_forms       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pno_forms, $version ) {

		$this->pno_forms = $pno_forms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->pno_forms, plugin_dir_url( __FILE__ ) . 'css/pno-forms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->pno_forms, plugin_dir_url( __FILE__ ) . 'js/pno-forms-public.js', [], $this->version, false );

	}

	public function pno_form_shortcode($attributes) {
		$markup = '';
		$options = get_option('pno_forms_options');
		if ($_POST) {
			$mailContent = '';
			foreach ($_POST as $key => $field) {
				if ($key !== 'files') {
					$mailContent .= $key . ": " . $field . "\n";
				}
			}
			$filesString = "\nfiles: ";
			$filesPrepared = [];
			foreach ($_FILES['files']['name'] as $index => $file) {
				$filesPrepared[] = [
					'name' => $file,
					'type' => $_FILES['files']['type'][$index],
					'tmp_name' => $_FILES['files']['tmp_name'][$index],
					'error' => $_FILES['files']['error'][$index],
					'size' => $_FILES['files']['size'][$index],
				];
			}

			$uploadedFiles = [];
			foreach ($filesPrepared as $file) {
				$uploadedFile = wp_handle_upload($file, ['test_form' => false]);
				if ($uploadedFile && !isset($uploadedFile['error'])) {
					$filesString .= "\n\t" . $uploadedFile['url'];
					$uploadedFiles[] = $uploadedFile;
				}
			}
			$mailContent .= $filesString;
			$db_submissions = new PNO_FORMS\form_submissions;
			$db_submissions->insert([
				'form_id' => $attributes[0],
				'fields' => serialize($_POST),
				'files' => serialize($uploadedFiles),
				'sent_to' => $options['pno_forms_forms'][$attributes[0]]['sendTo'],
			]);
			wp_mail($options['pno_forms_forms'][$attributes[0]]['sendTo'], 'Form', $mailContent);
			wp_redirect( $options['pno_forms_forms'][$attributes[0]]['redirect'] );
		} else {
			$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$markup .= require $options['pno_forms_forms'][$attributes[0]]['template'];
		}
		return $markup;
	}

}
