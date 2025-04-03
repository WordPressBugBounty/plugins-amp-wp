<?php
/**
 * DOMDocument Helper class
 *
 * Utility function for working with php DOMDocument class
 *
 * @since 1.0.0
 */
class Amp_WP_Html_Util extends DOMDocument {

	/**
	 * Amp_WP_Html_Util constructor.
	 *
	 * @param string     $html     Optional. The HTML string to load into the document. Default is an empty string.
	 * @param string     $encoding Optional. The encoding of the document as part of the HTML declaration. Default is UTF-8.
	 * @param string|int $version  Optional. The version number of the document as part of the HTML declaration. Default is '1.0'.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $html = '', $encoding = 'UTF-8', $version = '1.0' ) {
		parent::__construct( $version, $encoding );
		if ( $html ) {
			$this->loadHTML( $html );
		}
	}

	/**
	 * Add attributes to the node
	 *
	 * @param DOMElement $node       The DOM element to which attributes will be added.
	 * @param array      $attributes  Key-value paired attributes to set on the node.
	 *
	 * @since 1.0.0
	 */
	public function add_attributes( &$node, $attributes ) {
		foreach ( $attributes as $name => $value ) {
			$node->setAttribute( $name, $value );
		}
	}

	/**
	 * Remove attributes from the node
	 *
	 * @param DOMElement $node       The DOM element from which attributes will be removed.
	 * @param array      $attributes  An array of attribute names to remove from the node.
	 *
	 * @since 1.0.0
	 */
	public function remove_attributes( &$node, $attributes ) {
		foreach ( $attributes as $name ) {
			$node->removeAttribute( $name );
		}
	}

	/**
	 * Create a HTML Node
	 *
	 * @param string $tag         The node tag name.
	 * @param array  $attributes  Key-value paired attributes to set on the node.
	 *
	 * @return DOMElement The created DOM element.
	 * @since 1.0.0
	 */
	public function create_node( $tag, $attributes ) {
		$node = $this->createElement( $tag );
		$this->add_attributes( $node, $attributes );
		return $node;
	}

	/**
	 * Returns body node
	 *
	 * @return DOMNode|null The body node or null if it does not exist.
	 * @since 1.0.0
	 */
	public function get_body_node() {
		return $this->getElementsByTagName( 'body' )->item( 0 );
	}

	/**
	 * Remove <body> tag and return body inner HTML
	 *
	 * @param bool $body_element Optional. If true, returns just body elements. Default is true.
	 *
	 * @return string The inner HTML of the body tag.
	 * @since 1.0.0
	 */
	public function get_content( $body_element = true ) {
		if ( $body_element ) {
			if ( preg_match( '#<\s*body[^>]*>(.+)<\s*/\s*body\s*>#isx', $this->saveHTML(), $match ) ) {
				return $match[1];
			}
			return '';
		}
		return $this->saveHTML();
	}

	/**
	 * Get attributes of the element
	 *
	 * @param DOMElement $node The DOM element from which to retrieve attributes.
	 *
	 * @return array Key-value paired attributes of the element.
	 * @since 1.0.0
	 */
	public static function get_node_attributes( $node ) {
		$attributes = array();

		foreach ( $node->attributes as $attribute ) {
			$attributes[ $attribute->nodeName ] = $attribute->nodeValue;
		}

		return $attributes;
	}

	/**
	 * Get Child Tag Attribute of an element.
	 *
	 * @param DOMElement $node       The parent node to search within.
	 * @param string     $tag_name   The name of the child tag to find.
	 * @param string     $attribute   The attribute name to retrieve from the child tag.
	 *
	 * @return string|null The value of the attribute on success or null if not found.
	 * @since 1.4.0
	 */
	public static function get_child_tag_attribute( $node, $tag_name, $attribute ) {
		if ( $child = self::child( $node, $tag_name, array( $attribute ) ) ) {
			if ( $attr = $child->attributes->getNamedItem( $attribute ) ) {
				return $attr->value;
			}
		}
	}

	/**
	 * Replace node with new node
	 *
	 * @param DOMElement $node2replace    The node to be replaced.
	 * @param string     $new_tag          The new node tag name.
	 * @param array      $new_attributes    Key-value paired attributes for the new node.
	 *
	 * @return DOMNode|false The old node or false if an error occurs.
	 * @since 1.0.0
	 */
	public function replace_node( $node2replace, $new_tag, $new_attributes ) {
		$new_node = $this->create_node( $new_tag, $new_attributes );
		return $node2replace->parentNode->replaceChild( $new_node, $node2replace );
	}

	/**
	 * Filter attributes
	 *
	 * @param array $attributes Key-value paired attributes to filter.
	 *
	 * @return array Filtered attributes.
	 * @since 1.0.0
	 */
	public function filter_attributes( $attributes ) {
		if ( isset( $attributes['width'] ) ) {
			// Sanitize width attribute value.
			$attributes['width'] = Amp_WP_Content_Sanitizer::sanitize_dimension( $attributes['width'], 'width' );
		}

		if ( isset( $attributes['height'] ) ) {
			// Sanitize height attribute value.
			$attributes['height'] = Amp_WP_Content_Sanitizer::sanitize_dimension( $attributes['height'], 'height' );
		}

		if ( empty( $attributes['src'] ) ) {
			if ( ! empty( $attributes['data-src'] ) && $this->is_valid_url( $attributes['data-src'] ) ) {
				$attributes['src'] = $attributes['data-src'];
			}
		}

		return $attributes;
	}

	/**
	 * Is given URL valid?
	 *
	 * @param string $url The URL to check.
	 *
	 * @return bool True if the URL is valid, false otherwise.
	 * @since 1.5.8
	 */
	public function is_valid_url( $url ) {
		return preg_match( '#^(?: https?:)?// (?: w{3}.)? (.*?)/*$#ix', $url );
	}

	/**
	 * Load HTML from a string
	 *
	 * @link  http://php.net/manual/domdocument.loadhtml.ph
	 *
	 * @param string   $html          The HTML string to load.
	 * @param null|int $options       Optional. Reserved for future use. Default is null.
	 * @param bool     $wrap_body_tag Optional. If true, wraps content into <html><body> tags. Default is true.
	 *
	 * @return bool True on success or false on failure.
	 * @since 1.0.0
	 */
	public function loadHTML( $html, $options = null, $wrap_body_tag = true ) {
		$prev = libxml_use_internal_errors( true );
		if ( $wrap_body_tag ) {
			parent::loadHTML( '<!DOCTYPE html><html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head><body>' . $html . '</body></html>' );
		} else {
			$options = 0;
			if ( defined( 'LIBXML_HTML_NODEFDTD' ) ) {
				// Libxml >= 2.7.8
				$options |= LIBXML_HTML_NODEFDTD;
			}

			if ( defined( 'LIBXML_HTML_NOIMPLIED' ) ) {
				// Libxml >= 2.7.7
				$options |= LIBXML_HTML_NOIMPLIED;
			}

			if ( $options ) {
				parent::loadHTML( $html, $options );
			} else {
				// Support for old php version.
				parent::loadHTML( $html );
			}
		}

		libxml_use_internal_errors( $prev );
		libxml_clear_errors();
	}

	/**
	 * Whether to check if $node is empty
	 *
	 * @param DOMElement $node The DOM element to check.
	 *
	 * @return bool True if the node is empty, false otherwise.
	 * @since 1.0.0
	 */
	public static function is_node_empty( $node ) {
		return 0 === $node->childNodes->length && empty( $node->textContent );
	}

	/**
	 * Get Single Child of the Node
	 *
	 * @param DOMElement $node       The DOM element to get the child from.
	 * @param string     $tag_name   The name of the child tag to find.
	 * @param array      $attributes  Optional. An array of attribute names to check for. Default is an empty array.
	 *
	 * @return DOMElement|null The child element or null if not found.
	 * @since 1.0.0
	 */
	public static function child( $node, $tag_name, $required_atts = array() ) {

		if ( empty( $node->childNodes ) ) {
			return false;
		}

		$tag_name = strtolower( $tag_name );

		/**
		 * @var DOMElement $child_node
		 */
		foreach ( $node->childNodes as $child_node ) {
			if ( $tag_name === $child_node->tagName ) {
				foreach ( $required_atts as $attr ) {
					if ( ! $child_node->hasAttribute( $attr ) ) {
						continue 2;
					}
				}
				return $child_node;
			}
		}
		return false;
	}

	/**
	 * Rename element tag name.
	 *
	 * This method creates a new element with the specified name,
	 * transfers all child nodes and attributes from the old element,
	 * and replaces the old element in the DOM tree.
	 *
	 * @param DOMElement $element The DOM element to be renamed.
	 * @param string     $newName The new tag name for the element.
	 *
	 * @see   http://stackoverflow.com/questions/12463550/rename-an-xml-node-using-php
	 * @since 1.0.0
	 */
	public static function renameElement( $element, $newName ) {
		$newElement    = $element->ownerDocument->createElement( $newName );
		$parentElement = $element->parentNode;
		$parentElement->insertBefore( $newElement, $element );

		$childNodes = $element->childNodes;
		while ( $childNodes->length > 0 ) {
			$newElement->appendChild( $childNodes->item( 0 ) );
		}

		$attributes = $element->attributes;
		while ( $attributes->length > 0 ) {
			$attribute = $attributes->item( 0 );
			if ( ! is_null( $attribute->namespaceURI ) ) {
				$newElement->setAttributeNS( 'http://www.w3.org/2000/xmlns/', 'xmlns:' . $attribute->prefix, $attribute->namespaceURI );
			}
			$newElement->setAttributeNode( $attribute );
		}
		$parentElement->removeChild( $element );
	}

	/**
	 * Append given HTML into the element.
	 *
	 * This method replaces the inner HTML of the specified element
	 * with the provided HTML string. All existing child nodes will
	 * be removed before appending the new content.
	 *
	 * @param DOMElement $element The DOM element where HTML will be appended.
	 * @param string     $html    The HTML string to append.
	 *
	 * @since 1.2.1
	 */
	public static function set_inner_HTML( $element, $html ) {

		$fragment = $element->ownerDocument->createDocumentFragment();
		$fragment->appendXML( $html );

		while ( $element->hasChildNodes() ) {
			$element->removeChild( $element->firstChild );
		}

		$element->appendChild( $fragment );
	}

	/**
	 * Replace element with given HTML.
	 *
	 * This method replaces the specified element in the DOM tree
	 * with the provided HTML string. The original element will be
	 * removed from its parent.
	 *
	 * @param DOMElement $element The DOM element to be replaced.
	 * @param string     $html    The HTML string to replace the element with.
	 *
	 * @since 1.2.1
	 */
	public static function set_outer_HTML( $element, $html ) {

		$fragment = $element->ownerDocument->createDocumentFragment();
		$fragment->appendXML( $html );

		if ( $element->parentNode ) {
			$element->parentNode->appendChild( $fragment );
		}

		while ( $element->parentNode && $element->parentNode->hasChildNodes() ) {
			$element->parentNode->removeChild( $element->parentNode->firstChild );
		}
	}
}
