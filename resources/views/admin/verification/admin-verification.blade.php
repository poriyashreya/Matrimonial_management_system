@extends('admin.layouts.app')

@section('title', 'Verify Profiles')
@section('page-title', 'Profile Verification')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4 mb-4">

        <div class="col-12">
            <div class="card border-2 border-secondary-subtle shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                <div class="card-body p-0 table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($verifications as $v)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->email }}</td>


                                    <td>
                                        @if($v->status == 1)
                                        <span class="badge bg-success">Verified</span>
                                        @elseif($v->status == 0)
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.view-document', $v->verification_id) }}" class="btn btn-primary btn-sm">
                                            View Document
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection