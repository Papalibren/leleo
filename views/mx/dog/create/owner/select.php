<div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-owner_id-mx-box">
    <div>
    <p><?=$placeholder?></p>
    <input
    type="hidden"
    id="dog-owner-id"
    class="form-control"
    name="Dog[owner_id]"
    value="<?=$id?>">
    </div>
    <div id="search-results-owner" class="d-flex">
        <button type="button" class="btn btn-sm btn-danger" hx-swap="outerHTML" hx-get="/mx/dog/create/cancel-owner?owner_id=<?=$id?>" hx-target=".dog-owner_id-mx-box">Изменить</button>
    </div>
</div>