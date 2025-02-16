@php
$vehicles = auth()->user()->vehicles()
    ->withSum('incomes', 'amount')
    ->withSum('expenses', 'amount')
    ->get();

@endphp
<div class="card small">
    <div class="card-body pb-0">
        <div class="float-end d-none d-md-inline-block">
            <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='{{ route('vehicles.index') }}'">View All</button>
        </div>
        <h4 class="card-title"><i class="fa fa-car"></i> Vehicles</h4>
    </div>
    <div class="card-body py-0 px-2">
        <table class="table table-bordered">
            <caption>Your vehicles statistics</caption>
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Incomes</th>
                    <th>Expenses</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles AS $vehicle)
                <tr>
                    <td>{{ $vehicle->registration_number }} | {{ $vehicle->make }} | {{ $vehicle->model }} | {{ $vehicle->year }}</td>
                    <td>{{ round($vehicle->incomes_sum_amount/100, 2) ?? 0 }}</td>
                    <td>{{ round($vehicle->expenses_sum_amount/100, 2) ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3"><i class="fa fa-info-circle"></i> No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div><!-- end card -->