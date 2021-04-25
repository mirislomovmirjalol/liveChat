@extends('layouts.site')

@section('content')
    <h2 class="text-center">
        Attach Operators
    </h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row my-5">
        <div class="col-sm-12 col-lg-6 offset-lg-3">
            <form action="{{ route('site.operators.attached',$website->id) }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <select class="form-select form-control" aria-label="Default select example" name="operator">
                        <option selected disabled>Open this select menu</option>
                        @foreach($websiteOperators as $websiteOperator)
                            <option value="{{ $websiteOperator->id }}">{{ $websiteOperator->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-4 d-flex justify-content-end">
                    <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
                    <button class="btn btn-primary">
                        Attach
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
