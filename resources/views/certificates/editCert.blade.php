@extends('layout.mainLayout')

@section('title')
    Edit Birth Certificate
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/editCert.css') }}">
@endsection

@section('page-title')
    Edit Birth Certificate - {{ $birthCertificate->registry_no }}
@endsection

@section('page-actions')
    <div class="page-actions">
        <a href="{{ route('certificates.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Certificate List
        </a>
        <a href="{{ route('certificates.show', $birthCertificate->id) }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i> View Certificate
        </a>
    </div>
@endsection

@section('content')
    <div class="edit-certificate-container">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('certificates.update', $birthCertificate->id) }}" method="POST" id="editCertForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="certificate_type" value="birth">

            <div class="form-progress-container">
                <div class="form-progress-bar">
                    <div class="progress-step active" data-step="1">
                        <div class="step-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="step-label">Registry Info</div>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="step-icon"><i class="fas fa-baby"></i></div>
                        <div class="step-label">Child</div>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="step-icon"><i class="fas fa-female"></i></div>
                        <div class="step-label">Mother</div>
                    </div>
                    <div class="progress-step" data-step="4">
                        <div class="step-icon"><i class="fas fa-male"></i></div>
                        <div class="step-label">Father</div>
                    </div>
                    <div class="progress-step" data-step="5">
                        <div class="step-icon"><i class="fas fa-ring"></i></div>
                        <div class="step-label">Marriage</div>
                    </div>
                    <div class="progress-step" data-step="6">
                        <div class="step-icon"><i class="fas fa-user-md"></i></div>
                        <div class="step-label">Attendant</div>
                    </div>
                    <div class="progress-step" data-step="7">
                        <div class="step-icon"><i class="fas fa-user-edit"></i></div>
                        <div class="step-label">Officials</div>
                    </div>
                </div>
            </div>

            <!-- Step 1: Registry Information -->
            <div class="form-step active" id="step1">
                <div class="card">
                    <div class="card-header">
                        <h3>Registry Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="registry_no">Registry Number <span class="required">*</span></label>
                                <input type="text" class="form-control" id="registry_no" name="registry_no" value="{{ $birthCertificate->registry_no }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="province_id">Province <span class="required">*</span></label>
                                <select class="form-control" id="province_id" name="province_id" required>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $birthCertificate->province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="city_municipality_id">City/Municipality <span class="required">*</span></label>
                                <select class="form-control" id="city_municipality_id" name="city_municipality_id" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $birthCertificate->city_municipality_id == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="contact_no">Contact Number</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $birthCertificate->contact_no }}">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ $birthCertificate->remarks }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Child Information -->
            <div class="form-step" id="step2">
                <div class="card">
                    <div class="card-header">
                        <h3>Child Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="child_first_name">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="child_first_name" name="child[first_name]" value="{{ $birthCertificate->child->first_name }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="child_middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="child_middle_name" name="child[middle_name]" value="{{ $birthCertificate->child->middle_name }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="child_last_name">Last Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="child_last_name" name="child[last_name]" value="{{ $birthCertificate->child->last_name }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="child_sex">Sex <span class="required">*</span></label>
                                <select class="form-control" id="child_sex" name="child[sex]" required>
                                    <option value="Male" {{ $birthCertificate->child->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $birthCertificate->child->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $birthCertificate->child->sex == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="child_date_of_birth">Date of Birth <span class="required">*</span></label>
                                <input type="date" class="form-control" id="child_date_of_birth" name="child[date_of_birth]" value="{{ $birthCertificate->child->date_of_birth }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="child_weight_at_birth">Weight at Birth (grams)</label>
                                <input type="number" step="0.01" class="form-control" id="child_weight_at_birth" name="child[weight_at_birth]" value="{{ $birthCertificate->child->weight_at_birth }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="child_place_of_birth_hospital">Place of Birth (Hospital/Clinic/Institution) <span class="required">*</span></label>
                                <input type="text" class="form-control" id="child_place_of_birth_hospital" name="child[place_of_birth_hospital]" value="{{ $birthCertificate->child->place_of_birth_hospital }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="child_place_of_birth_province_id">Province of Birth <span class="required">*</span></label>
                                <select class="form-control province-select" id="child_place_of_birth_province_id" name="child[place_of_birth_province_id]" data-target="child_place_of_birth_city_municipality_id" required>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $birthCertificate->child->place_of_birth_province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="child_place_of_birth_city_municipality_id">City/Municipality of Birth <span class="required">*</span></label>
                                <select class="form-control" id="child_place_of_birth_city_municipality_id" name="child[place_of_birth_city_municipality_id]" required>
                                    @foreach($childCities as $city)
                                        <option value="{{ $city->id }}" {{ $birthCertificate->child->place_of_birth_city_municipality_id == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="child_type_of_birth">Type of Birth <span class="required">*</span></label>
                                <select class="form-control" id="child_type_of_birth" name="child[type_of_birth]" required>
                                    <option value="Single" {{ $birthCertificate->child->type_of_birth == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Twin" {{ $birthCertificate->child->type_of_birth == 'Twin' ? 'selected' : '' }}>Twin</option>
                                    <option value="Triplet" {{ $birthCertificate->child->type_of_birth == 'Triplet' ? 'selected' : '' }}>Triplet</option>
                                    <option value="Quadruplet" {{ $birthCertificate->child->type_of_birth == 'Quadruplet' ? 'selected' : '' }}>Quadruplet</option>
                                    <option value="Other" {{ $birthCertificate->child->type_of_birth == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 multiple-birth-field" style="{{ $birthCertificate->child->type_of_birth == 'Single' ? 'display: none;' : '' }}">
                                <label for="child_is_multiple_birth">Is Multiple Birth?</label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="child_is_multiple_birth" name="child[is_multiple_birth]" value="1" {{ $birthCertificate->child->is_multiple_birth ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="child_is_multiple_birth">Yes</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4 multiple-birth-field" style="{{ $birthCertificate->child->type_of_birth == 'Single' ? 'display: none;' : '' }}">
                                <label for="child_multiple_birth_type">Birth Order</label>
                                <select class="form-control" id="child_multiple_birth_type" name="child[multiple_birth_type]">
                                    <option value="First" {{ $birthCertificate->child->multiple_birth_type == 'First' ? 'selected' : '' }}>First</option>
                                    <option value="Second" {{ $birthCertificate->child->multiple_birth_type == 'Second' ? 'selected' : '' }}>Second</option>
                                    <option value="Third" {{ $birthCertificate->child->multiple_birth_type == 'Third' ? 'selected' : '' }}>Third</option>
                                    <option value="Fourth" {{ $birthCertificate->child->multiple_birth_type == 'Fourth' ? 'selected' : '' }}>Fourth</option>
                                    <option value="Fifth" {{ $birthCertificate->child->multiple_birth_type == 'Fifth' ? 'selected' : '' }}>Fifth</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Mother Information -->
            <div class="form-step" id="step3">
                <div class="card">
                    <div class="card-header">
                        <h3>Mother Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="mother_first_name">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="mother_first_name" name="mother[first_name]" value="{{ $birthCertificate->mother->first_name }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="mother_middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="mother_middle_name" name="mother[middle_name]" value="{{ $birthCertificate->mother->middle_name }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="mother_last_name">Last Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="mother_last_name" name="mother[last_name]" value="{{ $birthCertificate->mother->last_name }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="mother_maiden_name">Maiden Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="mother_maiden_name" name="mother[maiden_name]" value="{{ $birthCertificate->mother->maiden_name }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="mother_citizenship">Citizenship <span class="required">*</span></label>
                                <input type="text" class="form-control" id="mother_citizenship" name="mother[citizenship]" value="{{ $birthCertificate->mother->citizenship }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_religion">Religion</label>
                                <input type="text" class="form-control" id="mother_religion" name="mother[religion]" value="{{ $birthCertificate->mother->religion }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_occupation">Occupation</label>
                                <input type="text" class="form-control" id="mother_occupation" name="mother[occupation]" value="{{ $birthCertificate->mother->occupation }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="mother_age_at_birth">Age at Time of Birth</label>
                                <input type="number" class="form-control" id="mother_age_at_birth" name="mother[age_at_birth]" value="{{ $birthCertificate->mother->age_at_birth }}">
                            </div>
                            <div class="form-group col-md-8">
                                <label>Children Statistics</label>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="mother_total_children_born_alive">Total Born Alive</label>
                                        <input type="number" class="form-control" id="mother_total_children_born_alive" name="mother[total_children_born_alive]" value="{{ $birthCertificate->mother->total_children_born_alive }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mother_children_still_living">Still Living</label>
                                        <input type="number" class="form-control" id="mother_children_still_living" name="mother[children_still_living]" value="{{ $birthCertificate->mother->children_still_living }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mother_children_born_alive_now_dead">Now Dead</label>
                                        <input type="number" class="form-control" id="mother_children_born_alive_now_dead" name="mother[children_born_alive_now_dead]" value="{{ $birthCertificate->mother->children_born_alive_now_dead }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="mother_residence_house_no">House No.</label>
                                <input type="text" class="form-control" id="mother_residence_house_no" name="mother[residence_house_no]" value="{{ $birthCertificate->mother->residence_house_no }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_residence_street">Street</label>
                                <input type="text" class="form-control" id="mother_residence_street" name="mother[residence_street]" value="{{ $birthCertificate->mother->residence_street }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_residence_barangay">Barangay</label>
                                <input type="text" class="form-control" id="mother_residence_barangay" name="mother[residence_barangay]" value="{{ $birthCertificate->mother->residence_barangay }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="mother_residence_country_id">Country <span class="required">*</span></label>
                                <select class="form-control country-select" id="mother_residence_country_id" name="mother[residence_country_id]" data-target="mother_residence_province_id" required>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $birthCertificate->mother->residence_country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_residence_province_id">Province <span class="required">*</span></label>
                                <select class="form-control province-select" id="mother_residence_province_id" name="mother[residence_province_id]" data-target="mother_residence_city_municipality_id" required>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $birthCertificate->mother->residence_province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mother_residence_city_municipality_id">City/Municipality <span class="required">*</span></label>
                                <select class="form-control" id="mother_residence_city_municipality_id" name="mother[residence_city_municipality_id]" required>
                                    @foreach($motherCities as $city)
                                        <option value="{{ $city->id }}" {{ $birthCertificate->mother->residence_city_municipality_id == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Father Information -->
            <div class="form-step" id="step4">
                <div class="card">
                    <div class="card-header">
                        <h3>Father Information</h3>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="include_father" {{ isset($birthCertificate->father) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="include_father">Include Father Information</label>
                        </div>
                    </div>
                    <div class="card-body father-fields" {{ isset($birthCertificate->father) ? '' : 'style=display:none;' }}>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="father_first_name">First Name</label>
                                <input type="text" class="form-control" id="father_first_name" name="father[first_name]" value="{{ $birthCertificate->father->first_name ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="father_middle_name" name="father[middle_name]" value="{{ $birthCertificate->father->middle_name ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_last_name">Last Name</label>
                                <input type="text" class="form-control" id="father_last_name" name="father[last_name]" value="{{ $birthCertificate->father->last_name ?? '' }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="father_citizenship">Citizenship</label>
                                <input type="text" class="form-control" id="father_citizenship" name="father[citizenship]" value="{{ $birthCertificate->father->citizenship ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_religion">Religion</label>
                                <input type="text" class="form-control" id="father_religion" name="father[religion]" value="{{ $birthCertificate->father->religion ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_occupation">Occupation</label>
                                <input type="text" class="form-control" id="father_occupation" name="father[occupation]" value="{{ $birthCertificate->father->occupation ?? '' }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="father_age_at_birth">Age at Time of Birth</label>
                                <input type="number" class="form-control" id="father_age_at_birth" name="father[age_at_birth]" value="{{ $birthCertificate->father->age_at_birth ?? '' }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="father_residence_house_no">House No.</label>
                                <input type="text" class="form-control" id="father_residence_house_no" name="father[residence_house_no]" value="{{ $birthCertificate->father->residence_house_no ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_residence_street">Street</label>
                                <input type="text" class="form-control" id="father_residence_street" name="father[residence_street]" value="{{ $birthCertificate->father->residence_street ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_residence_barangay">Barangay</label>
                                <input type="text" class="form-control" id="father_residence_barangay" name="father[residence_barangay]" value="{{ $birthCertificate->father->residence_barangay ?? '' }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="father_residence_country_id">Country</label>
                                <select class="form-control country-select" id="father_residence_country_id" name="father[residence_country_id]" data-target="father_residence_province_id">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ isset($birthCertificate->father) && $birthCertificate->father->residence_country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_residence_province_id">Province</label>
                                <select class="form-control province-select" id="father_residence_province_id" name="father[residence_province_id]" data-target="father_residence_city_municipality_id">
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ isset($birthCertificate->father) && $birthCertificate->father->residence_province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="father_residence_city_municipality_id">City/Municipality</label>
                                <select class="form-control" id="father_residence_city_municipality_id" name="father[residence_city_municipality_id]">
                                    @if(isset($birthCertificate->father) && isset($birthCertificate->father->residence_province_id))
                                        @foreach($cities->where('province_id', $birthCertificate->father->residence_province_id) as $city)
                                            <option value="{{ $city->id }}" {{ $birthCertificate->father->residence_city_municipality_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach($cities->where('province_id', $provinces->first()->id) as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 5: Marriage Information -->
            <div class="form-step" id="step5">
                <div class="card">
                    <div class="card-header">
                        <h3>Marriage Information</h3>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="include_marriage" {{ isset($birthCertificate->marriage) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="include_marriage">Parents are Married</label>
                        </div>
                    </div>
                    <div class="card-body marriage-fields" {{ isset($birthCertificate->marriage) ? '' : 'style=display:none;' }}>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="marriage_date">Date of Marriage</label>
                                <input type="date" class="form-control" id="marriage_date" name="marriage[date]" value="{{ $birthCertificate->marriage->date ?? '' }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="marriage_place_country_id">Country</label>
                                <select class="form-control country-select" id="marriage_place_country_id" name="marriage[place_country_id]" data-target="marriage_place_province_id">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ isset($birthCertificate->marriage) && $birthCertificate->marriage->place_country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="marriage_place_province_id">Province</label>
                                <select class="form-control province-select" id="marriage_place_province_id" name="marriage[place_province_id]" data-target="marriage_place_city_municipality_id">
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ isset($birthCertificate->marriage) && $birthCertificate->marriage->place_province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="marriage_place_city_municipality_id">City/Municipality</label>
                                <select class="form-control" id="marriage_place_city_municipality_id" name="marriage[place_city_municipality_id]">
                                    @if(isset($marriageCities))
                                        @foreach($marriageCities as $city)
                                            <option value="{{ $city->id }}" {{ isset($birthCertificate->marriage) && $birthCertificate->marriage->place_city_municipality_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 6: Birth Attendant Information -->
            <div class="form-step" id="step6">
                <div class="card">
                    <div class="card-header">
                        <h3>Birth Attendant Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="birth_attendant_attendant_type">Attendant Type <span class="required">*</span></label>
                                <select class="form-control" id="birth_attendant_attendant_type" name="birth_attendant[attendant_type]" required>
                                    <option value="1" {{ $birthCertificate->birthAttendant->attendant_type == 1 ? 'selected' : '' }}>Physician</option>
                                    <option value="2" {{ $birthCertificate->birthAttendant->attendant_type == 2 ? 'selected' : '' }}>Nurse</option>
                                    <option value="3" {{ $birthCertificate->birthAttendant->attendant_type == 3 ? 'selected' : '' }}>Midwife</option>
                                    <option value="4" {{ $birthCertificate->birthAttendant->attendant_type == 4 ? 'selected' : '' }}>Hilot (Traditional Birth Attendant)</option>
                                    <option value="5" {{ $birthCertificate->birthAttendant->attendant_type == 5 ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 other-attendant-field" style="{{ $birthCertificate->birthAttendant->attendant_type == 5 ? '' : 'display: none;' }}">
                                <label for="birth_attendant_other_attendant_type">Specify Other Attendant Type</label>
                                <input type="text" class="form-control" id="birth_attendant_other_attendant_type" name="birth_attendant[other_attendant_type]" value="{{ $birthCertificate->birthAttendant->other_attendant_type }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="birth_attendant_name">Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="birth_attendant_name" name="birth_attendant[name]" value="{{ $birthCertificate->birthAttendant->name }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birth_attendant_title_or_position">Title/Position</label>
                                <input type="text" class="form-control" id="birth_attendant_title_or_position" name="birth_attendant[title_or_position]" value="{{ $birthCertificate->birthAttendant->title_or_position }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="birth_attendant_address">Address</label>
                                <input type="text" class="form-control" id="birth_attendant_address" name="birth_attendant[address]" value="{{ $birthCertificate->birthAttendant->address }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="birth_attendant_certification_date">Certification Date</label>
                                <input type="date" class="form-control" id="birth_attendant_certification_date" name="birth_attendant[certification_date]" value="{{ $birthCertificate->birthAttendant->certification_date }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="birth_attendant_birth_time">Birth Time</label>
                                <input type="time" class="form-control" id="birth_attendant_birth_time" name="birth_attendant[birth_time]" value="{{ $birthCertificate->birthAttendant->birth_time }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="button" class="btn btn-primary next-step">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- Step 7: Officials Information -->
            <div class="form-step" id="step7">
                <div class="card">
                    <div class="card-header">
                        <h3>Informant & Officials Information</h3>
                    </div>
                    <div class="card-body">
                        <h4>Informant</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="informant_name">Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="informant_name" name="informant[name]" value="{{ $birthCertificate->informant->name }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="informant_relationship_to_child">Relationship to Child <span class="required">*</span></label>
                                <input type="text" class="form-control" id="informant_relationship_to_child" name="informant[relationship_to_child]" value="{{ $birthCertificate->informant->relationship_to_child }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="informant_date">Date</label>
                                <input type="date" class="form-control" id="informant_date" name="informant[date]" value="{{ $birthCertificate->informant->date }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="informant_address">Address</label>
                                <input type="text" class="form-control" id="informant_address" name="informant[address]" value="{{ $birthCertificate->informant->address }}">
                            </div>
                        </div>

                        <hr>
                        <h4>Prepared By</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="prepared_by_name">Name</label>
                                <input type="text" class="form-control" id="prepared_by_name" name="prepared_by[name]" value="{{ $birthCertificate->preparedBy->name ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="prepared_by_title_or_position">Title/Position</label>
                                <input type="text" class="form-control" id="prepared_by_title_or_position" name="prepared_by[title_or_position]" value="{{ $birthCertificate->preparedBy->title_or_position ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="prepared_by_date">Date</label>
                                <input type="date" class="form-control" id="prepared_by_date" name="prepared_by[date]" value="{{ $birthCertificate->preparedBy->date ?? '' }}">
                            </div>
                        </div>

                        <hr>
                        <h4>Received By</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="received_by_name">Name</label>
                                <input type="text" class="form-control" id="received_by_name" name="received_by[name]" value="{{ $birthCertificate->receivedBy->name ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="received_by_title_or_position">Title/Position</label>
                                <input type="text" class="form-control" id="received_by_title_or_position" name="received_by[title_or_position]" value="{{ $birthCertificate->receivedBy->title_or_position ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="received_by_date">Date</label>
                                <input type="date" class="form-control" id="received_by_date" name="received_by[date]" value="{{ $birthCertificate->receivedBy->date ?? '' }}">
                            </div>
                        </div>

                        <hr>
                        <h4>Registered By</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="registered_by_name">Name</label>
                                <input type="text" class="form-control" id="registered_by_name" name="registered_by[name]" value="{{ $birthCertificate->registeredBy->name ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="registered_by_title_or_position">Title/Position</label>
                                <input type="text" class="form-control" id="registered_by_title_or_position" name="registered_by[title_or_position]" value="{{ $birthCertificate->registeredBy->title_or_position ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="registered_by_date">Date</label>
                                <input type="date" class="form-control" id="registered_by_date" name="registered_by[date]" value="{{ $birthCertificate->registeredBy->date ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-secondary prev-step"><i class="fas fa-arrow-left"></i> Previous</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/cert/editCert.js') }}"></script>
@endsection
