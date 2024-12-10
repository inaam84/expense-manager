<div class="modal fade bs-example-modal-center" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        {{ html()->form('GET', $searchRoute)->attributes(['name' => 'frmFilters'])->open() }}
        {{ html()->hidden('_reset', 0) }}
        <div class="modal-content">
            <div class="modal-header small">
                <h5 class="modal-title">Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {!! $filters->render() !!}

            </div>
            <div class="modal-footer">
                {{ formSubmit('<i class="fas fa-search"></i> Apply', 'btn btn-sm btn-primary') }}
                {{ filtersFormReset() }} |
                <button class="btn btn-info waves-effect btn-sm" type="button" data-bs-toggle="modal" data-bs-target=".bs-save-filters-modal-center">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div><!-- /.modal-content -->
        {{ html()->form()->close() }}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade bs-save-filters-modal-center" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    role="dialog" aria-labelledby="save filters" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header small">
                <h5 class="modal-title">Save Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="filter_name" class="col-sm-2 col-form-label">Text</label>
                    <div class="col-sm-10">
                        <input class="form-control form-control-sm" type="text" placeholder="Enter name to save your search filters" name="filter_name" maxlength="25">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm"  id="btnSaveFilters"><i class="fa fa-save"></i> Save Search Filters</button>
                <button class="btn btn-default btn-sm" data-bs-target=".bs-example-modal-center" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cacnel</button>
            </div>
        </div><!-- /.modal-content -->
        {{ html()->form()->close() }}
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('page-scripts')
<script>

    function parseQueryString(queryString)
    {
        let params = {};
        let queries = queryString.split("&");
        queries.forEach(function(query) {
            let [key, value] = query.split("=");
            if (key.includes("%5B%5D")) {
                key = key.replace("%5B%5D", "[]");
                if (!params[key]) {
                    params[key] = [];
                }
                params[key].push(decodeURIComponent(value || ""));
            } else {
                params[key] = decodeURIComponent(value || "");
            }
        });
        return params;
    }

    function populateForm(params)
    {
        for (const key in params) {
            let value = params[key];
            if (Array.isArray(value)) {
                let fieldName = key.replace("[]", "");
                let $select = $(`[name='${fieldName}[]']`);
                if ($select.is('select[multiple]')) {
                    $select.val(value);
                } else {
                    value.forEach(function(val) {
                        $(`[name='${fieldName}[]'][value='${val}']`).prop("checked", true);
                    });
                }
            } else {
                let $field = $(`[name='${key}']`);
                if ($field.attr("type") === "checkbox" || $field.attr("type") === "radio") {
                    $field.prop("checked", $field.val() == value);
                } else {
                    $field.val(value);
                }
            }
        }
    }

</script>
@endpush
