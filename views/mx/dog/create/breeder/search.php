<?php if (!empty($users)): ?>
    <form class="d-flex" hx-get="/mx/dog/create/select-breeder" hx-target=".dog-breeder_id-mx-box">
        <select class="form-select" name="breeder_id" id="dog-search-result-breeder">
            <?php foreach ($users as $c): ?>
                <option value="<?= $c->id ?>">
                    <?= $c->last_name ?> - <?= $c->first_name ?> (id:<?= $c->id ?>)
                </option>
            <?php endforeach ?>
        </select>
        <button type="submit" class="btn btn-sm btn-danger ms-1">Выбрать</button>
    </form>
<?php else : ?>
    <span class="me-2">Не нашли нужного человека?</span>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#breederModal">
        Добавить
    </button>
    <div class="modal fade" id="breederModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить владельца</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="breeder-form" hx-post="/mx/dog/create/add-breeder" hx-target=".dog-breeder_id-mx-box" hx-on::before-cleanup-element="closeModal('breederModal')">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Фамилия</label>
                            <input type="text" class="form-control" id="" name="last_name" required>
                            <div id="" class="form-text"></div>
                        </div>
                                                <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="" name="first_name" required>
                            <div id="" class="form-text"></div>
                        </div>
                                                <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Страна</label>
                            <input type="text" class="form-control" id="" name="country" required>
                            <div id="" class="form-text"></div>
                        </div>
                                                <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Город</label>
                            <input type="text" class="form-control" id="" name="city" required>
                            <div id="" class="form-text"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>