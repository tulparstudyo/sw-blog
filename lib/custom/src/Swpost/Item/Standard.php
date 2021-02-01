<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Swpost
 */


namespace Aimeos\MShop\Swpost\Item;


/**
 * Default impelementation of a swpost item.
 *
 * @package MShop
 * @subpackage Swpost
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Swpost\Item\Iface
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
		parent::__construct( 'swpost.', $values );

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
	 * Returns the catalog items referencing the swpost
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Catalog\Item\Iface
	 */
	public function getCatalogItems() : \Aimeos\Map
	{
		return map( $this->get( '.catalog', [] ) );
	}


	/**
	 * Returns the supplier items referencing the swpost
	 *
	 * @return \Aimeos\Map Associative list of items implementing \Aimeos\MShop\Supplier\Item\Iface
	 */
	public function getSupplierItems() : \Aimeos\Map
	{
		return map( $this->get( '.supplier', [] ) );
	}


	/**
	 * Returns the stock items associated to the swpost
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
	 * Returns the type of the swpost item.
	 *
	 * @return string|null Type of the swpost item
	 */
	public function getType() : ?string
	{
		return $this->get( 'swpost.type' );
	}


	/**
	 * Sets the new type of the swpost item.
	 *
	 * @param string $type New type of the swpost item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setType( string $type ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'swpost.type', $this->checkCode( $type ) );
	}


	/**
	 * Returns the status of the swpost item.
	 *
	 * @return int Status of the swpost item
	 */
	public function getStatus() : int
	{
		return $this->get( 'swpost.status', 1 );
	}


	/**
	 * Sets the new status of the swpost item.
	 *
	 * @param int $status New status of the swpost item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setStatus( int $status ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'swpost.status', $status );
	}


	/**
	 * Returns the code of the swpost item.
	 *
	 * @return string Code of the swpost item
	 */
	public function getCode() : string
	{
		return $this->get( 'swpost.code', '' );
	}


	/**
	 * Sets the new code of the swpost item.
	 *
	 * @param string $code New code of swpost item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setCode( string $code ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.code', $this->checkCode( $code ) );
	}


	/**
	 * Returns the data set name assigned to the swpost item.
	 *
	 * @return string Data set name
	 */
	public function getDataset() : string
	{
		return $this->get( 'swpost.dataset', '' );
	}


	/**
	 * Sets a new data set name assignd to the swpost item.
	 *
	 * @param string $name New data set name
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setDataset( ?string $name ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.dataset', $this->checkCode( (string) $name ) );
	}


	/**
	 * Returns the label of the swpost item.
	 *
	 * @return string Label of the swpost item
	 */
	public function getLabel() : string
	{
		return $this->get( 'swpost.label', '' );
	}


	/**
	 * Sets a new label of the swpost item.
	 *
	 * @param string $label New label of the swpost item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setLabel( string $label ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.label', $label );
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
	 * Returns the URL segment for the swpost item.
	 *
	 * @return string URL segment of the swpost item
	 */
	public function getUrl() : string
	{
		return $this->get( 'swpost.url' ) ?: \Aimeos\MW\Str::slug( $this->getLabel() );
	}


	/**
	 * Sets a new URL segment for the swpost.
	 *
	 * @param string|null $url New URL segment of the swpost item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setUrl( ?string $url ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.url', $url );
	}


	/**
	 * Returns the starting point of time, in which the swpost is available.
	 *
	 * @return string|null ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getDateStart() : ?string
	{
		$value = $this->get( 'swpost.datestart' );
		return $value ? substr( $value, 0, 19 ) : null;
	}


	/**
	 * Sets a new starting point of time, in which the swpost is available.
	 *
	 * @param string|null $date New ISO date in YYYY-MM-DD hh:mm:ss format
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setDateStart( ?string $date ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'swpost.datestart', $this->checkDateFormat( $date ) );
	}


	/**
	 * Returns the ending point of time, in which the swpost is available.
	 *
	 * @return string|null ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getDateEnd() : ?string
	{
		$value = $this->get( 'swpost.dateend' );
		return $value ? substr( $value, 0, 19 ) : null;
	}


	/**
	 * Sets a new ending point of time, in which the swpost is available.
	 *
	 * @param string|null $date New ISO date in YYYY-MM-DD hh:mm:ss format
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setDateEnd( ?string $date ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'swpost.dateend', $this->checkDateFormat( $date ) );
	}


	/**
	 * Returns the configuration values of the item
	 *
	 * @return array Configuration values
	 */
	public function getConfig() : array
	{
		return $this->get( 'swpost.config', [] );
	}


	/**
	 * Sets the configuration values of the item.
	 *
	 * @param array $config Configuration values
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setConfig( array $config ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->set( 'swpost.config', $config );
	}


	/**
	 * Returns the quantity scale of the swpost item.
	 *
	 * @return float Quantity scale
	 */
	public function getScale() : float
	{
		return (float) $this->get( 'swpost.scale', 1 ) ?: 1;
	}


	/**
	 * Sets a new quantity scale of the swpost item.
	 *
	 * @param float $value New quantity scale
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setScale( float $value ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.scale', $value > 0 ? $value : 1 );
	}


	/**
	 * Returns the URL target specific for that swpost
	 *
	 * @return string URL target specific for that swpost
	 */
	public function getTarget() : string
	{
		return $this->get( 'swpost.target', '' );
	}


	/**
	 * Sets a new URL target specific for that swpost
	 *
	 * @param string $value New URL target specific for that swpost
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setTarget( ?string $value ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.target', (string) $value );
	}


	/**
	 * Returns the create date of the item
	 *
	 * @return string ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getTimeCreated() : string
	{
		return $this->get( 'swpost.ctime', date( 'Y-m-d H:i:s' ) );
	}


	/**
	 * Sets the create date of the item
	 *
	 * @param string|null $value ISO date in YYYY-MM-DD hh:mm:ss format
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function setTimeCreated( ?string $value ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		return $this->set( 'swpost.ctime', $this->checkDateFormat( $value ) );
	}


	/**
	 * Returns the rating of the item
	 *
	 * @return string Decimal value of the item rating
	 */
	public function getRating() : string
	{
		return (string) $this->get( 'swpost.rating', 0 );
	}


	/**
	 * Returns the total number of ratings for the item
	 *
	 * @return int Total number of ratings for the item
	 */
	public function getRatings() : int
	{
		return (int) $this->get( 'swpost.ratings', 0 );
	}


	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType() : string
	{
		return 'swpost';
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
	 * @return \Aimeos\MShop\Swpost\Item\Iface Swpost item for chaining method calls
	 */
	public function fromArray( array &$list, bool $private = false ) : \Aimeos\MShop\Common\Item\Iface
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'swpost.url': $item = $item->setUrl( $value ); break;
				case 'swpost.type': $item = $item->setType( $value ); break;
				case 'swpost.code': $item = $item->setCode( $value ); break;
				case 'swpost.label': $item = $item->setLabel( $value ); break;
				case 'swpost.dataset': $item = $item->setDataset( $value ); break;
				case 'swpost.scale': $item = $item->setScale( (float) $value ); break;
				case 'swpost.status': $item = $item->setStatus( (int) $value ); break;
				case 'swpost.datestart': $item = $item->setDateStart( $value ); break;
				case 'swpost.dateend': $item = $item->setDateEnd( $value ); break;
				case 'swpost.config': $item = $item->setConfig( $value ); break;
				case 'swpost.target': $item = $item->setTarget( $value ); break;
				case 'swpost.ctime': $item = $item->setTimeCreated( $value ); break;
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

		$list['swpost.url'] = $this->getUrl();
		$list['swpost.type'] = $this->getType();
		$list['swpost.code'] = $this->getCode();
		$list['swpost.label'] = $this->getLabel();
		$list['swpost.status'] = $this->getStatus();
		$list['swpost.dataset'] = $this->getDataset();
		$list['swpost.datestart'] = $this->getDateStart();
		$list['swpost.dateend'] = $this->getDateEnd();
		$list['swpost.config'] = $this->getConfig();
		$list['swpost.scale'] = $this->getScale();
		$list['swpost.target'] = $this->getTarget();
		$list['swpost.ctime'] = $this->getTimeCreated();
		$list['swpost.rating'] = $this->getRating();
		$list['swpost.ratings'] = $this->getRatings();

		return $list;
	}
}
