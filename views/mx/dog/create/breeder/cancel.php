<div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-breeder_id-mx-box">
    <input type="text" id="dog-breeder-id" class="form-control" name="dog[breeder_id]" placeholder="ID или фамилия" hx-get="/mx/dog/create/search-breeder" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-breeder">
    <div id="search-results-breeder" class="d-flex"></div>
</div>