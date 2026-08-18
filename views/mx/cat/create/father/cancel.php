<div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-father_id-mx-box">
    <input type="text" id="cat-father-id" class="form-control" name="Cat[father_id]" placeholder="ID или кличка" hx-get="/mx/cat/create/search-father" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-father">
    <div id="search-results-father" class="d-flex"></div>
</div>