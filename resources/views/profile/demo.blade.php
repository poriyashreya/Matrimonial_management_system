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
                                <label class="pb-2 ps-1">Gender</label>
                                <select name="gender" class="form-select data">
                                    <option value="">Select</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>

                                @error('gender')
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

                            <div class="col-md-6">
                                <label class="pb-2 ps-1">Community</label>
                                <input type="text" name="community" class="form-control" value="{{ old('community') }}">
                                @error('community')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="pb-2 ps-1">Marital Status</label>
                                <select name="marital_status" class="form-select data">
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
                            <div class="col-md-4">
                                <select id="country" name="country" class="form-select data">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                </div>

                <!-- STEP 3: Partner Preferences -->
                <!-- STEP 3: Partner Preferences -->
                <div id="step3" class="hidden">
                    <div class="section">
                        <h4>Partner Preferences</h4>
                        <div class="row g-3">

                            <!-- Age Min -->
                            <div class="col-md-6">
                                <input type="number" name="preferences[age_min]" class="form-control" placeholder="Age Min"
                                    value="{{ old('preferences.age_min') }}">
                                @error('preferences.age_min')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Age Max -->
                            <div class="col-md-6">
                                <input type="number" name="preferences[age_max]" class="form-control" placeholder="Age Max"
                                    value="{{ old('preferences.age_max') }}">
                                @error('preferences.age_max')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preferred Religion -->
                            <div class="col-md-6">
                                <input type="text" name="preferences[religion]" class="form-control"
                                    placeholder="Preferred Religion" value="{{ old('preferences.religion') }}">
                                @error('preferences.religion')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preferred Community/Caste -->
                            <div class="col-md-6">
                                <input type="text" name="preferences[cast]" class="form-control"
                                    placeholder="Preferred Community/Caste" value="{{ old('preferences.cast') }}">
                                @error('preferences.cast')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preferred Marital Status -->
                            <div class="col-md-6">
                                <select name="preferences[marital_status][]" class="form-select">
                                    <option value="">Select Marital Status</option>
                                    <option value="single" {{ in_array('single', old('preferences.marital_status', [])) ? 'selected' : '' }}>Single</option>
                                    <option value="divorced" {{ in_array('divorced', old('preferences.marital_status', [])) ? 'selected' : '' }}>Divorced</option>
                                    <option value="widow" {{ in_array('widow', old('preferences.marital_status', [])) ? 'selected' : '' }}>Widow</option>
                                </select>
                                @error('preferences.marital_status.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preferred Profession -->
                            <div class="col-md-6">
                                <input type="text" name="preferences[profession][]" class="form-control"
                                    placeholder="Preferred Profession(s) e.g. Engineer, Doctor"
                                    value="{{ old('preferences.profession.0') }}">
                                @error('preferences.profession.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preferred Location (single select, optional) -->
                            <div class="col-md-12">
                                <select name="preferences[location][]" class="form-select">
                                    <option value="">Select Preferred Location</option>
                                    <option value="India,Gujarat,Rajkot" {{ in_array('India,Gujarat,Rajkot', old('preferences.location', [])) ? 'selected' : '' }}>India,Gujarat,Rajkot</option>
                                    <option value="India,Gujarat,Ahmedabad" {{ in_array('India,Gujarat,Ahmedabad', old('preferences.location', [])) ? 'selected' : '' }}>India,Gujarat,Ahmedabad
                                    </option>
                                    <option value="India,Gujarat,Surat" {{ in_array('India,Gujarat,Surat', old('preferences.location', [])) ? 'selected' : '' }}>India,Gujarat,Surat</option>
                                    <option value="India,Maharashtra,Mumbai" {{ in_array('India,Maharashtra,Mumbai', old('preferences.location', [])) ? 'selected' : '' }}>India,Maharashtra,Mumbai
                                    </option>
                                    <option value="India,Maharashtra,Pune" {{ in_array('India,Maharashtra,Pune', old('preferences.location', [])) ? 'selected' : '' }}>India,Maharashtra,Pune
                                    </option>
                                    <!-- Add more locations as needed -->
                                </select>
                                @error('preferences.location.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Partner Personality Traits (multi-select) -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Partner Personality Traits</label>
                                <select id="skills" name="preferences[personality][]" multiple data-placeholder="Select personality traits" class="w-full">
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

                    <!-- Step Navigation -->
                    <div class="d-flex gap-3 mt-3">
                        <button type="button" class="btn btn-secondary w-50" onclick="prevStep(2)">Previous</button>
                        <button type="submit" class="btn-main w-50">Submit</button>
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

@endsection