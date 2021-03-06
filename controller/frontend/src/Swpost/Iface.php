<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Swpost;


/**
 * Interface for swpost frontend controllers.
 *
 * @package Controller
 * @subpackage Frontend
 */
interface Iface
{
	/**
	 * Returns the aggregated count of swposts for the given key.
	 *
	 * @param string $key Search key to aggregate for, e.g. "index.attribute.id"
	 * @param string|null $value Search key for aggregating the value column
	 * @param string|null $type Type of the aggregation, empty string for count or "sum" or "avg" (average)
	 * @return \Aimeos\Map Associative list of key values as key and the swpost count for this key as value
	 * @since 2019.04
	 */
	public function aggregate( string $key, string $value = null, string $type = null ) : \Aimeos\Map;

	/**
	 * Adds attribute IDs for filtering where swposts must reference all IDs
	 *
	 * @param array|string $attrIds Attribute ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function allOf( $attrIds ) : Iface;

	/**
	 * Adds catalog IDs for filtering
	 *
	 * @param array|string $catIds Catalog ID or list of IDs
	 * @param string $listtype List type of the swposts referenced by the categories
	 * @param int $level Constant from \Aimeos\MW\Tree\Manager\Base if swposts in subcategories are matched too
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function category( $catIds, string $listtype = 'default', int $level = \Aimeos\MW\Tree\Manager\Base::LEVEL_ONE ) : Iface;

	/**
	 * Adds generic condition for filtering swposts
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the swpost manager, e.g. "swpost.status"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( string $operator, string $key, $value ) : Iface;

	/**
	 * Returns the swpost for the given swpost code
	 *
	 * @param string $code Unique swpost code
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item including the referenced domains items
	 * @since 2019.04
	 */
	public function find( string $code );

	/**
	 * Creates a search function string for the given name and parameters
	 *
	 * @param string $name Name of the search function without parenthesis, e.g. "swpost:has"
	 * @param array $params List of parameters for the search function with numeric keys starting at 0
	 * @return string Search function string that can be used in compare()
	 */
	public function function( string $name, array $params ) : string;

	/**
	 * Returns the swpost for the given swpost ID
	 *
	 * @param string $id Unique swpost ID
	 * @return \Aimeos\MShop\Prod\Item\Iface Swpost item including the referenced domains items
	 * @since 2019.04
	 */
	public function get( string $id );

	/**
	 * Adds a filter to return only items containing a reference to the given ID
	 *
	 * @param string $domain Domain name of the referenced item, e.g. "attribute"
	 * @param string|null $type Type code of the reference, e.g. "variant" or null for all types
	 * @param string|null $refId ID of the referenced item of the given domain or null for all references
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function has( string $domain, string $type = null, string $refId = null ) : Iface;

	/**
	 * Adds attribute IDs for filtering where swposts must reference at least one ID
	 *
	 * @param array|string $attrIds Attribute ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function oneOf( $attrIds ) : Iface;

	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. ['&&' => [['>' => ['swpost.status' => 0]], ['==' => ['swpost.type' => 'default']]]]
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions ) : Iface;

	/**
	 * Adds swpost IDs for filtering
	 *
	 * @param array|string $prodIds Swpost ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function swpost( $prodIds ) : Iface;

	/**
	 * Adds a filter to return only items containing the property
	 *
	 * @param string $type Type code of the property, e.g. "isbn"
	 * @param string|null $value Exact value of the property
	 * @param string|null $langId ISO country code (en or en_US) or null if not language specific
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function property( string $type, string $value = null, string $langId = null ) : Iface;

	/**
	 * Returns the swpost for the given swpost URL name
	 *
	 * @param string $name Swpost URL name
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item including the referenced domains items
	 * @since 2019.04
	 */
	public function resolve( string $name );

	/**
	 * Returns the swposts filtered by the previously assigned conditions
	 *
	 * @param int &$total Parameter where the total number of found swposts will be stored in
	 * @return \Aimeos\Map Ordered list of items implementing \Aimeos\MShop\Swpost\Item\Iface
	 * @since 2019.04
	 */
	public function search( int &$total = null ) : \Aimeos\Map;

	/**
	 * Sets the start value and the number of returned swposts for slicing the list of found swposts
	 *
	 * @param integer $start Start value of the first swpost in the list
	 * @param integer $limit Number of returned swposts
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( int $start, int $limit ) : Iface;

	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "name", "-name", "price", "-price", "code", "-code", "ctime, "-ctime" and "relevance", null for no sorting
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( string $key = null ) : Iface;

	/**
	 * Adds supplier IDs for filtering
	 *
	 * @param array|string $supIds Supplier ID or list of IDs
	 * @param string $listtype List type of the swposts referenced by the suppliers
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function supplier( $supIds, string $listtype = 'default' ) : Iface;

	/**
	 * Adds input string for full text search
	 *
	 * @param string|null $text User input for full text search
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function text( string $text = null ) : Iface;

	/**
	 * Sets the referenced domains that will be fetched too when retrieving items
	 *
	 * @param array $domains Domain names of the referenced items that should be fetched too
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function uses( array $domains ) : Iface;
}
