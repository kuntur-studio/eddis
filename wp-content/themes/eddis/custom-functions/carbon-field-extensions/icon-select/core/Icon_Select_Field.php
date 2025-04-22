<?php

namespace Carbon_Field_Icon_Select;

use Carbon_Fields\Field\Field;

class Icon_Select_Field extends Field {
	protected $options = [];

	/**
	 * Set the options for the field.
     *
     * @param array $options
     * @return self
     */
    public function set_options($options) {
        $this->options = $options;
        return $this;
    }

    /**
     * Get the options for the field.
     *
     * @return array
     */
    public function get_options() {
        return $this->options;
    }

	/**
     * Prepare the field data for use in React.
     *
     * @param bool $load
     * @return array
     */
    public function to_json($load) {
        $field_data = parent::to_json($load);
        $field_data = array_merge($field_data, [
            'options' => $this->get_options(),
            'fieldId' => $this->get_id(),
        ]);
        return $field_data;
    }

	/**
	 * Prepare the field type for use.
	 * Called once per field type when activated.
	 *
	 * @static
	 * @access public
	 *
	 * @return void
	 */
	public static function field_type_activated() {
		$dir = \Carbon_Field_Icon_Select\DIR . '/languages/';
		$locale = get_locale();
		$path = $dir . $locale . '.mo';
		load_textdomain( 'carbon-field-icon-select', $path );
	}

	/**
	 * Enqueue scripts and styles in admin.
	 * Called once per field type.
	 *
	 * @static
	 * @access public
	 *
	 * @return void
	 */
	public static function admin_enqueue_scripts() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Icon_Select\DIR );

		// Enqueue field styles.
		wp_enqueue_style( 'carbon-field-icon-select', $root_uri . '/build/bundle.css' );

		// Enqueue field scripts.
		wp_enqueue_script( 'carbon-field-icon-select', $root_uri . '/build/bundle.js', array( 'carbon-fields-core' ) );
	}
}
