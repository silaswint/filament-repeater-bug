<!-- resources/views/auth/passwords/change.blade.php -->

@extends('layouts.app')

@section('content')
    <style>
        /* Increase space between form groups */
        .form-group {
            margin-bottom: 20px;
        }

        /* Style for error messages */
        .alert {
            margin-bottom: 20px;
        }

        /* Center the form on smaller screens */
        @media (max-width: 576px) {
            .card-body {
                text-align: center;
            }
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Change password') }}</div>

                    <div class="card-body">
                        @if (session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.change') }}">
                            @csrf

                            <div class="form-group">
                                <label for="new_password">{{ __('New password') }}:</label>
                                <input
                                    id="new_password"
                                    type="password"
                                    class="form-control"
                                    name="new_password"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">{{ __('Confirm password') }}:</label>
                                <input
                                    id="new_password_confirmation"
                                    type="password"
                                    class="form-control"
                                    name="new_password_confirmation"
                                    required
                                />
                            </div>

                            <br />
                            <button type="submit" class="btn btn-primary">
                                {{ __('Change password') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
