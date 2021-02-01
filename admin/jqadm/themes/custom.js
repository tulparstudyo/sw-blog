/*
 * Custom sw-blog JS
 */
$(document).ready(function(){
    if($('select.form-control.item-domain').length){
       $('select.form-control.item-domain').append($('<option>', {value:'swpost', text:'Swpost'}));
    }
	$('.htmleditor').each(function(){
		CKEDITOR.replace( this );
	});
});
