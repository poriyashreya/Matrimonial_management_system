@extends('layouts.app')

@section('content')

    @php
        $prefs = is_array($profile->preferences) ? $profile->preferences : json_decode($profile->preferences, true);
        $prefs = $prefs ?? [];

        // Prepare old values for multi-select / arrays
        $oldPersonality = old('preferences.personality', $prefs['personality'] ?? []);
        $oldMarital = old('preferences.marital_status', $prefs['marital_status'] ?? []);
        $oldProfession = old('preferences.profession', $prefs['profession'] ?? []);
        $oldLocation1 = old('preferences.location', $prefs['location'] ?? '');
        $oldLocation = implode(', ', $oldLocation1);

        // If somehow array comes, convert to string
        if (is_array($oldLocation)) {
            $oldLocation = implode(',', $oldLocation);
            $oldLocation = str_replace(', ', ',', $oldLocation);
        } else {
            $oldLocation1 = old('preferences.location', $prefs['location'] ?? '');
            $oldLocation = str_replace(', ', ',', $oldLocation);
        }
    @endphp

    <div class="container" style="margin-bottom: 5%;">

        <!-- PAGE HEADER -->
        <div class="edit-header mb-4 text-center">
            <h2 class="text-white animate-slide-down">Edit Profile</h2>
            <p class="text-light animate-slide-down delay-1">Update your personal details</p>

            @can('changeActivation', $profile)
                <div class="mt-3">
                    @if($profile->is_active)
                        <button class="btn btn-deactive" data-bs-toggle="modal" data-bs-target="#activationModal"
                            data-action="deactivate">
                            Deactivate Profile
                        </button>
                    @else
                        <button class="btn btn-active" data-bs-toggle="modal" data-bs-target="#activationModal"
                            data-action="activate">
                            Activate Profile
                        </button>
                    @endif
                </div>
            @endcan
        </div>

        <!-- MAIN CARD -->
        <div class="edit-card shadow-lg p-4 rounded-4 animate-fade-in">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-4 text-center border-end border-light-subtle">
                        <!-- PROFILE IMAGE -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Profile Photo</label><br>
                            <img id="profileImage"
                                src="{{ $profile->images->first() ? Storage::url($profile->images->first()->file_path) : 'https://via.placeholder.com/300' }}"
                                class="rounded-circle shadow" width="250" height="250"
                                style="object-fit:cover;cursor:pointer">
                            <input type="file" id="profileUpload" name="profile_image" class="d-none" accept="image/*">
                            @error('profile_image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BASIC INFO -->
                        <div class="mt-5 text-start">
                            <div class="profile-section text-start mb-4">
                                <h5 class="section-title">Basic Information</h5>
                                <div class="section-divider"></div>
                            </div>

                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control modern-input"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                            <label class="form-label mt-3">Email</label>
                            <input type="email" name="email" class="form-control modern-input"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                            <label class="form-label mt-3">Contact Number</label>
                            <input type="tel" name="phone" class="form-control modern-input"
                                value="{{ old('phone', $user->contact_number) }}">
                            @error('phone') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                            <label class="form-label mt-3">Age</label>
                            <input type="number" name="age" class="form-control modern-input"
                                value="{{ old('age', $profile->age) }}" required>
                            @error('age') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                            <label class="form-label mt-3">Visibility</label>
                            <select name="visibility" class="form-select modern-input">
                                <option value="public" {{ old('visibility', $profile->visibility) === 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('visibility', $profile->visibility) === 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('visibility') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                            <label class="form-label mt-3">Marital Status</label>
                            <select name="marital_status" class="form-select modern-input">
                                <option value="single" {{ old('marital_status', $profile->marital_status) === 'single' ? 'selected' : '' }}>Single</option>
                                <option value="divorced" {{ old('marital_status', $profile->marital_status) === 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widow" {{ old('marital_status', $profile->marital_status) === 'widow' ? 'selected' : '' }}>Widow</option>
                            </select>

                            @error('marital_status') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-8 ps-lg-4">
                        <div class="row">
                            <div class="profile-section mb-4">
                                <h5 class="section-title">Personal Details</h5>
                                <p class="section-subtitle">Tell us about yourself</p>
                                <div class="section-divider"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Religion</label>
                                <input type="text" name="religion" class="form-control modern-input"
                                    value="{{ old('religion', $profile->religion) }}">
                                @error('religion')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Community</label>
                                <input type="text" name="community" class="form-control modern-input"
                                    value="{{ old('community', $profile->community) }}" required>
                            </div>
                            @error('community')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            @php
                                $oldCountry = old('country', $profile->country ?? '');
                                $oldState = old('state', $profile->state ?? '');
                                $oldCity = old('city', $profile->city ?? '');
                            @endphp

                            <div class="row mt-3">

                                <!-- COUNTRY -->
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <select id="country" name="country" class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $oldCountry == $country->id ? 'selected' : '' }}>{{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @error('country')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <!-- STATE -->
                                <div class="col-md-4">
                                    <label class="form-label">State</label>
                                    <select id="state" name="state" class="form-select">
                                        <option value="">Select State</option>
                                    </select>
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @error('state')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <!-- CITY -->
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <select id="city" name="city" class="form-select">
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @error('city')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                            </div>




                            <div class="col-md-12 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" name="profession" class="form-control modern-input"
                                    value="{{ old('profession', $profile->profession) }}" required>
                            </div>

                            <!-- PARTNER PREFERENCES -->
                            <div class="col-md-12 mb-3">
                                <div class="profile-section mt-4 mb-4">
                                    <h5 class="section-title">Partner Preferences</h5>
                                    <p class="section-subtitle">Help us find the best match for you</p>
                                    <div class="section-divider"></div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="number" name="preferences[age_min]" class="form-control modern-input"
                                            placeholder="Minimum Age"
                                            value="{{ old('preferences.age_min', $prefs['age_min'] ?? '') }}">

                                        @error('preferences.age_min')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="preferences[age_max]" class="form-control modern-input"
                                            placeholder="Maximum Age"
                                            value="{{ old('preferences.age_max', $prefs['age_max'] ?? '') }}">
                                    </div>
                                    @error('preferences.age_max')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <input type="text" name="preferences[religion]" class="form-control modern-input mt-2"
                                    placeholder="Preferred Religion"
                                    value="{{ old('preferences.religion', $prefs['religion'] ?? '') }}">
                                @error('preferences.religion')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <input type="text" name="preferences[cast]" class="form-control modern-input mt-2"
                                    placeholder="Preferred cast"
                                    value="{{ old('preferences.cast', $prefs['cast'] ?? '') }}">
                                @error('preferences.cast')
                                    <div class="text-danger mt-2">{{ $message }} </div>
                                @enderror

                                <label class="mt-2">Preferred Locations</label>
                                <select name="preferences[location][]" class="form-select">
                                    <option value="India,Gujarat,Rajkot" {{ $oldLocation === 'India,Gujarat,Rajkot' ? 'selected' : '' }}>India,Gujarat,Rajkot</option>
                                    <option value="India,Gujarat,Ahmedabad" {{ $oldLocation === 'India,Gujarat,Ahmedabad' ? 'selected' : '' }}>India,Gujarat,Ahmedabad
                                    </option>
                                    <option value="India,Gujarat,Surat" {{ $oldLocation === 'India,Gujarat,Surat' ? 'selected' : '' }}>India,Gujarat,Surat</option>
                                    <option value="India,Maharashtra,Mumbai" {{ $oldLocation === 'India,Maharashtra,Mumbai' ? 'selected' : '' }}>India,Maharashtra,Mumbai
                                    </option>
                                    <option value="India,Maharashtra,Pune" {{ $oldLocation === 'India,Maharashtra,Pune' ? 'selected' : '' }}>India,Maharashtra,Pune
                                    </option>
                                    <option value="India,Rajasthan,Jaipur" {{ $oldLocation === 'India,Rajasthan,Jaipur' ? 'selected' : '' }}>India,Rajasthan,Jaipur</option>
                                    <option value="India,Rajasthan,Udaipur" {{ $oldLocation === 'India,Rajasthan,Udaipur' ? 'selected' : '' }}>India,Rajasthan,Udaipur</option>
                                    <option value="India,Karnataka,Bengaluru" {{ $oldLocation === 'India,Karnataka,Bengaluru' ? 'selected' : '' }}>India,Karnataka,Bengaluru</option>
                                    <option value="India,Karnataka,Mysuru" {{ $oldLocation === 'India,Karnataka,Mysuru' ? 'selected' : '' }}>India,Karnataka,Mysuru</option>
                                    <option value="India,Tamil Nadu,Chennai" {{ $oldLocation === 'India,Tamil Nadu,Chennai' ? 'selected' : '' }}>India,Tamil Nadu,Chennai</option>
                                    <option value="India,Tamil Nadu,Coimbatore" {{ $oldLocation === 'India,Tamil Nadu,Coimbatore' ? 'selected' : '' }}>India,Tamil Nadu,Coimbatore</option>

                                    <!-- USA -->
                                    <option value="USA,California,Los Angeles" {{ $oldLocation === 'USA,California,Los Angeles' ? 'selected' : '' }}>USA,California,Los Angeles</option>
                                    <option value="USA,California,San Francisco" {{ $oldLocation === 'USA,California,San Francisco' ? 'selected' : '' }}>USA,California,San Francisco</option>
                                    <option value="USA,New York,New York City" {{ $oldLocation === 'USA,New York,New York City' ? 'selected' : '' }}>USA,New York,New York City</option>
                                    <option value="USA,Texas,Houston" {{ $oldLocation === 'USA,Texas,Houston' ? 'selected' : '' }}>USA,Texas,Houston</option>
                                    <option value="USA,Florida,Miami" {{ $oldLocation === 'USA,Florida,Miami' ? 'selected' : '' }}>USA,Florida,Miami</option>
                                    <!-- UK -->
                                    <option value="UK,England,London" {{ $oldLocation === 'UK,England,London' ? 'selected' : '' }}>UK,England,London</option>
                                    <option value="UK,Scotland,Edinburgh" {{ $oldLocation === 'UK,Scotland,Edinburgh' ? 'selected' : '' }}>UK,Scotland,Edinburgh</option>
                                    <option value="UK,Wales,Cardiff" {{ $oldLocation === 'UK,Wales,Cardiff' ? 'selected' : '' }}>UK,Wales,Cardiff</option>

                                    <!-- Canada -->
                                    <option value="Canada,Ontario,Toronto" {{ $oldLocation === 'Canada,Ontario,Toronto' ? 'selected' : '' }}>Canada,Ontario,Toronto</option>
                                    <option value="Canada,British Columbia,Vancouver" {{ $oldLocation === 'Canada,British Columbia,Vancouver' ? 'selected' : '' }}>Canada,British Columbia,Vancouver
                                    </option>
                                    <option value="Canada,Alberta,Calgary" {{ $oldLocation === 'Canada,Alberta,Calgary' ? 'selected' : '' }}>Canada,Alberta,Calgary</option>

                                    <!-- Australia -->
                                    <option value="Australia,New South Wales,Sydney" {{ $oldLocation === 'Australia,New South Wales,Sydney' ? 'selected' : '' }}>Australia,New South Wales,Sydney
                                    </option>
                                    <option value="Australia,Victoria,Melbourne" {{ $oldLocation === 'Australia,Victoria,Melbourne' ? 'selected' : '' }}>
                                        Australia,Victoria,Melbourne</option>
                                    <option value="Australia,Queensland,Brisbane" {{ $oldLocation === 'Australia,Queensland,Brisbane' ? 'selected' : '' }}>
                                        Australia,Queensland,Brisbane</option>

                                    <!-- Germany -->
                                    <option value="Germany,Bavaria,Munich" {{ $oldLocation === 'Germany,Bavaria,Munich' ? 'selected' : '' }}>Germany,Bavaria,Munich</option>
                                    <option value="Germany,Berlin,Berlin" {{ $oldLocation === 'Germany,Berlin,Berlin' ? 'selected' : '' }}>Germany,Berlin,Berlin</option>
                                    <option value="Germany,Hesse,Frankfurt" {{ $oldLocation === 'Germany,Hesse,Frankfurt' ? 'selected' : '' }}>Germany,Hesse,Frankfurt</option>
                                </select>
                                @error('preferences.location')
                                    <div class="text-danger mt-2">{{ $message }} </div>
                                @enderror


                                <label class="mt-3 form-label">Preferred Marital Status</label>
                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach(['single', 'divorced', 'widow'] as $status)
                                        <label class="pref-chip shadow-sm" style="background:#f8f9fa; cursor:pointer;">
                                            <input type="checkbox" name="preferences[marital_status][]" value="{{ $status }}" {{ in_array($status, $oldMarital) ? 'checked' : '' }}>
                                            <span class="fw-semibold text-capitalize">{{ $status }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @error('preferences.maritabl_status')
                                    <div class="text-danger mt-2">{{ $message }} </div>
                                @enderror

                                <label class="mt-3">Preferred Profession(s)</label>
                                <input type="text" name="preferences[profession][]" class="form-control modern-input"
                                    placeholder="Example: Engineer, Doctor" value="{{ implode(', ', $oldProfession) }}">
                                @error('preferences.profession')
                                    <div class="text-danger mt-2">{{ $message }} </div>
                                @enderror

                                <label class="mt-3">Personality Traits</label>

                                <select id="skills" name="preferences[personality][]" multiple class="w-full"
                                    data-placeholder="Select personality traits">
                                    <option value="Caring" {{ in_array('Caring', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Caring</option>
                                    <option value="Calm" {{ in_array('Calm', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Calm</option>
                                    <option value="Supportive" {{ in_array('Supportive', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Supportive</option>
                                    <option value="Honest" {{ in_array('Honest', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Honest</option>
                                    <option value="Romantic" {{ in_array('Romantic', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Romantic</option>
                                    <option value="Ambitious" {{ in_array('Ambitious', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Ambitious</option>
                                    <option value="Family Oriented" {{ in_array('Family Oriented', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Family
                                        Oriented</option>
                                    <option value="Loyal" {{ in_array('Loyal', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Loyal</option>
                                    <option value="Spiritual" {{ in_array('Spiritual', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Spiritual</option>
                                    <option value="Funny" {{ in_array('Funny', old('preferences.personality', $oldPersonality)) ? 'selected' : '' }}>Funny</option>
                                </select>
                                @error('preferences.personality')
                                    <div class="text-danger mt-2">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="text-end mt-4">
                    <a href="{{ route('profile.myprofile') }}" class="btn edit-cancel-btn">Cancel</a>
                    <button type="submit" class="btn save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ACTIVATION MODAL -->
    <div class="modal fade" id="activationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0">
                    <h5 id="modalTitle" class="fw-bold"></h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="modalText"></p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <form method="POST" action="{{ route('profile.changeactivation') }}">
                        @csrf
                        <input type="hidden" name="activation_action" id="activationInput">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn" id="modalConfirm">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Profile image preview
        document.getElementById('profileImage').addEventListener('click', function () {
            document.getElementById('profileUpload').click();
        });

        document.getElementById('profileUpload').addEventListener('change', function (event) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profileImage').src = e.target.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>

    <script>
        window.profileLocation = {
            country: "{{ $oldCountry }}",
            state: "{{ $oldState }}",
            city: "{{ $oldCity }}"
        };
    </script>

    <!-- sweetalert -->
    <script>
        window.flashData = {
            success: @json(session('success')),
            error: @json(session('error')),
            warning: @json(session('warning')),
            info: @json(session('info')),
        };
    </script>



@endsection