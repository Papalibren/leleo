<div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-owner_id-mx-box">
    <div>
    <p><?=$placeholder?></p>
    <input
    type="hidden"
    id="cat-owner-id"
    class="form-control"
    name="Cat[owner_id]"
    value="<?=$id?>">
    </div>
    <div id="search-results-owner" class="d-flex">
        <button type="button" class="btn btn-sm btn-danger" hx-swap="outerHTML" hx-get="/mx/cat/create/cancel-owner?owner_id=<?=$id?>" hx-target=".cat-owner_id-mx-box">Изменить</button>
    </div>
</div>