<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Swpost;


/**
 * Default implementation of the swpost frontend controller.
 *
 * @package Controller
 * @subpackage Frontend
 */
class Standard
	extends \Aimeos\Controller\Frontend\Base
	implements Iface, \Aimeos\Controller\Frontend\Common\Iface
{
	private $conditions = [];
	private $domain = 'swpost';
	private $domains = ['swpost'];
	private $sort = [];
	private $filter;
	private $manager;


	/**
	 * Common initialization for controller classes
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Common MShop context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );
		$this->manager = \Aimeos\MShop::create( $context, 'swpost' );
		$this->filter = $this->manager->createSearch( true );
		$this->conditions[] = $this->filter->getConditions();
	}


	/**
	 * Clones objects in controller and resets values
	 */
	public function __clone()
	{
		$this->filter = clone $this->filter;
	}


	/**
	 * Returns the aggregated count of swposts for the given key.
	 *
	 * @param string $key Search key to aggregate for, e.g. "index.swpost.id"
	 * @param string|null $value Search key for aggregating the value column
	 * @param string|null $type Type of the aggregation, empty string for count or "sum" or "avg" (average)
	 * @return \Aimeos\Map Associative list of key values as key and the swpost count for this key as value
	 * @since 2019.04
	 */
	public function aggregate( string $key, string $value = null, string $type = null ) : \Aimeos\Map
	{
		$this->filter->setConditions( $this->filter->combine( '&&', $this->conditions ) );
		return $this->manager->aggregate( $this->filter, $key, $value, $type );
	}


	/**
	 * Adds swpost IDs for filtering where swposts must reference all IDs
	 *
	 * @param array|string $attrIds Swpost ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function allOf( $attrIds ) : Iface
	{
		if( !empty( $attrIds ) && ( $ids = array_unique( $this->validateIds( (array) $attrIds ) ) ) !== [] )
		{
			$func = $this->filter->createFunction( 'index.swpost:allof', [$ids] );
			$this->conditions[] = $this->filter->compare( '!=', $func, null );
		}

		return $this;
	}


	/**
	 * Adds catalog IDs for filtering
	 *
	 * @param array|string $catIds Catalog ID or list of IDs
	 * @param string $listtype List type of the swposts referenced by the categories
	 * @param int $level Constant from \Aimeos\MW\Tree\Manager\Base if swposts in subcategories are matched too
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function category( $catIds, string $listtype = 'default', int $level = \Aimeos\MW\Tree\Manager\Base::LEVEL_ONE ) : Iface
	{
		if( !empty( $catIds ) && ( $ids = $this->validateIds( (array) $catIds ) ) !== [] )
		{
			if( $level != \Aimeos\MW\Tree\Manager\Base::LEVEL_ONE )
			{
				$list = map();
				$cntl = \Aimeos\Controller\Frontend::create( $this->getContext(), 'catalog' );

				foreach( $ids as $catId ) {
					$list->union( $cntl->root( $catId )->getTree( $level )->toList() );
				}

				$ids = $this->validateIds( $list->keys()->toArray() );
			}

			$func = $this->filter->createFunction( 'index.catalog:position', [$listtype, $ids] );

			$this->conditions[] = $this->filter->compare( '==', 'index.catalog.id', $ids );
			$this->conditions[] = $this->filter->compare( '>=', $func, 0 );

			$func = $this->filter->createFunction( 'sort:index.catalog:position', [$listtype, $ids] );
			$this->sort[] = $this->filter->sort( '+', $func );
			$this->sort[] = $this->filter->sort( '+', 'swpost.id' ); // prevent flaky order if swposts have same position
		}

		return $this;
	}


	/**
	 * Adds generic condition for filtering swposts
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the swpost manager, e.g. "swpost.status"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( string $operator, string $key, $value ) : Iface
	{
		$this->conditions[] = $this->filter->compare( $operator, $key, $value );
		return $this;
	}


	/**
	 * Returns the swpost for the given swpost code
	 *
	 * @param string $code Unique swpost code
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item including the referenced domains items
	 * @since 2019.04
	 */
	public function find( string $code ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->manager->findItem( $code, $this->domains, 'swpost', null, true );
	}


	/**
	 * Creates a search function string for the given name and parameters
	 *
	 * @param string $name Name of the search function without parenthesis, e.g. "swpost:has"
	 * @param array $params List of parameters for the search function with numeric keys starting at 0
	 * @return string Search function string that can be used in compare()
	 */
	public function function( string $name, array $params ) : string
	{
		return $this->filter->createFunction( $name, $params );
	}


	/**
	 * Returns the swpost for the given swpost ID
	 *
	 * @param string $id Unique swpost ID
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item including the referenced domains items
	 * @since 2019.04
	 */
	public function get( string $id ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->manager->getItem( $id, $this->domains, true );
	}


	/**
	 * Adds a filter to return only items containing a reference to the given ID
	 *
	 * @param string $domain Domain name of the referenced item, e.g. "swpost"
	 * @param string|null $type Type code of the reference, e.g. "variant" or null for all types
	 * @param string|null $refId ID of the referenced item of the given domain or null for all references
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function has( string $domain, string $type = null, string $refId = null ) : Iface
	{
		$params = [$domain];
		!$type ?: $params[] = $type;
		!$refId ?: $params[] = $refId;

		$func = $this->filter->createFunction( 'swpost:has', $params );
		$this->conditions[] = $this->filter->compare( '!=', $func, null );
		return $this;
	}


	/**
	 * Adds swpost IDs for filtering where swposts must reference at least one ID
	 *
	 * If an array of ID lists is given, each ID list is added separately as condition.
	 *
	 * @param array|string $attrIds Swpost ID, list of IDs or array of lists with IDs
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function oneOf( $attrIds ) : Iface
	{
		$attrIds = (array) $attrIds;

		foreach( $attrIds as $key => $entry )
		{
			if( is_array( $entry ) && ( $ids = array_unique( $this->validateIds( $entry ) ) ) !== [] )
			{
				$func = $this->filter->createFunction( 'index.swpost:oneof', [$ids] );
				$this->conditions[] = $this->filter->compare( '!=', $func, null );
				unset( $attrIds[$key] );
			}
		}

		if( ( $ids = array_unique( $this->validateIds( $attrIds ) ) ) !== [] )
		{
			$func = $this->filter->createFunction( 'index.swpost:oneof', [$ids] );
			$this->conditions[] = $this->filter->compare( '!=', $func, null );
		}

		return $this;
	}


	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. [['>' => ['swpost.status' => 0]], ['==' => ['swpost.type' => 'default']]]
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions ) : Iface
	{
		if( ( $cond = $this->filter->toConditions( $conditions ) ) !== null ) {
			$this->conditions[] = $cond;
		}

		return $this;
	}


	/**
	 * Adds price restrictions for filtering
	 *
	 * @param array|string $value Upper price limit, list of lower and upper price or NULL for no restrictions
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2020.10
	 */
	public function price( $value = null ) : Iface
	{
		if( $value )
		{
			$value = (array) $value;
			$func = $this->filter->make( 'index.price:value', [$this->getContext()->getLocale()->getCurrencyId()] );

			$this->conditions['price-high'] = $this->filter->compare( '<=', $func, sprintf( '%013.2F', end( $value ) ) );

			if( count( $value ) > 1 ) {
				$this->conditions['price-low'] = $this->filter->compare( '>=', $func, sprintf( '%013.2F', reset( $value ) ) );
			}
		}

		return $this;
	}


	/**
	 * Adds swpost IDs for filtering
	 *
	 * @param array|string $prodIds Swpost ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function swpost( $prodIds ) : Iface
	{
		if( !empty( $prodIds ) && ( $ids = array_unique( $this->validateIds( (array) $prodIds ) ) ) !== [] ) {
			$this->conditions[] = $this->filter->compare( '==', 'swpost.id', $ids );
			$this->conditions[] = $this->filter->compare( '==', 'swpost.id', $ids );
		}

		return $this;
	}


	/**
	 * Adds a filter to return only items containing the property
	 *
	 * @param string $type Type code of the property, e.g. "isbn"
	 * @param string|null $value Exact value of the property
	 * @param string|null $langid ISO country code (en or en_US) or null if not language specific
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function property( string $type, string $value = null, string $langid = null ) : Iface
	{
		$func = $this->filter->createFunction( 'swpost:prop', [$type, $langid, $value] );
		$this->conditions[] = $this->filter->compare( '!=', $func, null );
		return $this;
	}


	/**
	 * Returns the swpost for the given swpost URL name
	 *
	 * @param string $name Swpost URL name
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item including the referenced domains items
	 * @since 2019.04
	 */
	public function resolve( string $name ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		$search = $this->manager->createSearch()->setSlice( 0, 1 );
		$search->setConditions( $search->compare( '==', 'index.text:url()', $name ) );

		if( ( $item = $this->manager->searchItems( $search, $this->domains )->first() ) === null )
		{
			$msg = $this->getContext()->getI18n()->dt( 'controller/frontend', 'Unable to find swpost "%1$s"' );
			throw new \Aimeos\Controller\Frontend\Swpost\Exception( sprintf( $msg, $name ) );
		}

		return $item;
	}


	/**
	 * Returns the swposts filtered by the previously assigned conditions
	 *
	 * @param int &$total Parameter where the total number of found swposts will be stored in
	 * @return \Aimeos\Map Ordered list of swpost items implementing \Aimeos\MShop\Swpost\Item\Iface
	 * @since 2019.04
	 */
	public function search( int &$total = null ) : \Aimeos\Map
	{
		$this->filter->setSortations( $this->sort );
		$this->filter->setConditions( $this->filter->combine( '&&', $this->conditions ) );

		return $this->manager->searchItems( $this->filter, $this->domains, $total );
	}


	/**
	 * Sets the start value and the number of returned swposts for slicing the list of found swposts
	 *
	 * @param int $start Start value of the first swpost in the list
	 * @param int $limit Number of returned swposts
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( int $start, int $limit ) : Iface
	{
		$this->filter->setSlice( $start, $limit );
		return $this;
	}


	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "name", "-name", "price", "-price", "code", "-code",
	 * 	"ctime, "-ctime", "relevance" or comma separated combinations and null for no sorting
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( string $key = null ) : Iface
	{
		$list = ( $key ? explode( ',', $key ) : $this->sort = [] );

		foreach( $list as $sortkey )
		{
			$direction = ( $sortkey[0] === '-' ? '-' : '+' );
			$sortkey = ltrim( $sortkey, '+-' );

			switch( $sortkey )
			{
				case 'relevance':
					break;

				case 'code':
					$this->sort[] = $this->filter->sort( $direction, 'swpost.code' );
					break;

				case 'ctime':
					$this->sort[] = $this->filter->sort( $direction, 'swpost.ctime' );
					break;

				case 'name':
					$langid = $this->getContext()->getLocale()->getLanguageId();

					$cmpfunc = $this->filter->createFunction( 'index.text:name', [$langid] );
					$this->conditions[] = $this->filter->compare( '!=', $cmpfunc, null );

					$sortfunc = $this->filter->createFunction( 'sort:index.text:name', [$langid] );
					$this->sort[] = $this->filter->sort( $direction, $sortfunc );
					break;

				case 'price':
					$currencyid = $this->getContext()->getLocale()->getCurrencyId();
					$sortfunc = $this->filter->make( 'sort:index.price:value', [$currencyid] );

					$cmpfunc = $this->filter->make( 'index.price:value', [$currencyid] );
					$this->conditions['price-sort'] = $this->filter->compare( '!=', $cmpfunc, null );

					$this->sort[] = $this->filter->sort( $direction, $sortfunc );
					break;

				default:
					$this->sort[] = $this->filter->sort( $direction, $sortkey );
			}
		}

		$this->filter->setSortations( $this->sort );
		return $this;
	}


	/**
	 * Adds supplier IDs for filtering
	 *
	 * @param array|string $supIds Supplier ID or list of IDs
	 * @param string $listtype List type of the swposts referenced by the suppliers
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function supplier( $supIds, string $listtype = 'default' ) : Iface
	{
		if( !empty( $supIds ) && ( $ids = array_unique( $this->validateIds( (array) $supIds ) ) ) !== [] )
		{
			$func = $this->filter->createFunction( 'index.supplier:position', [$listtype, $ids] );

			$this->conditions[] = $this->filter->compare( '==', 'index.supplier.id', $ids );
			$this->conditions[] = $this->filter->compare( '>=', $func, 0 );

			$func = $this->filter->createFunction( 'sort:index.supplier:position', [$listtype, $ids] );
			$this->sort[] = $this->filter->sort( '+', $func );
		}

		return $this;
	}


	/**
	 * Adds input string for full text search
	 *
	 * @param string|null $text User input for full text search
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function text( string $text = null ) : Iface
	{
		if( !empty( $text ) )
		{
			$langid = $this->getContext()->getLocale()->getLanguageId();
			$func = $this->filter->createFunction( 'index.text:relevance', [$langid, $text] );
			$sortfunc = $this->filter->createFunction( 'sort:index.text:relevance', [$langid, $text] );

			$this->conditions[] = $this->filter->compare( '>', $func, 0 );
			$this->sort[] = $this->filter->sort( '-', $sortfunc );
		}

		return $this;
	}


	/**
	 * Sets the referenced domains that will be fetched too when retrieving items
	 *
	 * @param array $domains Domain names of the referenced items that should be fetched too
	 * @return \Aimeos\Controller\Frontend\Swpost\Iface Swpost controller for fluent interface
	 * @since 2019.04
	 */
	public function uses( array $domains ) : Iface
	{
		$this->domains = $domains;
		return $this;
	}


	/**
	 * Returns the list of catalog IDs for the given catalog tree
	 *
	 * @param \Aimeos\MShop\Catalog\Item\Iface $item Catalog item with children
	 * @return array List of catalog IDs
	 */
	protected function getCatalogIdsFromTree( \Aimeos\MShop\Catalog\Item\Iface $item ) : array
	{
		if( $item->getStatus() < 1 ) {
			return [];
		}

		$list = [$item->getId()];

		foreach( $item->getChildren() as $child ) {
			$list = array_merge( $list, $this->getCatalogIdsFromTree( $child ) );
		}

		return $list;
	}


	/**
	 * Validates the given IDs as integers
	 *
	 * @param array $ids List of IDs to validate
	 * @return array List of validated IDs
	 */
	protected function validateIds( array $ids ) : array
	{
		$list = [];

		foreach( $ids as $id )
		{
			if( $id != '' && preg_match( '/^[A-Za-z0-9\-\_]+$/', $id ) === 1 ) {
				$list[] = (string) $id;
			}
		}

		return $list;
	}
}
