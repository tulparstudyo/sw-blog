<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package MShop
 * @subpackage Post
 */


namespace Aimeos\MShop\Post\Manager;


/**
 * Default post manager.
 *
 * @package MShop
 * @subpackage Post
 */
class Standard
	extends \Aimeos\MShop\Common\Manager\Base
	implements \Aimeos\MShop\Post\Manager\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface,
		\Aimeos\MShop\Common\Manager\ListRef\Iface, \Aimeos\MShop\Common\Manager\PropertyRef\Iface,
		\Aimeos\MShop\Common\Manager\Rating\Iface
{
	use \Aimeos\MShop\Common\Manager\ListRef\Traits;
	use \Aimeos\MShop\Common\Manager\PropertyRef\Traits;


	private $searchConfig = array(
		'post.id' => array(
			'code' => 'post.id',
			'internalcode' => 'mpro."id"',
			'label' => 'ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'post.siteid' => array(
			'code' => 'post.siteid',
			'internalcode' => 'mpro."siteid"',
			'label' => 'Site ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.type' => array(
			'code' => 'post.type',
			'internalcode' => 'mpro."type"',
			'label' => 'Type',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.label' => array(
			'code' => 'post.label',
			'internalcode' => 'mpro."label"',
			'label' => 'Label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.code' => array(
			'code' => 'post.code',
			'internalcode' => 'mpro."code"',
			'label' => 'SKU',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.url' => array(
			'code' => 'post.url',
			'internalcode' => 'mpro."url"',
			'label' => 'URL segment',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.dataset' => array(
			'code' => 'post.dataset',
			'internalcode' => 'mpro."dataset"',
			'label' => 'Data set',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.datestart' => array(
			'code' => 'post.datestart',
			'internalcode' => 'mpro."start"',
			'label' => 'Start date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.dateend' => array(
			'code' => 'post.dateend',
			'internalcode' => 'mpro."end"',
			'label' => 'End date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'post.status' => array(
			'code' => 'post.status',
			'internalcode' => 'mpro."status"',
			'label' => 'Status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'post.scale' => array(
			'code' => 'post.scale',
			'internalcode' => 'mpro."scale"',
			'label' => 'Quantity scale',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
		),
		'post.config' => array(
			'code' => 'post.config',
			'internalcode' => 'mpro."config"',
			'label' => 'Config',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.target' => array(
			'code' => 'post.target',
			'internalcode' => 'mpro."target"',
			'label' => 'URL target',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.ctime' => array(
			'code' => 'post.ctime',
			'internalcode' => 'mpro."ctime"',
			'label' => 'Create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.mtime' => array(
			'code' => 'post.mtime',
			'internalcode' => 'mpro."mtime"',
			'label' => 'Modify date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.editor' => array(
			'code' => 'post.editor',
			'internalcode' => 'mpro."editor"',
			'label' => 'Editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.rating' => array(
			'code' => 'post.rating',
			'internalcode' => 'mpro."rating"',
			'label' => 'Rating value',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'post.ratings' => array(
			'code' => 'post.ratings',
			'internalcode' => 'mpro."ratings"',
			'label' => 'Number of ratings',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'post:has' => array(
			'code' => 'post:has()',
			'internalcode' => ':site AND :key AND mproli."id"',
			'internaldeps' => ['LEFT JOIN "mshop_post_list" AS mproli ON ( mproli."parentid" = mpro."id" )'],
			'label' => 'Post has list item, parameter(<domain>[,<list type>[,<reference ID>)]]',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
		'post:prop' => array(
			'code' => 'post:prop()',
			'internalcode' => ':site AND :key AND mpropr."id"',
			'internaldeps' => ['LEFT JOIN "mshop_post_property" AS mpropr ON ( mpropr."parentid" = mpro."id" )'],
			'label' => 'Post has property item, parameter(<property type>[,<language code>[,<property value>]])',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
	);

	private $date;


	/**
	 * Creates the post manager that will use the given context object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$this->setResourceName( 'db-post' );
		$this->date = $context->getDateTime();

		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $context->getConfig()->get( 'mshop/post/manager/sitemode', $level );


		$this->searchConfig['post:has']['function'] = function( &$source, array $params ) use ( $level ) {

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


		$this->searchConfig['post:prop']['function'] = function( &$source, array $params ) use ( $level ) {

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
			$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

			return $params;
		};
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Post\Manager\Iface Manager object for chaining method calls
	 */
	public function clear( array $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/post/manager/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, ['lists', 'property', 'type'] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/post/manager/standard/delete' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Post\Item\Iface New post item object
	 */
	public function createItem( array $values = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		$values['post.siteid'] = $this->getContext()->getLocale()->getSiteId();
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
			$object = $this->createSearchBase( 'post' );

			$expr = array( $object->getConditions() );

			$temp = array(
				$object->compare( '==', 'post.type', 'event' ),
				$object->compare( '==', 'post.datestart', null ),
				$object->compare( '<=', 'post.datestart', $this->date ),
			);
			$expr[] = $object->combine( '||', $temp );

			$temp = array(
				$object->compare( '==', 'post.dateend', null ),
				$object->compare( '>=', 'post.dateend', $this->date ),
			);

			/** mshop/post/manager/standard/strict-events
			 * Hide events automatically if they are over
			 *
			 * Events are hidden by default if they are finished, removed from the
			 * list view and can't be bought any more. If you sell webinars including
			 * an archive of old ones you want to continue to sell for example, then
			 * these webinars should be still shown.
			 *
			 * Setting this configuration option to false will display event posts
			 * that are already over and customers can still buy them.
			 *
			 * @param bool TRUE to hide events after they are over (default), FALSE to continue to show them
			 * @category Developer
			 * @category User
			 * @since 2019.10
			 */
			if( !$this->getContext()->getConfig()->get( 'mshop/post/manager/standard/strict-events', true ) ) {
				$temp[] = $object->compare( '==', 'post.type', 'event' );
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
	 * @return \Aimeos\MShop\Post\Manager\Iface Manager object for chaining method calls
	 */
	public function deleteItems( array $itemIds ) : \Aimeos\MShop\Common\Manager\Iface
	{
		/** mshop/post/manager/standard/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/post/manager/standard/delete/ansi
		 */

		/** mshop/post/manager/standard/delete/ansi
		 * Deletes the items matched by the given IDs from the database
		 *
		 * Removes the records specified by the given IDs from the post database.
		 * The records must be from the site that is configured via the
		 * context item.
		 *
		 * The ":cond" placeholder is replaced by the name of the ID column and
		 * the given ID or list of IDs while the site ID is bound to the question
		 * mark.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for deleting items
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/post/manager/standard/insert/ansi
		 * @see mshop/post/manager/standard/update/ansi
		 * @see mshop/post/manager/standard/newid/ansi
		 * @see mshop/post/manager/standard/search/ansi
		 * @see mshop/post/manager/standard/count/ansi
		 */
		$path = 'mshop/post/manager/standard/delete';

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
		return $this->findItemBase( array( 'post.code' => $code ), $ref, $default );
	}


	/**
	 * Returns the post item for the given post ID.
	 *
	 * @param string $id Unique ID of the post item
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param bool $default Add default criteria
	 * @return \Aimeos\MShop\Post\Item\Iface Returns the post item of the given id
	 * @throws \Aimeos\MShop\Exception If item couldn't be found
	 */
	public function getItem( string $id, array $ref = [], bool $default = false ) : \Aimeos\MShop\Common\Item\Iface
	{
		return $this->getItemBase( 'post.id', $id, $ref, $default );
	}


	/**
	 * Returns the available manager types
	 *
	 * @param bool $withsub Return also the resource type of sub-managers if true
	 * @return string[] Type of the manager and submanagers, subtypes are separated by slashes
	 */
	public function getResourceType( bool $withsub = true ) : array
	{
		$path = 'mshop/post/manager/submanagers';
		return $this->getResourceTypeBase( 'post', $path, ['lists', 'property'], $withsub );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return \Aimeos\MW\Criteria\Attribute\Iface[] List of search attribute items
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		/** mshop/post/manager/submanagers
		 * List of manager names that can be instantiated by the post manager
		 *
		 * Managers provide a generic interface to the underlying storage.
		 * Each manager has or can have sub-managers caring about particular
		 * aspects. Each of these sub-managers can be instantiated by its
		 * parent manager using the getSubManager() method.
		 *
		 * The search keys from sub-managers can be normally used in the
		 * manager as well. It allows you to search for items of the manager
		 * using the search keys of the sub-managers to further limit the
		 * retrieved list of items.
		 *
		 * @param array List of sub-manager names
		 * @since 2014.03
		 * @category Developer
		 */
		$path = 'mshop/post/manager/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for post extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Submanager, e.g. type, property, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'post', $manager, $name );
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
			/** mshop/post/manager/standard/rate/mysql
			 * Updates the rating of the post in the database
			 *
			 * @see mshop/post/manager/standard/rate/ansi
			 */

			/** mshop/post/manager/standard/rate/ansi
			 * Updates the rating of the post in the database
			 *
			 * The SQL statement must be a string suitable for being used as
			 * prepared statement. It must include question marks for binding
			 * the values for the rating to the statement before they are
			 * sent to the database server. The order of the columns must
			 * correspond to the order in the rate() method, so the
			 * correct values are bound to the columns.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for update ratings
			 * @since 2020.10
			 * @category Developer
			 * @see mshop/post/manager/standard/insert/ansi
			 * @see mshop/post/manager/standard/update/ansi
			 * @see mshop/post/manager/standard/newid/ansi
			 * @see mshop/post/manager/standard/delete/ansi
			 * @see mshop/post/manager/standard/search/ansi
			 * @see mshop/post/manager/standard/count/ansi
			 */
			$path = 'mshop/post/manager/standard/rate';

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
	 * Adds a new post to the storage.
	 *
	 * @param \Aimeos\MShop\Post\Item\Iface $item Post item that should be saved to the storage
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Post\Item\Iface Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Post\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Post\Item\Iface
	{
		if( !$item->isModified() )
		{
			$item = $this->savePropertyItems( $item, 'post', $fetch );
			return $this->saveListItems( $item, 'post', $fetch );
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
				/** mshop/post/manager/standard/insert/mysql
				 * Inserts a new post record into the database table
				 *
				 * @see mshop/post/manager/standard/insert/ansi
				 */

				/** mshop/post/manager/standard/insert/ansi
				 * Inserts a new post record into the database table
				 *
				 * Items with no ID yet (i.e. the ID is NULL) will be created in
				 * the database and the newly created ID retrieved afterwards
				 * using the "newid" SQL statement.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the post item to the statement before they are
				 * sent to the database server. The number of question marks must
				 * be the same as the number of columns listed in the INSERT
				 * statement. The order of the columns must correspond to the
				 * order in the saveItems() method, so the correct values are
				 * bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for inserting records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/post/manager/standard/update/ansi
				 * @see mshop/post/manager/standard/newid/ansi
				 * @see mshop/post/manager/standard/delete/ansi
				 * @see mshop/post/manager/standard/search/ansi
				 * @see mshop/post/manager/standard/count/ansi
				 */
				$path = 'mshop/post/manager/standard/insert';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
			}
			else
			{
				/** mshop/post/manager/standard/update/mysql
				 * Updates an existing post record in the database
				 *
				 * @see mshop/post/manager/standard/update/ansi
				 */

				/** mshop/post/manager/standard/update/ansi
				 * Updates an existing post record in the database
				 *
				 * Items which already have an ID (i.e. the ID is not NULL) will
				 * be updated in the database.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the post item to the statement before they are
				 * sent to the database server. The order of the columns must
				 * correspond to the order in the saveItems() method, so the
				 * correct values are bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for updating records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/post/manager/standard/insert/ansi
				 * @see mshop/post/manager/standard/newid/ansi
				 * @see mshop/post/manager/standard/delete/ansi
				 * @see mshop/post/manager/standard/search/ansi
				 * @see mshop/post/manager/standard/count/ansi
				 */
				$path = 'mshop/post/manager/standard/update';
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
				/** mshop/post/manager/standard/newid/mysql
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * @see mshop/post/manager/standard/newid/ansi
				 */

				/** mshop/post/manager/standard/newid/ansi
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * As soon as a new record is inserted into the database table,
				 * the database server generates a new and unique identifier for
				 * that record. This ID can be used for retrieving, updating and
				 * deleting that specific record from the table again.
				 *
				 * For MySQL:
				 *  SELECT LAST_INSERT_ID()
				 * For PostXgreSQL:
				 *  SELECT currval('seq_mpro_id')
				 * For SQL Server:
				 *  SELECT SCOPE_IDENTITY()
				 * For Oracle:
				 *  SELECT "seq_mpro_id".CURRVAL FROM DUAL
				 *
				 * There's no way to retrive the new ID by a SQL statements that
				 * fits for most database servers as they implement their own
				 * specific way.
				 *
				 * @param string SQL statement for retrieving the last inserted record ID
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/post/manager/standard/insert/ansi
				 * @see mshop/post/manager/standard/update/ansi
				 * @see mshop/post/manager/standard/delete/ansi
				 * @see mshop/post/manager/standard/search/ansi
				 * @see mshop/post/manager/standard/count/ansi
				 */
				$path = 'mshop/post/manager/standard/newid';
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

		$item = $this->savePropertyItems( $item, 'post', $fetch );
		return $this->saveListItems( $item, 'post', $fetch );
	}


	/**
	 * Search for posts based on the given criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param int|null &$total Number of items that are available in total
	 * @return \Aimeos\Map List of items implementing \Aimeos\MShop\Post\Item\Iface with ids as keys
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
			$required = array( 'post' );

			/** mshop/post/manager/sitemode
			 * Mode how items from levels below or above in the site tree are handled
			 *
			 * By default, only items from the current site are fetched from the
			 * storage. If the ai-sites extension is installed, you can create a
			 * tree of sites. Then, this setting allows you to define for the
			 * whole post domain if items from parent sites are inherited,
			 * sites from child sites are aggregated or both.
			 *
			 * Available constants for the site mode are:
			 * * 0 = only items from the current site
			 * * 1 = inherit items from parent sites
			 * * 2 = aggregate items from child sites
			 * * 3 = inherit and aggregate items at the same time
			 *
			 * You also need to set the mode in the locale manager
			 * (mshop/locale/manager/standard/sitelevel) to one of the constants.
			 * If you set it to the same value, it will work as described but you
			 * can also use different modes. For example, if inheritance and
			 * aggregation is configured the locale manager but only inheritance
			 * in the domain manager because aggregating items makes no sense in
			 * this domain, then items wil be only inherited. Thus, you have full
			 * control over inheritance and aggregation in each domain.
			 *
			 * @param int Constant from Aimeos\MShop\Locale\Manager\Base class
			 * @category Developer
			 * @since 2018.01
			 * @see mshop/locale/manager/standard/sitelevel
			 */
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$level = $context->getConfig()->get( 'mshop/post/manager/sitemode', $level );

			/** mshop/post/manager/standard/search/mysql
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * @see mshop/post/manager/standard/search/ansi
			 */

			/** mshop/post/manager/standard/search/ansi
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * Fetches the records matched by the given criteria from the post
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the SELECT statement can retrieve all records
			 * from the current site and the complete sub-tree of sites.
			 *
			 * As the records can normally be limited by criteria from sub-managers,
			 * their tables must be joined in the SQL context. This is done by
			 * using the "internaldeps" property from the definition of the ID
			 * column of the sub-managers. These internal dependencies specify
			 * the JOIN between the tables and the used columns for joining. The
			 * ":joins" placeholder is then replaced by the JOIN strings from
			 * the sub-managers.
			 *
			 * To limit the records matched, conditions can be added to the given
			 * criteria object. It can contain comparisons like column names that
			 * must match specific values which can be combined by AND, OR or NOT
			 * operators. The resulting string of SQL conditions replaces the
			 * ":cond" placeholder before the statement is sent to the database
			 * server.
			 *
			 * If the records that are retrieved should be ordered by one or more
			 * columns, the generated string of column / sort direction pairs
			 * replaces the ":order" placeholder. In case no ordering is required,
			 * the complete ORDER BY part including the "\/*-orderby*\/...\/*orderby-*\/"
			 * markers is removed to speed up retrieving the records. Columns of
			 * sub-managers can also be used for ordering the result set but then
			 * no index can be used.
			 *
			 * The number of returned records can be limited and can start at any
			 * number between the begining and the end of the result set. For that
			 * the ":size" and ":start" placeholders are replaced by the
			 * corresponding values from the criteria object. The default values
			 * are 0 for the start and 100 for the size value.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for searching items
			 * @since 2014.03
			 * @category Developer
			 * @see mshop/post/manager/standard/insert/ansi
			 * @see mshop/post/manager/standard/update/ansi
			 * @see mshop/post/manager/standard/newid/ansi
			 * @see mshop/post/manager/standard/delete/ansi
			 * @see mshop/post/manager/standard/count/ansi
			 */
			$cfgPathSearch = 'mshop/post/manager/standard/search';

			/** mshop/post/manager/standard/count/mysql
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * @see mshop/post/manager/standard/count/ansi
			 */

			/** mshop/post/manager/standard/count/ansi
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * Counts all records matched by the given criteria from the post
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the statement can count all records from the
			 * current site and the complete sub-tree of sites.
			 *
			 * As the records can normally be limited by criteria from sub-managers,
			 * their tables must be joined in the SQL context. This is done by
			 * using the "internaldeps" property from the definition of the ID
			 * column of the sub-managers. These internal dependencies specify
			 * the JOIN between the tables and the used columns for joining. The
			 * ":joins" placeholder is then replaced by the JOIN strings from
			 * the sub-managers.
			 *
			 * To limit the records matched, conditions can be added to the given
			 * criteria object. It can contain comparisons like column names that
			 * must match specific values which can be combined by AND, OR or NOT
			 * operators. The resulting string of SQL conditions replaces the
			 * ":cond" placeholder before the statement is sent to the database
			 * server.
			 *
			 * Both, the strings for ":joins" and for ":cond" are the same as for
			 * the "search" SQL statement.
			 *
			 * Contrary to the "search" statement, it doesn't return any records
			 * but instead the number of records that have been found. As counting
			 * thousands of records can be a long running task, the maximum number
			 * of counted records is limited for performance reasons.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for counting items
			 * @since 2014.03
			 * @category Developer
			 * @see mshop/post/manager/standard/insert/ansi
			 * @see mshop/post/manager/standard/update/ansi
			 * @see mshop/post/manager/standard/newid/ansi
			 * @see mshop/post/manager/standard/delete/ansi
			 * @see mshop/post/manager/standard/search/ansi
			 */
			$cfgPathCount = 'mshop/post/manager/standard/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== null )
			{
				if( ( $row['post.config'] = json_decode( $config = $row['post.config'], true ) ) === null )
				{
					$msg = sprintf( 'Invalid JSON as result of search for ID "%2$s" in "%1$s": %3$s', 'mshop_post.config', $row['post.id'], $config );
					$this->getContext()->getLogger()->log( $msg, \Aimeos\MW\Logger\Base::WARN );
				}

				$map[$row['post.id']] = $row;
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}


		$propItems = []; $name = 'post/property';
		if( isset( $ref[$name] ) || in_array( $name, $ref, true ) )
		{
			$propTypes = isset( $ref[$name] ) && is_array( $ref[$name] ) ? $ref[$name] : null;
			$propItems = $this->getPropertyItems( array_keys( $map ), 'post', $propTypes );
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
			$codes = array_column( $map, 'post.id', 'post.code' );

			foreach( $this->getStockItems( array_keys( $codes ), $ref ) as $stockId => $stockItem )
			{
				if( isset( $codes[$stockItem->getPostCode()] ) ) {
					$map[$codes[$stockItem->getPostCode()]]['.stock'][$stockId] = $stockItem;
				}
			}
		}

		return $this->buildItems( $map, $ref, 'post', $propItems );
	}


	/**
	 * Create new post item object initialized with given parameters.
	 *
	 * @param array $values Associative list of key/value pairs
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propertyItems List of property items
	 * @return \Aimeos\MShop\Post\Item\Iface New post item
	 */
	protected function createItemBase( array $values = [], array $listItems = [],
		array $refItems = [], array $propertyItems = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		$values['.date'] = $this->date;

		return new \Aimeos\MShop\Post\Item\Standard( $values, $listItems, $refItems, $propertyItems );
	}


	/**
	 * Returns the associative list of domain items referencing the post
	 *
	 * @param array $ids List of post IDs
	 * @param string $domain Domain name, e.g. "catalog" or "supplier"
	 * @param array $ref List of referenced items that should be fetched too
	 * @return array Associative list of post IDs as keys and list of domain items as values
	 */
	protected function getDomainRefItems( array $ids, string $domain, array $ref ) : array
	{
		$keys = $map = $result = [];
		$context = $this->getContext();

		foreach( $ids as $id ) {
			$keys[] = 'post|default|' . $id;
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
	 * Returns the stock items for the given post codes
	 *
	 * @param string[] $codes Unique post codes
	 * @param string[] $ref List of domains to fetch referenced items for
	 * @return \Aimeos\Map List of IDs as keys and items implementing \Aimeos\MShop\Stock\Item\Iface as values
	 */
	protected function getStockItems( array $codes, array $ref ) : \Aimeos\Map
	{
		$manager = \Aimeos\MShop::create( $this->getContext(), 'stock' );

		$search = $manager->createSearch( true )->setSlice( 0, 0x7fffffff );
		$expr = [
			$search->compare( '==', 'stock.postcode', $codes ),
			$search->getConditions(),
		];

		if( isset( $ref['stock'] ) && is_array( $ref['stock'] ) ) {
			$expr[] = $search->compare( '==', 'stock.type', $ref['stock'] );
		}

		$search->setConditions( $search->combine( '&&', $expr ) );

		return $manager->searchItems( $search );
	}
}
