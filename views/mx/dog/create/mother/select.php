<div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-mother_id-mx-box">
    <div>
    <p><?=$placeholder?></p>
    <input
    type="hidden"
    id="dog-mother-id"
    class="form-control"
    name="Dog[mother_id]"
    value="<?=$id?>">
    </div>
    <div id="search-results-mother" class="d-flex">
        <button type="button" class="btn btn-sm btn-danger" hx-get="/mx/dog/create/cancel-mother?mother_id=<?=$id?>" hx-target=".dog-mother_id-mx-box">Изменить</button>
    </div>
</div>