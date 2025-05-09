@extends('layout.mainLayout')

@section('title')
    Archived Certificates
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/certArchive.css') }}">
@endsection

@section('page-title')
    Certificates Archives
@endsection

@section('page-actions')
    <a href="/certificates" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Certificate List
    </a>
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
                                    <form action="certificates/{{$certificate->cert_id}}/restore" method="POST" class="d-inline restore-form" id="restore-form-{{ $certificate->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn-icon restore-cert" title="Restore Certificate" data-certificate-id="{{ $certificate->id }}" data-certificate-name="{{ $certificate->child->first_name }} {{ $certificate->child->last_name }}">
                                            <i class="fas fa-undo-alt" aria-hidden="true"></i>
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

            <!-- Death Certificates Section -->
            <div id="deathSection" class="cert-section">
                <div class="section-header">
                    <h3><i class="fas fa-cross" aria-hidden="true"></i> Death Certificates</h3>
                    <span class="cert-count">2 records</span>
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
                                <td>{{ \Carbon\Carbon::parse($certificate->date_of_death)->format('M d, Y') }}</td>
                                <td>{{ $deathCause->firstWhere('id', $certificate->death_cause_id)?->immediate_cause ?? 'N/A' }}</td>
                                <td>{{ $certificate->deceased->place_of_death }}, {{ $certificate->cityMunicipality->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($certificate->created_at)->format('M d, Y') }}</td>
                                <td class="cert-actions-cell">
                                    <form action="certificates/{{$certificate->cert_id}}/restoreDeath" method="POST" class="d-inline restore-form" id="restore-form-{{ $certificate->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn-icon restore-cert" title="Restore Certificate" data-certificate-id="{{ $certificate->id }}" data-certificate-name="{{ $certificate->deceased->first_name }} {{ $certificate->deceased->last_name }}">
                                            <i class="fas fa-undo-alt" aria-hidden="true"></i>
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
                   
                </div>
            </div>
        </div>
    </div>

    <!-- Restore Confirmation Modal -->
    <div id="restoreCertModal" class="modal" aria-labelledby="restoreModalTitle" aria-modal="true" role="dialog">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="restoreModalTitle">Restore Certificate</h2>
                <button type="button" class="modal-close" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <p id="restoreModalMessage">Are you sure you want to restore this certificate?</p>
                <p class="modal-description">Restored certificates will be moved back to the active certificates list and will be available for normal operations.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" id="cancelRestore">
                    Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmRestore">
                    <i class="fas fa-undo-alt"></i> Restore Certificate
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/cert/certArchive.js') }}"></script>
@endsection
