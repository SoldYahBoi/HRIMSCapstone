@extends('layout.mainLayout')

@section('title')
    Add Certificates
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/addCert.css') }}">
@endsection

@section('page-title')
    Add Birth Certificates and Death Certificates
@endsection

@section('page-actions')
    <a href="/certificates" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Certificate List
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="success-popup">
            {{ session('success') }}
        </div>
    @endif
    <div class="certificate-tabs">
        <button class="tab-button active" data-tab="birth">Birth Certificate</button>
        <button class="tab-button" data-tab="death">Death Certificate</button>
    </div>

    <div class="tab-content active" id="birth-tab">
        <form id="birthCertificateForm" method="POST" action="/certificates">
            @csrf
            <input type="hidden" name="certificate_type" value="birth">
            
            <!-- Registry Information Section -->
            <div class="form-section">
                <h3>Registry Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="registry_no">Registry Number <span class="required">*</span></label>
                        <input type="text" id="registry_no" name="registry_no" value="{{ old('registry_no') }}">
                        @error('registry_no')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="province_id">Province <span class="required">*</span></label>
                        <select id="province_id" name="province_id" >
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city_municipality_id">City/Municipality <span class="required">*</span></label>
                        <select id="city_municipality_id" name="city_municipality_id" >
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Child Information Section -->
            <div class="form-section">
                <h3>Child Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="child_first_name">First Name <span class="required">*</span></label>
                        <input type="text" id="child_first_name" name="child[first_name]" >
                    </div>
                    <div class="form-group">
                        <label for="child_middle_name">Middle Name</label>
                        <input type="text" id="child_middle_name" name="child[middle_name]">
                    </div>
                    <div class="form-group">
                        <label for="child_last_name">Last Name <span class="required">*</span></label>
                        <input type="text" id="child_last_name" name="child[last_name]" >
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="child_sex">Sex <span class="required">*</span></label>
                        <select id="child_sex" name="child[sex]" >
                            <option value="">Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="child_date_of_birth">Date of Birth <span class="required">*</span></label>
                        <input type="date" id="child_date_of_birth" name="child[date_of_birth]" >
                    </div>
                    <div class="form-group">
                        <label for="child_weight_at_birth">Birth Weight (grams)</label>
                        <input type="number" step="0.01" id="child_weight_at_birth" name="child[weight_at_birth]">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="child_place_of_birth_hospital">Hospital/Institution</label>
                        <input type="text" id="child_place_of_birth_hospital" name="child[place_of_birth_hospital]">
                    </div>
                    <div class="form-group">
                        <label for="child_place_of_birth_province_id">Birth Province <span class="required">*</span></label>
                        <select id="child_place_of_birth_province_id" name="child[place_of_birth_province_id]" >
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="child_place_of_birth_city_municipality_id">Birth City/Municipality <span class="required">*</span></label>
                        <select id="child_place_of_birth_city_municipality_id" name="child[place_of_birth_city_municipality_id]" >
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="child_type_of_birth">Type of Birth <span class="required">*</span></label>
                        <select id="child_type_of_birth" name="child[type_of_birth]" >
                            <option value="Single">Single</option>
                            <option value="Twin">Twin</option>
                            <option value="Triplet">Triplet</option>
                            <option value="Quadruplet">Quadruplet</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group multiple-birth-field" style="display: none;">
                        <label for="child_is_multiple_birth">Multiple Birth?</label>
                        <select id="child_is_multiple_birth" name="child[is_multiple_birth]">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group multiple-birth-field" style="display: none;">
                        <label for="child_multiple_birth_type">Birth Order</label>
                        <select id="child_multiple_birth_type" name="child[multiple_birth_type]">
                            <option value="First">First</option>
                            <option value="Second">Second</option>
                            <option value="Third">Third</option>
                            <option value="Fourth">Fourth</option>
                            <option value="Fifth">Fifth</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Mother Information Section -->
            <div class="form-section">
                <h3>Mother Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mother_first_name">First Name <span class="required">*</span></label>
                        <input type="text" id="mother_first_name" name="mother[first_name]" >
                    </div>
                    <div class="form-group">
                        <label for="mother_middle_name">Middle Name</label>
                        <input type="text" id="mother_middle_name" name="mother[middle_name]">
                    </div>
                    <div class="form-group">
                        <label for="mother_last_name">Last Name <span class="required">*</span></label>
                        <input type="text" id="mother_last_name" name="mother[last_name]" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mother_maiden_name">Maiden Name <span class="required">*</span></label>
                        <input type="text" id="mother_maiden_name" name="mother[maiden_name]" >
                    </div>
                    <div class="form-group">
                        <label for="mother_citizenship">Citizenship <span class="required">*</span></label>
                        <input type="text" id="mother_citizenship" name="mother[citizenship]" >
                    </div>
                    <div class="form-group">
                        <label for="mother_religion">Religion</label>
                        <input type="text" id="mother_religion" name="mother[religion]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mother_occupation">Occupation</label>
                        <input type="text" id="mother_occupation" name="mother[occupation]">
                    </div>
                    <div class="form-group">
                        <label for="mother_age_at_birth">Age at time of birth</label>
                        <input type="number" id="mother_age_at_birth" name="mother[age_at_birth]" min="12" max="100">
                    </div>
                </div>

                <h4>Residence Information</h4>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mother_residence_house_no">House No.</label>
                        <input type="text" id="mother_residence_house_no" name="mother[residence_house_no]">
                    </div>
                    <div class="form-group">
                        <label for="mother_residence_street">Street/Sitio</label>
                        <input type="text" id="mother_residence_street" name="mother[residence_street]">
                    </div>
                    <div class="form-group">
                        <label for="mother_residence_barangay">Barangay</label>
                        <input type="text" id="mother_residence_barangay" name="mother[residence_barangay]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mother_residence_country_id">Country <span class="required">*</span></label>
                        <select id="mother_residence_country_id" name="mother[residence_country_id]" >
                            <option value="">Select Country</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mother_residence_province_id">Province <span class="required">*</span></label>
                        <select id="mother_residence_province_id" name="mother[residence_province_id]" >
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mother_residence_city_municipality_id">City/Municipality <span class="required">*</span></label>
                        <select id="mother_residence_city_municipality_id" name="mother[residence_city_municipality_id]" >
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                </div>

                <h4>Children Information</h4>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mother_total_children_born_alive">Total Children Born Alive</label>
                        <input type="number" id="mother_total_children_born_alive" name="mother[total_children_born_alive]" min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label for="mother_children_still_living">Children Still Living</label>
                        <input type="number" id="mother_children_still_living" name="mother[children_still_living]" min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label for="mother_children_born_alive_now_dead">Children Born Alive Now Dead</label>
                        <input type="number" id="mother_children_born_alive_now_dead" name="mother[children_born_alive_now_dead]" min="0" value="0">
                    </div>
                </div>
            </div>
            
            <!-- Father Information Section -->
            <div class="form-section">
                <h3>Father Information</h3>
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="include_father" checked>
                    <label for="include_father">Include Father Information</label>
                </div>
                
                <div id="father_information_fields">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="father_first_name">First Name <span class="required">*</span></label>
                            <input type="text" id="father_first_name" name="father[first_name]" >
                        </div>
                        <div class="form-group">
                            <label for="father_middle_name">Middle Name</label>
                            <input type="text" id="father_middle_name" name="father[middle_name]">
                        </div>
                        <div class="form-group">
                            <label for="father_last_name">Last Name <span class="required">*</span></label>
                            <input type="text" id="father_last_name" name="father[last_name]" >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="father_citizenship">Citizenship <span class="required">*</span></label>
                            <input type="text" id="father_citizenship" name="father[citizenship]" >
                        </div>
                        <div class="form-group">
                            <label for="father_religion">Religion</label>
                            <input type="text" id="father_religion" name="father[religion]">
                        </div>
                        <div class="form-group">
                            <label for="father_occupation">Occupation</label>
                            <input type="text" id="father_occupation" name="father[occupation]">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="father_age_at_birth">Age at time of birth</label>
                            <input type="number" id="father_age_at_birth" name="father[age_at_birth]" min="12" max="100">
                        </div>
                    </div>

                    <h4>Residence Information</h4>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="same_as_mother_address">
                        <label for="same_as_mother_address">Same as Mother's Address</label>
                    </div>
                    <div id="father_address_fields">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="father_residence_house_no">House No.</label>
                                <input type="text" id="father_residence_house_no" name="father[residence_house_no]">
                            </div>
                            <div class="form-group">
                                <label for="father_residence_street">Street/Sitio</label>
                                <input type="text" id="father_residence_street" name="father[residence_street]">
                            </div>
                            <div class="form-group">
                                <label for="father_residence_barangay">Barangay</label>
                                <input type="text" id="father_residence_barangay" name="father[residence_barangay]">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="father_residence_country_id">Country <span class="required">*</span></label>
                                <select id="father_residence_country_id" name="father[residence_country_id]" >
                                    <option value="">Select Country</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="father_residence_province_id">Province <span class="required">*</span></label>
                                <select id="father_residence_province_id" name="father[residence_province_id]" >
                                    <option value="">Select Province</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="father_residence_city_municipality_id">City/Municipality <span class="required">*</span></label>
                                <select id="father_residence_city_municipality_id" name="father[residence_city_municipality_id]" >
                                    <option value="">Select City/Municipality</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Marriage Information Section -->
            <div class="form-section">
                <h3>Marriage Information</h3>
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="parents_married" checked>
                    <label for="parents_married">Parents are Married</label>
                </div>
                
                <div id="marriage_information_fields">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="marriage_date">Date of Marriage</label>
                            <input type="date" id="marriage_date" name="marriage[date]">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="marriage_place_country_id">Country</label>
                            <select id="marriage_place_country_id" name="marriage[place_country_id]">
                                <option value="">Select Country</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="marriage_place_province_id">Province</label>
                            <select id="marriage_place_province_id" name="marriage[place_province_id]">
                                <option value="">Select Province</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="marriage_place_city_municipality_id">City/Municipality</label>
                            <select id="marriage_place_city_municipality_id" name="marriage[place_city_municipality_id]">
                                <option value="">Select City/Municipality</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Birth Attendant Information Section -->
            <div class="form-section">
                <h3>Birth Attendant Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_attendant_attendant_type">Attendant Type <span class="required">*</span></label>
                        <select id="birth_attendant_attendant_type" name="birth_attendant[attendant_type]" >
                            <option value="">Select Type</option>
                            <option value="1">Physician</option>
                            <option value="2">Nurse</option>
                            <option value="3">Midwife</option>
                            <option value="4">Hilot</option>
                            <option value="5">Others</option>
                        </select>
                    </div>
                    <div class="form-group" id="other_attendant_type_field" style="display: none;">
                        <label for="birth_attendant_other_attendant_type">Other Attendant Type <span class="required">*</span></label>
                        <input type="text" id="birth_attendant_other_attendant_type" name="birth_attendant[other_attendant_type]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_attendant_name">Name <span class="required">*</span></label>
                        <input type="text" id="birth_attendant_name" name="birth_attendant[name]" >
                    </div>
                    <div class="form-group">
                        <label for="birth_attendant_title_or_position">Title/Position</label>
                        <input type="text" id="birth_attendant_title_or_position" name="birth_attendant[title_or_position]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_attendant_address">Address</label>
                        <textarea id="birth_attendant_address" name="birth_attendant[address]" rows="2"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_attendant_certification_date">Certification Date</label>
                        <input type="date" id="birth_attendant_certification_date" name="birth_attendant[certification_date]">
                    </div>
                    <div class="form-group">
                        <label for="birth_attendant_birth_time">Birth Time</label>
                        <input type="time" id="birth_attendant_birth_time" name="birth_attendant[birth_time]">
                    </div>
                </div>
            </div>
            
            <!-- Informant Information Section -->
            <div class="form-section">
                <h3>Informant Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="informant_name">Name <span class="required">*</span></label>
                        <input type="text" id="informant_name" name="informant[name]" >
                    </div>
                    <div class="form-group">
                        <label for="informant_relationship_to_child">Relationship to Child <span class="required">*</span></label>
                        <input type="text" id="informant_relationship_to_child" name="informant[relationship_to_child]" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="informant_address">Address</label>
                        <textarea id="informant_address" name="informant[address]" rows="2"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="informant_date">Date</label>
                        <input type="date" id="informant_date" name="informant[date]">
                    </div>
                </div>
            </div>
            
            <!-- Official Information Section -->
            <div class="form-section">
                <h3>Official Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="prepared_by_name">Prepared By</label>
                        <input type="text" id="prepared_by_name" name="prepared_by[name]">
                    </div>
                    <div class="form-group">
                        <label for="prepared_by_title_or_position">Title/Position</label>
                        <input type="text" id="prepared_by_title_or_position" name="prepared_by[title_or_position]">
                    </div>
                    <div class="form-group">
                        <label for="prepared_by_date">Date</label>
                        <input type="date" id="prepared_by_date" name="prepared_by[date]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="received_by_name">Received By</label>
                        <input type="text" id="received_by_name" name="received_by[name]">
                    </div>
                    <div class="form-group">
                        <label for="received_by_title_or_position">Title/Position</label>
                        <input type="text" id="received_by_title_or_position" name="received_by[title_or_position]">
                    </div>
                    <div class="form-group">
                        <label for="received_by_date">Date</label>
                        <input type="date" id="received_by_date" name="received_by[date]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="registered_by_name">Registered By</label>
                        <input type="text" id="registered_by_name" name="registered_by[name]">
                    </div>
                    <div class="form-group">
                        <label for="registered_by_title_or_position">Title/Position</label>
                        <input type="text" id="registered_by_title_or_position" name="registered_by[title_or_position]">
                    </div>
                    <div class="form-group">
                        <label for="registered_by_date">Date</label>
                        <input type="date" id="registered_by_date" name="registered_by[date]">
                    </div>
                </div>
            </div>
            
            <!-- Additional Information Section -->
            <div class="form-section">
                <h3>Additional Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="remarks">Remarks</label>
                        <textarea id="remarks" name="remarks" rows="3"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                <button type="submit" class="btn btn-primary">Save Birth Certificate</button>
            </div>
        </form>
    </div>
    
    <div class="tab-content" id="death-tab">
        <form id="deathCertificateForm" method="POST" action="{{ route('certificates.store') }}">
            @csrf
            <input type="hidden" name="certificate_type" value="death">
            <div class="form-section">
                <h3>Death Certificate Form</h3>
                <p>Death certificate implementation will be added here.</p>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/cert/addCert.js') }}"></script>
@endsection