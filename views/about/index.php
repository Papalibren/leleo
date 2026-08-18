<?php
$this->title = 'Информация о нас'
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
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
        </div>
    </div>
    <div class="row mt-2">

        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-lg-8 mx-auto">
            <form class="dog-form p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-3">Добавить заводчика</h4>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" required>
                </div>

                <div class="mb-3">
                    <label for="lastName" class="form-label">Фамилия</label>
                    <input type="text" class="form-control" id="lastName" required>
                </div>

                <div class="mb-3">
                    <label for="firstName" class="form-label">Имя</label>
                    <input type="text" class="form-control" id="firstName" required>
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Страна</label>
                    <input type="text" class="form-control" id="country" required>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">Город</label>
                    <input type="text" class="form-control" id="city" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="advancedUser" onchange="toggleAdvancedFields()">
                    <label class="form-check-label" for="advancedUser">Я продвинутый пользователь</label>
                </div>

                <div id="kennelGroup" class="mb-3" style="display: none;">
                    <label for="kennel" class="form-label">Питомник</label>
                    <select class="form-select" id="kennel">
                        <option value="">Выберите питомник</option>
                        <option value="kennel1">Питомник "Лунный Свет"</option>
                        <option value="kennel2">Питомник "Кошачий Рай"</option>
                        <option value="kennel3">Питомник "Золотые Лапки"</option>
                    </select>
                </div>

                <div id="websiteGroup" class="mb-3" style="display: none;">
                    <label for="website" class="form-label">Сайт</label>
                    <input type="url" class="form-control" id="website">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="privacyPolicy" required>
                    <label class="form-check-label" for="privacyPolicy">
                        Я принимаю политику конфиденциальности
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-lg-8 mx-auto">
            <form class="p-4 border rounded shadow-sm bg-danger-subtle">
            <h4 class="mb-3">Добавить питомник</h4>

                <div class="mb-3">
                    <label for="kennelName" class="form-label">Название питомника</label>
                    <input type="text" class="form-control" id="kennelName" required>
                </div>

                <div class="mb-3">
                    <label for="breeder" class="form-label">Заводчик</label>
                    <select class="form-select" id="breeder">
                        <option value="self" selected>Выбрать себя</option>
                        <option value="other">Другой заводчик</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Фото питомника (логотип)</label>
                    <input type="file" class="form-control" id="logo" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Сайт питомника</label>
                    <input type="url" class="form-control" id="website">
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Страна</label>
                    <input type="text" class="form-control" id="country" required>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">Город</label>
                    <input type="text" class="form-control" id="city" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="tel" class="form-control" id="phone" required>
                </div>

                <div class="mb-3">
                    <label for="info" class="form-label">Информация о питомнике</label>
                    <textarea class="form-control" id="info" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрировать питомник</button>
            </form>

            <hr>

            <h3 class="mt-4">Животные питомника</h3>

            <!-- Вкладки -->
            <ul class="nav nav-tabs" id="kennelTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="producers-tab" data-bs-toggle="tab" data-bs-target="#producers" type="button" role="tab">
                        Производители питомника
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="born-tab" data-bs-toggle="tab" data-bs-target="#born" type="button" role="tab">
                        Родились в питомнике
                    </button>
                </li>
            </ul>

            <!-- Контент вкладок -->
            <div class="tab-content mt-3" id="kennelTabsContent">
                <div class="tab-pane fade show active" id="producers" role="tabpanel">
                    <p>Список животных, у которых заводчик указан как владелец.</p>
                    <ul id="producersList" class="list-group">
                        <li class="list-group-item">Кот 1</li>
                        <li class="list-group-item">Кошка 2</li>
                    </ul>
                </div>

                <div class="tab-pane fade" id="born" role="tabpanel">
                    <p>Список животных, родившихся в питомнике.</p>
                    <ul id="bornList" class="list-group">
                        <li class="list-group-item">Котёнок 1</li>
                        <li class="list-group-item">Котёнок 2</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>