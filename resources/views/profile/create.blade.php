@extends('layouts.app')

@section('title', 'Create Profile')

@section('content')

    <div class="wrapper">
        <div class="profile-card">

            <h2 class="title">Create Your Profile</h2>
            <p class="subtitle">Complete your details to find better matches</p>

            <!-- Stepper -->
            <div class="stepper mb-4">
                <div class="step active" id="indicator1">1</div>
                <div class="step" id="indicator2">2</div>
                <div class="step" id="indicator3">3</div>
            </div>

            <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- STEP 1: Personal Details -->
                <div id="step1">
                    <div class="section">
                        <h4>Personal Details</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="pb-2 ps-1">Age</label>
                                <input type="number" name="age" class="form-control" value="{{ old('age') }}">

                                @error('age')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="pb-2 ps-1">Religion</label>
                                <input type="text" name="religion" class="form-control" value="{{ old('religion') }}">

                                @error('religion')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="pb-2 ps-1">Community</label>
                                <input type="text" name="community" class="form-control" value="{{ old('community') }}">
                                @error('community')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="pb-2 ps-1">Marital Status</label>
                                <select name="marital_status" class="form-select data">
                                    <option value="">Select Marital Status
                                    </option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single
                                    </option>
                                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>
                                        Divorced
                                    </option>
                                    <option value="widow" {{ old('marital_status') == 'widow' ? 'selected' : '' }}>Widow
                                    </option>
                                </select>
                                @error('marital_status')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-main w-100" onclick="nextStep(2)">Next</button>
                    <div class="text-center mt-3">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold text-muted">
                            Skip profile setup →
                        </a>
                    </div>
                </div>

                <!-- STEP 2: Professional & Location -->
                <div id="step2" class="hidden">
                    <div class="section">
                        <h4>Professional Details</h4>
                        <input type="text" name="education" class="form-control mb-3" placeholder="Education"
                            value="{{ old('education') }}">
                        @error('education')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror

                        <input type="text" name="profession" class="form-control mb-3" placeholder="Profession"
                            value="{{ old('profession') }}">
                        @error('profession')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror

                        <h4 class="mt-4">Location & Image</h4>
                        <div class="row g-3">
                            @php
                                $oldCountry = old('country' ?? '');
                                $oldState = old('state' ?? '');
                                $oldCity = old('city' ?? '');
                            @endphp
                            <div class="col-md-4">
                                <select id="country" name="country" class="form-select data">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('country')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-4">
                                <select id="state" name="state" class="form-select data">
                                    <option value="">Select State</option>
                                </select>

                                @error('state')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-4">
                                <select id="city" name="city" class="form-select data">
                                    <option value="">Select City</option>
                                </select>

                                @error('city')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="pb-2 ps-1">Profile Visibility</label>
                                <select name="visibility" class="form-select data">
                                    <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public
                                    </option>
                                    <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private
                                    </option>
                                </select>

                                @error('visibility')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="pb-2 ps-1">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-3">
                        <button type="button" class="btn btn-secondary w-50" onclick="prevStep(1)">Previous</button>
                        <button type="button" class="btn-main w-50" onclick="nextStep(3)">Next</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold text-muted">
                            Skip profile setup →
                        </a>
                    </div>
                </div>

                <!-- STEP 3: Partner Preferences -->
                <div id="step3" class="hidden">
                    <div class="section">
                        <h4>Partner Preferences</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="step-text" id="steptext"></div>
                                <input type="number" name="preferences[age_min]" class="form-control" placeholder="Age Min"
                                    value="{{ old('preferences.age_min') }}">

                                @error('preferences.age_min')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-md-6">
                                <input type="number" name="preferences[age_max]" class="form-control" placeholder="Age Max"
                                    value="{{ old('preferences.age_max') }}">

                                @error('preferences.age_max')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6">
                                <input type="text" name="preferences[religion]" class="form-control"
                                    placeholder="Preferred Religion" value="{{ old('preferences.religion') }}">

                                @error('preferences.religion')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="preferences[cast]" class="form-control"
                                    placeholder="Preferred Community/Caste" value="{{ old('preferences.cast') }}">

                                @error('preferences.cast')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6">
                                <label class="pb-2 ps-1">Preferred Marital Status</label>
                                <select name="preferences[marital_status][]" class="form-select data">
                                    <option value="">Select Marital Status</option>
                                    <option value="single" {{ old('preferences.marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="divorced" {{ old('preferences.marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widow" {{ old('preferences.marital_status') == 'widow' ? 'selected' : '' }}>Widow</option>
                                </select>

                                @error('preferences.marital_status.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6">
                                <label class="pb-2 ps-1">Preferred Profession</label>
                                <input type="text" name="preferences[profession][]"
                                    value="{{ is_array(old('preferences.profession')) ? implode(', ', old('preferences.profession')) : old('preferences.profession') }}"
                                    class="form-control">

                                @error('preferences.profession.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-12">
                                <select name="preferences[location][]" class="form-select data">
                                    <option value="">Select Prefered location</option>
                                    <!-- India -->
                                    <option value="India,Gujarat,Rajkot" {{ in_array('India,Gujarat,Rajkot', old('preferences.location', [])) ? 'selected' : '' }}>India,Gujarat,Rajkot</option>
                                    <option value="India,Gujarat,Ahmedabad" {{ in_array('India,Gujarat,Ahmedabad', old('preferences.location', [])) ? 'selected' : '' }}>India,Gujarat,Ahmedabad
                                    </option>
                                    <option value="India,Gujarat,Surat" {{ in_array('India,Gujarat,Surat', old('preferences.location', [])) ? 'selected' : '' }}>India,Gujarat,Surat</option>
                                    <option value="India,Maharashtra,Mumbai" {{ in_array('India,Maharashtra,Mumbai', old('preferences.location', [])) ? 'selected' : '' }}>India,Maharashtra,Mumbai
                                    </option>
                                    <option value="India,Maharashtra,Pune" {{ in_array('India,Maharashtra,Pune', old('preferences.location', [])) ? 'selected' : '' }}>India,Maharashtra,Pune
                                    </option>
                                    <option value="India,Rajasthan,Jaipur" {{ in_array('India,Rajasthan,Jaipur', old('preferences.location', [])) ? 'selected' : '' }}>India,Rajasthan,Jaipur
                                    </option>
                                    <option value="India,Rajasthan,Udaipur" {{ in_array('India,Rajasthan,Udaipur', old('preferences.location', [])) ? 'selected' : '' }}>India,Rajasthan,Udaipur
                                    </option>
                                    <option value="India,Karnataka,Bengaluru" {{ in_array('India,Karnataka,Bengaluru', old('preferences.location', [])) ? 'selected' : '' }}>India,Karnataka,Bengaluru
                                    </option>
                                    <option value="India,Karnataka,Mysuru" {{ in_array('India,Karnataka,Mysuru', old('preferences.location', [])) ? 'selected' : '' }}>India,Karnataka,Mysuru
                                    </option>
                                    <option value="India,Tamil Nadu,Chennai" {{ in_array('India,Tamil Nadu,Chennai', old('preferences.location', [])) ? 'selected' : '' }}>India,Tamil
                                        Nadu,Chennai</option>
                                    <option value="India,Tamil Nadu,Coimbatore" {{ in_array('India,Tamil Nadu,Coimbatore', old('preferences.location', [])) ? 'selected' : '' }}>India,Tamil
                                        Nadu,Coimbatore</option>

                                    <!-- USA -->
                                    <option value="USA,California,Los Angeles" {{ in_array('USA,California,Los Angeles', old('preferences.location', [])) ? 'selected' : '' }}>USA,California,Los
                                        Angeles</option>
                                    <option value="USA,California,San Francisco" {{ in_array('USA,California,San Francisco', old('preferences.location', [])) ? 'selected' : '' }}>USA,California,San
                                        Francisco</option>
                                    <option value="USA,New York,New York City" {{ in_array('USA,New York,New York City', old('preferences.location', [])) ? 'selected' : '' }}>USA,New York,New York
                                        City</option>
                                    <option value="USA,Texas,Houston" {{ in_array('USA,Texas,Houston', old('preferences.location', [])) ? 'selected' : '' }}>
                                        USA,Texas,Houston</option>
                                    <option value="USA,Florida,Miami" {{ in_array('USA,Florida,Miami', old('preferences.location', [])) ? 'selected' : '' }}>
                                        USA,Florida,Miami</option>

                                    <!-- UK -->
                                    <option value="UK,England,London" {{ in_array('UK,England,London', old('preferences.location', [])) ? 'selected' : '' }}>
                                        UK,England,London</option>
                                    <option value="UK,Scotland,Edinburgh" {{ in_array('UK,Scotland,Edinburgh', old('preferences.location', [])) ? 'selected' : '' }}>UK,Scotland,Edinburgh</option>
                                    <option value="UK,Wales,Cardiff" {{ in_array('UK,Wales,Cardiff', old('preferences.location', [])) ? 'selected' : '' }}>
                                        UK,Wales,Cardiff</option>

                                    <!-- Canada -->
                                    <option value="Canada,Ontario,Toronto" {{ in_array('Canada,Ontario,Toronto', old('preferences.location', [])) ? 'selected' : '' }}>Canada,Ontario,Toronto
                                    </option>
                                    <option value="Canada,British Columbia,Vancouver" {{ in_array('Canada,British Columbia,Vancouver', old('preferences.location', [])) ? 'selected' : '' }}>
                                        Canada,British Columbia,Vancouver
                                    </option>
                                    <option value="Canada,Alberta,Calgary" {{ in_array('Canada,Alberta,Calgary', old('preferences.location', [])) ? 'selected' : '' }}>Canada,Alberta,Calgary
                                    </option>

                                    <!-- Australia -->
                                    <option value="Australia,New South Wales,Sydney" {{ in_array('Australia,New South Wales,Sydney', old('preferences.location', [])) ? 'selected' : '' }}>Australia,New
                                        South Wales,Sydney
                                    </option>
                                    <option value="Australia,Victoria,Melbourne" {{ in_array('Australia,Victoria,Melbourne', old('preferences.location', [])) ? 'selected' : '' }}>Australia,Victoria,Melbourne
                                    </option>
                                    <option value="Australia,Queensland,Brisbane" {{ in_array('Australia,Queensland,Brisbane', old('preferences.location', [])) ? 'selected' : '' }}>Australia,Queensland,Brisbane</option>

                                    <!-- Germany -->
                                    <option value="Germany,Bavaria,Munich" {{ in_array('Germany,Bavaria,Munich', old('preferences.location', [])) ? 'selected' : '' }}>Germany,Bavaria,Munich
                                    </option>
                                    <option value="Germany,Berlin,Berlin" {{ in_array('Germany,Berlin,Berlin', old('preferences.location', [])) ? 'selected' : '' }}>Germany,Berlin,Berlin</option>
                                    <option value="Germany,Hesse,Frankfurt" {{ in_array('Germany,Hesse,Frankfurt', old('preferences.location', [])) ? 'selected' : '' }}>Germany,Hesse,Frankfurt
                                    </option>
                                </select>

                                @error('preferences.location.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Partner Personality Traits</label>

                                <select id="skills" name="preferences[personality][]" multiple class="w-full"
                                    data-placeholder="Select personality traits">
                                    <option value="Caring" {{ in_array('Caring', old('preferences.personality', [])) ? 'selected' : '' }}>Caring</option>
                                    <option value="Calm" {{ in_array('Calm', old('preferences.personality', [])) ? 'selected' : '' }}>Calm</option>
                                    <option value="Supportive" {{ in_array('Supportive', old('preferences.personality', [])) ? 'selected' : '' }}>Supportive</option>
                                    <option value="Honest" {{ in_array('Honest', old('preferences.personality', [])) ? 'selected' : '' }}>Honest</option>
                                    <option value="Romantic" {{ in_array('Romantic', old('preferences.personality', [])) ? 'selected' : '' }}>Romantic</option>
                                    <option value="Ambitious" {{ in_array('Ambitious', old('preferences.personality', [])) ? 'selected' : '' }}>Ambitious</option>
                                    <option value="Family Oriented" {{ in_array('Family Oriented', old('preferences.personality', [])) ? 'selected' : '' }}>Family Oriented</option>
                                    <option value="Loyal" {{ in_array('Loyal', old('preferences.personality', [])) ? 'selected' : '' }}>Loyal</option>
                                    <option value="Spiritual" {{ in_array('Spiritual', old('preferences.personality', [])) ? 'selected' : '' }}>Spiritual</option>
                                    <option value="Funny" {{ in_array('Funny', old('preferences.personality', [])) ? 'selected' : '' }}>Funny</option>
                                </select>

                                @error('preferences.personality')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>

                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-3">
                        <button type="button" class="btn btn-secondary w-50" onclick="prevStep(2)">Previous</button>
                        <button type="submit" class="btn-main w-50">Submit</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none fw-semibold text-muted">
                            Skip profile setup →
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>


    </script>
    <script>
        const btn = document.getElementById('profileImage');
        const upload = document.getElementById('profileUpload');

        btn.addEventListener('click', () => upload.click());
    </script>

    <script>
        window.profileLocation = {
            country: "{{ $oldCountry }}",
            state: "{{ $oldState }}",
            city: "{{ $oldCity }}"
        };
    </script>

@endsection