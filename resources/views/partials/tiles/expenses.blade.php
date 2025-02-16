@php
$expenses = App\Models\Expense::latest('expense_date')
->whereHas('vehicle', function($query){
$query->where('user_id', auth()->user()->id);
})
->with('vehicle')
->limit(5)
->get();

$expense30Days = auth()->user()->vehicles()
->whereHas('expenses', function ($query) {
$query->where('expense_date', '>=', now()->subDays(30));
})
->withSum(['expenses as total_expense' => function ($query) {
$query->where('expense_date', '>=', now()->subDays(30));
}], 'amount')
->get()
->sum('total_expense');

$expense6Months = auth()->user()->vehicles()
->whereHas('expenses', function ($query) {
$query->where('expense_date', '>=', now()->subMonth(6));
})
->withSum(['expenses as total_expense' => function ($query) {
$query->where('expense_date', '>=', now()->subMonth(6));
}], 'amount')
->get()
->sum('total_expense');

$expense1Year = auth()->user()->vehicles()
->whereHas('expenses', function ($query) {
$query->where('expense_date', '>=', now()->subYear(1));
})
->withSum(['expenses as total_expense' => function ($query) {
$query->where('expense_date', '>=', now()->subYear(1));
}], 'amount')
->get()
->sum('total_expense');

@endphp
<div class="card small">
    <div class="card-body pb-0">
        <div class="float-end d-none d-md-inline-block">
            <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='{{ route('expenses.index') }}'">View All</button>
        </div>
        <h4 class="card-title"><i class="fa fa-money-bill-wave"></i> expenses</h4>

        <div class="text-center pt-3">
            <div class="row">
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="d-inline-flex">
                        <h5 class="me-2">
                            &pound;
                            {{ round($expense30Days/100, 2) }}
                        </h5>
                        <div class="text-success font-size-12">
                            <i class="mdi mdi-menu-up font-size-14"> </i>2.2 %
                        </div>
                    </div>
                    <p class="text-muted text-truncate mb-0">Last 30 days</p>
                </div><!-- end col -->
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="d-inline-flex">
                        <h5 class="me-2">&pound; {{ round($expense6Months/100, 2) }}</h5>
                        <div class="text-success font-size-12">
                            <i class="mdi mdi-menu-up font-size-14"> </i>1.2 %
                        </div>
                    </div>
                    <p class="text-muted text-truncate mb-0">Last 6 months</p>
                </div><!-- end col -->
                <div class="col-sm-4">
                    <div class="d-inline-flex">
                        <h5 class="me-2">&pound; {{ round($expense1Year/100, 2) }}</h5>
                        <div class="text-success font-size-12">
                            <i class="mdi mdi-menu-up font-size-14"> </i>1.7 %
                        </div>
                    </div>
                    <p class="text-muted text-truncate mb-0">Last 12 months</p>
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div>
    <div class="card-body py-0 px-2">
        <table class="table table-bordered">
            <caption>Recent Expense Entries</caption>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Vehicle</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses AS $expense)
                <tr>
                    <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->vehicle->registration_number }} | {{ $expense->vehicle->make }} | {{ $expense->vehicle->model }} | {{ $expense->vehicle->year }}</td>
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