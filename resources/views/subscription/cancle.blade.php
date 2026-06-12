@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-body text-center p-5">

                        <div class="mb-4">

                            <h1 class="text-danger display-3">
                                ❌
                            </h1>

                        </div>

                        <h2 class="fw-bold mb-3">
                            Payment Cancelled
                        </h2>

                        <p class="text-muted mb-4">
                            Your payment was cancelled. You can try again anytime.
                        </p>

                        <a href="{{ route('plans') }}" class="btn btn-primary rounded-pill px-4">

                            Back To Plans

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection