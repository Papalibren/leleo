<div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-mother_id-mx-box">
    <input type="text" id="dog-mother-id" class="form-control" name="Dog[mother_id]" placeholder="ID или фамилия" hx-get="/mx/dog/create/search-mother" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-mother">
    <div id="search-results-mother" class="d-flex"></div>
</div>