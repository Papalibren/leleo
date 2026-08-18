<?php if (!empty($dogs)): ?>
    <form class="d-flex" hx-get="/mx/dog/create/select-mother" hx-target=".dog-mother_id-mx-box">
        <select class="form-select" name="mother_id" id="dog-search-result-mother">
            <?php foreach ($dogs as $c): ?>
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