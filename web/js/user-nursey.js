
$breeder_input = $('.field-nursey-breeder_id').find('input')
$breeder_btn = $('.field-nursey-breeder_id').find('button')
$placholder_nursey_breeder = $('<p class="text-start"></p>');

$breeder_input.val('');


$breeder_btn.on('click', function(){
    if($breeder_input.prop('type') == 'hidden'){
        $breeder_btn.text('Указать себя')
        $breeder_input.prop('type', 'text');
        $breeder_input.val('');
        $placholder_nursey_breeder.detach();
    }else{
        $breeder_btn.text('Указать другого заводчика')
        $breeder_input.prop('type', 'hidden');
        $breeder_input.val($(this).data('id'));
        $placholder_nursey_breeder.text(`${$(this).data('first_name')} ${$(this).data('last_name')}`);
        $placholder_nursey_breeder.insertBefore($(this))
    }

})