@extends('layouts.master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                @include('partials.tiles.incomes')
                @include('partials.tiles.expenses')
                @include('partials.tiles.vehicles')
            </div><!-- end col -->
        </div>
    </div>

</div>
<!-- End Page-content -->
@endsection

@push('page-scripts')


</script>
@endpush