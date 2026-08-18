$owner_input = $('.field-dog-owner_id').find('input')
$owner_btn = $('.field-dog-owner_id').find('button')
$placholder_dog_owner = $('<p class="text-start"></p>');

$breeder_input = $('.field-dog-breeder_id').find('input')
$breeder_btn = $('.field-dog-breeder_id').find('button')
$placholder_dog_breeder = $('<p class="text-start"></p>');

$owner_input.val('');
$breeder_input.val('');


$owner_btn.on('click', function(){
    if($owner_input.prop('type') == 'hidden'){
        $owner_btn.text('Указать себя')
        $owner_input.prop('type', 'text');
        $owner_input.val('');
        $placholder_dog_owner.detach();
    }else{
        $owner_btn.text('Указать другого владельца')
        $owner_input.prop('type', 'hidden');
        $owner_input.val($(this).data('id'));
        $placholder_dog_owner.text(`${$(this).data('first_name')} ${$(this).data('last_name')}`);
        $placholder_dog_owner.insertBefore($(this))
    }

})

$breeder_btn.on('click', function(){
    if($breeder_input.prop('type') == 'hidden'){
        $breeder_btn.text('Указать себя')
        $breeder_input.prop('type', 'text');
        $breeder_input.val('');
        $placholder_dog_breeder.detach();
    }else{
        $breeder_btn.text('Указать другого заводчика')
        $breeder_input.prop('type', 'hidden');
        $breeder_input.val($(this).data('id'));
        $placholder_dog_breeder.text(`${$(this).data('first_name')} ${$(this).data('last_name')}`);
        $placholder_dog_breeder.insertBefore($(this))
    }

})

function closeModal(id) {
        const modalEl = document.getElementById(id);
        if (!modalEl) return;
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
}


function toggleMatingFields() {
    if ($('#dog-is_for_mating').is(':checked')) {
        $('#dog-mating_contacts').closest('.field-dog-mating_contacts').show();
    } else {
        $('#dog-mating_contacts').closest('.field-dog-mating_contacts').hide();
    }
}

function toggleSaleFields() {
    if ($('#dog-is_for_sale').is(':checked')) {
        $('#dog-price').closest('.field-dog-price').show();
        $('#dog-sale_contacts').closest('.field-dog-sale_contacts').show();
    } else {
        $('#dog-price').closest('.field-dog-price').hide();
        $('#dog-sale_contacts').closest('.field-dog-sale_contacts').hide();
    }
}

$(document).ready(function() {
    toggleMatingFields();
    toggleSaleFields();

    $('#dog-is_for_mating').change(function() {
        toggleMatingFields();
    });

    $('#dog-is_for_sale').change(function() {
        toggleSaleFields();
    });
});

// web/js/user-dog.js
$(document).ready(function() {
    // Обработчик изменения породы
    $('#dog-breed').change(function() {
        var breed = $(this).val();
        var colorSelect = $('#dog-color-id');

        if (breed) {
            // Показываем индикатор загрузки
            colorSelect.html('<option value="">Загрузка...</option>');

            // AJAX запрос для получения цветов
            $.get('/user/dog/get-colors', { breed: breed }, function(data) {
                var options = '<option value="">Выбрать цвет</option>';

                $.each(data, function(id, name) {
                    options += '<option value="' + id + '">' + name + '</option>';
                });

                colorSelect.html(options);
            });
        } else {
            colorSelect.html('<option value="">Сначала выберите породу</option>');
        }
    });

    // Инициализация при загрузке страницы
    var initialBreed = $('#dog-breed').val();
    if (initialBreed) {
        $('#dog-breed').trigger('change');
    }
});


// Обновление цветов в модальных окнах при изменении породы
$('#dog-breed').change(function() {
    var breed = $(this).val();
    updateModalColors(breed);
});

function updateModalColors(breed) {
    if (breed) {
        $('.modal-color-select').html('<option value="">Загрузка...</option>');

        $.get('/user/dog/get-colors', { breed: breed }, function(data) {
            var options = '<option value="">Выбрать окрас</option>';

            $.each(data, function(id, name) {
                options += '<option value="' + id + '">' + name + '</option>';
            });

            $('.modal-color-select').html(options);
        });
    } else {
        $('.modal-color-select').html('<option value="">Сначала выберите породу</option>');
    }
}

// При открытии модального окна обновляем цвета
$('#fatherModal, #motherModal').on('show.bs.modal', function() {
    var breed = $('#dog-breed').val();
    updateModalColors(breed);
});
