@extends('layouts.site')

@section('content')
    <h2 class="text-center">
        Operators
    </h2>


    <div class="w-75 text-left mx-auto mt-4">
        <div class="d-flex my-4 justify-content-end">
            <div class="dropdown">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle px-4" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Add
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="btn btn-primary dropdown-item">
                            Attach Existed Operator
                        </a>
                        <a href="{{ route('site.showOperator') }}" class="btn btn-primary dropdown-item">
                            Create New Operator
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    Email
                </td>
            </tr>
            @foreach($websiteOperators as $websiteOperator)
            <tr>
                <td>
                    {{ $websiteOperator->user->name }}
                </td>
                <td>
                    {{ $websiteOperator->user->email }}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
