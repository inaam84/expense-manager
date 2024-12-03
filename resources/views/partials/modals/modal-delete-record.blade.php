<div class="modal fade" id="{{ $modal_delete_id ?? 'confirm-delete' }}" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        {{ html()->form('DELETE', $modal_delete_route)->attributes(['onsubmit' => 'return modal_dialog_delete_record(this);'])->open() }}
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button type="button" class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base btnModalDialogDeleteCancel" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                    <h4 class="mb-1">Confirmation</h4>
                </div>
                <div class="p-4 pb-0">
                    <p>{{ $modal_delete_message ?? 'You are about to delete this record, this action is irreversible.' }}</p>
                    <p>Do you want to proceed?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm btnModalDialogDeleteCancel" type="button" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Delete </button>
            </div>
        </div>
        {!! html()->form()->close() !!}
    </div>
</div>
