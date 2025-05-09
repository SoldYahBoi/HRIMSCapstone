@extends('layout.mainLayout')

@section('title')
    Certificates Management
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/manageCert.css') }}">
@endsection

@section('page-title')
    Certificates Management
@endsection

@section('page-actions')
    <div class="page-actions">
        <a href="/certArchives" class="btn btn-secondary">
            <i class="fas fa-archive"></i> Archives
        </a>
        <a href="/certificates/create" class="btn btn-primary">
            <i class="fas fa-plus" aria-hidden="true"></i> Add Certificate
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="success-popup">
            <div class="success-popup-content">
                <div class="success-popup-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="success-popup-message">
                    {{ session('success') }}
                </div>
                <button class="success-popup-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="success-popup-progress">
                <div class="success-popup-progress-bar"></div>
            </div>
        </div>
    @endif
    
    <div class="cert-container">
        <div class="cert-nav">
            <button id="birthBtn" class="cert-nav-btn active">
                <i class="fas fa-baby" aria-hidden="true"></i> Birth Certificates
            </button>
            <button id="deathBtn" class="cert-nav-btn">
                <i class="fas fa-cross" aria-hidden="true"></i> Death Certificates
            </button>
        </div>

        <div class="cert-actions">
            <div class="search-container">
                <input type="text" id="certSearch" class="form-control" placeholder="Search certificates...">
                <button class="btn btn-outline search-btn">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </button>
            </div>
            <div class="filter-container">
                <select id="certFilter" class="form-control">
                    <option value="all">All Dates</option>
                    <option value="recent">Last 30 Days</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>

        <div class="cert-content">
            <!-- Birth Certificates Section -->
            <div id="birthSection" class="cert-section active">
                <div class="section-header">
                    <h3><i class="fas fa-baby" aria-hidden="true"></i> Birth Certificates</h3>
                    <span class="cert-count">{{$count}} records</span>
                </div>
                
                <div class="table-responsive">
                    <table class="cert-table">
                        <thead>
                            <tr>
                                <th>Registry No.</th>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Parents</th>
                                <th>Place of Birth</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($birthCertificates ?? [] as $certificate)
                            <tr>
                                <td>{{ $certificate->registry_no }}</td>
                                <td>{{ $certificate->child->first_name }} {{ $certificate->child->middle_name }} {{ $certificate->child->last_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($certificate->child->date_of_birth)->format('M d, Y') }}</td>
                                <td>
                                    {{ $certificate->mother->first_name }} {{ $certificate->mother->last_name }}
                                    @if($certificate->father)
                                        & {{ $certificate->father->first_name }} {{ $certificate->father->last_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $certificate->child->place_of_birth_hospital }}, 
                                    {{ $cityMunicipality->firstWhere('id', $certificate->child->place_of_birth_city_municipality_id)?->name }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($certificate->created_at)->format('M d, Y') }}</td>
                                <td class="cert-actions-cell">
                                    <a href="{{ route('certificates.show', $certificate->cert_id) }}" class="btn-icon view-cert" title="View Certificate">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('certificates.edit', $certificate->cert_id) }}" class="btn-icon edit-cert" title="Edit Certificate">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <button class="btn-icon print-cert" data-id="{{ $certificate->id }}" title="Print Certificate">
                                        <i class="fas fa-print" aria-hidden="true"></i>
                                    </button>
                                    <form action="certificates/{{$certificate->cert_id}}/archive" method="POST" class="d-inline archive-form" id="archive-form-{{ $certificate->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn-icon archive" title="Archive Certificate" data-employee-id="{{ $certificate->cert_id }}" data-employee-name="{{ $certificate->child->first_name }} {{ $certificate->child->last_name }}">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No birth certificates found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    {{ $birthCertificates->links() ?? '' }}
                </div>
            </div>

            <!-- Uncomment and update the Death Certificates Section -->
            <div id="deathSection" class="cert-section">
                <div class="section-header">
                    <h3><i class="fas fa-cross" aria-hidden="true"></i> Death Certificates</h3>
                    <span class="cert-count">{{ $deathCount ?? 0 }} records</span>
                </div>
                
                <div class="table-responsive">
                    <table class="cert-table">
                        <thead>
                            <tr>
                                <th>Registry No.</th>
                                <th>Name</th>
                                <th>Date of Death</th>
                                <th>Cause of Death</th>
                                <th>Place of Death</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deathCertificates ?? [] as $certificate)
                            <tr>
                                <td>{{ $certificate->registry_no }}</td>
                                <td>{{ $certificate->deceased->first_name }} {{ $certificate->deceased->middle_name }} {{ $certificate->deceased->last_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($certificate->deceased->date_of_death)->format('M d, Y') }}</td>
                                <td>{{ $certificate->deathCause->immediate_cause ?? 'Not specified' }}</td>
                                <td>{{ $certificate->deceased->place_of_death }}, {{ $certificate->cityMunicipality->name ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($certificate->created_at)->format('M d, Y') }}</td>
                                <td class="cert-actions-cell">
                                    <a href="{{ route('certificates.show', $certificate->cert_id) }}" class="btn-icon view-cert" title="View Certificate">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('certificates.edit', $certificate->cert_id) }}" class="btn-icon edit-cert" title="Edit Certificate">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <button class="btn-icon print-cert" data-id="{{ $certificate->id }}" title="Print Certificate">
                                        <i class="fas fa-print" aria-hidden="true"></i>
                                    </button>
                                    <form action="certificates/{{$certificate->cert_id}}/archiveDeath" method="POST" class="d-inline archive-form" id="archive-form-{{ $certificate->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn-icon archive" title="Archive Certificate" data-employee-id="{{ $certificate->cert_id }}" data-employee-name="{{ $certificate->deceased->first_name }} {{ $certificate->deceased->last_name }}">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No death certificates found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    {{ $deathCertificates->links() ?? '' }}
                </div>
            </div>

        </div>
    </div>

    <!-- Archive Confirmation Modal -->
    <div id="archiveCertModal" class="modal" aria-labelledby="archiveModalTitle" aria-modal="true" role="dialog">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="archiveModalTitle">Archive Certificate</h2>
                <button type="button" class="modal-close" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <p id="archiveModalMessage">Are you sure you want to archive this certificate?</p>
                <p class="modal-description">Archived certificates will be moved to the archives section but their records will be preserved in the system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelArchive">
                    Cancel
                </button>
                <button type="button" class="btn btn-warning" id="confirmArchive">
                    <i class="fas fa-archive"></i> Archive Certificate
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/cert/manageCert.js') }}"></script>
@endsection
