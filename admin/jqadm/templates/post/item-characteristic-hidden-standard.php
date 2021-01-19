<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2020
 */


$enc = $this->encoder();

$starget = $this->config( 'admin/jqadm/url/search/target' );
$scntl = $this->config( 'admin/jqadm/url/search/controller', 'Jqadm' );
$saction = $this->config( 'admin/jqadm/url/search/action', 'search' );
$sconfig = $this->config( 'admin/jqadm/url/search/config', [] );

$keys = [
	'post.lists.id', 'post.lists.siteid', 'post.lists.refid',
	'attribute.label', 'attribute.type'
];


?>
<div class="col-xl-12 content-block item-characteristic-hidden">

	<table class="attribute-list table table-default"
		data-items="<?= $enc->attr( $this->get( 'hiddenData', [] ) ); ?>"
		data-keys="<?= $enc->attr( $keys ) ?>"
		data-prefix="post.lists."
		data-siteid="<?= $this->site()->siteid() ?>" >

		<thead>
			<tr>
				<th>
					<span class="help"><?= $enc->html( $this->translate( 'admin', 'Type' ) ); ?></span>
					<div class="form-text text-muted help-text">
						<?= $enc->html( $this->translate( 'admin', 'Attribute type that limits the list of available attributes' ) ); ?>
					</div>
				</th>
				<th>
					<span class="help"><?= $enc->html( $this->translate( 'admin', 'Hidden attributes' ) ); ?></span>
					<div class="form-text text-muted help-text">
						<?= $enc->html( $this->translate( 'admin', 'Hidden post attributes that are stored with the ordered posts' ) ); ?>
					</div>
				</th>
				<th class="actions">
					<a class="btn act-list fa" tabindex="<?= $this->get( 'tabindex' ); ?>" target="_blank"
						title="<?= $enc->attr( $this->translate( 'admin', 'Go to attribute panel' ) ); ?>"
						href="<?= $enc->attr( $this->url( $starget, $scntl, $saction, ['resource' => 'attribute'] + $this->get( 'pageParams', [] ), [], $sconfig ) ); ?>">
					</a>
					<div class="btn act-add fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ); ?>"
						v-on:click="add()">
					</div>
				</th>
			</tr>
		</thead>

		<tbody is="draggable" v-model="items" group="characteristic-hidden" handle=".act-move" tag="tbody">

			<tr v-for="(item, idx) in items" v-bind:key="idx"
				v-bind:class="item['post.lists.siteid'] != '<?= $this->site()->siteid() ?>' ? 'readonly' : ''">
				<td v-bind:class="item['css'] || ''">
					<select class="form-control custom-select item-type" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>"
						v-bind:name="'<?= $enc->attr( $this->formparam( array( 'characteristic', 'hidden', 'idx', 'attribute.type' ) ) ); ?>'.replace('idx', idx)"
						v-bind:readonly="checkSite('post.lists.siteid', idx) || item['post.lists.id'] != ''"
						v-model="item['attribute.type']" >

						<option v-if="item['post.lists.id'] == ''" value="" disabled="disabled">
							<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
						</option>

						<?php foreach( $this->get( 'attributeTypes', [] ) as $item ) : ?>
							<option v-if="item['post.lists.id'] == '' || item['attribute.type'] == '<?= $enc->attr( $item->getCode() ) ?>'"
								v-bind:selected="item['attribute.type'] == '<?= $enc->attr( $item->getCode() ) ?>'"
								value="<?= $enc->attr( $item->getCode() ); ?>" >
								<?= $enc->html( $item->getLabel() ); ?>
							</option>
						<?php endforeach; ?>

					</select>
				</td>
				<td v-bind:class="item['css'] || ''">
					<input class="item-listid" type="hidden" v-model="item['post.lists.id']"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['characteristic', 'hidden', 'idx', 'post.lists.id'] ) ); ?>'.replace( 'idx', idx )" />

					<input class="item-label" type="hidden" v-model="item['attribute.label']"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['characteristic', 'hidden', 'idx', 'attribute.label'] ) ); ?>'.replace( 'idx', idx )" />

					<select is="combo-box" class="form-control custom-select item-refid"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['characteristic', 'hidden', 'idx', 'post.lists.refid'] ) ); ?>'.replace( 'idx', idx )"
						v-bind:readonly="checkSite('post.lists.siteid', idx) || item['post.lists.id'] != ''"
						v-bind:tabindex="'<?= $this->get( 'tabindex' ); ?>'"
						v-bind:label="item['attribute.label']"
						v-bind:required="'required'"
						v-bind:getfcn="getItems"
						v-bind:index="idx"
						v-on:select="update"
						v-model="item['post.lists.refid']" >
					</select>
				</td>
				<td class="actions">
					<div v-if="!checkSite('post.lists.siteid', idx) && item['post.lists.id'] != ''"
						class="btn btn-card-header act-move fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Move this entry up/down' ) ); ?>">
					</div>
					<div v-if="!checkSite('post.lists.siteid', idx)"
						class="btn act-delete fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry' ) ); ?>"
						v-on:click.stop="remove(idx)">
					</div>
				</td>
			</tr>

		</tbody>

	</table>

	<?= $this->get( 'hiddenBody' ); ?>

</div>
