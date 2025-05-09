@extends('layout.mainLayout')

@section('title')
    Edit Death Certificate
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/editDeathCert.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-title')
    Edit Death Certificate - {{ $deathCertificate->registry_no }}
@endsection

@section('page-actions')
    <div class="page-actions">
        <a href="{{ route('certificates.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Certificate List
        </a>
        <a href="{{ route('certificates.show', $deathCertificate->cert_id) }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i> View Certificate
        </a>
    </div>
@endsection

@section('content')
    <div class="edit-certificate-container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> Please check the form for errors.
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Form Progress Bar -->
        <div class="form-progress-container">
            <div class="form-progress-bar">
                <div class="progress-step" data-step="0">
                    <div class="step-icon">1</div>
                    <div class="step-label">Certificate Info</div>
                </div>
                <div class="progress-step" data-step="1">
                    <div class="step-icon">2</div>
                    <div class="step-label">Deceased Info</div>
                </div>
                <div class="progress-step" data-step="2">
                    <div class="step-icon">3</div>
                    <div class="step-label">Death Cause</div>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="step-icon">4</div>
                    <div class="step-label">Attendant & Informant</div>
                </div>
                <div class="progress-step" data-step="4">
                    <div class="step-icon">5</div>
                    <div class="step-label">Disposal & Officials</div>
                </div>
            </div>
        </div>

        <form id="editDeathCertForm" action="{{ route('certificates.update', $deathCertificate->cert_id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="certificate_type" value="death">

            <!-- Step 1: Certificate Information -->
            <div class="form-step" id="step1">
                <div class="card">
                    <div class="card-header">
                        <h3>Certificate Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="registry_no">Registry Number <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="registry_no" name="registry_no" value="{{ $deathCertificate->registry_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province_id">Province <span class="required">*</span></label>
                                    <select class="form-control" id="province_id" name="province_id" required>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $deathCertificate->province_id == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_municipality_id">City/Municipality <span class="required">*</span></label>
                                    <select class="form-control" id="city_municipality_id" name="city_municipality_id" required>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $deathCertificate->city_municipality_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_no">Contact Number</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $deathCertificate->contact_no }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ $deathCertificate->remarks }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div></div>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Deceased Information -->
            <div class="form-step" id="step2">
                <div class="card">
                    <div class="card-header">
                        <h3>Deceased Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_first_name">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="deceased_first_name" name="deceased[first_name]" value="{{ $deathCertificate->deceased->first_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="deceased_middle_name" name="deceased[middle_name]" value="{{ $deathCertificate->deceased->middle_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_last_name">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="deceased_last_name" name="deceased[last_name]" value="{{ $deathCertificate->deceased->last_name }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_sex">Sex <span class="required">*</span></label>
                                    <select class="form-control" id="deceased_sex" name="deceased[sex]" required>
                                        <option value="Male" {{ $deathCertificate->deceased->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $deathCertificate->deceased->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ $deathCertificate->deceased->sex == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_date_of_birth">Date of Birth</label>
                                    <input type="date" class="form-control" id="deceased_date_of_birth" name="deceased[date_of_birth]" value="{{ $deathCertificate->deceased->date_of_birth }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_date_of_death">Date of Death <span class="required">*</span></label>
                                    <input type="date" class="form-control" id="deceased_date_of_death" name="deceased[date_of_death]" value="{{ $deathCertificate->deceased->date_of_death }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mt-3 mb-3">Age at Death</h4>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="deceased_age_years">Years</label>
                                    <input type="number" class="form-control" id="deceased_age_years" name="deceased[age_years]" value="{{ $deathCertificate->deceased->age_years }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="deceased_age_months">Months</label>
                                    <input type="number" class="form-control" id="deceased_age_months" name="deceased[age_months]" value="{{ $deathCertificate->deceased->age_months }}" min="0" max="11">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="deceased_age_days">Days</label>
                                    <input type="number" class="form-control" id="deceased_age_days" name="deceased[age_days]" value="{{ $deathCertificate->deceased->age_days }}" min="0" max="30">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="deceased_age_hours">Hours</label>
                                    <input type="number" class="form-control" id="deceased_age_hours" name="deceased[age_hours]" value="{{ $deathCertificate->deceased->age_hours }}" min="0" max="23">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="deceased_age_minutes">Minutes</label>
                                    <input type="number" class="form-control" id="deceased_age_minutes" name="deceased[age_minutes]" value="{{ $deathCertificate->deceased->age_minutes }}" min="0" max="59">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deceased_place_of_death">Place of Death <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="deceased_place_of_death" name="deceased[place_of_death]" value="{{ $deathCertificate->deceased->place_of_death }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deceased_civil_status">Civil Status <span class="required">*</span></label>
                                    <select class="form-control" id="deceased_civil_status" name="deceased[civil_status]" required>
                                        <option value="Single" {{ $deathCertificate->deceased->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ $deathCertificate->deceased->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Widowed" {{ $deathCertificate->deceased->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Divorced" {{ $deathCertificate->deceased->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="Separated" {{ $deathCertificate->deceased->civil_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deceased_religion">Religion</label>
                                    <input type="text" class="form-control" id="deceased_religion" name="deceased[religion]" value="{{ $deathCertificate->deceased->religion }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deceased_citizenship">Citizenship</label>
                                    <input type="text" class="form-control" id="deceased_citizenship" name="deceased[citizenship]" value="{{ $deathCertificate->deceased->citizenship }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mt-3 mb-3">Residence</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_residence_house_no">House No./Lot/Bldg</label>
                                    <input type="text" class="form-control" id="deceased_residence_house_no" name="deceased[residence_house_no]" value="{{ $deathCertificate->deceased->residence_house_no }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_residence_street">Street</label>
                                    <input type="text" class="form-control" id="deceased_residence_street" name="deceased[residence_street]" value="{{ $deathCertificate->deceased->residence_street }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_residence_barangay">Barangay</label>
                                    <input type="text" class="form-control" id="deceased_residence_barangay" name="deceased[residence_barangay]" value="{{ $deathCertificate->deceased->residence_barangay }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_residence_country_id">Country <span class="required">*</span></label>
                                    <select class="form-control country-select" id="deceased_residence_country_id" name="deceased[residence_country_id]" data-target="deceased_residence_province_id" required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $deathCertificate->deceased->residence_country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_residence_province_id">Province <span class="required">*</span></label>
                                    <select class="form-control province-select" id="deceased_residence_province_id" name="deceased[residence_province_id]" data-target="deceased_residence_city_municipality_id" required>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $deathCertificate->deceased->residence_province_id == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_residence_city_municipality_id">City/Municipality <span class="required">*</span></label>
                                    <select class="form-control" id="deceased_residence_city_municipality_id" name="deceased[residence_city_municipality_id]" required>
                                        @foreach($deceasedCities as $city)
                                            <option value="{{ $city->id }}" {{ $deathCertificate->deceased->residence_city_municipality_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_occupation">Occupation</label>
                                    <input type="text" class="form-control" id="deceased_occupation" name="deceased[occupation]" value="{{ $deathCertificate->deceased->occupation }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_father_name">Father's Name</label>
                                    <input type="text" class="form-control" id="deceased_father_name" name="deceased[father_name]" value="{{ $deathCertificate->deceased->father_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deceased_mother_maiden_name">Mother's Maiden Name</label>
                                    <input type="text" class="form-control" id="deceased_mother_maiden_name" name="deceased[mother_maiden_name]" value="{{ $deathCertificate->deceased->mother_maiden_name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Death Cause Information -->
            <div class="form-step" id="step3">
                <div class="card">
                    <div class="card-header">
                        <h3>Cause of Death</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_cause_immediate_cause">Immediate Cause</label>
                                    <input type="text" class="form-control" id="death_cause_immediate_cause" name="death_cause[immediate_cause]" value="{{ $deathCertificate->deathCause->immediate_cause }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_cause_interval_between_onset_and_death">Interval Between Onset and Death</label>
                                    <input type="text" class="form-control" id="death_cause_interval_between_onset_and_death" name="death_cause[interval_between_onset_and_death]" value="{{ $deathCertificate->deathCause->interval_between_onset_and_death }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="death_cause_antecedent_cause">Antecedent Cause</label>
                                    <input type="text" class="form-control" id="death_cause_antecedent_cause" name="death_cause[antecedent_cause]" value="{{ $deathCertificate->deathCause->antecedent_cause }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="death_cause_underlying_cause">Underlying Cause</label>
                                    <input type="text" class="form-control" id="death_cause_underlying_cause" name="death_cause[underlying_cause]" value="{{ $deathCertificate->deathCause->underlying_cause }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="death_cause_other_significant_conditions">Other Significant Conditions</label>
                                    <textarea class="form-control" id="death_cause_other_significant_conditions" name="death_cause[other_significant_conditions]" rows="3">{{ $deathCertificate->deathCause->other_significant_conditions }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_cause_maternal_condition">Maternal Condition (if applicable)</label>
                                    <input type="text" class="form-control" id="death_cause_maternal_condition" name="death_cause[maternal_condition]" value="{{ $deathCertificate->deathCause->maternal_condition }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_cause_manner_of_death">Manner of Death</label>
                                    <select class="form-control" id="death_cause_manner_of_death" name="death_cause[manner_of_death]">
                                        <option value="" {{ $deathCertificate->deathCause->manner_of_death == '' ? 'selected' : '' }}>Select Manner of Death</option>
                                        <option value="Natural" {{ $deathCertificate->deathCause->manner_of_death == 'Natural' ? 'selected' : '' }}>Natural</option>
                                        <option value="Accident" {{ $deathCertificate->deathCause->manner_of_death == 'Accident' ? 'selected' : '' }}>Accident</option>
                                        <option value="Suicide" {{ $deathCertificate->deathCause->manner_of_death == 'Suicide' ? 'selected' : '' }}>Suicide</option>
                                        <option value="Homicide" {{ $deathCertificate->deathCause->manner_of_death == 'Homicide' ? 'selected' : '' }}>Homicide</option>
                                        <option value="Pending Investigation" {{ $deathCertificate->deathCause->manner_of_death == 'Pending Investigation' ? 'selected' : '' }}>Pending Investigation</option>
                                        <option value="Undetermined" {{ $deathCertificate->deathCause->manner_of_death == 'Undetermined' ? 'selected' : '' }}>Undetermined</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_cause_external_cause_place">Place of Occurrence (if external cause)</label>
                                    <input type="text" class="form-control" id="death_cause_external_cause_place" name="death_cause[external_cause_place]" value="{{ $deathCertificate->deathCause->external_cause_place }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="death_cause_autopsy_performed" name="death_cause[autopsy_performed]" value="1" {{ $deathCertificate->deathCause->autopsy_performed ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="death_cause_autopsy_performed">Autopsy Performed</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Attendant & Informant Information -->
            <div class="form-step" id="step4">
                <div class="card">
                    <div class="card-header">
                        <h3>Death Attendant</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_attendant_attendant_type">Attendant Type <span class="required">*</span></label>
                                    <select class="form-control" id="death_attendant_attendant_type" name="death_attendant[attendant_type]" required>
                                        <option value="1" {{ $deathCertificate->deathAttendant->attendant_type == 1 ? 'selected' : '' }}>Physician</option>
                                        <option value="2" {{ $deathCertificate->deathAttendant->attendant_type == 2 ? 'selected' : '' }}>Nurse</option>
                                        <option value="3" {{ $deathCertificate->deathAttendant->attendant_type == 3 ? 'selected' : '' }}>Midwife</option>
                                        <option value="4" {{ $deathCertificate->deathAttendant->attendant_type == 4 ? 'selected' : '' }}>Hospital Staff</option>
                                        <option value="5" {{ $deathCertificate->deathAttendant->attendant_type == 5 ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 other-attendant-field" style="{{ $deathCertificate->deathAttendant->attendant_type == 5 ? '' : 'display: none;' }}">
                                <div class="form-group">
                                    <label for="death_attendant_other_attendant_type">Specify Other Attendant Type</label>
                                    <input type="text" class="form-control" id="death_attendant_other_attendant_type" name="death_attendant[other_attendant_type]" value="{{ $deathCertificate->deathAttendant->other_attendant_type }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_attendant_name">Attendant Name</label>
                                    <input type="text" class="form-control" id="death_attendant_name" name="death_attendant[name]" value="{{ $deathCertificate->deathAttendant->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_attendant_title_or_position">Title/Position</label>
                                    <input type="text" class="form-control" id="death_attendant_title_or_position" name="death_attendant[title_or_position]" value="{{ $deathCertificate->deathAttendant->title_or_position }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="death_attendant_address">Address</label>
                                    <textarea class="form-control" id="death_attendant_address" name="death_attendant[address]" rows="2">{{ $deathCertificate->deathAttendant->address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="death_attendant_attended_from">Attended From</label>
                                    <input type="date" class="form-control" id="death_attendant_attended_from" name="death_attendant[attended_from]" value="{{ $deathCertificate->deathAttendant->attended_from }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="death_attendant_attended_to">Attended To</label>
                                    <input type="date" class="form-control" id="death_attendant_attended_to" name="death_attendant[attended_to]" value="{{ $deathCertificate->deathAttendant->attended_to }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="death_attendant_death_time">Time of Death</label>
                                    <input type="time" class="form-control" id="death_attendant_death_time" name="death_attendant[death_time]" value="{{ $deathCertificate->deathAttendant->death_time }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="death_attendant_certification_date">Certification Date</label>
                                    <input type="date" class="form-control" id="death_attendant_certification_date" name="death_attendant[certification_date]" value="{{ $deathCertificate->deathAttendant->certification_date }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="death_attendant_attended_deceased" name="death_attendant[attended_deceased]" value="1" {{ $deathCertificate->deathAttendant->attended_deceased ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="death_attendant_attended_deceased">Attended the Deceased</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Death Informant</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_informant_name">Informant Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="death_informant_name" name="death_informant[name]" value="{{ $deathCertificate->deathInformant->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="death_informant_relationship_to_deceased">Relationship to Deceased <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="death_informant_relationship_to_deceased" name="death_informant[relationship_to_deceased]" value="{{ $deathCertificate->deathInformant->relationship_to_deceased }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="death_informant_address">Address</label>
                                    <textarea class="form-control" id="death_informant_address" name="death_informant[address]" rows="2">{{ $deathCertificate->deathInformant->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="death_informant_date">Date</label>
                                    <input type="date" class="form-control" id="death_informant_date" name="death_informant[date]" value="{{ $deathCertificate->deathInformant->date }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 5: Disposal & Officials Information -->
            <div class="form-step" id="step5">
                <div class="card">
                    <div class="card-header">
                        <h3>Corpse Disposal</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_disposal_type">Disposal Type <span class="required">*</span></label>
                                    <select class="form-control" id="corpse_disposal_disposal_type" name="corpse_disposal[disposal_type]" required>
                                        <option value="Burial" {{ $deathCertificate->corpseDisposal->disposal_type == 'Burial' ? 'selected' : '' }}>Burial</option>
                                        <option value="Cremation" {{ $deathCertificate->corpseDisposal->disposal_type == 'Cremation' ? 'selected' : '' }}>Cremation</option>
                                        <option value="Others" {{ $deathCertificate->corpseDisposal->disposal_type == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 other-disposal-field" style="{{ $deathCertificate->corpseDisposal->disposal_type == 'Others' ? '' : 'display: none;' }}">
                                <div class="form-group">
                                    <label for="corpse_disposal_other_disposal_type">Specify Other Disposal Type</label>
                                    <input type="text" class="form-control" id="corpse_disposal_other_disposal_type" name="corpse_disposal[other_disposal_type]" value="{{ $deathCertificate->corpseDisposal->other_disposal_type }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_burial_cremation_permit_number">Burial/Cremation Permit Number</label>
                                    <input type="text" class="form-control" id="corpse_disposal_burial_cremation_permit_number" name="corpse_disposal[burial_cremation_permit_number]" value="{{ $deathCertificate->corpseDisposal->burial_cremation_permit_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_burial_cremation_permit_date">Burial/Cremation Permit Date</label>
                                    <input type="date" class="form-control" id="corpse_disposal_burial_cremation_permit_date" name="corpse_disposal[burial_cremation_permit_date]" value="{{ $deathCertificate->corpseDisposal->burial_cremation_permit_date }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_transfer_permit_number">Transfer Permit Number</label>
                                    <input type="text" class="form-control" id="corpse_disposal_transfer_permit_number" name="corpse_disposal[transfer_permit_number]" value="{{ $deathCertificate->corpseDisposal->transfer_permit_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_transfer_permit_date">Transfer Permit Date</label>
                                    <input type="date" class="form-control" id="corpse_disposal_transfer_permit_date" name="corpse_disposal[transfer_permit_date]" value="{{ $deathCertificate->corpseDisposal->transfer_permit_date }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_cemetery_name">Cemetery/Crematory Name</label>
                                    <input type="text" class="form-control" id="corpse_disposal_cemetery_name" name="corpse_disposal[cemetery_name]" value="{{ $deathCertificate->corpseDisposal->cemetery_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="corpse_disposal_cemetery_address">Cemetery/Crematory Address</label>
                                    <input type="text" class="form-control" id="corpse_disposal_cemetery_address" name="corpse_disposal[cemetery_address]" value="{{ $deathCertificate->corpseDisposal->cemetery_address }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Officials</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="mb-3">Prepared By</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prepared_by_name">Name</label>
                                    <input type="text" class="form-control" id="prepared_by_name" name="prepared_by[name]" value="{{ $deathCertificate->preparedBy->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prepared_by_title_or_position">Title/Position</label>
                                    <input type="text" class="form-control" id="prepared_by_title_or_position" name="prepared_by[title_or_position]" value="{{ $deathCertificate->preparedBy->title_or_position ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prepared_by_date">Date</label>
                                    <input type="date" class="form-control" id="prepared_by_date" name="prepared_by[date]" value="{{ $deathCertificate->preparedBy->date ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">Received By</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="received_by_name">Name</label>
                                    <input type="text" class="form-control" id="received_by_name" name="received_by[name]" value="{{ $deathCertificate->receivedBy->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="received_by_title_or_position">Title/Position</label>
                                    <input type="text" class="form-control" id="received_by_title_or_position" name="received_by[title_or_position]" value="{{ $deathCertificate->receivedBy->title_or_position ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="received_by_date">Date</label>
                                    <input type="date" class="form-control" id="received_by_date" name="received_by[date]" value="{{ $deathCertificate->receivedBy->date ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">Registered By</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="registered_by_name">Name</label>
                                    <input type="text" class="form-control" id="registered_by_name" name="registered_by[name]" value="{{ $deathCertificate->registeredBy->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="registered_by_title_or_position">Title/Position</label>
                                    <input type="text" class="form-control" id="registered_by_title_or_position" name="registered_by[title_or_position]" value="{{ $deathCertificate->registeredBy->title_or_position ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="registered_by_date">Date</label>
                                    <input type="date" class="form-control" id="registered_by_date" name="registered_by[date]" value="{{ $deathCertificate->registeredBy->date ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">Reviewed By</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reviewed_by_name">Name</label>
                                    <input type="text" class="form-control" id="reviewed_by_name" name="reviewed_by[name]" value="{{ $deathCertificate->reviewedBy->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reviewed_by_title_or_position">Title/Position</label>
                                    <input type="text" class="form-control" id="reviewed_by_title_or_position" name="reviewed_by[title_or_position]" value="{{ $deathCertificate->reviewedBy->title_or_position ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reviewed_by_date">Date</label>
                                    <input type="date" class="form-control" id="reviewed_by_date" name="reviewed_by[date]" value="{{ $deathCertificate->reviewedBy->date ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/cert/editDeathCert.js') }}"></script>
@endsection