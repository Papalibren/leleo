<?php if (!empty($cats)): ?>
    <form class="d-flex" hx-get="/mx/cat/create/select-mother" hx-target=".cat-mother_id-mx-box">
        <select class="form-select" name="mother_id" id="cat-search-result-mother">
            <?php foreach ($cats as $c): ?>
                <option value="<?= $c->id ?>">
                    <?= $c->name ?> -
                    <span class="fst-italic">id<?= $c->id ?></span>,
                    <span class="fst-italic">pedigree <?= $c->pedigree_number ?></span>
                </option>
            <?php endforeach ?>
        </select>
        <button type="submit" class="btn btn-sm btn-danger ms-1">Выбрать</button>
    </form>
<?php endif ?>