<?php
/**
 * Component for amp-playbuzz
 * Displays any Playbuzz item content (e.g., list, poll, etc.)
 * Can be any item URL taken from playbuzz.com
 *
 * @category    Core
 * @package     Amp_WP/includes/components
 * @version     1.0.0
 * @author      Pixelative <mohsin@pixelative.co>
 * @copyright   Copyright (c) 2018-2019, Pixelative
 * @since 1.5.8
 */

class Amp_WP_Playbuzz_Component implements Amp_WP_Component_Interface {
	
	/**
	 * @see   Amp_WP_Component_Base::$enable_enqueue_scripts
	 *
	 * @since 1.5.8
	 *
	 * @var bool
	 */
	public $enable_enqueue_scripts = false;
	
	/**
	 * Required Script
	 *
	 * @since 1.5.8
	 *
	 * @return array
	 */
	public function config() {
		return array(
			'scripts' => array(
				'amp-playbuzz' => 'https://cdn.ampproject.org/v0/amp-playbuzz-0.1.js'
			)
		);
	}

	/**
	 * Transform <playbuzz> tag to the <amp-playbuzz> tag
	 *
	 * @param Amp_WP_Html_Util $instance
	 *
	 * @return Amp_WP_Html_Util
	 * @since 1.5.8
	 */
	public function transform( Amp_WP_Html_Util $instance ) {

		$finder     = new DomXPath( $instance );
		$class_name = 'playbuzz';
		$elements   = $finder->query( "//*[contains(@class, '$class_name')]" );
		/**
		 * @var DOMElement $element
		 */
		if ( ! $nodes_count = $elements->length ) {
			return $instance;
		}
		
		for ( $i = $nodes_count - 1; $i >= 0; $i -- ) {
			
			if ( ! $element = $elements->item( $i ) ) {
				continue;
			}
			
			$id = $element->getAttribute( 'data-id' );
			if ( empty( $id ) ) {
				continue;
			}
			
			$this->enable_enqueue_scripts = true;
			$attributes = array(
				'data-item' => $id,
				'height'    => 500,
			);
			
			$instance->replace_node( $element, 'amp-playbuzz', $attributes );
		}
		
		return $instance;
	}
}

// Register component class.
amp_wp_register_component( 'Amp_WP_Playbuzz_Component' );