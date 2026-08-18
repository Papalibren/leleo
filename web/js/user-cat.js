$owner_input = $('.field-cat-owner_id').find('input')
$owner_btn = $('.field-cat-owner_id').find('button')
$placholder_cat_owner = $('<p class="text-start"></p>');

$breeder_input = $('.field-cat-breeder_id').find('input')
$breeder_btn = $('.field-cat-breeder_id').find('button')
$placholder_cat_breeder = $('<p class="text-start"></p>');

$owner_input.val('');
$breeder_input.val('');


$owner_btn.on('click', function(){
    if($owner_input.prop('type') == 'hidden'){
        $owner_btn.text('Указать себя')
        $owner_input.prop('type', 'text');
        $owner_input.val('');
        $placholder_cat_owner.detach();
    }else{
        $owner_btn.text('Указать другого владельца')
        $owner_input.prop('type', 'hidden');
        $owner_input.val($(this).data('id'));
        $placholder_cat_owner.text(`${$(this).data('first_name')} ${$(this).data('last_name')}`);
        $placholder_cat_owner.insertBefore($(this))
    }

})

$breeder_btn.on('click', function(){
    if($breeder_input.prop('type') == 'hidden'){
        $breeder_btn.text('Указать себя')
        $breeder_input.prop('type', 'text');
        $breeder_input.val('');
        $placholder_cat_breeder.detach();
    }else{
        $breeder_btn.text('Указать другого заводчика')
        $breeder_input.prop('type', 'hidden');
        $breeder_input.val($(this).data('id'));
        $placholder_cat_breeder.text(`${$(this).data('first_name')} ${$(this).data('last_name')}`);
        $placholder_cat_breeder.insertBefore($(this))
    }

})

function closeModal(id) {
        const modalEl = document.getElementById(id);
        if (!modalEl) return;
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
}


function toggleMatingFields() {
    if ($('#cat-is_for_mating').is(':checked')) {
        $('#cat-mating_contacts').closest('.field-cat-mating_contacts').show();
    } else {
        $('#cat-mating_contacts').closest('.field-cat-mating_contacts').hide();
    }
}

function toggleSaleFields() {
    if ($('#cat-is_for_sale').is(':checked')) {
        $('#cat-price').closest('.field-cat-price').show();
        $('#cat-sale_contacts').closest('.field-cat-sale_contacts').show();
    } else {
        $('#cat-price').closest('.field-cat-price').hide();
        $('#cat-sale_contacts').closest('.field-cat-sale_contacts').hide();
    }
}

$(document).ready(function() {
    toggleMatingFields();
    toggleSaleFields();

    $('#cat-is_for_mating').change(function() {
        toggleMatingFields();
    });

    $('#cat-is_for_sale').change(function() {
        toggleSaleFields();
    });
});


