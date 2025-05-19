@extends('layout.mainLayout')

@section('title')
    Archived Employees
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/archive.css') }}">
@endsection

@section('page-title')
    Archived Employee Management
@endsection

@section('page-actions')
    <div class="action-buttons">
        <a href="/employees" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Return to List
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="success-popup">
            {{ session('success') }}
        </div>
    @endif
    <div class="employee-table-container">
        <div class="table-header-actions">
            <div class="table-title">Archived Employees</div>
            <div class="table-actions-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search employees...">
                </div>
                <button class="btn btn-outline">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
        
        <div class="table-container">
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Date of Archive</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count=0; @endphp
                    @foreach($employee as $index => $e)
                    @if($e->status != 'Active')
                        @php $count++; @endphp
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">{{ $e->first_name[0] }}{{ $e->last_name[0] }}</div>
                                    <div>
                                        <div class="employee-name">{{ $e->last_name }}, {{ $e->first_name }} {{ $e->middle_name }}</div>
                                        <div class="employee-email">{{ $e->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach($position as $pos)
                                    @if($pos->id == $e->position_id)
                                        <span class="position-badge">{{ $pos->position_name }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($department as $dept)
                                    @if($dept->id == $e->department_id)
                                        <span class="department-badge dept-{{ strtolower($dept->department_name) }}">
                                            {{ $dept->department_name }}
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($employment as $emp)
                                    @if($emp->id == $e->employment_type_id)
                                        <span class="position-badge">
                                            {{ $emp->type_name }}
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <span class="archive-date">
                                    <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($e->updated_at)->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ strtolower($e->status) }}">{{ $e->status }}</span>
                            </td>
                            <td>
                                <div class="table-actions"> 
                                    <form action="employees/{{$e->id}}/restore" method="POST" class="d-inline archive-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn-icon restore" title="Restore Employee" data-employee-id="{{ $e->id }}" data-employee-name="{{ $e->first_name }} {{ $e->last_name }}">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif   
                    @endforeach
                    @if($count == 0)
                        <tr>
                            <td colspan="7" class="no-data">No archived employees found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if(count($employee) > 0)
        <div class="pagination">
            {{ $employee->links() }}
        </div>
        @endif
    </div>

    <!-- Archive Confirmation Modal -->
    <div id="archiveModal" class="modal" aria-labelledby="archiveModalTitle" aria-modal="true" role="dialog">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="archiveModalTitle">Restore Employee</h2>
                <button type="button" class="modal-close" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <p id="archiveModalMessage">Are you sure you want to restore this employee?</p>
                <p class="modal-description">Restored employees will be returned to the active list.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelArchive">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirmArchive">
                    <i class="fas fa-archive"></i> Restore Employee
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/archive.js') }}"></script>
    <script src="{{ asset('js/notif.js') }}"></script>
@endsection