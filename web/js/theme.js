// Функция транслитерации с русского на латиницу
function transliterate(text) {
    const map = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
        'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
        'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
        'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
        'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch',
        'ш': 'sh', 'щ': 'shch', 'ъ': '', 'ы': 'y', 'ь': '',
        'э': 'e', 'ю': 'yu', 'я': 'ya',

        'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D',
        'Е': 'E', 'Ё': 'E', 'Ж': 'Zh', 'З': 'Z', 'И': 'I',
        'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N',
        'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T',
        'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'Ts', 'Ч': 'Ch',
        'Ш': 'Sh', 'Щ': 'Shch', 'Ъ': '', 'Ы': 'Y', 'Ь': '',
        'Э': 'E', 'Ю': 'Yu', 'Я': 'Ya'
    };

    return text.split('').map(char => map[char] !== undefined ? map[char] : char).join('')
        .replace(/\s+/g, '-')   // Пробелы заменяем на тире
        .replace(/[^a-zA-Z0-9\-]/g, '') // Удаляем недопустимые символы
        .toLowerCase(); // Приводим к нижнему регистру
}

$(document).ready(function () {
    $('#cat-name').on('input', function () {
        const name = $(this).val();
        const translit = transliterate(name);
        $('#cat-translit').val(translit);
    });

    $('#self-father-name').on('input', function () {
        const name = $(this).val();
        const translit = transliterate(name);
        $('#self-father-translit').val(translit);
    });

    $('#self-mother-name').on('input', function () {
        const name = $(this).val();
        const translit = transliterate(name);
        $('#self-mother-translit').val(translit);
    });

    $('#dog-name').on('input', function () {
        const name = $(this).val();
        const translit = transliterate(name);
        $('#dog-translit').val(translit);
    });
});

