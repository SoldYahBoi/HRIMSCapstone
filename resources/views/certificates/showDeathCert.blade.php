@extends('layout.mainLayout')

@section('title')
    Death Certificate - {{ $deathCertificate->registry_no }}
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/showDeathCert.css') }}">
@endsection

@section('page-title')
    Death Certificate Details
@endsection

@section('page-actions')
    <div class="page-actions">
        <a href="{{ route('certificates.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Certificate List
        </a>
        <button id="downloadPdf" class="btn btn-primary">
            <i class="fas fa-download" aria-hidden="true"></i> Download as PDF
        </button>
    </div>
@endsection

@section('content')
    <div class="certificate-container" id="certificate">
        <div class="certificate-header">
            <div class="form-number">
                Municipal Form No. 103<br>
                (Revised August 2016)
            </div>
            <div class="header-text">
                <p>Republic of the Philippines</p>
                <p>OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
                <h1>CERTIFICATE OF DEATH</h1>
            </div>
            <div class="instruction">
                (To be accomplished in quadruplicate using black ink)
            </div>
        </div>

        <div class="registry-info">
            <div class="registry-left">
                <div class="registry-field">
                    <label>Province</label>
                    <p>{{ $deathCertificate->province->name ?? '' }}</p>
                </div>
                <div class="registry-field">
                    <label>City/Municipality</label>
                    <p>{{ $deathCertificate->cityMunicipality->name ?? '' }}</p>
                </div>
            </div>
            <div class="registry-right">
                <div class="registry-field">
                    <label>Registry No.</label>
                    <p>{{ $deathCertificate->registry_no }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-content">
                <div class="field-row">
                    <div class="field" style="flex: 3;">
                        <label>1. NAME</label>
                        <div class="name-fields">
                            <div class="name-field">
                                <p>{{ $deathCertificate->deceased->first_name ?? '' }}</p>
                                <span>(First)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ $deathCertificate->deceased->middle_name ?? '' }}</p>
                                <span>(Middle)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ $deathCertificate->deceased->last_name ?? '' }}</p>
                                <span>(Last)</span>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>2. SEX</label>
                        <p>{{ $deathCertificate->deceased->sex ?? '' }}</p>
                        <span>(Male/Female)</span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>3. DATE OF DEATH</label>
                        <p>{{ $deathCertificate->deceased->date_of_death ? date('F d, Y', strtotime($deathCertificate->deceased->date_of_death)) : '' }}</p>
                        <span>(Day, Month, Year)</span>
                    </div>
                    <div class="field">
                        <label>4. DATE OF BIRTH</label>
                        <div class="date-fields">
                            <div class="date-field">
                                <p>{{ $deathCertificate->deceased->date_of_birth ? date('d', strtotime($deathCertificate->deceased->date_of_birth)) : '' }}</p>
                                <span>(Day)</span>
                            </div>
                            <div class="date-field">
                                <p>{{ $deathCertificate->deceased->date_of_birth ? date('F', strtotime($deathCertificate->deceased->date_of_birth)) : '' }}</p>
                                <span>(Month)</span>
                            </div>
                            <div class="date-field">
                                <p>{{ $deathCertificate->deceased->date_of_birth ? date('Y', strtotime($deathCertificate->deceased->date_of_birth)) : '' }}</p>
                                <span>(Year)</span>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>5. AGE AT THE TIME OF DEATH</label>
                        <div class="age-fields">
                            <div class="age-field">
                                <p>{{ $deathCertificate->deceased->age_years ?? '' }}</p>
                                <label>a. IF 1 YEAR OR ABOVE<br>Completed years</label>
                            </div>
                            <div class="age-field">
                                <p>{{ $deathCertificate->deceased->age_months ?? '' }}</p>
                                <label>b. IF UNDER 1 YEAR<br>Months</label>
                            </div>
                            <div class="age-field">
                                <p>{{ $deathCertificate->deceased->age_days ?? '' }}</p>
                                <label>Days</label>
                            </div>
                            <div class="age-field">
                                <p>{{ $deathCertificate->deceased->age_hours ?? '' }}</p>
                                <label>c. IF UNDER 24 HRS<br>Hours</label>
                            </div>
                            <div class="age-field">
                                <p>{{ $deathCertificate->deceased->age_minutes ?? '' }}</p>
                                <label>Min/Sec</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field" style="flex: 3;">
                        <label>6. PLACE OF DEATH</label>
                        <p>{{ $deathCertificate->deceased->place_of_death ?? '' }}</p>
                        <span>(Name of Hospital/Clinic/Institution/House No., St., Barangay, City/Municipality, Province)</span>
                    </div>
                    <div class="field">
                        <label>7. CIVIL STATUS</label>
                        <p>{{ $deathCertificate->deceased->civil_status ?? '' }}</p>
                        <span>(Single/Married/Widow/Widower/Annulled/Divorced)</span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>8. RELIGION/RELIGIOUS SECT</label>
                        <p>{{ $deathCertificate->deceased->religion ?? '' }}</p>
                    </div>
                    <div class="field">
                        <label>9. CITIZENSHIP</label>
                        <p>{{ $deathCertificate->deceased->citizenship ?? '' }}</p>
                    </div>
                    <div class="field" style="flex: 2;">
                        <label>10. RESIDENCE</label>
                        <p>{{ ($deathCertificate->deceased->residence_house_no ?? '') . ' ' . ($deathCertificate->deceased->residence_street ?? '') . ', ' . ($deathCertificate->deceased->residence_barangay ?? '') . ', ' . 
                            (isset($deathCertificate->deceased->residenceCity) ? $deathCertificate->deceased->residenceCity->name . ', ' : '') . 
                            (isset($deathCertificate->deceased->residenceProvince) ? $deathCertificate->deceased->residenceProvince->name . ', ' : '') . 
                            (isset($deathCertificate->deceased->residenceCountry) ? $deathCertificate->deceased->residenceCountry->name : '') }}</p>
                        <span>(House No., St., Barangay, City/Municipality, Province, Country)</span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>11. OCCUPATION</label>
                        <p>{{ $deathCertificate->deceased->occupation ?? '' }}</p>
                    </div>
                    <div class="field" style="flex: 2;">
                        <label>12. NAME OF FATHER</label>
                        <p>{{ $deathCertificate->deceased->father_name ?? '' }}</p>
                        <span>(First, Middle, Last)</span>
                    </div>
                    <div class="field" style="flex: 2;">
                        <label>13. MAIDEN NAME OF MOTHER</label>
                        <p>{{ $deathCertificate->deceased->mother_maiden_name ?? '' }}</p>
                        <span>(First, Middle, Last)</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="medical-certificate-header">
                MEDICAL CERTIFICATE
            </div>
            <div class="medical-certificate-subheader">
                (For ages 0 to 7 days, accomplish items 14-19a at the back)
            </div>
            <div class="section-content">
                <div class="field-row">
                    <div class="field" style="flex: 3;">
                        <label>19b. CAUSES OF DEATH (If the deceased is aged 8 days and over)</label>
                        <div class="cause-row">
                            <div class="cause-label">I. Immediate cause</div>
                            <div class="cause-value">{{ $deathCertificate->deathCause->immediate_cause ?? '' }}</div>
                        </div>
                        <div class="cause-row">
                            <div class="cause-label">Antecedent cause</div>
                            <div class="cause-value">{{ $deathCertificate->deathCause->antecedent_cause ?? '' }}</div>
                        </div>
                        <div class="cause-row">
                            <div class="cause-label">Underlying cause</div>
                            <div class="cause-value">{{ $deathCertificate->deathCause->underlying_cause ?? '' }}</div>
                        </div>
                        <div class="cause-row">
                            <div class="cause-label">II. Other significant conditions contributing to death:</div>
                            <div class="cause-value">{{ $deathCertificate->deathCause->other_significant_conditions ?? '' }}</div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="interval-label">Interval Between Onset and Death</label>
                        <p>{{ $deathCertificate->deathCause->interval_between_onset_and_death ?? '' }}</p>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>19c. MATERNAL CONDITION (If the deceased is female aged 15-49 years old)</label>
                        <div class="maternal-options">
                            <div class="maternal-option {{ $deathCertificate->deathCause->maternal_condition == 'pregnant, not in labour' ? 'selected' : '' }}">
                                a. pregnant, not in labour
                            </div>
                            <div class="maternal-option {{ $deathCertificate->deathCause->maternal_condition == 'pregnant, in labour' ? 'selected' : '' }}">
                                b. pregnant, in labour
                            </div>
                            <div class="maternal-option {{ $deathCertificate->deathCause->maternal_condition == 'less than 42 days after delivery' ? 'selected' : '' }}">
                                c. less than 42 days after delivery
                            </div>
                            <div class="maternal-option {{ $deathCertificate->deathCause->maternal_condition == '42 days to 1 year after delivery' ? 'selected' : '' }}">
                                d. 42 days to 1 year after delivery
                            </div>
                            <div class="maternal-option {{ $deathCertificate->deathCause->maternal_condition == 'None of the choices' ? 'selected' : '' }}">
                                e. None of the choices
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field" style="flex: 3;">
                        <label>19d. DEATH BY EXTERNAL CAUSES</label>
                        <div class="external-causes-row">
                            <label>a. Manner of death (Homicide, Suicide, Accident, Legal intervention, etc.)</label>
                            <p>{{ $deathCertificate->deathCause->manner_of_death ?? '' }}</p>
                        </div>
                        <div class="external-causes-row">
                            <label>b. Place of Occurrence of External Cause (e.g. home, farm, factory, street, sea, etc.)</label>
                            <p>{{ $deathCertificate->deathCause->external_cause_place ?? '' }}</p>
                        </div>
                    </div>
                    <div class="field">
                        <label>20. AUTOPSY</label>
                        <p>{{ $deathCertificate->deathCause->autopsy_performed ? 'Yes' : 'No' }}</p>
                        <span>(Yes / No)</span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field" style="flex: 3;">
                        <label>21a. ATTENDANT</label>
                        <div class="attendant-options">
                            <div class="attendant-option {{ $deathCertificate->deathAttendant->attendant_type == 1 ? 'selected' : '' }}">
                                <span>1</span> Private Physician
                            </div>
                            <div class="attendant-option {{ $deathCertificate->deathAttendant->attendant_type == 2 ? 'selected' : '' }}">
                                <span>2</span> Public Health Officer
                            </div>
                            <div class="attendant-option {{ $deathCertificate->deathAttendant->attendant_type == 3 ? 'selected' : '' }}">
                                <span>3</span> Hospital Authority
                            </div>
                            <div class="attendant-option {{ $deathCertificate->deathAttendant->attendant_type == 4 ? 'selected' : '' }}">
                                <span>4</span> None
                            </div>
                            <div class="attendant-option {{ $deathCertificate->deathAttendant->attendant_type == 5 ? 'selected' : '' }}">
                                <span>5</span> Others (Specify): {{ $deathCertificate->deathAttendant->other_attendant_type ?? '' }}
                              {{ $deathCertificate->deathAttendant->other_attendant_type ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>21b. If attended, state duration (mm/dd/yy)</label>
                        <div class="field-row">
                            <div class="field">
                                <label>From</label>
                                <p>{{ $deathCertificate->deathAttendant->attended_from ? date('m/d/Y', strtotime($deathCertificate->deathAttendant->attended_from)) : '' }}</p>
                            </div>
                            <div class="field">
                                <label>To</label>
                                <p>{{ $deathCertificate->deathAttendant->attended_to ? date('m/d/Y', strtotime($deathCertificate->deathAttendant->attended_to)) : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>22. CERTIFICATION OF DEATH</label>
                        <p class="certification-text">
                            I hereby certify that the foregoing particulars are correct as near as same can be ascertained and I further certify that I 
                            <span style="{{ $deathCertificate->deathAttendant->attended_deceased ? 'text-decoration: underline;' : '' }}">have attended</span> / 
                            <span style="{{ !$deathCertificate->deathAttendant->attended_deceased ? 'text-decoration: underline;' : '' }}">have not attended</span> 
                            the deceased and that death occurred at 
                            {{ $deathCertificate->deathAttendant->death_time ?? '____' }} am/pm on the date of death specified above.
                        </p>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line"></p>
                                <span>Signature</span>
                            </div>
                        </div>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line">{{ $deathCertificate->deathAttendant->name ?? '' }}</p>
                                <span>Name in Print</span>
                            </div>
                        </div>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line">{{ $deathCertificate->deathAttendant->title_or_position ?? '' }}</p>
                                <span>Title or Position</span>
                            </div>
                        </div>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line">{{ $deathCertificate->deathAttendant->address ?? '' }}</p>
                                <span>Address</span>
                            </div>
                        </div>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line">{{ $deathCertificate->deathAttendant->certification_date ? date('m/d/Y', strtotime($deathCertificate->deathAttendant->certification_date)) : '' }}</p>
                                <span>Date</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <div style="text-align: right; padding: 10px; border: 1px solid #ddd; margin-bottom: 10px;">
                            <label>REVIEWED BY:</label>
                            <div class="signature-block" style="justify-content: flex-end;">
                                <div class="signature-field" style="flex: 0 0 60%;">
                                    <p class="signature-line"></p>
                                    <span>Signature Over Printed Name of Health Officer</span>
                                </div>
                            </div>
                            <div class="signature-block" style="justify-content: flex-end;">
                                <div class="signature-field" style="flex: 0 0 60%;">
                                    <p class="signature-line">{{ isset($deathCertificate->reviewedBy) ? $deathCertificate->reviewedBy->date ? date('m/d/Y', strtotime($deathCertificate->reviewedBy->date)) : '' : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-content">
                <div class="field-row">
                    <div class="field">
                        <label>23. CORPSE DISPOSAL</label>
                        <div class="disposal-options">
                            <div class="disposal-option {{ $deathCertificate->corpseDisposal->disposal_type == 'Burial' ? 'selected' : '' }}">
                                Burial
                            </div>
                            <div class="disposal-option {{ $deathCertificate->corpseDisposal->disposal_type == 'Cremation' ? 'selected' : '' }}">
                                Cremation
                            </div>
                            <div class="disposal-option {{ $deathCertificate->corpseDisposal->disposal_type != 'Burial' && $deathCertificate->corpseDisposal->disposal_type != 'Cremation' ? 'selected' : '' }}">
                                Others, specify: {{ $deathCertificate->corpseDisposal->other_disposal_type ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>24a. BURIAL/CREMATION PERMIT</label>
                        <div class="permit-section">
                            <label>Number</label>
                            <p>{{ $deathCertificate->corpseDisposal->burial_cremation_permit_number ?? '' }}</p>
                            <label>Date Issued</label>
                            <p>{{ $deathCertificate->corpseDisposal->burial_cremation_permit_date ? date('m/d/Y', strtotime($deathCertificate->corpseDisposal->burial_cremation_permit_date)) : '' }}</p>
                        </div>
                    </div>
                    <div class="field">
                        <label>24b. TRANSFER PERMIT</label>
                        <div class="permit-section">
                            <label>Number</label>
                            <p>{{ $deathCertificate->corpseDisposal->transfer_permit_number ?? '' }}</p>
                            <label>Date Issued</label>
                            <p>{{ $deathCertificate->corpseDisposal->transfer_permit_date ? date('m/d/Y', strtotime($deathCertificate->corpseDisposal->transfer_permit_date)) : '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>25. NAME AND ADDRESS OF CEMETERY OR CREMATORY</label>
                        <p>{{ $deathCertificate->corpseDisposal->cemetery_name ?? '' }}</p>
                        <p>{{ $deathCertificate->corpseDisposal->cemetery_address ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-content two-column">
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>26. CERTIFICATION OF INFORMANT</label>
                            <p class="certification-text">I hereby certify that all information supplied are true and correct to my own knowledge and belief.</p>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ $deathCertificate->deathInformant->name ?? '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ $deathCertificate->deathInformant->relationship_to_deceased ?? '' }}</p>
                                    <span>Relationship to the Deceased</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ $deathCertificate->deathInformant->address ?? '' }}</p>
                                    <span>Address</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ $deathCertificate->deathInformant->date ? date('m/d/Y', strtotime($deathCertificate->deathInformant->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>27. PREPARED BY</label>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->preparedBy) ? $deathCertificate->preparedBy->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->preparedBy) ? $deathCertificate->preparedBy->title_or_position : '' }}</p>
                                    <span>Title or Position</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->preparedBy) && $deathCertificate->preparedBy->date ? date('m/d/Y', strtotime($deathCertificate->preparedBy->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-content two-column">
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>28. RECEIVED BY</label>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->receivedBy) ? $deathCertificate->receivedBy->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->receivedBy) ? $deathCertificate->receivedBy->title_or_position : '' }}</p>
                                    <span>Title or Position</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->receivedBy) && $deathCertificate->receivedBy->date ? date('m/d/Y', strtotime($deathCertificate->receivedBy->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>29. REGISTERED AT THE OFFICE OF THE CIVIL REGISTRAR</label>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->registeredBy) ? $deathCertificate->registeredBy->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->registeredBy) ? $deathCertificate->registeredBy->title_or_position : '' }}</p>
                                    <span>Title or Position</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($deathCertificate->registeredBy) && $deathCertificate->registeredBy->date ? date('m/d/Y', strtotime($deathCertificate->registeredBy->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section remarks-section">
            <div class="section-content">
                <div class="field-row">
                    <div class="field full-width">
                        <label>REMARKS/ANNOTATIONS (For LCRO/OCRG Use Only)</label>
                        <p class="remarks-text">{{ $deathCertificate->remarks ?? '' }}</p>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <div class="contact-info">
                            <label>Contact No:</label>
                            <p>{{ $deathCertificate->contact_no ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="certificate-footer">
            <p>TO BE FILLED-UP AT THE OFFICE OF THE CIVIL REGISTRAR</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/cert/showDeathCert.js') }}"></script>
@endsection
