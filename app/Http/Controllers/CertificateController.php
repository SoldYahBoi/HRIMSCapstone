<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\BirthCertificate;
use App\Models\Mother;
use App\Models\Father;
use App\Models\Informant;
use App\Models\Marriage;
use App\Models\BirthAttendant;
use App\Models\CityMunicipality;
use App\Models\Province;
use App\Models\Country;
use App\Models\Official;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Deceased;
use App\Models\DeathCause;
use App\Models\DeathAttendant;
use App\Models\DeathInformant;
use App\Models\CorpseDisposal;
use App\Models\DeathCertificate;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $birthCertificates = BirthCertificate::where('status','Active')->paginate(5);
        $count = BirthCertificate::where('status','Active')->count();
        $child = Child::all();
        $mother = Mother::all();
        $father = Father::all();
        $marriage = Marriage::all();
        $birthAttendant = BirthAttendant::all();
        $informant = Informant::all();
        $official = Official::all();
        $cityMunicipality = CityMunicipality::all();
        
        // Death certificate data
        $deathCertificates = DeathCertificate::where('status', 'Active')->paginate(5);
        $deathCount = DeathCertificate::where('status', 'Active')->count();
        $deceased = Deceased::all();
        $deathCause = DeathCause::all();
        $deathAttendant = DeathAttendant::all();
        $deathInformant = DeathInformant::all();
        $corpseDisposal = CorpseDisposal::all();
        
        return view('certificates.manageCertificates')
            ->with('birthCertificates', $birthCertificates)
            ->with('child', $child)
            ->with('mother', $mother)
            ->with('father', $father)
            ->with('marriage', $marriage)
            ->with('birthAttendant', $birthAttendant)
            ->with('informant', $informant)
            ->with('official', $official)
            ->with('cityMunicipality', $cityMunicipality)
            ->with('count', $count)
            ->with('deathCertificates', $deathCertificates)
            ->with('deathCount', $deathCount)
            ->with('deceased', $deceased)
            ->with('deathCause', $deathCause)
            ->with('deathAttendant', $deathAttendant)
            ->with('deathInformant', $deathInformant)
            ->with('corpseDisposal', $corpseDisposal);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $countries = Country::all();
        $provinces = Province::where('country_id', 1)->get(); // Default to Philippines
        $cities = CityMunicipality::where('province_id', 1)->get(); // Default to first province
        
        return view('certificates.addCert', compact('countries', 'provinces', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check certificate type
        if ($request->certificate_type === 'birth') {
            return $this->storeBirthCertificate($request);
        } else if ($request->certificate_type === 'death') {
            return $this->storeDeathCertificate($request);
    }
    
    return redirect()->back()->with('error', 'Invalid certificate type.');
}
    
    /**
     * Store a birth certificate and related records
     */
    private function storeBirthCertificate(Request $request)
    {
        // Validate main certificate data
        $validator = Validator::make($request->all(), [
            'registry_no' => 'required|string|unique:birth_certificates,registry_no',
            'province_id' => 'required|exists:provinces,id',
            'city_municipality_id' => 'required|exists:cities_municipalities,id',
            'contact_no' => 'nullable|string|max:20',
            'remarks' => 'nullable|string',
            
            // Child validation
            'child.first_name' => 'required|string|max:255',
            'child.middle_name' => 'nullable|string|max:255',
            'child.last_name' => 'required|string|max:255',
            'child.sex' => 'required|in:Male,Female,Other',
            'child.date_of_birth' => 'required|date',
            'child.place_of_birth_hospital' => 'nullable|string|max:255',
            'child.place_of_birth_city_municipality_id' => 'required|exists:cities_municipalities,id',
            'child.place_of_birth_province_id' => 'required|exists:provinces,id',
            'child.type_of_birth' => 'required|string|max:255',
            'child.is_multiple_birth' => 'nullable|boolean',
            'child.multiple_birth_type' => 'nullable|string|max:255',
            'child.weight_at_birth' => 'nullable|numeric',
            
            // Mother validation
            'mother.first_name' => 'required|string|max:255',
            'mother.middle_name' => 'nullable|string|max:255',
            'mother.last_name' => 'required|string|max:255',
            'mother.maiden_name' => 'required|string|max:255',
            'mother.citizenship' => 'required|string|max:255',
            'mother.religion' => 'nullable|string|max:255',
            'mother.occupation' => 'nullable|string|max:255',
            'mother.age_at_birth' => 'nullable|integer|min:12|max:100',
            'mother.residence_house_no' => 'nullable|string|max:255',
            'mother.residence_street' => 'nullable|string|max:255',
            'mother.residence_barangay' => 'nullable|string|max:255',
            'mother.residence_city_municipality_id' => 'required|exists:cities_municipalities,id',
            'mother.residence_province_id' => 'required|exists:provinces,id',
            'mother.residence_country_id' => 'required|exists:countries,id',
            'mother.total_children_born_alive' => 'nullable|integer|min:0',
            'mother.children_still_living' => 'nullable|integer|min:0',
            'mother.children_born_alive_now_dead' => 'nullable|integer|min:0',
            
            // Father validation (conditional)
            'father.first_name' => 'required_if:include_father,on|string|max:255',
            'father.middle_name' => 'nullable|string|max:255',
            'father.last_name' => 'required_if:include_father,on|string|max:255',
            'father.citizenship' => 'required_if:include_father,on|string|max:255',
            'father.religion' => 'nullable|string|max:255',
            'father.occupation' => 'nullable|string|max:255',
            'father.age_at_birth' => 'nullable|integer|min:12|max:100',
            'father.residence_house_no' => 'nullable|string|max:255',
            'father.residence_street' => 'nullable|string|max:255',
            'father.residence_barangay' => 'nullable|string|max:255',
            'father.residence_city_municipality_id' => 'required_if:include_father,on|exists:cities_municipalities,id',
            'father.residence_province_id' => 'required_if:include_father,on|exists:provinces,id',
            'father.residence_country_id' => 'required_if:include_father,on|exists:countries,id',
            
            // Marriage validation (conditional)
            'marriage.date' => 'nullable|date',
            'marriage.place_city_municipality_id' => 'nullable|exists:cities_municipalities,id',
            'marriage.place_province_id' => 'nullable|exists:provinces,id',
            'marriage.place_country_id' => 'nullable|exists:countries,id',
            
            // Birth Attendant validation
            'birth_attendant.attendant_type' => 'required|integer|min:1|max:5',
            'birth_attendant.other_attendant_type' => 'required_if:birth_attendant.attendant_type,5|nullable|string|max:255',
            'birth_attendant.name' => 'required|string|max:255',
            'birth_attendant.title_or_position' => 'nullable|string|max:255',
            'birth_attendant.address' => 'nullable|string',
            'birth_attendant.certification_date' => 'nullable|date',
            'birth_attendant.birth_time' => 'nullable|string',
            
            // Informant validation
            'informant.name' => 'required|string|max:255',
            'informant.relationship_to_child' => 'required|string|max:255',
            'informant.address' => 'nullable|string',
            'informant.date' => 'nullable|date',
            
            // Officials validation
            'prepared_by.name' => 'nullable|string|max:255',
            'prepared_by.title_or_position' => 'nullable|string|max:255',
            'prepared_by.date' => 'nullable|date',
            
            'received_by.name' => 'nullable|string|max:255',
            'received_by.title_or_position' => 'nullable|string|max:255',
            'received_by.date' => 'nullable|date',
            
            'registered_by.name' => 'nullable|string|max:255',
            'registered_by.title_or_position' => 'nullable|string|max:255',
            'registered_by.date' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return redirect('/certificates/create')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'There were errors in your submission. Please check the form and try again.');
        }
        
        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        
        try {
            // Create Child record
            $child = new Child();
            $child->first_name = $request->input('child.first_name');
            $child->middle_name = $request->input('child.middle_name');
            $child->last_name = $request->input('child.last_name');
            $child->sex = $request->input('child.sex');
            $child->date_of_birth = $request->input('child.date_of_birth');
            $child->place_of_birth_hospital = $request->input('child.place_of_birth_hospital');
            $child->place_of_birth_city_municipality_id = $request->input('child.place_of_birth_city_municipality_id');
            $child->place_of_birth_province_id = $request->input('child.place_of_birth_province_id');
            $child->type_of_birth = $request->input('child.type_of_birth');
            $child->is_multiple_birth = $request->input('child.is_multiple_birth', 0);
            $child->multiple_birth_type = $request->input('child.multiple_birth_type');
            $child->weight_at_birth = $request->input('child.weight_at_birth');
            $child->save();
            
            // Create Mother record
            $mother = new Mother();
            $mother->first_name = $request->input('mother.first_name');
            $mother->middle_name = $request->input('mother.middle_name');
            $mother->last_name = $request->input('mother.last_name');
            $mother->maiden_name = $request->input('mother.maiden_name');
            $mother->citizenship = $request->input('mother.citizenship');
            $mother->religion = $request->input('mother.religion');
            $mother->occupation = $request->input('mother.occupation');
            $mother->age_at_birth = $request->input('mother.age_at_birth');
            $mother->residence_house_no = $request->input('mother.residence_house_no');
            $mother->residence_street = $request->input('mother.residence_street');
            $mother->residence_barangay = $request->input('mother.residence_barangay');
            $mother->residence_city_municipality_id = $request->input('mother.residence_city_municipality_id');
            $mother->residence_province_id = $request->input('mother.residence_province_id');
            $mother->residence_country_id = $request->input('mother.residence_country_id');
            $mother->total_children_born_alive = $request->input('mother.total_children_born_alive', 0);
            $mother->children_still_living = $request->input('mother.children_still_living', 0);
            $mother->children_born_alive_now_dead = $request->input('mother.children_born_alive_now_dead', 0);
            $mother->save();
            
            // Create Father record if included
            $fatherId = null;
            if ($request->has('father.first_name') && $request->input('father.first_name') !== '') {
                $father = new Father();
                $father->first_name = $request->input('father.first_name');
                $father->middle_name = $request->input('father.middle_name');
                $father->last_name = $request->input('father.last_name');
                $father->citizenship = $request->input('father.citizenship');
                $father->religion = $request->input('father.religion');
                $father->occupation = $request->input('father.occupation');
                $father->age_at_birth = $request->input('father.age_at_birth');
                $father->residence_house_no = $request->input('father.residence_house_no');
                $father->residence_street = $request->input('father.residence_street');
                $father->residence_barangay = $request->input('father.residence_barangay');
                $father->residence_city_municipality_id = $request->input('father.residence_city_municipality_id');
                $father->residence_province_id = $request->input('father.residence_province_id');
                $father->residence_country_id = $request->input('father.residence_country_id');
                $father->save();
                $fatherId = $father->id;
            }
            
            // Create Marriage record if parents are married
            $marriageId = null;
            if ($request->has('marriage.date') && $request->input('marriage.date') !== '') {
                $marriage = new Marriage();
                $marriage->date = $request->input('marriage.date');
                $marriage->place_city_municipality_id = $request->input('marriage.place_city_municipality_id');
                $marriage->place_province_id = $request->input('marriage.place_province_id');
                $marriage->place_country_id = $request->input('marriage.place_country_id');
                $marriage->save();
                $marriageId = $marriage->id;
            }
            
            // Create Birth Attendant record
            $birthAttendant = new BirthAttendant();
            $birthAttendant->attendant_type = $request->input('birth_attendant.attendant_type');
            $birthAttendant->other_attendant_type = $request->input('birth_attendant.other_attendant_type');
            $birthAttendant->name = $request->input('birth_attendant.name');
            $birthAttendant->title_or_position = $request->input('birth_attendant.title_or_position');
            $birthAttendant->address = $request->input('birth_attendant.address');
            $birthAttendant->certification_date = $request->input('birth_attendant.certification_date');
            $birthAttendant->birth_time = $request->input('birth_attendant.birth_time');
            $birthAttendant->save();
            
            // Create Informant record
            $informant = new Informant();
            $informant->name = $request->input('informant.name');
            $informant->relationship_to_child = $request->input('informant.relationship_to_child');
            $informant->address = $request->input('informant.address');
            $informant->date = $request->input('informant.date');
            $informant->save();
            
            // Create Officials records
            $preparedById = null;
            if ($request->has('prepared_by.name') && !empty($request->input('prepared_by.name'))) {
                $preparedBy = new Official();
                $preparedBy->name = $request->input('prepared_by.name');
                $preparedBy->title_or_position = $request->input('prepared_by.title_or_position');
                $preparedBy->date = $request->input('prepared_by.date');
                $preparedBy->save();
                $preparedById = $preparedBy->id;
            }
            
            $receivedById = null;
            if ($request->has('received_by.name') && !empty($request->input('received_by.name'))) {
                $receivedBy = new Official();
                $receivedBy->name = $request->input('received_by.name');
                $receivedBy->title_or_position = $request->input('received_by.title_or_position');
                $receivedBy->date = $request->input('received_by.date');
                $receivedBy->save();
                $receivedById = $receivedBy->id;
            }
            
            $registeredById = null;
            if ($request->has('registered_by.name') && !empty($request->input('registered_by.name'))) {
                $registeredBy = new Official();
                $registeredBy->name = $request->input('registered_by.name');
                $registeredBy->title_or_position = $request->input('registered_by.title_or_position');
                $registeredBy->date = $request->input('registered_by.date');
                $registeredBy->save();
                $registeredById = $registeredBy->id;
            }
            
            // Create Birth Certificate record
            $birthCertificate = new BirthCertificate();
            $newId = BirthCertificate::max('id') + 1;
            $birthCertificate->cert_id = 'BRTH-' . str_pad($newId, 3, '0', STR_PAD_LEFT);
            $birthCertificate->registry_no = $request->input('registry_no');
            $birthCertificate->province_id = $request->input('province_id');
            $birthCertificate->city_municipality_id = $request->input('city_municipality_id');
            $birthCertificate->child_id = $child->id;
            $birthCertificate->mother_id = $mother->id;
            $birthCertificate->father_id = $fatherId;
            $birthCertificate->marriage_id = $marriageId;
            $birthCertificate->birth_attendant_id = $birthAttendant->id;
            $birthCertificate->informant_id = $informant->id;
            $birthCertificate->prepared_by_id = $preparedById;
            $birthCertificate->received_by_id = $receivedById;
            $birthCertificate->registered_by_id = $registeredById;
            $birthCertificate->remarks = $request->input('remarks');
            $birthCertificate->contact_no = $request->input('contact_no');
            $birthCertificate->save();
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('certificates.create')
                ->with('success', 'Birth Certificate created successfully with Registry No: ' . $request->input('registry_no'));
                
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while saving the birth certificate: ' . $e->getMessage());
        }
        
    }

    private function storeDeathCertificate(Request $request)
{
    // Validate main certificate data
    $validator = Validator::make($request->all(), [
        'registry_no' => 'required|string|unique:death_certificates,registry_no',
        'province_id' => 'required|exists:provinces,id',
        'city_municipality_id' => 'required|exists:cities_municipalities,id',
        'contact_no' => 'nullable|string|max:20',
        'remarks' => 'nullable|string',
        
        // Deceased validation
        'deceased.first_name' => 'required|string|max:255',
        'deceased.middle_name' => 'nullable|string|max:255',
        'deceased.last_name' => 'required|string|max:255',
        'deceased.sex' => 'required|in:Male,Female,Other',
        'deceased.date_of_birth' => 'nullable|date',
        'deceased.date_of_death' => 'required|date',
        'deceased.age_years' => 'nullable|integer|min:0',
        'deceased.age_months' => 'nullable|integer|min:0|max:11',
        'deceased.age_days' => 'nullable|integer|min:0|max:30',
        'deceased.age_hours' => 'nullable|integer|min:0|max:23',
        'deceased.age_minutes' => 'nullable|integer|min:0|max:59',
        'deceased.place_of_death' => 'required|string|max:255',
        'deceased.civil_status' => 'required|string|max:255',
        'deceased.religion' => 'nullable|string|max:255',
        'deceased.citizenship' => 'nullable|string|max:255',
        'deceased.residence_house_no' => 'nullable|string|max:255',
        'deceased.residence_street' => 'nullable|string|max:255',
        'deceased.residence_barangay' => 'nullable|string|max:255',
        'deceased.residence_city_municipality_id' => 'required|exists:cities_municipalities,id',
        'deceased.residence_province_id' => 'required|exists:provinces,id',
        'deceased.residence_country_id' => 'required|exists:countries,id',
        'deceased.occupation' => 'nullable|string|max:255',
        'deceased.father_name' => 'nullable|string|max:255',
        'deceased.mother_maiden_name' => 'nullable|string|max:255',
        
        // Death Cause validation
        'death_cause.immediate_cause' => 'nullable|string|max:255',
        'death_cause.antecedent_cause' => 'nullable|string|max:255',
        'death_cause.underlying_cause' => 'nullable|string|max:255',
        'death_cause.other_significant_conditions' => 'nullable|string',
        'death_cause.interval_between_onset_and_death' => 'nullable|string|max:255',
        'death_cause.maternal_condition' => 'nullable|string|max:255',
        'death_cause.manner_of_death' => 'nullable|string|max:255',
        'death_cause.external_cause_place' => 'nullable|string|max:255',
        'death_cause.autopsy_performed' => 'nullable|boolean',
        
        // Death Attendant validation
        'death_attendant.attendant_type' => 'required|integer|min:1|max:5',
        'death_attendant.other_attendant_type' => 'required_if:death_attendant.attendant_type,5|nullable|string|max:255',
        'death_attendant.name' => 'nullable|string|max:255',
        'death_attendant.title_or_position' => 'nullable|string|max:255',
        'death_attendant.address' => 'nullable|string',
        'death_attendant.attended_from' => 'nullable|date',
        'death_attendant.attended_to' => 'nullable|date',
        'death_attendant.attended_deceased' => 'nullable|boolean',
        'death_attendant.death_time' => 'nullable|string',
        'death_attendant.certification_date' => 'nullable|date',
        
        // Death Informant validation
        'death_informant.name' => 'required|string|max:255',
        'death_informant.relationship_to_deceased' => 'required|string|max:255',
        'death_informant.address' => 'nullable|string',
        'death_informant.date' => 'nullable|date',
        
        // Corpse Disposal validation
        'corpse_disposal.disposal_type' => 'required|string|max:255',
        'corpse_disposal.other_disposal_type' => 'required_if:corpse_disposal.disposal_type,Others|nullable|string|max:255',
        'corpse_disposal.burial_cremation_permit_number' => 'nullable|string|max:255',
        'corpse_disposal.burial_cremation_permit_date' => 'nullable|date',
        'corpse_disposal.transfer_permit_number' => 'nullable|string|max:255',
        'corpse_disposal.transfer_permit_date' => 'nullable|date',
        'corpse_disposal.cemetery_name' => 'nullable|string|max:255',
        'corpse_disposal.cemetery_address' => 'nullable|string|max:255',
        
        // Officials validation
        'prepared_by.name' => 'nullable|string|max:255',
        'prepared_by.title_or_position' => 'nullable|string|max:255',
        'prepared_by.date' => 'nullable|date',
        
        'received_by.name' => 'nullable|string|max:255',
        'received_by.title_or_position' => 'nullable|string|max:255',
        'received_by.date' => 'nullable|date',
        
        'registered_by.name' => 'nullable|string|max:255',
        'registered_by.title_or_position' => 'nullable|string|max:255',
        'registered_by.date' => 'nullable|date',
        
        'reviewed_by.name' => 'nullable|string|max:255',
        'reviewed_by.title_or_position' => 'nullable|string|max:255',
        'reviewed_by.date' => 'nullable|date',
    ]);
    
    if ($validator->fails()) {
        return redirect('/certificates/create')
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'There were errors in your submission. Please check the form and try again.');
    }
    
    // Begin transaction to ensure data integrity
    DB::beginTransaction();
    
    try {
        // Create Deceased record
        $deceased = new Deceased();
        $deceased->first_name = $request->input('deceased.first_name');
        $deceased->middle_name = $request->input('deceased.middle_name');
        $deceased->last_name = $request->input('deceased.last_name');
        $deceased->sex = $request->input('deceased.sex');
        $deceased->date_of_birth = $request->input('deceased.date_of_birth');
        $deceased->date_of_death = $request->input('deceased.date_of_death');
        $deceased->age_years = $request->input('deceased.age_years');
        $deceased->age_months = $request->input('deceased.age_months');
        $deceased->age_days = $request->input('deceased.age_days');
        $deceased->age_hours = $request->input('deceased.age_hours');
        $deceased->age_minutes = $request->input('deceased.age_minutes');
        $deceased->place_of_death = $request->input('deceased.place_of_death');
        $deceased->civil_status = $request->input('deceased.civil_status');
        $deceased->religion = $request->input('deceased.religion');
        $deceased->citizenship = $request->input('deceased.citizenship');
        $deceased->residence_house_no = $request->input('deceased.residence_house_no');
        $deceased->residence_street = $request->input('deceased.residence_street');
        $deceased->residence_barangay = $request->input('deceased.residence_barangay');
        $deceased->residence_city_municipality_id = $request->input('deceased.residence_city_municipality_id');
        $deceased->residence_province_id = $request->input('deceased.residence_province_id');
        $deceased->residence_country_id = $request->input('deceased.residence_country_id');
        $deceased->occupation = $request->input('deceased.occupation');
        $deceased->father_name = $request->input('deceased.father_name');
        $deceased->mother_maiden_name = $request->input('deceased.mother_maiden_name');
        $deceased->save();
        
        // Create Death Cause record
        $deathCause = new DeathCause();
        $deathCause->immediate_cause = $request->input('death_cause.immediate_cause');
        $deathCause->antecedent_cause = $request->input('death_cause.antecedent_cause');
        $deathCause->underlying_cause = $request->input('death_cause.underlying_cause');
        $deathCause->other_significant_conditions = $request->input('death_cause.other_significant_conditions');
        $deathCause->interval_between_onset_and_death = $request->input('death_cause.interval_between_onset_and_death');
        $deathCause->maternal_condition = $request->input('death_cause.maternal_condition');
        $deathCause->manner_of_death = $request->input('death_cause.manner_of_death');
        $deathCause->external_cause_place = $request->input('death_cause.external_cause_place');
        $deathCause->autopsy_performed = $request->input('death_cause.autopsy_performed', false);
        $deathCause->save();
        
        // Create Death Attendant record
        $deathAttendant = new DeathAttendant();
        $deathAttendant->attendant_type = $request->input('death_attendant.attendant_type');
        $deathAttendant->other_attendant_type = $request->input('death_attendant.other_attendant_type');
        $deathAttendant->name = $request->input('death_attendant.name');
        $deathAttendant->title_or_position = $request->input('death_attendant.title_or_position');
        $deathAttendant->address = $request->input('death_attendant.address');
        $deathAttendant->attended_from = $request->input('death_attendant.attended_from');
        $deathAttendant->attended_to = $request->input('death_attendant.attended_to');
        $deathAttendant->attended_deceased = $request->input('death_attendant.attended_deceased', false);
        $deathAttendant->death_time = $request->input('death_attendant.death_time');
        $deathAttendant->certification_date = $request->input('death_attendant.certification_date');
        $deathAttendant->save();
        
        // Create Death Informant record
        $deathInformant = new DeathInformant();
        $deathInformant->name = $request->input('death_informant.name');
        $deathInformant->relationship_to_deceased = $request->input('death_informant.relationship_to_deceased');
        $deathInformant->address = $request->input('death_informant.address');
        $deathInformant->date = $request->input('death_informant.date');
        $deathInformant->save();
        
        // Create Corpse Disposal record
        $corpseDisposal = new CorpseDisposal();
        $corpseDisposal->disposal_type = $request->input('corpse_disposal.disposal_type');
        $corpseDisposal->other_disposal_type = $request->input('corpse_disposal.other_disposal_type');
        $corpseDisposal->burial_cremation_permit_number = $request->input('corpse_disposal.burial_cremation_permit_number');
        $corpseDisposal->burial_cremation_permit_date = $request->input('corpse_disposal.burial_cremation_permit_date');
        $corpseDisposal->transfer_permit_number = $request->input('corpse_disposal.transfer_permit_number');
        $corpseDisposal->transfer_permit_date = $request->input('corpse_disposal.transfer_permit_date');
        $corpseDisposal->cemetery_name = $request->input('corpse_disposal.cemetery_name');
        $corpseDisposal->cemetery_address = $request->input('corpse_disposal.cemetery_address');
        $corpseDisposal->save();
        
        // Create Officials records
        $preparedById = null;
        if ($request->has('prepared_by.name') && !empty($request->input('prepared_by.name'))) {
            $preparedBy = new Official();
            $preparedBy->name = $request->input('prepared_by.name');
            $preparedBy->title_or_position = $request->input('prepared_by.title_or_position');
            $preparedBy->date = $request->input('prepared_by.date');
            $preparedBy->save();
            $preparedById = $preparedBy->id;
        }
        
        $receivedById = null;
        if ($request->has('received_by.name') && !empty($request->input('received_by.name'))) {
            $receivedBy = new Official();
            $receivedBy->name = $request->input('received_by.name');
            $receivedBy->title_or_position = $request->input('received_by.title_or_position');
            $receivedBy->date = $request->input('received_by.date');
            $receivedBy->save();
            $receivedById = $receivedBy->id;
        }
        
        $registeredById = null;
        if ($request->has('registered_by.name') && !empty($request->input('registered_by.name'))) {
            $registeredBy = new Official();
            $registeredBy->name = $request->input('registered_by.name');
            $registeredBy->title_or_position = $request->input('registered_by.title_or_position');
            $registeredBy->date = $request->input('registered_by.date');
            $registeredBy->save();
            $registeredById = $registeredBy->id;
        }
        
        $reviewedById = null;
        if ($request->has('reviewed_by.name') && !empty($request->input('reviewed_by.name'))) {
            $reviewedBy = new Official();
            $reviewedBy->name = $request->input('reviewed_by.name');
            $reviewedBy->title_or_position = $request->input('reviewed_by.title_or_position');
            $reviewedBy->date = $request->input('reviewed_by.date');
            $reviewedBy->save();
            $reviewedById = $reviewedBy->id;
        }
        
        // Create Death Certificate record
        $deathCertificate = new DeathCertificate();
        $newId = DeathCertificate::max('id') + 1;
        $deathCertificate->cert_id = 'DTHC-' . str_pad($newId, 3, '0', STR_PAD_LEFT);
        $deathCertificate->registry_no = $request->input('registry_no');
        $deathCertificate->province_id = $request->input('province_id');
        $deathCertificate->city_municipality_id = $request->input('city_municipality_id');
        $deathCertificate->deceased_id = $deceased->id;
        $deathCertificate->death_cause_id = $deathCause->id;
        $deathCertificate->death_attendant_id = $deathAttendant->id;
        $deathCertificate->death_informant_id = $deathInformant->id;
        $deathCertificate->corpse_disposal_id = $corpseDisposal->id;
        $deathCertificate->prepared_by_id = $preparedById;
        $deathCertificate->received_by_id = $receivedById;
        $deathCertificate->registered_by_id = $registeredById;
        $deathCertificate->reviewed_by_id = $reviewedById;
        $deathCertificate->remarks = $request->input('remarks');
        $deathCertificate->contact_no = $request->input('contact_no');
        $deathCertificate->status = 'Active';
        $deathCertificate->save();
        
        // Commit transaction
        DB::commit();
        
        return redirect()->route('certificates.create')
            ->with('success', 'Death Certificate created successfully with Registry No: ' . $request->input('registry_no'));
            
    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollBack();
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'An error occurred while saving the death certificate: ' . $e->getMessage());
    }
}

// Add this method to show death certificates
public function showDeathCertificate(string $id)
{
    $deathCertificate = DeathCertificate::with([
        'deceased', 'deathCause', 'deathAttendant', 
        'deathInformant', 'corpseDisposal', 'preparedBy', 
        'receivedBy', 'registeredBy', 'reviewedBy', 
        'province', 'cityMunicipality'
    ])->findOrFail($id);
    
    return view('certificates.showDeathCertificate', compact('deathCertificate'));
}

// Modify the show method to handle both certificate types
public function show(string $id)
{
    // Try to find a birth certificate first
    $birthCertificate = BirthCertificate::where('cert_id',$id)->first();
    if ($birthCertificate) {
        return view('certificates.showCertificate', compact('birthCertificate'));
    }
    
    // If not found, try to find a death certificate
    $deathCertificate = DeathCertificate::where('cert_id',$id)->first();
    if ($deathCertificate) {
        return view('certificates.showDeathCert', compact('deathCertificate'));
    }
    
    // If neither is found, return 404
    abort(404, 'Certificate not found');
}

// Add this method to archive death certificates
public function archiveDeathCertificate($id)
{
    $status = 'Archived';
    $certificate = DeathCertificate::where('cert_id',$id)->first();
    $certificate->status = $status;
    $certificate->save();
    $latest = $certificate->registry_no;
    return redirect('/certificates')->with('success', 'Death Certificate '.$latest. ' Archived Successfully!');
}

// Add this method to restore death certificates
public function restoreDeathCertificate($id)
{
    $status = 'Active';
    $certificate = DeathCertificate::where('cert_id',$id)->first();
    $certificate->status = $status;
    $certificate->save();
    $latest = $certificate->registry_no;
    return redirect('/certArchives')->with('success', 'Death Certificate '.$latest. ' Restored Successfully!');
}

public function archive($id)
{
    $status = 'Archived';
    $certificate = BirthCertificate::where('cert_id',$id)->first();
    $certificate->status = $status;
    $certificate->save();
    $latest = $certificate->registry_no;
    return redirect('/certificates')->with('success', 'Birth Certificate '.$latest. ' Archived Successfully!');
}

// Add this method to restore death certificates
public function restore($id)
{
    $status = 'Active';
    $certificate = BirthCertificate::where('cert_id',$id)->first();
    $certificate->status = $status;
    $certificate->save();
    $latest = $certificate->registry_no;
    return redirect('/certArchives')->with('success', 'Birth Certificate '.$latest. ' Restored Successfully!');
}

/**
 * Show the form for editing the specified resource.
 */
public function edit(string $id)
{
    // Check if it's a birth certificate
    $birthCertificate = BirthCertificate::with([
        'child', 'mother', 'father', 'marriage', 
        'birthAttendant', 'informant', 'preparedBy', 
        'receivedBy', 'registeredBy', 'province', 
        'cityMunicipality'
    ])->where('cert_id', $id)->first();
    
    if ($birthCertificate) {
        $countries = Country::all();
        $provinces = Province::all();
        $cities = CityMunicipality::all();
        
        // For convenience, also get specific collections for the main dropdowns
        $childCities = CityMunicipality::where('province_id', $birthCertificate->child->place_of_birth_province_id ?? 1)->get();
        $motherCities = CityMunicipality::where('province_id', $birthCertificate->mother->residence_province_id ?? 1)->get();
        
        // Get marriage cities if marriage exists
        $marriageCities = isset($birthCertificate->marriage) && isset($birthCertificate->marriage->place_province_id) 
            ? CityMunicipality::where('province_id', $birthCertificate->marriage->place_province_id)->get() 
            : collect([]);
        
        return view('certificates.editCert', compact(
            'birthCertificate', 'countries', 'provinces', 'cities',
            'childCities', 'motherCities', 'marriageCities'
        ));
    }
    
    // If not a birth certificate, check if it's a death certificate
    $deathCertificate = DeathCertificate::with([
        'deceased', 'deathCause', 'deathAttendant', 
        'deathInformant', 'corpseDisposal', 'preparedBy', 
        'receivedBy', 'registeredBy', 'reviewedBy', 
        'province', 'cityMunicipality'
    ])->where('cert_id', $id)->first();
    
    if ($deathCertificate) {
        $countries = Country::all();
        $provinces = Province::all();
        $cities = CityMunicipality::all();
        
        // For convenience, also get specific collections for the main dropdowns
        $deceasedCities = CityMunicipality::where('province_id', $deathCertificate->deceased->residence_province_id ?? 1)->get();
        
        return view('certificates.editDeathCert', compact(
            'deathCertificate', 'countries', 'provinces', 'cities', 'deceasedCities'
        ));
    }
    
    // If neither is found, return 404
    abort(404, 'Certificate not found');
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    // Check certificate type
    if ($request->certificate_type === 'birth') {
        return $this->updateBirthCertificate($request, $id);
    } else if ($request->certificate_type === 'death') {
        return $this->updateDeathCertificate($request, $id);
    }
    
    return redirect()->back()->with('error', 'Invalid certificate type.');
}

/**
 * Update a birth certificate and related records
 */
private function updateBirthCertificate(Request $request, string $id)
{
    // Validate main certificate data
    $validator = Validator::make($request->all(), [
        'registry_no' => 'required|string|unique:birth_certificates,registry_no,' . $id,
        'province_id' => 'required|exists:provinces,id',
        'city_municipality_id' => 'required|exists:cities_municipalities,id',
        'contact_no' => 'nullable|string|max:20',
        'remarks' => 'nullable|string',
        
        // Child validation
        'child.first_name' => 'required|string|max:255',
        'child.middle_name' => 'nullable|string|max:255',
        'child.last_name' => 'required|string|max:255',
        'child.sex' => 'required|in:Male,Female,Other',
        'child.date_of_birth' => 'required|date',
        'child.place_of_birth_hospital' => 'nullable|string|max:255',
        'child.place_of_birth_city_municipality_id' => 'required|exists:cities_municipalities,id',
        'child.place_of_birth_province_id' => 'required|exists:provinces,id',
        'child.type_of_birth' => 'required|string|max:255',
        'child.is_multiple_birth' => 'nullable|boolean',
        'child.multiple_birth_type' => 'nullable|string|max:255',
        'child.weight_at_birth' => 'nullable|numeric',
        
        // Mother validation
        'mother.first_name' => 'required|string|max:255',
        'mother.middle_name' => 'nullable|string|max:255',
        'mother.last_name' => 'required|string|max:255',
        'mother.maiden_name' => 'required|string|max:255',
        'mother.citizenship' => 'required|string|max:255',
        'mother.religion' => 'nullable|string|max:255',
        'mother.occupation' => 'nullable|string|max:255',
        'mother.age_at_birth' => 'nullable|integer|min:12|max:100',
        'mother.residence_house_no' => 'nullable|string|max:255',
        'mother.residence_street' => 'nullable|string|max:255',
        'mother.residence_barangay' => 'nullable|string|max:255',
        'mother.residence_city_municipality_id' => 'required|exists:cities_municipalities,id',
        'mother.residence_province_id' => 'required|exists:provinces,id',
        'mother.residence_country_id' => 'required|exists:countries,id',
        'mother.total_children_born_alive' => 'nullable|integer|min:0',
        'mother.children_still_living' => 'nullable|integer|min:0',
        'mother.children_born_alive_now_dead' => 'nullable|integer|min:0',
        
        // Father validation (conditional)
        'father.first_name' => 'nullable|string|max:255',
        'father.middle_name' => 'nullable|string|max:255',
        'father.last_name' => 'nullable|string|max:255',
        'father.citizenship' => 'nullable|string|max:255',
        'father.religion' => 'nullable|string|max:255',
        'father.occupation' => 'nullable|string|max:255',
        'father.age_at_birth' => 'nullable|integer|min:12|max:100',
        'father.residence_house_no' => 'nullable|string|max:255',
        'father.residence_street' => 'nullable|string|max:255',
        'father.residence_barangay' => 'nullable|string|max:255',
        'father.residence_city_municipality_id' => 'nullable|exists:cities_municipalities,id',
        'father.residence_province_id' => 'nullable|exists:provinces,id',
        'father.residence_country_id' => 'nullable|exists:countries,id',
        
        // Marriage validation (conditional)
        'marriage.date' => 'nullable|date',
        'marriage.place_city_municipality_id' => 'nullable|exists:cities_municipalities,id',
        'marriage.place_province_id' => 'nullable|exists:provinces,id',
        'marriage.place_country_id' => 'nullable|exists:countries,id',
        
        // Birth Attendant validation
        'birth_attendant.attendant_type' => 'required|integer|min:1|max:5',
        'birth_attendant.other_attendant_type' => 'required_if:birth_attendant.attendant_type,5|nullable|string|max:255',
        'birth_attendant.name' => 'required|string|max:255',
        'birth_attendant.title_or_position' => 'nullable|string|max:255',
        'birth_attendant.address' => 'nullable|string',
        'birth_attendant.certification_date' => 'nullable|date',
        'birth_attendant.birth_time' => 'nullable|string',
        
        // Informant validation
        'informant.name' => 'required|string|max:255',
        'informant.relationship_to_child' => 'required|string|max:255',
        'informant.address' => 'nullable|string',
        'informant.date' => 'nullable|date',
        
        // Officials validation
        'prepared_by.name' => 'nullable|string|max:255',
        'prepared_by.title_or_position' => 'nullable|string|max:255',
        'prepared_by.date' => 'nullable|date',
        
        'received_by.name' => 'nullable|string|max:255',
        'received_by.title_or_position' => 'nullable|string|max:255',
        'received_by.date' => 'nullable|date',
        
        'registered_by.name' => 'nullable|string|max:255',
        'registered_by.title_or_position' => 'nullable|string|max:255',
        'registered_by.date' => 'nullable|date',
    ]);
    
    if ($validator->fails()) {
        return redirect()->route('certificates.edit', $id)
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'There were errors in your submission. Please check the form and try again.');
    }
    
    // Begin transaction to ensure data integrity
    DB::beginTransaction();
    
    try {
        $birthCertificate = BirthCertificate::findOrFail($id);
        
        // Update Child record
        $child = Child::findOrFail($birthCertificate->child_id);
        $child->first_name = $request->input('child.first_name');
        $child->middle_name = $request->input('child.middle_name');
        $child->last_name = $request->input('child.last_name');
        $child->sex = $request->input('child.sex');
        $child->date_of_birth = $request->input('child.date_of_birth');
        $child->place_of_birth_hospital = $request->input('child.place_of_birth_hospital');
        $child->place_of_birth_city_municipality_id = $request->input('child.place_of_birth_city_municipality_id');
        $child->place_of_birth_province_id = $request->input('child.place_of_birth_province_id');
        $child->type_of_birth = $request->input('child.type_of_birth');
        $child->is_multiple_birth = $request->input('child.is_multiple_birth', 0);
        $child->multiple_birth_type = $request->input('child.multiple_birth_type');
        $child->weight_at_birth = $request->input('child.weight_at_birth');
        $child->save();
        
        // Update Mother record
        $mother = Mother::findOrFail($birthCertificate->mother_id);
        $mother->first_name = $request->input('mother.first_name');
        $mother->middle_name = $request->input('mother.middle_name');
        $mother->last_name = $request->input('mother.last_name');
        $mother->maiden_name = $request->input('mother.maiden_name');
        $mother->citizenship = $request->input('mother.citizenship');
        $mother->religion = $request->input('mother.religion');
        $mother->occupation = $request->input('mother.occupation');
        $mother->age_at_birth = $request->input('mother.age_at_birth');
        $mother->residence_house_no = $request->input('mother.residence_house_no');
        $mother->residence_street = $request->input('mother.residence_street');
        $mother->residence_barangay = $request->input('mother.residence_barangay');
        $mother->residence_city_municipality_id = $request->input('mother.residence_city_municipality_id');
        $mother->residence_province_id = $request->input('mother.residence_province_id');
        $mother->residence_country_id = $request->input('mother.residence_country_id');
        $mother->total_children_born_alive = $request->input('mother.total_children_born_alive', 0);
        $mother->children_still_living = $request->input('mother.children_still_living', 0);
        $mother->children_born_alive_now_dead = $request->input('mother.children_born_alive_now_dead', 0);
        $mother->save();
        
        // Update or Create Father record
        $fatherId = $birthCertificate->father_id;
        if ($request->has('father.first_name') && $request->input('father.first_name') !== '') {
            if ($fatherId) {
                $father = Father::findOrFail($fatherId);
                $father->first_name = $request->input('father.first_name');
                $father->middle_name = $request->input('father.middle_name');
                $father->last_name = $request->input('father.last_name');
                $father->citizenship = $request->input('father.citizenship');
                $father->religion = $request->input('father.religion');
                $father->occupation = $request->input('father.occupation');
                $father->age_at_birth = $request->input('father.age_at_birth');
                $father->residence_house_no = $request->input('father.residence_house_no');
                $father->residence_street = $request->input('father.residence_street');
                $father->residence_barangay = $request->input('father.residence_barangay');
                $father->residence_city_municipality_id = $request->input('father.residence_city_municipality_id');
                $father->residence_province_id = $request->input('father.residence_province_id');
                $father->residence_country_id = $request->input('father.residence_country_id');
                $father->save();
            } else {
                $father = new Father();
                $father->first_name = $request->input('father.first_name');
                $father->middle_name = $request->input('father.middle_name');
                $father->last_name = $request->input('father.last_name');
                $father->citizenship = $request->input('father.citizenship');
                $father->religion = $request->input('father.religion');
                $father->occupation = $request->input('father.occupation');
                $father->age_at_birth = $request->input('father.age_at_birth');
                $father->residence_house_no = $request->input('father.residence_house_no');
                $father->residence_street = $request->input('father.residence_street');
                $father->residence_barangay = $request->input('father.residence_barangay');
                $father->residence_city_municipality_id = $request->input('father.residence_city_municipality_id');
                $father->residence_province_id = $request->input('father.residence_province_id');
                $father->residence_country_id = $request->input('father.residence_country_id');
                $father->save();
                $fatherId = $father->id;
            }
        } elseif ($fatherId) {
            // Remove father association if no father data provided
            $fatherId = null;
        }
        
        // Update or Create Marriage record
        $marriageId = $birthCertificate->marriage_id;
        if ($request->has('marriage.date') && $request->input('marriage.date') !== '') {
            if ($marriageId) {
                $marriage = Marriage::findOrFail($marriageId);
                $marriage->date = $request->input('marriage.date');
                $marriage->place_city_municipality_id = $request->input('marriage.place_city_municipality_id');
                $marriage->place_province_id = $request->input('marriage.place_province_id');
                $marriage->place_country_id = $request->input('marriage.place_country_id');
                $marriage->save();
            } else {
                $marriage = new Marriage();
                $marriage->date = $request->input('marriage.date');
                $marriage->place_city_municipality_id = $request->input('marriage.place_city_municipality_id');
                $marriage->place_province_id = $request->input('marriage.place_province_id');
                $marriage->place_country_id = $request->input('marriage.place_country_id');
                $marriage->save();
                $marriageId = $marriage->id;
            }
        } elseif ($marriageId) {
            // Remove marriage association if no marriage data provided
            $marriageId = null;
        }
        
        // Update Birth Attendant record
        $birthAttendant = BirthAttendant::findOrFail($birthCertificate->birth_attendant_id);
        $birthAttendant->attendant_type = $request->input('birth_attendant.attendant_type');
        $birthAttendant->other_attendant_type = $request->input('birth_attendant.other_attendant_type');
        $birthAttendant->name = $request->input('birth_attendant.name');
        $birthAttendant->title_or_position = $request->input('birth_attendant.title_or_position');
        $birthAttendant->address = $request->input('birth_attendant.address');
        $birthAttendant->certification_date = $request->input('birth_attendant.certification_date');
        $birthAttendant->birth_time = $request->input('birth_attendant.birth_time');
        $birthAttendant->save();
        
        // Update Informant record
        $informant = Informant::findOrFail($birthCertificate->informant_id);
        $informant->name = $request->input('informant.name');
        $informant->relationship_to_child = $request->input('informant.relationship_to_child');
        $informant->address = $request->input('informant.address');
        $informant->date = $request->input('informant.date');
        $informant->save();
        
        // Update or Create Officials records
        $preparedById = $birthCertificate->prepared_by_id;
        if ($request->has('prepared_by.name') && !empty($request->input('prepared_by.name'))) {
            if ($preparedById) {
                $preparedBy = Official::findOrFail($preparedById);
                $preparedBy->name = $request->input('prepared_by.name');
                $preparedBy->title_or_position = $request->input('prepared_by.title_or_position');
                $preparedBy->date = $request->input('prepared_by.date');
                $preparedBy->save();
            } else {
                $preparedBy = new Official();
                $preparedBy->name = $request->input('prepared_by.name');
                $preparedBy->title_or_position = $request->input('prepared_by.title_or_position');
                $preparedBy->date = $request->input('prepared_by.date');
                $preparedBy->save();
                $preparedById = $preparedBy->id;
            }
        } elseif ($preparedById) {
            // Remove prepared_by association if no data provided
            $preparedById = null;
        }
        
        $receivedById = $birthCertificate->received_by_id;
        if ($request->has('received_by.name') && !empty($request->input('received_by.name'))) {
            if ($receivedById) {
                $receivedBy = Official::findOrFail($receivedById);
                $receivedBy->name = $request->input('received_by.name');
                $receivedBy->title_or_position = $request->input('received_by.title_or_position');
                $receivedBy->date = $request->input('received_by.date');
                $receivedBy->save();
            } else {
                $receivedBy = new Official();
                $receivedBy->name = $request->input('received_by.name');
                $receivedBy->title_or_position = $request->input('received_by.title_or_position');
                $receivedBy->date = $request->input('received_by.date');
                $receivedBy->save();
                $receivedById = $receivedBy->id;
            }
        } elseif ($receivedById) {
            // Remove received_by association if no data provided
            $receivedById = null;
        }
        
        $registeredById = $birthCertificate->registered_by_id;
        if ($request->has('registered_by.name') && !empty($request->input('registered_by.name'))) {
            if ($registeredById) {
                $registeredBy = Official::findOrFail($registeredById);
                $registeredBy->name = $request->input('registered_by.name');
                $registeredBy->title_or_position = $request->input('registered_by.title_or_position');
                $registeredBy->date = $request->input('registered_by.date');
                $registeredBy->save();
            } else {
                $registeredBy = new Official();
                $registeredBy->name = $request->input('registered_by.name');
                $registeredBy->title_or_position = $request->input('registered_by.title_or_position');
                $registeredBy->date = $request->input('registered_by.date');
                $registeredBy->save();
                $registeredById = $registeredBy->id;
            }
        } elseif ($registeredById) {
            // Remove registered_by association if no data provided
            $registeredById = null;
        }
        
        // Update Birth Certificate record
        $birthCertificate->registry_no = $request->input('registry_no');
        $birthCertificate->province_id = $request->input('province_id');
        $birthCertificate->city_municipality_id = $request->input('city_municipality_id');
        $birthCertificate->father_id = $fatherId;
        $birthCertificate->marriage_id = $marriageId;
        $birthCertificate->prepared_by_id = $preparedById;
        $birthCertificate->received_by_id = $receivedById;
        $birthCertificate->registered_by_id = $registeredById;
        $birthCertificate->remarks = $request->input('remarks');
        $birthCertificate->contact_no = $request->input('contact_no');
        $birthCertificate->save();
        
        // Commit transaction
        DB::commit();
        
        return redirect()->route('certificates.index')
            ->with('success', 'Birth Certificate updated successfully with Registry No: ' . $request->input('registry_no'));
            
    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollBack();
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'An error occurred while updating the birth certificate: ' . $e->getMessage());
    }
}

/**
 * Update a death certificate and related records
 */
private function updateDeathCertificate(Request $request, string $id)
{
    // First, find the death certificate to get its actual ID for validation
    $deathCertificate = DeathCertificate::where('cert_id', $id)->first();
    
    if (!$deathCertificate) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Death certificate not found with ID: ' . $id);
    }
    
    // Use the actual database ID for the unique validation rule
    $actualId = $deathCertificate->id;
    
    // Validate main certificate data
    $validator = Validator::make($request->all(), [
        'registry_no' => 'required|string|unique:death_certificates,registry_no,' . $actualId,
        'province_id' => 'required|exists:provinces,id',
        'city_municipality_id' => 'required|exists:cities_municipalities,id',
        'contact_no' => 'nullable|string|max:20',
        'remarks' => 'nullable|string',
        
        // Rest of validation rules remain the same
        // ...
    ]);
    
    if ($validator->fails()) {
        return redirect()->route('certificates.edit', $id)
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'There were errors in your submission. Please check the form and try again.');
    }
    
    // Begin transaction to ensure data integrity
    DB::beginTransaction();
    
    try {
        // Update Deceased record
        $deceased = Deceased::findOrFail($deathCertificate->deceased_id);
        $deceased->first_name = $request->input('deceased.first_name');
        $deceased->middle_name = $request->input('deceased.middle_name');
        $deceased->last_name = $request->input('deceased.last_name');
        $deceased->sex = $request->input('deceased.sex');
        $deceased->date_of_birth = $request->input('deceased.date_of_birth');
        $deceased->date_of_death = $request->input('deceased.date_of_death');
        $deceased->age_years = $request->input('deceased.age_years');
        $deceased->age_months = $request->input('deceased.age_months');
        $deceased->age_days = $request->input('deceased.age_days');
        $deceased->age_hours = $request->input('deceased.age_hours');
        $deceased->age_minutes = $request->input('deceased.age_minutes');
        $deceased->place_of_death = $request->input('deceased.place_of_death');
        $deceased->civil_status = $request->input('deceased.civil_status');
        $deceased->religion = $request->input('deceased.religion');
        $deceased->citizenship = $request->input('deceased.citizenship');
        $deceased->residence_house_no = $request->input('deceased.residence_house_no');
        $deceased->residence_street = $request->input('deceased.residence_street');
        $deceased->residence_barangay = $request->input('deceased.residence_barangay');
        $deceased->residence_city_municipality_id = $request->input('deceased.residence_city_municipality_id');
        $deceased->residence_province_id = $request->input('deceased.residence_province_id');
        $deceased->residence_country_id = $request->input('deceased.residence_country_id');
        $deceased->occupation = $request->input('deceased.occupation');
        $deceased->father_name = $request->input('deceased.father_name');
        $deceased->mother_maiden_name = $request->input('deceased.mother_maiden_name');
        $deceased->save();
        
        // Update Death Cause record
        $deathCause = DeathCause::findOrFail($deathCertificate->death_cause_id);
        $deathCause->immediate_cause = $request->input('death_cause.immediate_cause');
        $deathCause->antecedent_cause = $request->input('death_cause.antecedent_cause');
        $deathCause->underlying_cause = $request->input('death_cause.underlying_cause');
        $deathCause->other_significant_conditions = $request->input('death_cause.other_significant_conditions');
        $deathCause->interval_between_onset_and_death = $request->input('death_cause.interval_between_onset_and_death');
        $deathCause->maternal_condition = $request->input('death_cause.maternal_condition');
        $deathCause->manner_of_death = $request->input('death_cause.manner_of_death');
        $deathCause->external_cause_place = $request->input('death_cause.external_cause_place');
        $deathCause->autopsy_performed = $request->has('death_cause.autopsy_performed') ? 1 : 0;
        $deathCause->save();
        
        // Update Death Attendant record
        $deathAttendant = DeathAttendant::findOrFail($deathCertificate->death_attendant_id);
        $deathAttendant->attendant_type = $request->input('death_attendant.attendant_type');
        $deathAttendant->other_attendant_type = $request->input('death_attendant.other_attendant_type');
        $deathAttendant->name = $request->input('death_attendant.name');
        $deathAttendant->title_or_position = $request->input('death_attendant.title_or_position');
        $deathAttendant->address = $request->input('death_attendant.address');
        $deathAttendant->attended_from = $request->input('death_attendant.attended_from');
        $deathAttendant->attended_to = $request->input('death_attendant.attended_to');
        $deathAttendant->attended_deceased = $request->has('death_attendant.attended_deceased') ? 1 : 0;
        $deathAttendant->death_time = $request->input('death_attendant.death_time');
        $deathAttendant->certification_date = $request->input('death_attendant.certification_date');
        $deathAttendant->save();
        
        // Update Death Informant record
        $deathInformant = DeathInformant::findOrFail($deathCertificate->death_informant_id);
        $deathInformant->name = $request->input('death_informant.name');
        $deathInformant->relationship_to_deceased = $request->input('death_informant.relationship_to_deceased');
        $deathInformant->address = $request->input('death_informant.address');
        $deathInformant->date = $request->input('death_informant.date');
        $deathInformant->save();
        
        // Update Corpse Disposal record
        $corpseDisposal = CorpseDisposal::findOrFail($deathCertificate->corpse_disposal_id);
        $corpseDisposal->disposal_type = $request->input('corpse_disposal.disposal_type');
        $corpseDisposal->other_disposal_type = $request->input('corpse_disposal.other_disposal_type');
        $corpseDisposal->burial_cremation_permit_number = $request->input('corpse_disposal.burial_cremation_permit_number');
        $corpseDisposal->burial_cremation_permit_date = $request->input('corpse_disposal.burial_cremation_permit_date');
        $corpseDisposal->transfer_permit_number = $request->input('corpse_disposal.transfer_permit_number');
        $corpseDisposal->transfer_permit_date = $request->input('corpse_disposal.transfer_permit_date');
        $corpseDisposal->cemetery_name = $request->input('corpse_disposal.cemetery_name');
        $corpseDisposal->cemetery_address = $request->input('corpse_disposal.cemetery_address');
        $corpseDisposal->save();
        
        // Update or Create Officials records
        $preparedById = $deathCertificate->prepared_by_id;
        if ($request->has('prepared_by.name') && !empty($request->input('prepared_by.name'))) {
            if ($preparedById) {
                $preparedBy = Official::findOrFail($preparedById);
                $preparedBy->name = $request->input('prepared_by.name');
                $preparedBy->title_or_position = $request->input('prepared_by.title_or_position');
                $preparedBy->date = $request->input('prepared_by.date');
                $preparedBy->save();
            } else {
                $preparedBy = new Official();
                $preparedBy->name = $request->input('prepared_by.name');
                $preparedBy->title_or_position = $request->input('prepared_by.title_or_position');
                $preparedBy->date = $request->input('prepared_by.date');
                $preparedBy->save();
                $preparedById = $preparedBy->id;
            }
        } elseif ($preparedById) {
            // Remove prepared_by association if no data provided
            $preparedById = null;
        }
        
        $receivedById = $deathCertificate->received_by_id;
        if ($request->has('received_by.name') && !empty($request->input('received_by.name'))) {
            if ($receivedById) {
                $receivedBy = Official::findOrFail($receivedById);
                $receivedBy->name = $request->input('received_by.name');
                $receivedBy->title_or_position = $request->input('received_by.title_or_position');
                $receivedBy->date = $request->input('received_by.date');
                $receivedBy->save();
            } else {
                $receivedBy = new Official();
                $receivedBy->name = $request->input('received_by.name');
                $receivedBy->title_or_position = $request->input('received_by.title_or_position');
                $receivedBy->date = $request->input('received_by.date');
                $receivedBy->save();
                $receivedById = $receivedBy->id;
            }
        } elseif ($receivedById) {
            // Remove received_by association if no data provided
            $receivedById = null;
        }
        
        $registeredById = $deathCertificate->registered_by_id;
        if ($request->has('registered_by.name') && !empty($request->input('registered_by.name'))) {
            if ($registeredById) {
                $registeredBy = Official::findOrFail($registeredById);
                $registeredBy->name = $request->input('registered_by.name');
                $registeredBy->title_or_position = $request->input('registered_by.title_or_position');
                $registeredBy->date = $request->input('registered_by.date');
                $registeredBy->save();
            } else {
                $registeredBy = new Official();
                $registeredBy->name = $request->input('registered_by.name');
                $registeredBy->title_or_position = $request->input('registered_by.title_or_position');
                $registeredBy->date = $request->input('registered_by.date');
                $registeredBy->save();
                $registeredById = $registeredBy->id;
            }
        } elseif ($registeredById) {
            // Remove registered_by association if no data provided
            $registeredById = null;
        }
        
        $reviewedById = $deathCertificate->reviewed_by_id;
        if ($request->has('reviewed_by.name') && !empty($request->input('reviewed_by.name'))) {
            if ($reviewedById) {
                $reviewedBy = Official::findOrFail($reviewedById);
                $reviewedBy->name = $request->input('reviewed_by.name');
                $reviewedBy->title_or_position = $request->input('reviewed_by.title_or_position');
                $reviewedBy->date = $request->input('reviewed_by.date');
                $reviewedBy->save();
            } else {
                $reviewedBy = new Official();
                $reviewedBy->name = $request->input('reviewed_by.name');
                $reviewedBy->title_or_position = $request->input('reviewed_by.title_or_position');
                $reviewedBy->date = $request->input('reviewed_by.date');
                $reviewedBy->save();
                $reviewedById = $reviewedBy->id;
            }
        } elseif ($reviewedById) {
            // Remove reviewed_by association if no data provided
            $reviewedById = null;
        }
        
        // Update Death Certificate record
        $deathCertificate->registry_no = $request->input('registry_no');
        $deathCertificate->province_id = $request->input('province_id');
        $deathCertificate->city_municipality_id = $request->input('city_municipality_id');
        $deathCertificate->prepared_by_id = $preparedById;
        $deathCertificate->received_by_id = $receivedById;
        $deathCertificate->registered_by_id = $registeredById;
        $deathCertificate->reviewed_by_id = $reviewedById;
        $deathCertificate->remarks = $request->input('remarks');
        $deathCertificate->contact_no = $request->input('contact_no');
        $deathCertificate->save();
        
        // Commit transaction
        DB::commit();
        
        return redirect()->route('certificates.index')
            ->with('success', 'Death Certificate updated successfully with Registry No: ' . $request->input('registry_no'));
            
    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollBack();
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'An error occurred while updating the death certificate: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $birthCertificate = BirthCertificate::findOrFail($id);
            
            // Begin transaction
            DB::beginTransaction();
            
            // Delete related records
            if ($birthCertificate->child_id) {
                Child::destroy($birthCertificate->child_id);
            }
            
            if ($birthCertificate->mother_id) {
                Mother::destroy($birthCertificate->mother_id);
            }
            
            if ($birthCertificate->father_id) {
                Father::destroy($birthCertificate->father_id);
            }
            
            if ($birthCertificate->marriage_id) {
                Marriage::destroy($birthCertificate->marriage_id);
            }
            
            if ($birthCertificate->birth_attendant_id) {
                BirthAttendant::destroy($birthCertificate->birth_attendant_id);
            }
            
            if ($birthCertificate->informant_id) {
                Informant::destroy($birthCertificate->informant_id);
            }
            
            if ($birthCertificate->prepared_by_id) {
                Official::destroy($birthCertificate->prepared_by_id);
            }
            
            if ($birthCertificate->received_by_id) {
                Official::destroy($birthCertificate->received_by_id);
            }
            
            if ($birthCertificate->registered_by_id) {
                Official::destroy($birthCertificate->registered_by_id);
            }
            
            // Delete the birth certificate
            $birthCertificate->delete();
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('certificates.index')
                ->with('success', 'Birth Certificate deleted successfully.');
                
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            return redirect()->route('certificates.index')
                ->with('error', 'An error occurred while deleting the birth certificate: ' . $e->getMessage());
        }
    }
    
    /**
     * Get cities for a province via AJAX
     */
    public function getCities($provinceId)
    {
        $cities = CityMunicipality::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }
    
    /**
     * Get provinces for a country via AJAX
     */
    public function getProvinces($countryId)
    {
        $provinces = Province::where('country_id', $countryId)->get();
        return response()->json($provinces);
    }
}
