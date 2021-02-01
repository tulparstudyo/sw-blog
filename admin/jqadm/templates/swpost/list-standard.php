<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */

$enc = $this->encoder();


$target = $this->config( 'admin/jqadm/url/search/target' );

$controller = $this->config( 'admin/jqadm/url/search/controller', 'Jqadm' );

$action = $this->config( 'admin/jqadm/url/search/action', 'search' );

$config = $this->config( 'admin/jqadm/url/search/config', [] );

$newTarget = $this->config( 'admin/jqadm/url/create/target' );

$newCntl = $this->config( 'admin/jqadm/url/create/controller', 'Jqadm' );

$newAction = $this->config( 'admin/jqadm/url/create/action', 'create' );

$newConfig = $this->config( 'admin/jqadm/url/create/config', [] );

$getTarget = $this->config( 'admin/jqadm/url/get/target' );

$getCntl = $this->config( 'admin/jqadm/url/get/controller', 'Jqadm' );

$getAction = $this->config( 'admin/jqadm/url/get/action', 'get' );

$getConfig = $this->config( 'admin/jqadm/url/get/config', [] );

$copyTarget = $this->config( 'admin/jqadm/url/copy/target' );

$copyCntl = $this->config( 'admin/jqadm/url/copy/controller', 'Jqadm' );

$copyAction = $this->config( 'admin/jqadm/url/copy/action', 'copy' );

$copyConfig = $this->config( 'admin/jqadm/url/copy/config', [] );

$delTarget = $this->config( 'admin/jqadm/url/delete/target' );

$delCntl = $this->config( 'admin/jqadm/url/delete/controller', 'Jqadm' );

$delAction = $this->config( 'admin/jqadm/url/delete/action', 'delete' );

$delConfig = $this->config( 'admin/jqadm/url/delete/config', [] );

$default = $this->config( 'admin/jqadm/swpost/fields', ['image', 'swpost.id', 'swpost.status', 'swpost.type', 'swpost.code', 'swpost.label'] );
$fields = $this->session( 'aimeos/admin/jqadm/swpost/fields', $default );

$searchParams = $params = $this->get( 'pageParams', [] );
$searchParams['page']['start'] = 0;

$typeList = [];
foreach( $this->get( 'itemTypes', [] ) as $typeItem ) {
	$typeList[$typeItem->getCode()] = $typeItem->getCode();
}

$columnList = [
	'image' => null,
	'swpost.id' => $this->translate( 'admin', 'ID' ),
	'swpost.status' => $this->translate( 'admin', 'Status' ),
	'swpost.type' => $this->translate( 'admin', 'Type' ),
	'swpost.code' => $this->translate( 'admin', 'Code' ),
	'swpost.label' => $this->translate( 'admin', 'Label' ),
	'swpost.datestart' => $this->translate( 'admin', 'Start date' ),
	'swpost.dateend' => $this->translate( 'admin', 'End date' ),
	'swpost.config' => $this->translate( 'admin', 'Config' ),
	'swpost.ctime' => $this->translate( 'admin', 'Created' ),
	'swpost.mtime' => $this->translate( 'admin', 'Modified' ),
	'swpost.editor' => $this->translate( 'admin', 'Editor' ),
];

if (($key = array_search('swpost.code', $fields)) !== false) {
    unset($fields[$key]);
}
if (($key = array_search('swpost.id', $fields)) !== false) {
    unset($fields[$key]);
}
?>
<?php $this->block()->start( 'jqadm_content' ); ?>
<div class="vue-block" data-data="<?= $enc->attr( $this->get( 'items', map() )->getId()->toArray() ) ?>">

<nav class="main-navbar">

	<span class="navbar-brand">
		<?= $enc->html( $this->translate( 'admin', 'Swpost' ) ); ?>
		<span class="navbar-secondary">(<?= $enc->html( $this->site()->label() ); ?>)</span>
	</span>

	<?= $this->partial(
		$this->config( 'admin/jqadm/partial/navsearch', 'common/partials/navsearch-standard' ), [
			'filter' => $this->session( 'aimeos/admin/jqadm/swpost/filter', [] ),
			'filterAttributes' => $this->get( 'filterAttributes', [] ),
			'filterOperators' => $this->get( 'filterOperators', [] ),
			'params' => $params,
		]
	); ?>
</nav>


<div is="list-view" inline-template v-bind:items="data"><div>

<?= $this->partial(
		$this->config( 'admin/jqadm/partial/pagination', 'common/partials/pagination-standard' ),
		['pageParams' => $params, 'pos' => 'top', 'total' => $this->get( 'total' ),
		'page' =>$this->session( 'aimeos/admin/jqadm/swpost/page', [] )]
	);
?>

<form class="list list-swpost" method="POST" action="<?= $enc->attr( $this->url( $target, $controller, $action, $searchParams, [], $config ) ); ?>">
	<?= $this->csrf()->formfield(); ?>

	<table class="list-items table table-hover table-striped">
		<thead class="list-header">
			<tr>
				<th class="select">
					<a href="#" class="btn act-delete fa" tabindex="1" data-multi="1"
						v-on:click.prevent.stop="removeAll('<?= $enc->attr( $this->url( $delTarget, $delCntl, $delAction, ['id' => ''] + $params, [], $delConfig ) ) ?>','<?= $enc->attr( $this->translate( 'admin', 'Selected entries' ) ) ?>')"
						title="<?= $enc->attr( $this->translate( 'admin', 'Delete selected entries' ) ); ?>"
						aria-label="<?= $enc->attr( $this->translate( 'admin', 'Delete' ) ); ?>">
					</a>
				</th>

				<?= $this->partial(
						$this->config( 'admin/jqadm/partial/listhead', 'common/partials/listhead-standard' ),
						['fields' => $fields, 'params' => $params, 'data' => $columnList,
						'sort' => $this->session( 'aimeos/admin/jqadm/swpost/sort', 'swpost.id' )]
					);
				?>

				<th class="actions">
					<a class="btn fa act-add" tabindex="1"
						href="<?= $enc->attr( $this->url( $newTarget, $newCntl, $newAction, $params, [], $newConfig ) ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ); ?>"
						aria-label="<?= $enc->attr( $this->translate( 'admin', 'Add' ) ); ?>">
					</a>

					<?= $this->partial(
							$this->config( 'admin/jqadm/partial/columns', 'common/partials/columns-standard' ),
							['fields' => $fields, 'data' => $columnList]
						);
					?>
				</th>
			</tr>
		</thead>
		<tbody>

			<?= $this->partial(
				$this->config( 'admin/jqadm/partial/listsearch', 'common/partials/listsearch-standard' ), [
					'fields' => array_merge( $fields, ['select'] ), 'filter' => $this->session( 'aimeos/admin/jqadm/swpost/filter', [] ),
					'data' => [
						'image' => null,
						'swpost.id' => ['op' => '=='],
						'swpost.status' => ['op' => '==', 'type' => 'select', 'val' => [
							'1' => $this->translate( 'mshop/code', 'status:1' ),
							'0' => $this->translate( 'mshop/code', 'status:0' ),
							'-1' => $this->translate( 'mshop/code', 'status:-1' ),
							'-2' => $this->translate( 'mshop/code', 'status:-2' ),
						]],
						'swpost.type' => ['op' => '==', 'type' => 'select', 'val' => $typeList],
						/*'swpost.code' => [],*/
						'swpost.label' => [],
						'swpost.datestart' => ['op' => '-', 'type' => 'datetime-local'],
						'swpost.dateend' => ['op' => '-', 'type' => 'datetime-local'],
						'swpost.config' => ['op' => '~='],
						'swpost.ctime' => ['op' => '-', 'type' => 'datetime-local'],
						'swpost.mtime' => ['op' => '-', 'type' => 'datetime-local'],
						'swpost.editor' => [],
					]
				] );
			?>

			<?php foreach( $this->get( 'items', [] ) as $id => $item ) : ?>
				<?php $url = $enc->attr( $this->url( $getTarget, $getCntl, $getAction, ['id' => $id] + $params, [], $getConfig ) ); ?>
				<tr class="list-item <?= $this->site()->readonly( $item->getSiteId() ); ?>" data-label="<?= $enc->attr( $item->getLabel() ) ?>">
					<td class="select"><input v-on:click="toggle('<?= $id ?>')" v-bind:checked="!items['<?= $id ?>']" class="form-control" type="checkbox" tabindex="1" name="<?= $enc->attr( $this->formparam( ['id', ''] ) ) ?>" value="<?= $enc->attr( $item->getId() ) ?>" /></td>
					<?php if( in_array( 'image', $fields ) ) : $mediaItem = $item->getRefItems( 'media', 'default', 'default' )->first(); ?>
						<td class="image" ><a class="items-field" href="<?= $url; ?>" tabindex="1"><img class="image" src="<?= $mediaItem ? $enc->attr( $this->content( $mediaItem->getPreview() ) ) : '' ?>" /></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.id', $fields ) ) : ?>
						<td class="swpost-id"><a class="items-field" href="<?= $url; ?>" tabindex="1"><?= $enc->html( $item->getId() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.status', $fields ) ) : ?>
						<td class="swpost-status"><a class="items-field" href="<?= $url; ?>"><div class="fa status-<?= $enc->attr( $item->getStatus() ); ?>"></div></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.type', $fields ) ) : ?>
						<td class="swpost-type <?= $enc->html( $item->getType() ); ?>"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getType() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.code', $fields ) ) : ?>
						<td class="swpost-code">***<a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getCode() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.label', $fields ) ) : ?>
						<td class="swpost-label"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getLabel() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.datestart', $fields ) ) : ?>
						<td class="swpost-datestart"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getDateStart() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.dateend', $fields ) ) : ?>
						<td class="swpost-dateend"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getDateEnd() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.config', $fields ) ) : ?>
						<td class="swpost-config config-item">
							<a class="items-field" href="<?= $url; ?>">
								<?php foreach( $item->getConfig() as $key => $value ) : ?>
									<span class="config-key"><?= $enc->html( $key ); ?></span>
									<span class="config-value"><?= $enc->html( $value ); ?></span>
									<br/>
								<?php endforeach; ?>
							</a>
						</td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.ctime', $fields ) ) : ?>
						<td class="swpost-ctime"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getTimeCreated() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.mtime', $fields ) ) : ?>
						<td class="swpost-mtime"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getTimeModified() ); ?></a></td>
					<?php endif; ?>
					<?php if( in_array( 'swpost.editor', $fields ) ) : ?>
						<td class="swpost-editor"><a class="items-field" href="<?= $url; ?>"><?= $enc->html( $item->getEditor() ); ?></a></td>
					<?php endif; ?>

					<td class="actions">
					<a class="btn act-copy fa" tabindex="1"
							href="<?= $enc->attr( $this->url( $copyTarget, $copyCntl, $copyAction, ['id' => $id] + $params, [], $copyConfig ) ); ?>"
							title="<?= $enc->attr( $this->translate( 'admin', 'Copy this entry' ) ); ?>"
							aria-label="<?= $enc->attr( $this->translate( 'admin', 'Copy' ) ); ?>">
						</a>
						<?php if( !$this->site()->readonly( $item->getSiteId() ) ) : ?>
							<a class="btn act-delete fa" tabindex="1" href="#"
								v-on:click.prevent.stop="remove('<?= $enc->attr( $this->url( $delTarget, $delCntl, $delAction, ['id' => $id] + $params, [], $delConfig ) ) ?>','<?= $enc->attr( $item->getLabel() ) ?>')"
								title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry' ) ); ?>"
								aria-label="<?= $enc->attr( $this->translate( 'admin', 'Delete' ) ); ?>">
							</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php if( $this->get( 'items', map() )->isEmpty() ) : ?>
		<div class="noitems"><?= $enc->html( sprintf( $this->translate( 'admin', 'No items found' ) ) ); ?></div>
	<?php endif; ?>
</form>

<?= $this->partial(
		$this->config( 'admin/jqadm/partial/pagination', 'common/partials/pagination-standard' ),
		['pageParams' => $params, 'pos' => 'bottom', 'total' => $this->get( 'total' ),
		'page' => $this->session( 'aimeos/admin/jqadm/swpost/page', [] )]
	);
?>

</div></div>

</div>
<?php $this->block()->stop(); ?>

<?= $this->render( $this->config( 'admin/jqadm/template/page', 'common/page-standard' ) ); ?>
