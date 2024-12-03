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
                {!! html()
                    ->select('saved_filters')
                    ->class('form-select-sm')
                    ->options( ['' => 'Select Saved Searches'] + auth()->user()->savedFilters()->where('uri', url()->current())->pluck('filter_name', 'filter_id')->toArray() )
                     !!}
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
    $(function(){
        $("button#btnSaveFilters").on("click", function(event){
            event.preventDefault();

            var btn = $(this);
            var filter_name = $("input[name=filter_name]").val();

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    btn.attr('disabled', true);
                    btn.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                url: '{{ route('ajax.saveUserFilters') }}',
                data: {
                    filter_name: filter_name,
                    uri: '{{ url()->current() }}',
                    filters: $("form[name=frmFilters]").serialize()
                },
                success: function(response) {
                    $.each(response.filters, function(key, value) {
                        var newOption = $('<option>', {
                            value: key,
                            text: value
                        });
                        $('#saved_filters').append(newOption);
                    });

                    btn.closest('.modal').modal('hide');

                    setTimeout(function(){
                        $('.bs-example-modal-center').modal('show');
                    }, 500);
                },
                error: function(errorInfo, code, errorMessage) {
                    btn.attr('disabled', false);
                    btn.html('<i class="fa fa-save"></i> Save Search Filters');
                    alert(errorInfo.responseJSON.message !==
                            undefined ? errorInfo.responseJSON.message :
                            errorMessage);
                }
            });

            $("input[name=filter_name]").val('');

        });

        $("select[name=saved_filters]").on("change", function(e){
            e.preventDefault();

            var thisSelect = $(this);
            var filterId = this.value;

            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '{{ route('ajax.getUserFilters') }}',
                data: {
                    filter_id: filterId
                },
                success: function(response) {
                    const params = parseQueryString(response.filters);
                    populateForm(params);
                    thisSelect.val(filterId);
                },
                error: function(errorInfo, code, errorMessage) {
                    alert(errorInfo.responseJSON.message !==
                            undefined ? errorInfo.responseJSON.message :
                            errorMessage);
                }
            });
        });
    });

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