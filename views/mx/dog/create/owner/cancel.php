<div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-owner_id-mx-box">
    <input type="text" id="dog-owner-id" class="form-control" name="Dog[owner_id]" placeholder="ID или Фамилия"  hx-get="/mx/dog/create/search-owner" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-owner">
    <div id="search-results-owner" class="d-flex"></div>
</div>