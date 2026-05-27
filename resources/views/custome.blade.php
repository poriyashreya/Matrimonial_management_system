<div class="profile-card-modern">
    @foreach($profiles as $profile)

        <div class="col-md-4">
            <div class="profile-card-modern">
                <div class="profile-img-wrapper">
                    <img src="{{ $profile->images->first() ? asset($profile->images->first()->file_path) : 'https://via.placeholder.com/300' }}"
                        class="w-100">
                    @if($profile->is_premium)
                        <span class="premium-badge">Premium</span>
                    @endif
                </div>
                <div class="profile-info">
                    <h5 class="hover-name">{{ $profile->user->name }}, {{ $profile->age }}</h5>
                    <p class="hover-sub">{{ $profile->profession }}</p>
                    <div class="profile-tags my-3">
                        <span>{{ $profile->religion }}</span>
                        <span>{{ $profile->community }}</span>
                    </div>
                    <a href="{{ route('user.show', $profile->id) }}" class="btn btn-view-modern">View
                        Profile</a>
                    @if($profile->requestStatus === 'friends')
                        <span class="badge bg-success">💖 Connected</span>

                    @elseif($profile->requestStatus === 'sent')
                        <span class="badge bg-secondary">📩 Request Sent</span>

                    @elseif($profile->requestStatus === 'received')
                        <span class="badge bg-warning">📥 Request Received</span>

                    @elseif($profile->requestStatus === 'blocked')
                        <span class="badge bg-dark">⛔ Blocked</span>
                    @endif

                    {{-- ACTION BUTTON --}}
                    @if($profile->requestStatus === null)
                        <form method="POST" action="{{ route('request.send', $profile->id) }}">
                            @csrf
                            <button class="btn btn-primary btn-sm mt-2">💌 Follow</button>
                        </form>
                    @endif

                    <a href="{{ url()->previous() }}" class="btn edit-cancel-btn">
                        Back
                    </a>
                    <div class="mb-3"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>




<!-- profile.index.blade.php  -->
@foreach($profiles as $profile)
    <div class="col-md-4">
        <div class="profile-card-modern">
            <div class="profile-img-wrapper">
                <img src="{{ $profile->images->first() ? asset($profile->images->first()->file_path) : 'https://via.placeholder.com/300' }}"
                    class="w-100">
                @if($profile->is_premium)
                    <span class="premium-badge">Premium</span>
                @endif
            </div>
            <div class="profile-info">
                <h5 class="hover-name">{{ $profile->user->name }}, {{ $profile->age }}</h5>
                <p class="hover-sub">{{ $profile->profession }}</p>
                <div class="profile-tags my-3">
                    <span>{{ $profile->religion }}</span>
                    <span>{{ $profile->community }}</span>
                </div>
                <!-- <a href="{{ route('user.show', $profile->id) }}" class="btn btn-view-modern">View
                                            Profile</a> -->
                @if($profile->requestStatus === 'friends')
                    <span class="badge bg-success">💖 Connected</span>

                @elseif($profile->requestStatus === 'sent')
                    <span class="badge bg-secondary">📩 Request Sent</span>

                @elseif($profile->requestStatus === 'received')
                    <span class="badge bg-warning">📥 Request Received</span>

                @elseif($profile->requestStatus === 'blocked')
                    <span class="badge bg-dark">⛔ Blocked</span>
                @endif

                {{-- ACTION BUTTON --}}
                @if($profile->requestStatus === null)
                    <form method="POST" action="{{ route('request.send', $profile->id) }}">
                        @csrf
                        <button class="btn btn-view-modern mt-2">Follow</button>
                    </form>
                @endif

                <div class="mb-3"></div>
            </div>
        </div>
    </div>
@endforeach