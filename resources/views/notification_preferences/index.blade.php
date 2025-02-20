@extends('layouts.master')



@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Notification Preferences</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body pb-0">
                        <h4 class="card-title"><i class="fa fa-coins"></i> Notification Preferences</h4>
                    </div>
                    <div class="card-body py-0 px-2">
                        <table class="table table-bordered">
                            <tbody>
                                <tr id="mot">
                                    <td>MOT Due Date</td>
                                    <td>
                                        {{ 
                                            html()
                                                ->select('notify_before_days', ['' => ''] + $notifyDaysBefore)
                                                ->class('form-select form-select-sm')
                                                ->value(optional($savedPreferences->where('notification_type', 'mot')->first())->notify_before_days) 
                                        }}
                                        @error('notify_before_days') <div class="error">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        {{ 
                                            html()
                                                ->select('frequency', $frequency)
                                                ->class('form-select form-select-sm')
                                                ->value(optional($savedPreferences->where('notification_type', 'mot')->first())->frequency) 
                                        }}
                                        @error('frequency') <div class="error">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success btnSave" data-notification-type="mot"><i class="fa fa-save"></i> Save</button>
                                    </td>
                                </tr>
                                <tr id="tax">
                                    <td>Tax Due Date</td>
                                    <td>
                                        {{ 
                                            html()
                                                ->select('notify_before_days', ['' => ''] + $notifyDaysBefore)
                                                ->class('form-select form-select-sm')
                                                ->value(optional($savedPreferences->where('notification_type', 'tax')->first())->notify_before_days) 
                                        }}
                                        @error('notify_before_days') <div class="error">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        {{ 
                                            html()
                                                ->select('frequency', $frequency)
                                                ->class('form-select form-select-sm')
                                                ->value(optional($savedPreferences->where('notification_type', 'tax')->first())->frequency) 
                                        }}
                                        @error('frequency') <div class="error">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success btnSave" data-notification-type="tax"><i class="fa fa-save"></i> Save</button>
                                    </td>
                                </tr>
                                <tr id="insurance">
                                    <td>Insurance Due Date</td>
                                    <td>
                                        {{ 
                                            html()
                                                ->select('notify_before_days', ['' => ''] + $notifyDaysBefore)
                                                ->class('form-select form-select-sm')
                                                ->value(optional($savedPreferences->where('notification_type', 'insurance')->first())->notify_before_days) 
                                        }}
                                        @error('notify_before_days') <div class="error">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        {{ 
                                            html()
                                                ->select('frequency', $frequency)
                                                ->class('form-select form-select-sm')
                                                ->value(optional($savedPreferences->where('notification_type', 'insurance')->first())->frequency) 
                                        }}
                                        @error('frequency') <div class="error">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success btnSave" data-notification-type="insurance"><i class="fa fa-save"></i> Save</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- End Page-content -->
@endsection

@push('page-scripts')
<script>
    $(".btnSave").on("click", function(e){
        e.preventDefault();

        var $row = $(this).closest("tr");
        var notificationType = $(this).data("notification-type");
        var notifyBeforeDays = $row.find("select[name='notify_before_days']").val();
        var frequency = $row.find("select[name='frequency']").val();

        $.ajax({
            url: "{{ route('notification_preferences.store') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}", 
                notification_type: notificationType,
                notify_before_days: notifyBeforeDays,
                frequency: frequency
            },
            success: function(response) {
                alert("Notification preferences saved successfully!");
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = Object.values(errors).map(err => err.join("\n")).join("\n");
                    alert("Validation Error:\n" + errorMessage);
                } else {
                    alert("Something went wrong! Please try again.");
                }
            }
        });

    });
</script>
@endpush