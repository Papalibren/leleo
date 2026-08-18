<div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-breeder_id-mx-box">
    <div>
    <p><?=$placeholder?></p>
    <input
    type="hidden"
    id="dog-breeder-id"
    class="form-control"
    name="Dog[breeder_id]"
    value="<?=$id?>">
    </div>
    <div id="search-results-breeder" class="d-flex">
        <button type="button" class="btn btn-sm btn-danger" hx-swap="outerHTML" hx-get="/mx/dog/create/cancel-breeder?breeder_id=<?=$id?>" hx-target=".dog-breeder_id-mx-box">Изменить</button>
    </div>
</div>