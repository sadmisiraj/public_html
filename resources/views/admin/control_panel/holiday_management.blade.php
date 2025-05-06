@extends('admin.layouts.app')
@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Weekly Holidays</h5>
                    </div>
                    <div class="card-body">
                        <!-- Toggle Switch HTML with simple inline function -->
                        <div class="form-group mb-4">
                            <label for="holiday_profit_disable" class="mb-2 font-weight-bold">Disable Profit on Holidays</label>
                            <div class="form-check form-switch">
                                <form id="toggleProfitForm" action="{{ route('admin.holiday.toggle.profit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="value" id="profit_disable_value" value="{{ $basicControl->holiday_profit_disable ? '1' : '0' }}">
                                    <input type="checkbox" class="form-check-input" id="holiday_profit_disable" 
                                        {{ $basicControl->holiday_profit_disable ? 'checked' : '' }}
                                        onclick="document.getElementById('profit_disable_value').value = this.checked ? '1' : '0'; document.getElementById('toggle-status').innerHTML = '<small class=\'text-info\'>Updating...</small>'; document.getElementById('toggleProfitForm').submit();">
                                    <label class="form-check-label" for="holiday_profit_disable">
                                        <span class="text-muted">If enabled, users will not receive profits on holiday days</span>
                                    </label>
                                </form>
                            </div>
                            <div id="toggle-status" class="mt-2"></div>
                        </div>

                        <form action="{{ route('admin.holiday.update-weekly') }}" method="POST">
                            @csrf
                            <!-- Weekly Holidays Form -->
                            <div class="form-group">
                                <label class="font-weight-bold mb-3">Select days to mark as holidays:</label>
                                <div class="row">
                                    @foreach($weeklyHolidays as $day)
                                        <div class="col-md-3 mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" 
                                                    id="day{{ $day->day_of_week }}" 
                                                    name="days[]" 
                                                    value="{{ $day->day_of_week }}" 
                                                    {{ $day->status ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day{{ $day->day_of_week }}">
                                                    {{ $day->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Weekly Holidays</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5 mt-4">
                <div class="card card-primary shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Add New Holiday</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.holiday.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Holiday Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Holiday</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7 mt-4">
                <div class="card card-primary shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Specific Holidays</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($specificHolidays as $holiday)
                                        <tr>
                                            <td>{{ $holiday->name }}</td>
                                            <td>{{ $holiday->date->format('d M, Y') }}</td>
                                            <td>
                                                @if($holiday->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.holiday.delete', $holiday->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this holiday?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No specific holidays added yet</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            {{ $specificHolidays->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 