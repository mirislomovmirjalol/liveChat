@extends('layouts.app')

@section('content')
    <section id="hero" class="d-flex min-vh-100 align-items-start">
        <div class="container bg-light py-4" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('manage_sites') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-10 col-lg-8 offset-lg-2 offset-1">
                        <div class="row">
                            <h3>
                                Add New WebSite
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

                            <label for="url" class="col-md-4 col-form-label">Url</label>
                            <input id="url" type="text" class="form-control" required name="url"
                                   value="{{ old('url') }}" autocomplete="caption" autofocus>

                            <label for="title" class="col-md-4 col-form-label">Title</label>
                            <input id="title" type="text" class="form-control" required name="title"
                                   value="{{ old('title') }}" autocomplete="caption" autofocus>

                            <label for="description" class="col-md-4 col-form-label">Description</label>
                            <input id="description" type="text" class="form-control" required name="description"
                                   value="{{ old('description') }}" autocomplete="caption" autofocus>

                            <label for="welcome_text" class="col-md-4 col-form-label">Welcome text</label>
                            <input id="welcome_text" type="text" class="form-control" name="welcome_text"
                                   value="{{ old('welcome_text') }}" autocomplete="caption" autofocus>

                            <label for="logo" class="col-md-4 col-form-label">Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                        </div>

                        <div class="row pt-4">
                            <button class="btn btn-primary">
                                Add New WebSite
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section><!-- End Hero -->
@endsection
