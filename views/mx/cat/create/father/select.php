<div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-father_id-mx-box">
    <div>
    <p><?=$placeholder?></p>
    <input
    type="hidden"
    id="cat-father-id"
    class="form-control"
    name="Cat[father_id]"
    value="<?=$id?>">
    </div>
    <div id="search-results-father" class="d-flex">
        <button type="button" class="btn btn-sm btn-danger" hx-get="/mx/cat/create/cancel-father?father_id=<?=$id?>" hx-target=".cat-father_id-mx-box">Изменить</button>
    </div>
</div>