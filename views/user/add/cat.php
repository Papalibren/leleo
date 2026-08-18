<form class="container mt-4 p-4 border rounded bg-info-subtle">
    <h2 class="mb-4">Добавить кошку</h2>
    <div class="mb-3">
        <label class="form-label">Кличка *</label>
        <input type="text" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Транслит *</label>
        <input type="text" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Порода</label>
        <input type="text" class="form-control" value="Бенгальская" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Дата рождения</label>
        <input type="date" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Пол *</label>
        <select class="form-select" required>
            <option value="">Выберите пол</option>
            <option value="Кошка">Кошка</option>
            <option value="Кот">Кот</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Окрас</label>
        <select class="form-select">
            <option value="">Выберите окрас</option>
            <option>Рыжий</option>
            <option>Черный</option>
            <option>Белый</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Код окраса в родословной</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Родословная *</label>
        <input type="text" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Чип</label>
        <input type="text" class="form-control">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="breedingOffer">
        <label class="form-check-label" for="breedingOffer">Предлагаю для вязки</label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="saleOffer">
        <label class="form-check-label" for="saleOffer">Предлагаю для продажи</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Владелец</label>
        <select class="form-select">
            <option value="">Выберите владельца</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Заводчик</label>
        <select class="form-select">
            <option value="">Выберите заводчика</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Отец</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Мать</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Титулы</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Дополнительная информация</label>
        <textarea class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Фото (максимум 3)</label>
        <input type="file" class="form-control" multiple>
    </div>
    <div class="mb-3">
        <label class="form-label">Фото документов на модерацию</label>
        <input type="file" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>