<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Post
 */


namespace Aimeos\MShop\Post\Item;


/**
 * Default impelementation of a post item.
 *
 * @package MShop
 * @subpackage Post
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Post\Item\Iface
{
	use \Aimeos\MShop\Common\Item\Config\Traits;
	use \Aimeos\MShop\Common\Item\ListRef\Traits {
		__clone as __cloneList;
	}
	use \Aimeos\MShop\Common\Item\PropertyRef\Traits {
		__clone as __cloneProperty;
	}


	private $date;


	/**
	 * Initializes the item object.
	 *
	 * @param array $values Parameter for initializing the basic properties
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propItems List of property items
	 */
	public function __construct( array $values = [], array $listItems = [],
		array $refItems = [], array $propItems = [] )
	{
		parent::__construct( 'post.', $values );

		$this->date = isset( $values['.date'] ) ? $values['.date'] : date( 'Y-m-d H:i:s' );
		$this->initListItems( $listItems, $refItems );
		$this->initPropertyItems( $propItems );
	}


	/**
	 * Creates a deep clone of all objects
	 */
	public function __clone()
	{
		parent::__clone();
		$this->__cloneList();
		$this->__cloneProperty();
	}


	/**
	 * Returns the catalog items referencing the post
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Catalog\Item\Iface
	 */
	public function getCatalogItems() : \Aimeos\Map
	{
		return map( $this->get( '.catalog', [] ) );
	}


	/**
	 * Returns the supplier items referencing the post
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Supplier\Item\Iface
	 */
	public function getSupplierItems() : \Aimeos\Map
	{
		return map( $this->get( '.supplier', [] ) );
	}


	/**
	 * Returns the stock items associated to the post
	 *
	 * @param string|null $type Type of the stock item
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Stock\Item\Iface
	 */
	public function getStockItems( $type = null ) : \Aimeos\Map
	{
		$list = map( $this->get( '.stock', [] ) );

		if( $type !== null )
		{
			$list = $list->filter( function( $item ) use ( $type ) {
				return $item->getType() === $type;
			});
		}

		return $list;
	}


	/**
	 * Returns the type of the post item.
	 *
	 * @return string|null Type of the post item
	 */
	public function getType() : ?string
	{
		return $this->get( 'post.type' );
	}


	/**
	 * Sets the new type of the post item.
	 *
	 * @param string $type New type of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setType( string $type ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'post.type', $this->checkCode( $type ) );
	}


	/**
	 * Returns the status of the post item.
	 *
	 * @return int Status of the post item
	 */
	public function getStatus() : int
	{
		return $this->get( 'post.status', 1 );
	}


	/**
	 * Sets the new status of the post item.
	 *
	 * @param int $status New status of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setStatus( int $status ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'post.status', $status );
	}


	/**
	 * Returns the code of the post item.
	 *
	 * @return string Code of the post item
	 */
	public function getCode() : string
	{
		return $this->get( 'post.code', '' );
	}


	/**
	 * Sets the new code of the post item.
	 *
	 * @param string $code New code of post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setCode( string $code ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.code', $this->checkCode( $code ) );
	}


	/**
	 * Returns the data set name assigned to the post item.
	 *
	 * @return string Data set name
	 */
	public function getDataset() : string
	{
		return $this->get( 'post.dataset', '' );
	}


	/**
	 * Sets a new data set name assignd to the post item.
	 *
	 * @param string $name New data set name
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setDataset( ?string $name ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.dataset', $this->checkCode( (string) $name ) );
	}


	/**
	 * Returns the label of the post item.
	 *
	 * @return string Label of the post item
	 */
	public function getLabel() : string
	{
		return $this->get( 'post.label', '' );
	}


	/**
	 * Sets a new label of the post item.
	 *
	 * @param string $label New label of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setLabel( string $label ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.label', $label );
	}


	/**
	 * Returns the localized text type of the item or the internal label if no name is available.
	 *
	 * @param string $type Text type to be returned
	 * @return string Specified text type or label of the item
	 */
	public function getName( string $type = 'name' ) : string
	{
		if( ( $item = $this->getRefItems( 'text', $type )->first() ) !== null ) {
			return $item->getContent();
		}

		return $type === 'url' ? $this->getUrl() : $this->getLabel();
	}


	/**
	 * Returns the URL segment for the post item.
	 *
	 * @return string URL segment of the post item
	 */
	public function getUrl() : string
	{
		return $this->get( 'post.url' ) ?: \Aimeos\MW\Str::slug( $this->getLabel() );
	}


	/**
	 * Sets a new URL segment for the post.
	 *
	 * @param string|null $url New URL segment of the post item
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setUrl( ?string $url ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.url', $url );
	}


	/**
	 * Returns the starting point of time, in which the post is available.
	 *
	 * @return string|null ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getDateStart() : ?string
	{
		$value = $this->get( 'post.datestart' );
		return $value ? substr( $value, 0, 19 ) : null;
	}


	/**
	 * Sets a new starting point of time, in which the post is available.
	 *
	 * @param string|null $date New ISO date in YYYY-MM-DD hh:mm:ss format
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setDateStart( ?string $date ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'post.datestart', $this->checkDateFormat( $date ) );
	}


	/**
	 * Returns the ending point of time, in which the post is available.
	 *
	 * @return string|null ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getDateEnd() : ?string
	{
		$value = $this->get( 'post.dateend' );
		return $value ? substr( $value, 0, 19 ) : null;
	}


	/**
	 * Sets a new ending point of time, in which the post is available.
	 *
	 * @param string|null $date New ISO date in YYYY-MM-DD hh:mm:ss format
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setDateEnd( ?string $date ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'post.dateend', $this->checkDateFormat( $date ) );
	}


	/**
	 * Returns the configuration values of the item
	 *
	 * @return array Configuration values
	 */
	public function getConfig() : array
	{
		return $this->get( 'post.config', [] );
	}


	/**
	 * Sets the configuration values of the item.
	 *
	 * @param array $config Configuration values
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setConfig( array $config ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'post.config', $config );
	}


	/**
	 * Returns the quantity scale of the post item.
	 *
	 * @return float Quantity scale
	 */
	public function getScale() : float
	{
		return (float) $this->get( 'post.scale', 1 ) ?: 1;
	}


	/**
	 * Sets a new quantity scale of the post item.
	 *
	 * @param float $value New quantity scale
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setScale( float $value ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.scale', $value > 0 ? $value : 1 );
	}


	/**
	 * Returns the URL target specific for that post
	 *
	 * @return string URL target specific for that post
	 */
	public function getTarget() : string
	{
		return $this->get( 'post.target', '' );
	}


	/**
	 * Sets a new URL target specific for that post
	 *
	 * @param string $value New URL target specific for that post
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setTarget( ?string $value ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.target', (string) $value );
	}


	/**
	 * Returns the create date of the item
	 *
	 * @return string ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getTimeCreated() : string
	{
		return $this->get( 'post.ctime', date( 'Y-m-d H:i:s' ) );
	}


	/**
	 * Sets the create date of the item
	 *
	 * @param string|null $value ISO date in YYYY-MM-DD hh:mm:ss format
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function setTimeCreated( ?string $value ) : \Aimeos\MShop\Post\Item\Iface
	{
		return $this->set( 'post.ctime', $this->checkDateFormat( $value ) );
	}


	/**
	 * Returns the rating of the item
	 *
	 * @return string Decimal value of the item rating
	 */
	public function getRating() : string
	{
		return (string) $this->get( 'post.rating', 0 );
	}


	/**
	 * Returns the total number of ratings for the item
	 *
	 * @return int Total number of ratings for the item
	 */
	public function getRatings() : int
	{
		return (int) $this->get( 'post.ratings', 0 );
	}


	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType() : string
	{
		return 'post';
	}


	/**
	 * Tests if the item is available based on status, time, language and currency
	 *
	 * @return bool True if available, false if not
	 */
	public function isAvailable() : bool
	{
		return parent::isAvailable() && $this->getStatus() > 0
			&& ( $this->getDateEnd() === null || $this->getDateEnd() > $this->date )
			&& ( $this->getDateStart() === null || $this->getDateStart() < $this->date || $this->getType() === 'event' );
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param bool True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Post\Item\Iface Post item for chaining method calls
	 */
	public function fromArray( array &$list, bool $private = false ) : \Aimeos\MShop\Common\Item\Iface
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'post.url': $item = $item->setUrl( $value ); break;
				case 'post.type': $item = $item->setType( $value ); break;
				case 'post.code': $item = $item->setCode( $value ); break;
				case 'post.label': $item = $item->setLabel( $value ); break;
				case 'post.dataset': $item = $item->setDataset( $value ); break;
				case 'post.scale': $item = $item->setScale( (float) $value ); break;
				case 'post.status': $item = $item->setStatus( (int) $value ); break;
				case 'post.datestart': $item = $item->setDateStart( $value ); break;
				case 'post.dateend': $item = $item->setDateEnd( $value ); break;
				case 'post.config': $item = $item->setConfig( $value ); break;
				case 'post.target': $item = $item->setTarget( $value ); break;
				case 'post.ctime': $item = $item->setTimeCreated( $value ); break;
				default: continue 2;
			}

			unset( $list[$key] );
		}

		return $item;
	}


	/**
	 * Returns the item values as array.
	 *
	 * @param bool True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( bool $private = false ) : array
	{
		$list = parent::toArray( $private );

		$list['post.url'] = $this->getUrl();
		$list['post.type'] = $this->getType();
		$list['post.code'] = $this->getCode();
		$list['post.label'] = $this->getLabel();
		$list['post.status'] = $this->getStatus();
		$list['post.dataset'] = $this->getDataset();
		$list['post.datestart'] = $this->getDateStart();
		$list['post.dateend'] = $this->getDateEnd();
		$list['post.config'] = $this->getConfig();
		$list['post.scale'] = $this->getScale();
		$list['post.target'] = $this->getTarget();
		$list['post.ctime'] = $this->getTimeCreated();
		$list['post.rating'] = $this->getRating();
		$list['post.ratings'] = $this->getRatings();

		return $list;
	}
}
