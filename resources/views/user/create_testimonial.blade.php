@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Add Testimonial</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('testimonial.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <!-- <label>Profile ID</label> -->
                <input type="hidden" name="profile_id" class="form-control" value="{{ $profile->id }}" readonly>
            </div>

            <div class="mb-3">
                <label>Couple Name</label>
                <input type="text" name="couple_name" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Married">Married</option>
                    <option value="Engaged">Engaged</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-primary">Save Testimonial</button>
        </form>
    </div>
@endsection