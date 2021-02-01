<?php
global $data;
$enc = $this->encoder();
foreach ( $this->get( 'textData', [] ) as $row ) {
    $data[ $row[ 'text.languageid' ] ][$row[ 'text.type' ]] = $row;
}

if ( !function_exists( 'get_lang_data' ) ) {
    function get_lang_data( $lang, $type, $key, $default = '' ) {
        global $data;
        if ( isset( $data[ $lang ] ) && isset( $data[ $lang ][ $type ] ) && isset( $data[ $lang ][ $type ][ $key ] ) ) {
            return $data[ $lang ][ $type ][ $key ];
        }
        return $default;
    }
}

?>
<div id="text" class="item-text content-block tab-pane fade" role="tablist" aria-labelledby="text">
    <nav>
        <div class="nav nav-tabs nav-fill" id="tore-nav-tab" role="tablist">
            <?php if( ( $languages = $this->get( 'pageLangItems', map() ) )->count() >0 ) : ?>
            <?php foreach($languages as $language){ ?>
            <a class="nav-item nav-link" id="store-nav-<?=$language->getCode()?>-tab" data-toggle="tab" href="#store-nav-<?=$language->getCode()?>" role="tab" aria-controls="nav-<?=$language->getCode()?>" aria-selected="true"><img src="/packages/swordbros/common/img/flags/<?=$language->getCode()?>.png" width="24">
            <?=$language->getLabel()?>
            </a>
            <?php }?>
            <?php endif; ?>
        </div>
    </nav>
    <div class="tab-content py-3 px-3 px-sm-0" id="tore-nav-tabContent">
        <?php if( ( $languages = $this->get( 'pageLangItems', map() ) )->count() >0 ) : ?>
        <?php foreach($languages as $language){?>
        <div class="tab-pane fade show" id="store-nav-<?=$language->getCode()?>" role="tabpanel" aria-labelledby="store-nav-<?=$language->getCode()?>-tab">
            <div class="group-item card">
                <div id="item-text-group-item-<?=$language->getCode()?>" class="card-header header"> <h4 class="item-label header-label"><?=$language->getLabel()?> Content</h4></div>
                <div id="item-text-group-data-<?=$language->getCode()?>" aria-labelledby="item-text-group-item-<?=$language->getCode()?>" role="tabpanel" class="card-block row collapsed collapse show" style="">
                    <div class="col-xl-12">
                        <div class="form-group row optional">
                            <label class="col-sm-2 form-control-label help">Label</label>
                            <div class="col-sm-10">
                                <input type="text" name="text[long_<?=$language->getCode()?>][text.label]" placeholder="Label" class="form-control item-label" value="<?=get_lang_data($language->getCode(), 'long',  'text.label', '')?>">
                            </div>
                            <div class="col-sm-12 form-text text-muted help-text"> Description of the text content if it's in a foreign language</div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="form-group row mandatory">
                            <div class="col-sm-12">
<textarea name="text[long_<?=$language->getCode()?>][text.content]"  class="form-control htmleditor form-control item-content"><?=get_lang_data($language->getCode(), 'long', 'text.content', '')?>
</textarea>
                            </div>
                        </div>
<input type="hidden" name="text[long_<?=$language->getCode()?>][text.id]" value="<?=get_lang_data($language->getCode(), 'long', 'text.id', '')?>">
<input type="hidden" name="text[long_<?=$enc->attr( $language->getCode() ) ?>][text.status]" value="1" />
<input type="hidden" name="text[long_<?=$enc->attr( $language->getCode() ) ?>][text.languageid]" value="<?= $enc->attr( $language->getCode() ) ?>" />
<input type="hidden" name="text[long_<?=$enc->attr( $language->getCode() ) ?>][text.type]" value="long" />
<input type="hidden" name="text[long_<?=$language->getCode()?>][swpost.lists.type]" value="default">
<input type="hidden" name="text[long_<?=$language->getCode()?>][swpost.lists.datestart]" >
<input type="hidden" name="text[long_<?=$language->getCode()?>][swpost.lists.dateend]">                    
                    </div>
                    <div class="col-xl-12">
                        <div class="form-group row mandatory">
<div class="col-sm-12">Excerpt</div>
                            <div class="col-sm-12">
                                <input type="text" name="text[short_<?=$language->getCode()?>][text.label]" placeholder="Excerpt Title" class="form-control item-label" value="<?=get_lang_data($language->getCode(), 'short',  'text.label', '')?>">
                            </div>

                            <div class="col-sm-12">
<textarea name="text[short_<?=$language->getCode()?>][text.content]"  class="form-control form-control item-content"><?=get_lang_data($language->getCode(), 'short', 'text.content', '')?>
</textarea>
                            </div>
                        </div>
<input type="hidden" name="text[short_<?=$language->getCode()?>][text.id]" value="<?=get_lang_data($language->getCode(), 'short', 'text.id', '')?>">
<input type="hidden" name="text[short_<?=$enc->attr( $language->getCode() ) ?>][text.status]" value="1" />
<input type="hidden" name="text[short_<?=$enc->attr( $language->getCode() ) ?>][text.languageid]" value="<?= $enc->attr( $language->getCode() ) ?>" />
<input type="hidden" name="text[short_<?=$enc->attr( $language->getCode() ) ?>][text.type]" value="short" />
<input type="hidden" name="text[short_<?=$language->getCode()?>][swpost.lists.type]" value="default">
<input type="hidden" name="text[short_<?=$language->getCode()?>][swpost.lists.datestart]" >
<input type="hidden" name="text[short_<?=$language->getCode()?>][swpost.lists.dateend]">                    
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <?php endif; ?>
    </div>
</div>
