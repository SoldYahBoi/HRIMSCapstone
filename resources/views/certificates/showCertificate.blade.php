@extends('layout.mainLayout')

@section('title')
    Birth Certificate - {{ $birthCertificate->registry_no }}
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/cert/showCert.css') }}">
@endsection

@section('page-title')
    Birth Certificate Details
@endsection

@section('page-actions')
    <div class="page-actions">
        <a href="{{ route('certificates.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Certificate List
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="success-popup">
            {{ session('success') }}
        </div>
    @endif
    <div class="page-actions">
        <button id="downloadPdf" class="btn btn-primary">
                <i class="fas fa-download" aria-hidden="true"></i> Download as PDF
        </button>
    </div>
    <div class="certificate-container" id="certificate">
        <div class="certificate-header">
            <div class="header-text">
                <p>Republic of the Philippines</p>
                <p>OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
                <h1>CERTIFICATE OF LIVE BIRTH</h1>
            </div>
        </div>

        <div class="registry-info">
            <div class="registry-left">
                <div class="registry-field">
                    <label>Province</label>
                    <p>{{ $birthCertificate->province->name ?? '' }}</p>
                </div>
                <div class="registry-field">
                    <label>City/Municipality</label>
                    <p>{{ $birthCertificate->cityMunicipality->name ?? '' }}</p>
                </div>
            </div>
            <div class="registry-right">
                <div class="registry-field">
                    <label>Registry No.</label>
                    <p>{{ $birthCertificate->registry_no }}</p>
                </div>
            </div>
        </div>

        <div class="section child-section">
            <div class="section-label">
                <span>C</span>
                <span>H</span>
                <span>I</span>
                <span>L</span>
                <span>D</span>
            </div>
            <div class="section-content">
                <div class="field-row">
                    <div class="field full-width">
                        <label>1. NAME</label>
                        <div class="name-fields">
                            <div class="name-field">
                                <p>{{ $birthCertificate->child->first_name ?? '' }}</p>
                                <span>(First)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ $birthCertificate->child->middle_name ?? '' }}</p>
                                <span>(Middle)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ $birthCertificate->child->last_name ?? '' }}</p>
                                <span>(Last)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>2. SEX</label>
                        <p>{{ $birthCertificate->child->sex ?? '' }}</p>
                    </div>
                    <div class="field">
                        <label>3. DATE OF BIRTH</label>
                        <div class="date-fields">
                            <div class="date-field">
                                <p>{{ $birthCertificate->child->date_of_birth ? date('d', strtotime($birthCertificate->child->date_of_birth)) : '' }}</p>
                                <span>(Day)</span>
                            </div>
                            <div class="date-field">
                                <p>{{ $birthCertificate->child->date_of_birth ? date('F', strtotime($birthCertificate->child->date_of_birth)) : '' }}</p>
                                <span>(Month)</span>
                            </div>
                            <div class="date-field">
                                <p>{{ $birthCertificate->child->date_of_birth ? date('Y', strtotime($birthCertificate->child->date_of_birth)) : '' }}</p>
                                <span>(Year)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>4. PLACE OF BIRTH</label>
                        <div class="place-fields">
                            <div class="place-field">
                                <p>{{ $birthCertificate->child->place_of_birth_hospital ?? '' }}</p>
                                <span>(Name of Hospital/Clinic/Institution/House No., St., Barangay)</span>
                            </div>
                            <div class="place-field">
                                <p>{{ isset($birthCertificate->child->placeOfBirthCity) ? $birthCertificate->child->placeOfBirthCity->name : '' }}</p>
                                <span>(City/Municipality)</span>
                            </div>
                            <div class="place-field">
                                <p>{{ isset($birthCertificate->child->placeOfBirthProvince) ? $birthCertificate->child->placeOfBirthProvince->name : '' }}</p>
                                <span>(Province)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>5a. TYPE OF BIRTH</label>
                        <p>{{ $birthCertificate->child->type_of_birth ?? '' }}</p>
                        <span>(Single, Twin, Triplet, etc.)</span>
                    </div>
                    <div class="field">
                        <label>5b. IF MULTIPLE BIRTH, CHILD WAS</label>
                        <p>{{ $birthCertificate->child->multiple_birth_type ?? '' }}</p>
                        <span>(First, Second, Third, etc.)</span>
                    </div>
                    <div class="field">
                        <label>5c. BIRTH ORDER</label>
                        <p>{{ $birthCertificate->child->multiple_birth_type ?? '' }}</p>
                        <span>(First, Second, Third, etc.)</span>
                    </div>
                    <div class="field">
                        <label>6. WEIGHT AT BIRTH</label>
                        <p>{{ $birthCertificate->child->weight_at_birth ?? '' }} grams</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section mother-section">
            <div class="section-label">
                <span>M</span>
                <span>O</span>
                <span>T</span>
                <span>H</span>
                <span>E</span>
                <span>R</span>
            </div>
            <div class="section-content">
                <div class="field-row">
                    <div class="field full-width">
                        <label>7. MAIDEN NAME</label>
                        <div class="name-fields">
                            <div class="name-field">
                                <p>{{ $birthCertificate->mother->first_name ?? '' }}</p>
                                <span>(First)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ $birthCertificate->mother->middle_name ?? '' }}</p>
                                <span>(Middle)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ $birthCertificate->mother->maiden_name ?? '' }}</p>
                                <span>(Last)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>8. CITIZENSHIP</label>
                        <p>{{ $birthCertificate->mother->citizenship ?? '' }}</p>
                    </div>
                    <div class="field">
                        <label>9. RELIGION/RELIGIOUS SECT</label>
                        <p>{{ $birthCertificate->mother->religion ?? '' }}</p>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>10a. Total number of children born alive</label>
                        <p>{{ $birthCertificate->mother->total_children_born_alive ?? '' }}</p>
                    </div>
                    <div class="field">
                        <label>10b. No. of children still living including this birth</label>
                        <p>{{ $birthCertificate->mother->children_still_living ?? '' }}</p>
                    </div>
                    <div class="field">
                        <label>10c. No. of children born alive but are now dead</label>
                        <p>{{ $birthCertificate->mother->children_born_alive_now_dead ?? '' }}</p>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>11. OCCUPATION</label>
                        <p>{{ $birthCertificate->mother->occupation ?? '' }}</p>
                    </div>
                    <div class="field">
                        <label>12. AGE at the time of this birth</label>
                        <p>{{ $birthCertificate->mother->age_at_birth ?? '' }}</p>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>13. RESIDENCE</label>
                        <div class="residence-fields">
                            <div class="residence-field">
                                <p>{{ ($birthCertificate->mother->residence_house_no ?? '') . ' ' . ($birthCertificate->mother->residence_street ?? '') . ', ' . ($birthCertificate->mother->residence_barangay ?? '') }}</p>
                                <span>(House No., St., Barangay)</span>
                            </div>
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->mother->residenceCity) ? $birthCertificate->mother->residenceCity->name : '' }}</p>
                                <span>(City/Municipality)</span>
                            </div>
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->mother->residenceProvince) ? $birthCertificate->mother->residenceProvince->name : '' }}</p>
                                <span>(Province)</span>
                            </div>
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->mother->residenceCountry) ? $birthCertificate->mother->residenceCountry->name : '' }}</p>
                                <span>(Country)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section father-section">
            <div class="section-label">
                <span>F</span>
                <span>A</span>
                <span>T</span>
                <span>H</span>
                <span>E</span>
                <span>R</span>
            </div>
            <div class="section-content">
                <div class="field-row">
                    <div class="field full-width">
                        <label>14. NAME</label>
                        <div class="name-fields">
                            <div class="name-field">
                                <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->first_name : '' }}</p>
                                <span>(First)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->middle_name : '' }}</p>
                                <span>(Middle)</span>
                            </div>
                            <div class="name-field">
                                <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->last_name : '' }}</p>
                                <span>(Last)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>15. CITIZENSHIP</label>
                        <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->citizenship : '' }}</p>
                    </div>
                    <div class="field">
                        <label>16. RELIGION/RELIGIOUS SECT</label>
                        <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->religion : '' }}</p>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>17. OCCUPATION</label>
                        <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->occupation : '' }}</p>
                    </div>
                    <div class="field">
                        <label>18. AGE at the time of this birth</label>
                        <p>{{ isset($birthCertificate->father) ? $birthCertificate->father->age_at_birth : '' }}</p>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>19. RESIDENCE</label>
                        <div class="residence-fields">
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->father) ? ($birthCertificate->father->residence_house_no ?? '') . ' ' . ($birthCertificate->father->residence_street ?? '') . ', ' . ($birthCertificate->father->residence_barangay ?? '') : '' }}</p>
                                <span>(House No., St., Barangay)</span>
                            </div>
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->father) && isset($birthCertificate->father->residenceCity) ? $birthCertificate->father->residenceCity->name : '' }}</p>
                                <span>(City/Municipality)</span>
                            </div>
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->father) && isset($birthCertificate->father->residenceProvince) ? $birthCertificate->father->residenceProvince->name : '' }}</p>
                                <span>(Province)</span>
                            </div>
                            <div class="residence-field">
                                <p>{{ isset($birthCertificate->father) && isset($birthCertificate->father->residenceCountry) ? $birthCertificate->father->residenceCountry->name : '' }}</p>
                                <span>(Country)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section marriage-section">
            <div class="section-content">
                <div class="field-row">
                    <div class="field full-width">
                        <label>MARRIAGE OF PARENTS (If not married, accomplish Affidavit of Acknowledgement/Admission of Paternity at the back.)</label>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label>20a. DATE</label>
                        <div class="date-fields">
                            <div class="date-field">
                                <p>{{ isset($birthCertificate->marriage) && $birthCertificate->marriage->date ? date('F', strtotime($birthCertificate->marriage->date)) : '' }}</p>
                                <span>(Month)</span>
                            </div>
                            <div class="date-field">
                                <p>{{ isset($birthCertificate->marriage) && $birthCertificate->marriage->date ? date('d', strtotime($birthCertificate->marriage->date)) : '' }}</p>
                                <span>(Day)</span>
                            </div>
                            <div class="date-field">
                                <p>{{ isset($birthCertificate->marriage) && $birthCertificate->marriage->date ? date('Y', strtotime($birthCertificate->marriage->date)) : '' }}</p>
                                <span>(Year)</span>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>20b. PLACE</label>
                        <div class="place-fields">
                            <div class="place-field">
                                <p>{{ isset($birthCertificate->marriage) && isset($birthCertificate->marriage->placeCity) ? $birthCertificate->marriage->placeCity->name : '' }}</p>
                                <span>(City/Municipality)</span>
                            </div>
                            <div class="place-field">
                                <p>{{ isset($birthCertificate->marriage) && isset($birthCertificate->marriage->placeProvince) ? $birthCertificate->marriage->placeProvince->name : '' }}</p>
                                <span>(Province)</span>
                            </div>
                            <div class="place-field">
                                <p>{{ isset($birthCertificate->marriage) && isset($birthCertificate->marriage->placeCountry) ? $birthCertificate->marriage->placeCountry->name : '' }}</p>
                                <span>(Country)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section attendant-section">
            <div class="section-content">
                <div class="field-row">
                    <div class="field full-width">
                        <label>21a. ATTENDANT</label>
                        <div class="attendant-options">
                            <div class="attendant-option {{ isset($birthCertificate->birthAttendant) && $birthCertificate->birthAttendant->attendant_type == 1 ? 'selected' : '' }}">
                                <span>1</span> Physician
                            </div>
                            <div class="attendant-option {{ isset($birthCertificate->birthAttendant) && $birthCertificate->birthAttendant->attendant_type == 2 ? 'selected' : '' }}">
                                <span>2</span> Nurse
                            </div>
                            <div class="attendant-option {{ isset($birthCertificate->birthAttendant) && $birthCertificate->birthAttendant->attendant_type == 3 ? 'selected' : '' }}">
                                <span>3</span> Midwife
                            </div>
                            <div class="attendant-option {{ isset($birthCertificate->birthAttendant) && $birthCertificate->birthAttendant->attendant_type == 4 ? 'selected' : '' }}">
                                <span>4</span> Hilot (Traditional Birth Attendant)
                            </div>
                            <div class="attendant-option {{ isset($birthCertificate->birthAttendant) && $birthCertificate->birthAttendant->attendant_type == 5 ? 'selected' : '' }}">
                                <span>5</span> Others (Specify): {{ isset($birthCertificate->birthAttendant) ? $birthCertificate->birthAttendant->other_attendant_type : '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <label>21b. CERTIFICATION OF ATTENDANT AT BIRTH</label>
                        <p class="certification-text">I hereby certify that I attended the birth of the child who was born alive at 
                            <span class="blank-line">{{ isset($birthCertificate->birthAttendant) ? $birthCertificate->birthAttendant->birth_time : '' }}</span> am/pm 
                            on the date of birth specified above.
                        </p>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line"></p>
                                <span>Signature</span>
                            </div>
                            <div class="signature-field">
                                <p class="signature-line">{{ isset($birthCertificate->birthAttendant) ? $birthCertificate->birthAttendant->address : '' }}</p>
                                <span>Address</span>
                            </div>
                        </div>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line">{{ isset($birthCertificate->birthAttendant) ? $birthCertificate->birthAttendant->name : '' }}</p>
                                <span>Name in Print</span>
                            </div>
                            <div class="signature-field">
                                <p class="signature-line">{{ isset($birthCertificate->birthAttendant) && $birthCertificate->birthAttendant->certification_date ? date('m/d/Y', strtotime($birthCertificate->birthAttendant->certification_date)) : '' }}</p>
                                <span>Date</span>
                            </div>
                        </div>
                        <div class="signature-block">
                            <div class="signature-field">
                                <p class="signature-line">{{ isset($birthCertificate->birthAttendant) ? $birthCertificate->birthAttendant->title_or_position : '' }}</p>
                                <span>Title or Position</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section certification-section">
            <div class="section-content two-column">
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>22. CERTIFICATION OF INFORMANT</label>
                            <p class="certification-text">I hereby certify that all information supplied are true and correct to my own knowledge and belief.</p>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->informant) ? $birthCertificate->informant->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->informant) ? $birthCertificate->informant->relationship_to_child : '' }}</p>
                                    <span>Relationship to the Child</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->informant) ? $birthCertificate->informant->address : '' }}</p>
                                    <span>Address</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->informant) && $birthCertificate->informant->date ? date('m/d/Y', strtotime($birthCertificate->informant->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>23. PREPARED BY</label>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->preparedBy) ? $birthCertificate->preparedBy->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->preparedBy) ? $birthCertificate->preparedBy->title_or_position : '' }}</p>
                                    <span>Title or Position</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->preparedBy) && $birthCertificate->preparedBy->date ? date('m/d/Y', strtotime($birthCertificate->preparedBy->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section certification-section">
            <div class="section-content two-column">
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>24. RECEIVED BY</label>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->receivedBy) ? $birthCertificate->receivedBy->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->receivedBy) ? $birthCertificate->receivedBy->title_or_position : '' }}</p>
                                    <span>Title or Position</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->receivedBy) && $birthCertificate->receivedBy->date ? date('m/d/Y', strtotime($birthCertificate->receivedBy->date)) : '' }}</p>
                                    <span>Date</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field-row">
                        <div class="field full-width">
                            <label>25. REGISTERED AT THE OFFICE OF THE CIVIL REGISTRAR</label>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line"></p>
                                    <span>Signature</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->registeredBy) ? $birthCertificate->registeredBy->name : '' }}</p>
                                    <span>Name in Print</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->registeredBy) ? $birthCertificate->registeredBy->title_or_position : '' }}</p>
                                    <span>Title or Position</span>
                                </div>
                            </div>
                            <div class="signature-block">
                                <div class="signature-field">
                                    <p class="signature-line">{{ isset($birthCertificate->registeredBy) && $birthCertificate->registeredBy->date ? date('m/d/Y', strtotime($birthCertificate->registeredBy->date)) : '' }}</p>
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
                        <p class="remarks-text">{{ $birthCertificate->remarks ?? '' }}</p>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <div class="contact-info">
                            <label>Contact No:</label>
                            <p>{{ $birthCertificate->contact_no ?? '' }}</p>
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
    <script src="{{ asset('js/cert/showCert.js') }}"></script>
@endsection
