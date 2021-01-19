<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2020
 */

$enc = $this->encoder();

$keys = [
	'post.lists.id', 'post.lists.siteid', 'post.lists.refid', 'post.label', 'post.code'
];


?>
<div class="col-xl-6 content-block item-related-bought">

	<table class="post-list table table-default"
		data-items="<?= $enc->attr( $this->get( 'boughtData', [] ) ); ?>"
		data-keys="<?= $enc->attr( $keys ) ?>"
		data-prefix="post.lists."
		data-siteid="<?= $this->site()->siteid() ?>" >

		<thead>
			<tr>
				<th>
					<span class="help"><?= $enc->html( $this->translate( 'admin', 'Posts bought together' ) ); ?></span>
					<div class="form-text text-muted help-text">
						<?= $enc->html( $this->translate( 'admin', 'List of posts often bought together' ) ); ?>
					</div>
				</th>
				<th class="actions">
					<div class="btn act-add fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)' ) ); ?>"
						v-on:click="add()">
					</div>
				</th>
			</tr>
		</thead>

		<tbody is="draggable" v-model="items" group="related" handle=".act-move" tag="tbody">

			<tr v-for="(item, idx) in items" v-bind:key="idx"
				v-bind:class="item['post.lists.siteid'] != '<?= $this->site()->siteid() ?>' ? 'readonly' : ''">
				<td v-bind:class="(item['css'] || '')">
					<input class="item-listid" type="hidden" v-model="item['post.lists.id']"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['related', 'bought', 'idx', 'post.lists.id'] ) ); ?>'.replace( 'idx', idx )" />

					<input class="item-label" type="hidden" v-model="item['post.label']"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['related', 'bought', 'idx', 'post.label'] ) ); ?>'.replace( 'idx', idx )" />

					<input class="item-code" type="hidden" v-model="item['post.code']"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['related', 'bought', 'idx', 'post.code'] ) ); ?>'.replace( 'idx', idx )" />

					<select is="combo-box" class="form-control custom-select item-refid"
						v-bind:name="'<?= $enc->attr( $this->formparam( ['related', 'bought', 'idx', 'post.lists.refid'] ) ); ?>'.replace( 'idx', idx )"
						v-bind:readonly="checkSite('post.lists.siteid', idx) || item['post.lists.id'] != ''"
						v-bind:tabindex="'<?= $this->get( 'tabindex' ); ?>'"
						v-bind:label="getLabel(idx)"
						v-bind:required="'required'"
						v-bind:getfcn="getItems"
						v-bind:index="idx"
						v-on:select="update"
						v-model="item['post.lists.refid']">
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

	<?= $this->get( 'boughtBody' ); ?>
</div>
