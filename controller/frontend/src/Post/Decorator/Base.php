<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2020
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Post\Decorator;


/**
 * Base for post frontend controller decorators
 *
 * @package Controller
 * @subpackage Frontend
 */
abstract class Base
	extends \Aimeos\Controller\Frontend\Base
	implements \Aimeos\Controller\Frontend\Common\Decorator\Iface, \Aimeos\Controller\Frontend\Post\Iface
{
	private $controller;


	/**
	 * Initializes the controller decorator.
	 *
	 * @param \Aimeos\Controller\Frontend\Iface $controller Controller object
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\Controller\Frontend\Iface $controller, \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$iface = \Aimeos\Controller\Frontend\Post\Iface::class;
		$this->controller = \Aimeos\MW\Common\Base::checkClass( $iface, $controller );
	}


	/**
	 * Clones objects in decorator
	 */
	public function __clone()
	{
		$this->controller = clone $this->controller;
	}


	/**
	 * Passes unknown methods to wrapped objects.
	 *
	 * @param string $name Name of the method
	 * @param array $param List of method parameter
	 * @return mixed Returns the value of the called method
	 * @throws \Aimeos\Controller\Frontend\Exception If method call failed
	 */
	public function __call( string $name, array $param )
	{
		return @call_user_func_array( array( $this->controller, $name ), $param );
	}


	/**
	 * Returns the aggregated count of posts for the given key.
	 *
	 * @param string $key Search key to aggregate for, e.g. "index.attribute.id"
	 * @param string|null $value Search key for aggregating the value column
	 * @param string|null $type Type of the aggregation, empty string for count or "sum" or "avg" (average)
	 * @return \Aimeos\Map Associative list of key values as key and the post count for this key as value
	 * @since 2019.04
	 */
	public function aggregate( string $key, string $value = null, string $type = null ) : \Aimeos\Map
	{
		return $this->controller->aggregate( $key, $value, $type );
	}


	/**
	 * Adds attribute IDs for filtering where posts must reference all IDs
	 *
	 * @param array|string $attrIds Attribute ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function allOf( $attrIds ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->allOf( $attrIds );
		return $this;
	}


	/**
	 * Adds catalog IDs for filtering
	 *
	 * @param array|string $catIds Catalog ID or list of IDs
	 * @param string $listtype List type of the posts referenced by the categories
	 * @param int $level Constant from \Aimeos\MW\Tree\Manager\Base if posts in subcategories are matched too
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function category( $catIds, string $listtype = 'default', int $level = \Aimeos\MW\Tree\Manager\Base::LEVEL_ONE ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->category( $catIds, $listtype, $level );
		return $this;
	}


	/**
	 * Adds generic condition for filtering posts
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the post manager, e.g. "post.status"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( string $operator, string $key, $value ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->compare( $operator, $key, $value );
		return $this;
	}


	/**
	 * Returns the post for the given post code
	 *
	 * @param string $code Unique post code
	 * @return \Aimeos\MShop\Post\Item\Iface Post item including the referenced domains items
	 * @since 2019.04
	 */
	public function find( string $code ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->controller->find( $code );
	}


	/**
	 * Creates a search function string for the given name and parameters
	 *
	 * @param string $name Name of the search function without parenthesis, e.g. "post:has"
	 * @param array $params List of parameters for the search function with numeric keys starting at 0
	 * @return string Search function string that can be used in compare()
	 */
	public function function( string $name, array $params ) : string
	{
		return $this->controller->function( $name, $params );
	}


	/**
	 * Returns the post for the given post ID
	 *
	 * @param string $id Unique post ID
	 * @return \Aimeos\MShop\Post\Item\Iface Post item including the referenced domains items
	 * @since 2019.04
	 */
	public function get( string $id ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->controller->get( $id );
	}


	/**
	 * Adds a filter to return only items containing a reference to the given ID
	 *
	 * @param string $domain Domain name of the referenced item, e.g. "attribute"
	 * @param string|null $type Type code of the reference, e.g. "variant" or null for all types
	 * @param string|null $refId ID of the referenced item of the given domain or null for all references
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function has( string $domain, string $type = null, string $refId = null ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->has( $domain, $type, $refId );
		return $this;
	}


	/**
	 * Adds attribute IDs for filtering where posts must reference at least one ID
	 *
	 * @param array|string $attrIds Attribute ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function oneOf( $attrIds ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->oneOf( $attrIds );
		return $this;
	}


	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. ['&&' => [['>' => ['post.status' => 0]], ['==' => ['post.type' => 'default']]]]
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->parse( $conditions );
		return $this;
	}


	/**
	 * Adds price restrictions for filtering
	 *
	 * @param array|string $value Upper price limit, list of lower and upper price or NULL for no restrictions
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2020.10
	 */
	public function price( $value = null ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->price( $value );
		return $this;
	}


	/**
	 * Adds post IDs for filtering
	 *
	 * @param array|string $prodIds Post ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function post( $prodIds ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->post( $prodIds );
		return $this;
	}


	/**
	 * Adds a filter to return only items containing the property
	 *
	 * @param string $type Type code of the property, e.g. "isbn"
	 * @param string|null $value Exact value of the property
	 * @param string|null $langId ISO country code (en or en_US) or null if not language specific
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function property( string $type, string $value = null, string $langId = null ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->property( $type, $value, $langId );
		return $this;
	}


	/**
	 * Returns the post for the given post URL name
	 *
	 * @param string $name Post URL name
	 * @return \Aimeos\MShop\Post\Item\Iface Post item including the referenced domains items
	 * @since 2019.04
	 */
	public function resolve( string $name ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->controller->resolve( $name );
	}


	/**
	 * Returns the posts filtered by the previously assigned conditions
	 *
	 * @param int &$total Parameter where the total number of found posts will be stored in
	 * @return \Aimeos\Map Ordered list of items implementing \Aimeos\MShop\Post\Item\Iface
	 * @since 2019.04
	 */
	public function search( int &$total = null ) : \Aimeos\Map
	{
		return $this->controller->search( $total );
	}


	/**
	 * Sets the start value and the number of returned posts for slicing the list of found posts
	 *
	 * @param int $start Start value of the first post in the list
	 * @param int $limit Number of returned posts
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( int $start, int $limit ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->slice( $start, $limit );
		return $this;
	}


	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "name", "-name", "price", "-price", "code", "-code", "ctime, "-ctime" and "relevance", null for no sorting
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( string $key = null ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->sort( $key );
		return $this;
	}


	/**
	 * Adds supplier IDs for filtering
	 *
	 * @param array|string $supIds Supplier ID or list of IDs
	 * @param string $listtype List type of the posts referenced by the suppliers
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function supplier( $supIds, string $listtype = 'default' ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->supplier( $supIds, $listtype );
		return $this;
	}


	/**
	 * Adds input string for full text search
	 *
	 * @param string|null $text User input for full text search
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function text( string $text = null ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->text( $text );
		return $this;
	}


	/**
	 * Sets the referenced domains that will be fetched too when retrieving items
	 *
	 * @param array $domains Domain names of the referenced items that should be fetched too
	 * @return \Aimeos\Controller\Frontend\Post\Iface Post controller for fluent interface
	 * @since 2019.04
	 */
	public function uses( array $domains ) : \Aimeos\Controller\Frontend\Post\Iface
	{
		$this->controller->uses( $domains );
		return $this;
	}


	/**
	 * Injects the reference of the outmost object
	 *
	 * @param \Aimeos\Controller\Frontend\Iface $object Reference to the outmost controller or decorator
	 * @return \Aimeos\Controller\Frontend\Iface Controller object for chaining method calls
	 */
	public function setObject( \Aimeos\Controller\Frontend\Iface $object ) : \Aimeos\Controller\Frontend\Iface
	{
		parent::setObject( $object );

		$this->controller->setObject( $object );

		return $this;
	}


	/**
	 * Returns the frontend controller
	 *
	 * @return \Aimeos\Controller\Frontend\Post\Iface Frontend controller object
	 */
	protected function getController() : \Aimeos\Controller\Frontend\Post\Iface
	{
		return $this->controller;
	}
}
