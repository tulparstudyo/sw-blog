<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */

$selected = function( $key, $code ) {
	return ( $key == $code ? 'selected="selected"' : '' );
};

$enc = $this->encoder();

$target = $this->config( 'admin/jqadm/url/save/target' );

$cntl = $this->config( 'admin/jqadm/url/save/controller', 'Jqadm' );

$action = $this->config( 'admin/jqadm/url/save/action', 'save' );

$config = $this->config( 'admin/jqadm/url/save/config', [] );

$cfgSuggest = $this->config( 'admin/jqadm/swpost/item/config/suggest', ['css-class'] );

$navlimit = $this->config( 'admin/jqadm/swpost/item/navbar-limit', 7 );

$icons = $this->config( 'admin/jqadm/swpost/icons', [] );
$item = $this->get( 'item' );
if($item){
    $icon = $item->getConfigValue('icon');
} else {
    $icon = '';
}

$params = $this->get( 'pageParams', [] );

$navlist = array_values( $this->get( 'itemSubparts', [] ) );
?>
<?php $this->block()->start( 'jqadm_content' ); ?>

<form class="item item-swpost form-horizontal" method="POST" enctype="multipart/form-data" action="<?= $enc->attr( $this->url( $target, $cntl, $action, $params, [], $config ) ); ?>">
	<input id="item-id" type="hidden" name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.id' ) ) ); ?>" value="<?= $enc->attr( $this->get( 'itemData/swpost.id' ) ); ?>" />
	<input id="item-next" type="hidden" name="<?= $enc->attr( $this->formparam( array( 'next' ) ) ); ?>" value="get" />
	<?= $this->csrf()->formfield(); ?>

	<nav class="main-navbar">
		<h1 class="navbar-brand">
			<span class="navbar-title"><?= $enc->html( $this->translate( 'admin', 'Swpost' ) ); ?></span>
			<span class="navbar-id"><?= $enc->html( $this->get( 'itemData/swpost.id' ) ); ?></span>
			<span class="navbar-label"><?= $enc->html( $this->get( 'itemData/swpost.label' ) ?: $this->translate( 'admin', 'New' ) ); ?></span>
			<span class="navbar-site"><?= $enc->html( $this->site()->match( $this->get( 'itemData/swpost.siteid' ) ) ); ?></span>
		</h1>
		<div class="item-actions">
			<?= $this->partial( $this->config( 'admin/jqadm/partial/itemactions', 'common/partials/itemactions-standard' ), ['params' => $params] ); ?>
		</div>
	</nav>

	<div class="row item-container">

		<div class="col-md-3 item-navbar">
			<div class="navbar-content">
				<ul class="nav nav-tabs flex-md-column flex-wrap d-flex justify-content-between" role="tablist">
					<li class="nav-item basic">
						<a class="nav-link active" href="#basic" data-toggle="tab" role="tab" aria-expanded="true" aria-controls="basic">
							<?= $enc->html( $this->translate( 'admin', 'Basic' ) ); ?>
						</a>
					</li>

					<?php foreach( array_splice( $navlist, 0, $navlimit ) as $idx => $subpart ) : ?>
						<li class="nav-item <?= $enc->attr( $subpart ); ?>">
							<a class="nav-link" href="#<?= $enc->attr( $subpart ); ?>" data-toggle="tab" role="tab" tabindex="<?= ++$idx + 1; ?>">
								<?= $enc->html( $this->translate( 'admin', $subpart ) ); ?>
							</a>
						</li>
					<?php endforeach; ?>

					<li class="separator"><i class="nav-link icon more"></i></li>

					<?php foreach( $navlist as $idx => $subpart ) : ?>
						<li class="nav-item advanced <?= $enc->attr( $subpart ); ?>">
							<a class="nav-link" href="#<?= $enc->attr( $subpart ); ?>" data-toggle="tab" role="tab" tabindex="<?= ++$idx + $navlimit + 1; ?>">
								<?= $enc->html( $this->translate( 'admin', $subpart ) ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="item-meta text-muted">
					<small>
						<?= $enc->html( $this->translate( 'admin', 'Modified' ) ); ?>:
						<span class="meta-value"><?= $enc->html( $this->get( 'itemData/swpost.mtime' ) ); ?></span>
					</small>
					<small>
						<?= $enc->html( $this->translate( 'admin', 'Created' ) ); ?>:
						<span class="meta-value"><?= $enc->html( $this->get( 'itemData/swpost.ctime' ) ); ?></span>
					</small>
					<small>
						<?= $enc->html( $this->translate( 'admin', 'Editor' ) ); ?>:
						<span class="meta-value"><?= $enc->html( $this->get( 'itemData/swpost.editor' ) ); ?></span>
					</small>
				</div>
			</div>
		</div>

		<div class="col-md-9 item-content tab-content">

			<div id="basic" class="row item-basic tab-pane fade show active" role="tabpanel" aria-labelledby="basic">

				<div class="col-xl-6 content-block vue-block <?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?>"
					data-data="<?= $enc->attr( $this->get( 'itemData', new stdClass() ) ) ?>">

					<?php if( $this->config( 'admin/jqadm/dataset/swpost', [] ) !== [] ) : ?>
						<div class="form-group row optional">
							<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Data set' ) ); ?></label>
							<div class="col-sm-8">
								<select class="form-control custom-select item-set" tabindex="1"
									name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.dataset' ) ) ); ?>"
									<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> >
									<option value="">
										<?= $enc->html( $this->translate( 'admin', 'None' ) ); ?>
									</option>

									<?php foreach( $this->config( 'admin/jqadm/dataset/swpost', [] ) as $name => $config ) : ?>
										<option value="<?= $enc->attr( $name ); ?>" <?= $selected( $this->get( 'itemData/swpost.dataset' ), $name ); ?>
											data-config="<?= $enc->attr( $config ) ?>" >
											<?= $enc->html( $name ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-sm-12 form-text text-muted help-text">
								<?= $enc->html( $this->translate( 'admin', 'Depending on the selected data set, the list of shown fields for the swpost will be different' ) ); ?>
							</div>
						</div>
					<?php endif ?>
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Status' ) ); ?></label>
						<div class="col-sm-8">
							<select class="form-control custom-select item-status" required="required" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.status' ) ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> >
								<option value="">
									<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
								</option>
								<option value="1" <?= $selected( $this->get( 'itemData/swpost.status', 1 ), 1 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:1' ) ); ?>
								</option>
								<option value="0" <?= $selected( $this->get( 'itemData/swpost.status', 1 ), 0 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:0' ) ); ?>
								</option>
								<option value="-1" <?= $selected( $this->get( 'itemData/swpost.status', 1 ), -1 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:-1' ) ); ?>
								</option>
								<option value="-2" <?= $selected( $this->get( 'itemData/swpost.status', 1 ), -2 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:-2' ) ); ?>
								</option>
							</select>
						</div>
					</div>
					<?php if( ( $types = $this->get( 'itemTypes', map() )->col( 'swpost.type.label', 'swpost.type.code' ) )->count() !== 1 ) : ?>
						<div class="form-group row mandatory">
							<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Type' ) ); ?></label>
							<div class="col-sm-8">
								<select is="select-component" class="form-control custom-select item-type" required v-bind:tabindex="'1'"
									v-bind:readonly="'<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?>' ? true : false"
									v-bind:name="'<?= $enc->attr( $this->formparam( ['item', 'swpost.type'] ) ); ?>'"
									v-bind:text="'<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>'"
									v-bind:items="JSON.parse('<?= $enc->attr( $types->toArray() ) ?>')"
									v-model="data['swpost.type']" >
									<option value="<?= $enc->attr( $this->get( 'itemData/swpost.type' ) ) ?>">
										<?= $enc->html( $types[$this->get( 'itemData/swpost.type', '' )] ?? $this->translate( 'admin', 'Please select' ) ) ?>
									</option>
								</select>
							</div>
						</div>
					<?php else : ?>
						<input class="item-type" type="hidden"
							name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.type' ) ) ); ?>"
							value="<?= $enc->attr( $types->firstKey() ) ?>" />
					<?php endif; ?>
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'SKU' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-code" type="text" required="required" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.code' ) ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'EAN, SKU or article number (required)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/swpost.code' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Unique article code related to stock levels, e.g. from the ERP system, an EAN/GTIN number or self invented' ) ); ?>
						</div>
					</div>
					<div class="form-group row mandatory">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Label' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-label" type="text" required="required" tabindex="1"
								name="<?= $this->formparam( array( 'item', 'swpost.label' ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'Internal name (required)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/swpost.label' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Internal article name, will be used on the web site and for searching only if no other swpost names in any language exist' ) ); ?>
						</div>
					</div>

					<div class="separator"><i class="icon more"></i></div>

					<div class="form-group row optional advanced">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'URL segment' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-label" type="text" tabindex="1"
								name="<?= $this->formparam( array( 'item', 'swpost.url' ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'Name in URL (optional)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/swpost.url' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'The name of the swpost shown in the URL, will be used if no language specific URL segment exists' ) ); ?>
						</div>
					</div>
					<div class="form-group row optional advanced">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Quantity scale' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-scale" type="number" tabindex="1" min="0.001" step="0.001"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.scale' ) ) ); ?>"
								value="<?= $enc->attr( $this->datetime( $this->get( 'itemData/swpost.scale', 1 ) ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'The step value allowed for quantities in the basket, e.g. "0.1" for fractional quantities or "5" for multiple of five articles' ) ); ?>
						</div>
					</div>
					<div class="form-group row optional advanced">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Start date' ) ); ?></label>
						<div class="col-sm-8">
							<input is="flat-pickr" class="form-control item-datestart" type="datetime-local" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.datestart' ) ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'YYYY-MM-DD hh:mm:ss (optional)' ) ); ?>"
								v-bind:value="'<?= $enc->attr( $this->datetime( $this->get( 'itemData/swpost.datestart' ) ) ); ?>'"
								v-bind:disabled="'<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?>' !== ''"
								v-bind:config="Aimeos.flatpickr.datetime" />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'The article is only shown on the web site after that date and time, useful or seasonal articles' ) ); ?>
						</div>
					</div>
					<div class="form-group row optional advanced">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'End date' ) ); ?></label>
						<div class="col-sm-8">
							<input is="flat-pickr" class="form-control item-dateend" type="datetime-local" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.dateend' ) ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'YYYY-MM-DD hh:mm:ss (optional)' ) ); ?>"
								v-bind:value="'<?= $enc->attr( $this->datetime( $this->get( 'itemData/swpost.dateend' ) ) ); ?>'"
								v-bind:disabled="'<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?>' !== ''"
								v-bind:config="Aimeos.flatpickr.datetime" />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'The article is only shown on the web site until that date and time, useful or seasonal articles' ) ); ?>
						</div>
					</div>
					<div class="form-group row optional advanced">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'Created' ) ); ?></label>
						<div class="col-sm-8">
							<input is="flat-pickr" class="form-control item-ctime" type="datetime-local" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.ctime' ) ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'YYYY-MM-DD hh:mm:ss (optional)' ) ); ?>"
								v-bind:value="'<?= $enc->attr( $this->datetime( $this->get( 'itemData/swpost.ctime' ) ) ); ?>'"
								v-bind:disabled="'<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?>' !== ''"
								v-bind:config="Aimeos.flatpickr.datetime" />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Since when the swpost is available, used for sorting in the front-end' ) ); ?>
						</div>
					</div>
					<div class="form-group row optional advanced warning">
						<label class="col-sm-4 form-control-label help"><?= $enc->html( $this->translate( 'admin', 'URL target' ) ); ?></label>
						<div class="col-sm-8">
							<input class="form-control item-target" type="text" tabindex="1"
								name="<?= $enc->attr( $this->formparam( array( 'item', 'swpost.target' ) ) ); ?>"
								placeholder="<?= $enc->attr( $this->translate( 'admin', 'Route or page ID (optional)' ) ); ?>"
								value="<?= $enc->attr( $this->get( 'itemData/swpost.target' ) ); ?>"
								<?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?> />
						</div>
						<div class="col-sm-12 form-text text-muted help-text">
							<?= $enc->html( $this->translate( 'admin', 'Route name or page ID of the swpost detail page if this swpost should shown on a different page' ) ); ?>
						</div>
					</div>
				</div><!--

				--><div class="col-xl-6 content-block vue-block <?= $this->site()->readonly( $this->get( 'itemData/swpost.siteid' ) ); ?>"
					data-data="<?= $enc->attr( $this->get( 'itemData', new stdClass() ) ) ?>">

					<config-table inline-template
						v-bind:readonly="data['swpost.siteid'] != '<?= $this->site()->siteid() ?>'"
						v-bind:items="data['config']" v-on:change="data['config'] = $event">

						<table class="item-config table table-striped">
							<thead>
								<tr>
									<th class="config-row-key">
										<span class="help"><?= $enc->html( $this->translate( 'admin', 'Option' ) ); ?></span>
										<div class="form-text text-muted help-text">
											<?= $enc->html( $this->translate( 'admin', 'Article specific configuration options, will be available as key/value pairs in the templates' ) ); ?>
										</div>
									</th>
									<th class="config-row-value"><?= $enc->html( $this->translate( 'admin', 'Value' ) ); ?></th>
									<th class="actions">
										<div v-if="!readonly" class="btn act-add fa" tabindex="1" v-on:click="add()"
											title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ); ?>"></div>
									</th>
								</tr>
							</thead>
							<tbody>
<tr class="config-item"><td class="config-row-key"><input type="text" name="item[config][icon][key]" required="required"  class="form-control form-control ui-autocomplete-input is-valid" autocomplete="off" value="icon" readonly></td> <td class="config-row-value"><select name="item[config][icon][val]" class="form-control">
<option value=""><?= $enc->attr( $this->translate( 'admin', 'Select a Icon' ) ); ?></option>    
    <?php foreach($icons as $icon_key => $icon_name ){ ?>
<option value="<?=$icon_key?>" <?php if($icon_key==$icon) echo 'selected';?>><?= $enc->attr( $this->translate( 'admin', $icon_name ) ); ?></option>    
    <?php } ?>
    </select></td> <td class="actions"><div  title="Delete this entry" class="btn act-delete fa"></div></td></tr>
                                
                                
								<tr v-for="(entry, pos) in items" v-bind:key="pos" class="config-item">
									<td class="config-row-key">
										<input is="auto-complete" required class="form-control" v-bind:readonly="readonly" tabindex="1"
											v-bind:name="'<?= $enc->attr( $this->formparam( array( 'item', 'config', '_pos_', 'key' ) ) ); ?>'.replace('_pos_', pos)"
											v-bind:keys="JSON.parse('<?= $enc->attr( $this->config( 'admin/jqadm/swpost/item/config/suggest', ['css-class'] ) ) ?>')"
											v-model="entry.key" />
									</td>
									<td class="config-row-value">
										<input class="form-control" v-bind:readonly="readonly" v-bind:tabindex="1"
											v-bind:name="'<?= $enc->attr( $this->formparam( array( 'item', 'config', '_pos_', 'val' ) ) ); ?>'.replace('_pos_', pos)"
											v-model="entry.val" />
									</td>
									<td class="actions">
										<div v-if="!readonly" class="btn act-delete fa" tabindex="1" v-on:click="remove(pos)"
											title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry' ) ); ?>"></div>
									</td>
								</tr>
							</tbody>
						</table>
					</config-table>
				</div>

			</div>
			<?= $this->get( 'itemBody' ); ?>
		</div>

		<div class="item-actions">
			<?= $this->partial( $this->config( 'admin/jqadm/partial/itemactions', 'common/partials/itemactions-standard' ), ['params' => $params] ); ?>
		</div>
	</div>
</form>

<?php $this->block()->stop(); ?>


<?= $this->render( $this->config( 'admin/jqadm/template/page', 'common/page-standard' ) ); ?>
