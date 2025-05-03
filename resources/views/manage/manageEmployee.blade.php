@extends('layout.mainLayout')

@section('title')
    Manage Employees
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/employeeManagement.css') }}">
@endsection

@section('page-title')
    Employee Management
@endsection

@section('page-actions')
    <div class="action-buttons">
        <a href="/archives" class="btn btn-secondary">
            <i class="fas fa-archive"></i> Archives
        </a>
        <a href="/admin/create">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Employee
            </button>
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
            <div class="table-title">Employee Directory</div>
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employee as $index => $e)
                    <tr>
                        @if($e->status == 'Active')
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
                            <span class="status-badge {{ strtolower($e->status) }}">{{ $e->status }}</span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="admin/{{$e->id}}" class="btn-icon view" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="admin/{{$e->id}}/edit" class="btn-icon edit" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="employees/{{$e->id}}/archive" method="POST" class="d-inline archive-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" class="btn-icon archive" title="Archive Employee" data-employee-id="{{ $e->id }}" data-employee-name="{{ $e->first_name }} {{ $e->last_name }}">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>No employees found</h3>
                                <p>There are no employees in the system yet.</p>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Employee
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
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
                <h2 id="archiveModalTitle">Archive Employee</h2>
                <button type="button" class="modal-close" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <p id="archiveModalMessage">Are you sure you want to archive this employee?</p>
                <p class="modal-description">Archived employees will be marked as inactive but their records will be preserved in the system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelArchive">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmArchive">
                    <i class="fas fa-archive"></i> Archive Employee
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/manage.js') }}"></script>
    <script src="{{ asset('js/notif.js') }}"></script>
@endsection