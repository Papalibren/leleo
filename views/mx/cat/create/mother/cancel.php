<div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-mother_id-mx-box">
    <input type="text" id="cat-mother-id" class="form-control" name="Cat[mother_id]" placeholder="ID или фамилия" hx-get="/mx/cat/create/search-mother" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-mother">
    <div id="search-results-mother" class="d-flex"></div>
</div>