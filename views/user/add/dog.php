<div class="col-12 col-lg-8 mx-auto">
    <form class="dog-form p-4 border rounded shadow-sm bg-warning-subtle">
        <h4 class="mb-3">Добавить собаку</h4>

        <div class="mb-3">
            <label for="dogName" class="form-label">Кличка</label>
            <input type="text" class="form-control" id="dogName" required>
        </div>

        <div class="mb-3">
            <label for="dogTranslit" class="form-label">Транслит</label>
            <input type="text" class="form-control" id="dogTranslit" required>
        </div>

        <div class="mb-3">
            <label for="dogBreed" class="form-label">Порода</label>
            <select class="form-select" id="dogBreed" required>
                <option value="">Выберите породу</option>
                <option value="spitz">Шпиц</option>
                <option value="mastiff">Тибетский мастиф</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="dogBirthdate" class="form-label">Дата рождения</label>
            <input type="date" class="form-control" id="dogBirthdate">
        </div>

        <div class="mb-3">
            <label class="form-label">Пол</label>
            <div>
                <input type="radio" class="btn-check" name="dogGender" id="female" value="female" required>
                <label class="btn btn-outline-primary" for="female">Сука</label>

                <input type="radio" class="btn-check" name="dogGender" id="male" value="male" required>
                <label class="btn btn-outline-primary" for="male">Кобель</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="dogColor" class="form-label">Окрас</label>
                <input type="text" class="form-control" id="dogColor">
            </div>
            <div class="col-md-3 mb-3">
                <label for="dogHeight" class="form-label">Рост (см)</label>
                <input type="number" class="form-control" id="dogHeight">
            </div>
            <div class="col-md-3 mb-3">
                <label for="dogWeight" class="form-label">Вес (кг)</label>
                <input type="number" class="form-control" id="dogWeight">
            </div>
        </div>

        <div class="mb-3">
            <label for="dogPedigree" class="form-label">Родословная</label>
            <input type="text" class="form-control" id="dogPedigree" required>
        </div>

        <div class="mb-3">
            <label for="dogChip" class="form-label">Чип</label>
            <input type="text" class="form-control" id="dogChip">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="forBreeding">
            <label class="form-check-label" for="forBreeding">Предлагаю для вязки</label>
        </div>

        <div id="breedingContacts" class="d-none mt-2">
            <label for="breedingContact" class="form-label">Контакты для связи</label>
            <input type="text" class="form-control" id="breedingContact">
        </div>

        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="forSale">
            <label class="form-check-label" for="forSale">Предлагаю для продажи</label>
        </div>

        <div id="saleSection" class="d-none mt-2">
            <label for="salePrice" class="form-label">Цена</label>
            <input type="number" class="form-control" id="salePrice">
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="dogOwner" class="form-label">Владелец</label>
                <select class="form-select" id="dogOwner">
                    <option value="">Выберите владельца</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="dogBreeder" class="form-label">Заводчик</label>
                <select class="form-select" id="dogBreeder">
                    <option value="">Выберите заводчика</option>
                </select>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <label for="dogFather" class="form-label">Отец</label>
            <input type="text" class="form-control" id="dogFather">
        </div>

        <div class="mb-3">
            <label for="dogMother" class="form-label">Мать</label>
            <input type="text" class="form-control" id="dogMother">
        </div>

        <div class="mb-3">
            <label for="dogTitles" class="form-label">Титулы</label>
            <input type="text" class="form-control" id="dogTitles">
        </div>

        <div class="mb-3">
            <label for="dogDescription" class="form-label">Описание собаки</label>
            <textarea class="form-control" id="dogDescription" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Фото (максимум 3)</label>
            <input type="file" class="form-control" multiple accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Фото документов на модерацию</label>
            <input type="file" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Добавить собаку</button>
    </form>