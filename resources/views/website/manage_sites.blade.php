@extends('layouts.app')

@section('content')
    <section id="hero" class="d-flex min-vh-100 align-items-start">
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row">

                <div class="col-lg-3 my-3" data-aos="zoom-in"
                     data-aos-delay="200">
                    <a href="{{ route('site.create') }}">
                        <div class="card-body d-flex h-100 justify-content-center align-items-center icon-box">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus-square" viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            <span class="ml-1">
                                Add Website
                            </span>
                        </div>
                    </a>
                </div>

                @foreach( $websites as $website)
                    <div class="col-lg-3 my-3">
                        <div data-aos="zoom-in"
                             data-aos-delay="200">
                            <div class="card-body icon-box">
                                <h5 class="card-title">{{ $website->website->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted"><a href="#">{{ $website->website->url }}</a></h6>
                                <p class="card-text">{{ $website->website->description }}</p>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('site.edit', $website->website) }}" class="card-link">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section><!-- End Hero -->
@endsection
