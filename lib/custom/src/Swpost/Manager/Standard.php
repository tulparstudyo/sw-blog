<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Swpost
 */


namespace Aimeos\MShop\Swpost\Manager;


/**
 * Default swpost manager.
 *
 * @package MShop
 * @subpackage Swpost
 */
class Standard
	extends \Aimeos\MShop\Common\Manager\Base
	implements \Aimeos\MShop\Swpost\Manager\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface,
		\Aimeos\MShop\Common\Manager\ListRef\Iface, \Aimeos\MShop\Common\Manager\PropertyRef\Iface,
		\Aimeos\MShop\Common\Manager\Rating\Iface
{
	use \Aimeos\MShop\Common\Manager\ListRef\Traits;
	use \Aimeos\MShop\Common\Manager\PropertyRef\Traits;


	private $searchConfig = array(
		'swpost.id' => array(
			'code' => 'swpost.id',
			'internalcode' => 'mpro."id"',
			'label' => 'ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'swpost.siteid' => array(
			'code' => 'swpost.siteid',
			'internalcode' => 'mpro."siteid"',
			'label' => 'Site ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.type' => array(
			'code' => 'swpost.type',
			'internalcode' => 'mpro."type"',
			'label' => 'Type',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.label' => array(
			'code' => 'swpost.label',
			'internalcode' => 'mpro."label"',
			'label' => 'Label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.code' => array(
			'code' => 'swpost.code',
			'internalcode' => 'mpro."code"',
			'label' => 'SKU',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.url' => array(
			'code' => 'swpost.url',
			'internalcode' => 'mpro."url"',
			'label' => 'URL segment',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.dataset' => array(
			'code' => 'swpost.dataset',
			'internalcode' => 'mpro."dataset"',
			'label' => 'Data set',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.datestart' => array(
			'code' => 'swpost.datestart',
			'internalcode' => 'mpro."start"',
			'label' => 'Start date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.dateend' => array(
			'code' => 'swpost.dateend',
			'internalcode' => 'mpro."end"',
			'label' => 'End date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'swpost.status' => array(
			'code' => 'swpost.status',
			'internalcode' => 'mpro."status"',
			'label' => 'Status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'swpost.scale' => array(
			'code' => 'swpost.scale',
			'internalcode' => 'mpro."scale"',
			'label' => 'Quantity scale',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
		),
		'swpost.config' => array(
			'code' => 'pwpost.config',
			'internalcode' => 'mpro."config"',
			'label' => 'Config',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.target' => array(
			'code' => 'swpost.target',
			'internalcode' => 'mpro."target"',
			'label' => 'URL target',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.ctime' => array(
			'code' => 'swpost.ctime',
			'internalcode' => 'mpro."ctime"',
			'label' => 'Create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.mtime' => array(
			'code' => 'swpost.mtime',
			'internalcode' => 'mpro."mtime"',
			'label' => 'Modify date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.editor' => array(
			'code' => 'swpost.editor',
			'internalcode' => 'mpro."editor"',
			'label' => 'Editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.rating' => array(
			'code' => 'swpost.rating',
			'internalcode' => 'mpro."rating"',
			'label' => 'Rating value',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'swpost.ratings' => array(
			'code' => 'swpost.ratings',
			'internalcode' => 'mpro."ratings"',
			'label' => 'Number of ratings',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'swpost:has' => array(
			'code' => 'swpost:has()',
			'internalcode' => ':site AND :key AND mproli."id"',
			'internaldeps' => ['LEFT JOIN "sw_post_list" AS mproli ON ( mproli."parentid" = mpro."id" )'],
			'label' => 'Swpost has list item, parameter(<domain>[,<list type>[,<reference ID>)]]',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
		'swpost:prop' => array(
			'code' => 'swpost:prop()',
			'internalcode' => ':site AND :key AND mpropr."id"',
			'internaldeps' => ['LEFT JOIN "sw_post_property" AS mpropr ON ( mpropr."parentid" = mpro."id" )'],
			'label' => 'Swpost has property item, parameter(<property type>[,<language code>[,<property value>]])',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
	);

	private $date;


	/**
	 * Creates the swpost manager that will use the given context object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$this->setResourceName( 'db-swpost' );
		$this->date = $context->getDateTime();

		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $context->getConfig()->get( 'mshop/swpost/manager/sitemode', $level );


		$this->searchConfig['swpost:has']['function'] = function( &$source, array $params ) use ( $level ) {

			array_walk_recursive( $params, function( &$v ) {
				$v = trim( $v, '\'' );
			} );

			$keys = [];
			$params[1] = isset( $params[1] ) ? $params[1] : '';
			$params[2] = isset( $params[2] ) ? $params[2] : '';

			foreach( (array) $params[1] as $type ) {
				foreach( (array) $params[2] as $id ) {
					$keys[] = $params[0] . '|' . ( $type ? $type . '|' : '' ) . $id;
				}
			}

			$sitestr = $this->getSiteString( 'mproli."siteid"', $level );
			$keystr = $this->toExpression( 'mproli."key"', $keys, $params[2] !== '' ? '==' : '=~' );
			$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

			return $params;
		};


		$this->searchConfig['swpost:prop']['function'] = function( &$source, array $params ) use ( $level ) {

			array_walk_recursive( $params, function( &$v ) {
				$v = trim( $v, '\'' );
			} );

			$keys = [];
			$params[1] = array_key_exists( 1, $params ) ? $params[1] : '';
			$params[2] = isset( $params[2] ) ? $params[2] : '';

			foreach( (array) $params[1] as $lang ) {
				foreach( (array) $params[2] as $id ) {
					$keys[] = $params[0] . '|' . ( $lang ? $lang . '|' : '' ) . ( $id !== '' ?  md5( $id ) : '' );
				}
			}

			$sitestr = $this->getSiteString( 'mpropr."siteid"', $level );
			$keystr = $this->toExpression( 'mpropr."key"', $keys, $params[2] !== '' ? '==' : '=~' );
            echo $source;
			$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

			return $params;
		};
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Swpost\Manager\Iface Manager object for chaining method calls
	 */
	public function clear( array $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/swpost/manager/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, ['lists', 'property', 'type'] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/swpost/manager/standard/delete' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Swpost\Item\Iface New swpost item object
	 */
	public function createItem( array $values = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		$values['swpost.siteid'] = $this->getContext()->getLocale()->getSiteId();
		return $this->createItemBase( $values );
	}


	/**
	 * Creates a search object and optionally sets base criteria.
	 *
	 * @param bool $default Add default criteria
	 * @return \Aimeos\MW\Criteria\Iface Criteria object
	 */
	public function createSearch( bool $default = false ) : \Aimeos\MW\Criteria\Iface
	{
		if( $default === true )
		{
			$object = $this->createSearchBase( 'swpost' );

			$expr = array( $object->getConditions() );

			$temp = array(
				$object->compare( '==', 'swpost.type', 'event' ),
				$object->compare( '==', 'swpost.datestart', null ),
				$object->compare( '<=', 'swpost.datestart', $this->date ),
			);
			$expr[] = $object->combine( '||', $temp );

			$temp = array(
				$object->compare( '==', 'swpost.dateend', null ),
				$object->compare( '>=', 'swpost.dateend', $this->date ),
			);

			if( !$this->getContext()->getConfig()->get( 'mshop/swpost/manager/standard/strict-events', true ) ) {
				$temp[] = $object->compare( '==', 'swpost.type', 'event' );
			}

			$expr[] = $object->combine( '||', $temp );

			$object->setConditions( $object->combine( '&&', $expr ) );

			return $object;
		}

		return parent::createSearch();
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $itemIds List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Swpost\Manager\Iface Manager object for chaining method calls
	 */
	public function deleteItems( array $itemIds ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/swpost/manager/standard/delete';

		return $this->deleteItemsBase( $itemIds, $path )->deleteRefItems( $itemIds );
	}


	/**
	 * Returns the item specified by its code and domain/type if necessary
	 *
	 * @param string $code Code of the item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param string|null $domain Domain of the item if necessary to identify the item uniquely
	 * @param string|null $type Type code of the item if necessary to identify the item uniquely
	 * @param bool $default True to add default criteria
	 * @return \Aimeos\MShop\Common\Item\Iface Item object
	 */
	public function findItem( string $code, array $ref = [], string $domain = null, string $type = null,
		bool $default = false ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->findItemBase( array( 'swpost.code' => $code ), $ref, $default );
	}


	/**
	 * Returns the swpost item for the given swpost ID.
	 *
	 * @param string $id Unique ID of the swpost item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param bool $default Add default criteria
	 * @return \Aimeos\MShop\Swpost\Item\Iface Returns the swpost item of the given id
	 * @throws \Aimeos\MShop\Exception If item couldn't be found
	 */
	public function getItem( string $id, array $ref = [], bool $default = false ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->getItemBase( 'swpost.id', $id, $ref, $default );
	}


	/**
	 * Returns the available manager types
	 *
	 * @param bool $withsub Return also the resource type of sub-managers if true
	 * @return string[] Type of the manager and submanagers, subtypes are separated by slashes
	 */
	public function getResourceType( bool $withsub = true ) : array
	{
		$path = 'mshop/swpost/manager/submanagers';
		return $this->getResourceTypeBase( 'swpost', $path, ['lists', 'property'], $withsub );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return \Aimeos\MW\Criteria\Attribute\Iface[] List of search attribute items
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/swpost/manager/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for swpost extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Submanager, e.g. type, property, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'swpost', $manager, $name );
	}


	/**
	 * Updates the rating of the item
	 *
	 * @param string $id ID of the item
	 * @param string $rating Decimal value of the rating
	 * @param int $ratings Total number of ratings for the item
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object for chaining method calls
	 */
	public function rate( string $id, string $rating, int $ratings ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$path = 'mshop/swpost/manager/standard/rate';

			$stmt = $this->getCachedStatement( $conn, $path, $this->getSqlConfig( $path ) );

			$stmt->bind( 1, $rating );
			$stmt->bind( 2, $ratings, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 3, $context->getLocale()->getSiteId() );
			$stmt->bind( 4, (int) $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );

			$stmt->execute()->finish();

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		return $this;
	}


	/**
	 * Adds a new swpost to the storage.
	 *
	 * @param \Aimeos\MShop\Swpost\Item\Iface $item Swpost item that should be saved to the storage
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Swpost\Item\Iface Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Swpost\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Swpost\Item\Iface
	{
		if( !$item->isModified() )
		{
			$item = $this->savePropertyItems( $item, 'swpost', $fetch );
			return $this->saveListItems( $item, 'swpost', $fetch );
		}

		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$id = $item->getId();
			$date = date( 'Y-m-d H:i:s' );
			$columns = $this->getObject()->getSaveAttributes();

			if( $id === null )
			{
				$path = 'mshop/swpost/manager/standard/insert';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
			}
			else
			{
				$path = 'mshop/swpost/manager/standard/update';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ), false );
			}

			$idx = 1;
			$stmt = $this->getCachedStatement( $conn, $path, $sql );

			foreach( $columns as $name => $entry ) {
				$stmt->bind( $idx++, $item->get( $name ), $entry->getInternalType() );
			}

			$stmt->bind( $idx++, $item->getType() );
			$stmt->bind( $idx++, $item->getCode() );
			$stmt->bind( $idx++, $item->getDataset() );
			$stmt->bind( $idx++, $item->getLabel() );
			$stmt->bind( $idx++, $item->getUrl() );
			$stmt->bind( $idx++, $item->getStatus(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getScale(), \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT );
			$stmt->bind( $idx++, $item->getDateStart() );
			$stmt->bind( $idx++, $item->getDateEnd() );
			$stmt->bind( $idx++, json_encode( $item->getConfig() ) );
			$stmt->bind( $idx++, $item->getTarget() );
			$stmt->bind( $idx++, $context->getEditor() );
			$stmt->bind( $idx++, $date ); // mtime
			$stmt->bind( $idx++, $item->getTimeCreated() ?: $date );
			$stmt->bind( $idx++, $context->getLocale()->getSiteId() );

			if( $id !== null ) {
				$stmt->bind( $idx++, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			}

			$stmt->execute()->finish();

			if( $id === null )
			{
				$path = 'mshop/swpost/manager/standard/newid';
				$id = $this->newId( $conn, $path );
			}

			$item->setId( $id );

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		$item = $this->savePropertyItems( $item, 'swpost', $fetch );
		return $this->saveListItems( $item, 'swpost', $fetch );
	}


	/**
	 * Search for swposts based on the given criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param int|null &$total Number of items that are available in total
	 * @return \Aimeos\Map List of items implementing \Aimeos\MShop\Swpost\Item\Iface with ids as keys
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], int &$total = null ) : \Aimeos\Map
	{
		$map = [];
		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$required = array( 'swpost' );

			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$level = $context->getConfig()->get( 'mshop/swpost/manager/sitemode', $level );

			$cfgPathSearch = 'mshop/swpost/manager/standard/search';

			$cfgPathCount = 'mshop/swpost/manager/standard/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== null )
			{
				if( ( $row['swpost.config'] = json_decode( $config = $row['swpost.config'], true ) ) === null )
				{
					$msg = sprintf( 'Invalid JSON as result of search for ID "%2$s" in "%1$s": %3$s', 'sw_post.config', $row['swpost.id'], $config );
					$this->getContext()->getLogger()->log( $msg, \Aimeos\MW\Logger\Base::WARN );
				}

				$map[$row['swpost.id']] = $row;
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}


		$propItems = []; $name = 'swpost/property';
		if( isset( $ref[$name] ) || in_array( $name, $ref, true ) )
		{
			$propTypes = isset( $ref[$name] ) && is_array( $ref[$name] ) ? $ref[$name] : null;
			$propItems = $this->getPropertyItems( array_keys( $map ), 'swpost', $propTypes );
		}

		if( isset( $ref['catalog'] ) || in_array( 'catalog', $ref, true ) )
		{
			$domains = isset( $ref['catalog'] ) && is_array( $ref['catalog'] ) ? $ref['catalog'] : [];

			foreach( $this->getDomainRefItems( array_keys( $map ), 'catalog', $domains ) as $prodId => $list ) {
				$map[$prodId]['.catalog'] = $list;
			}
		}

		if( isset( $ref['supplier'] ) || in_array( 'supplier', $ref, true ) )
		{
			$domains = isset( $ref['supplier'] ) && is_array( $ref['supplier'] ) ? $ref['supplier'] : [];

			foreach( $this->getDomainRefItems( array_keys( $map ), 'supplier', $domains ) as $prodId => $list ) {
				$map[$prodId]['.supplier'] = $list;
			}
		}

		if( isset( $ref['stock'] ) || in_array( 'stock', $ref, true ) )
		{
			$codes = array_column( $map, 'swpost.id', 'swpost.code' );

			foreach( $this->getStockItems( array_keys( $codes ), $ref ) as $stockId => $stockItem )
			{
				if( isset( $codes[$stockItem->getSwpostCode()] ) ) {
					$map[$codes[$stockItem->getSwpostCode()]]['.stock'][$stockId] = $stockItem;
				}
			}
		}

		return $this->buildItems( $map, $ref, 'swpost', $propItems );
	}


	/**
	 * Create new swpost item object initialized with given parameters.
	 *
	 * @param array $values Associative list of key/value pairs
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propertyItems List of property items
	 * @return \Aimeos\MShop\Swpost\Item\Iface New swpost item
	 */
	protected function createItemBase( array $values = [], array $listItems = [],
		array $refItems = [], array $propertyItems = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		$values['.date'] = $this->date;

		return new \Aimeos\MShop\Swpost\Item\Standard( $values, $listItems, $refItems, $propertyItems );
	}


	/**
	 * Returns the associative list of domain items referencing the swpost
	 *
	 * @param array $ids List of swpost IDs
	 * @param string $domain Domain name, e.g. "catalog" or "supplier"
	 * @param array $ref List of referenced items that should be fetched too
	 * @return array Associative list of swpost IDs as keys and list of domain items as values
	 */
	protected function getDomainRefItems( array $ids, string $domain, array $ref ) : array
	{
		$keys = $map = $result = [];
		$context = $this->getContext();

		foreach( $ids as $id ) {
			$keys[] = 'swpost|default|' . $id;
		}

		$manager = \Aimeos\MShop::create( $context, $domain . '/lists' );

		$search = $manager->createSearch( true )->setSlice( 0, 0x7fffffff );
		$search->setConditions( $search->combine( '&&', [
			$search->compare( '==', $domain . '.lists.key', $keys ),
			$search->getConditions(),
		] ) );

		foreach( $manager->searchItems( $search ) as $listItem ) {
			$map[$listItem->getParentId()][] = $listItem->getRefId();
		}

		$manager = \Aimeos\MShop::create( $context, $domain );

		$search = $manager->createSearch( true )->setSlice( 0, 0x7fffffff );
		$search->setConditions( $search->combine( '&&', [
			$search->compare( '==', $domain . '.id', array_keys( $map ) ),
			$search->getConditions(),
		] ) );

		$items = $manager->searchItems( $search, $ref );

		foreach( $map as $parentId => $list )
		{
			if( isset( $items[$parentId] ) )
			{
				foreach( $list as $prodId ) {
					$result[$prodId][$parentId] = $items[$parentId];
				}
			}
		}

		return $result;
	}


	/**
	 * Returns the stock items for the given swpost codes
	 *
	 * @param string[] $codes Unique swpost codes
	 * @param string[] $ref List of domains to fetch referenced items for
	 * @return \Aimeos\Map List of IDs as keys and items implementing \Aimeos\MShop\Stock\Item\Iface as values
	 */
	protected function getStockItems( array $codes, array $ref ) : \Aimeos\Map
	{
		$manager = \Aimeos\MShop::create( $this->getContext(), 'stock' );

		$search = $manager->createSearch( true )->setSlice( 0, 0x7fffffff );
		$expr = [
			$search->compare( '==', 'stock.swpostcode', $codes ),
			$search->getConditions(),
		];

		if( isset( $ref['stock'] ) && is_array( $ref['stock'] ) ) {
			$expr[] = $search->compare( '==', 'stock.type', $ref['stock'] );
		}

		$search->setConditions( $search->combine( '&&', $expr ) );

		return $manager->searchItems( $search );
	}
}
