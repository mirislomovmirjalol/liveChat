@extends('layouts.app')

@section('content')
    <section id="hero" class="d-flex min-vh-100 align-items-start">
        <div class="container bg-light py-4" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('site.createOperator') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-10 col-lg-8 offset-lg-2 offset-1">
                        <div class="row">
                            <h3>
                                Add New Operator
                            </h3>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label">Name</label>
                            <input id="name" type="text" class="form-control" required name="name"
                                   value="{{ old('name') }}" autocomplete="caption" autofocus>

                            <label for="email" class="col-md-4 col-form-label">Email</label>
                            <input id="email" type="text" class="form-control" required name="email"
                                   value="{{ old('email') }}" autocomplete="caption" autofocus>

                            <label for="password" class="col-md-4 col-form-label">Password</label>
                            <input id="password" type="password" class="form-control" required name="password"
                                   value="{{ old('password') }}" autocomplete="caption" autofocus>

                            <label for="password-confirm" class="col-md-4 col-form-label">Password Confirm</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                            @isset($website)
                                <label for="website" class="col-md-4 col-form-label">Website</label>
                                <input id="website" type="password" class="form-control" disabled placeholder="{{ $website->name }}">
                                <input type="hidden" name="website_id" value="{{ $website->id }}">
                            @endisset
                        </div>

                        <div class="row pt-4">
                            <button class="btn btn-primary">
                                Add New Operator
                            </button>
                            <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section><!-- End Hero -->
@endsection
