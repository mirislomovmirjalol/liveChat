@extends('layouts.site')

@section('content')
    <h2 class="text-center">
        About
    </h2>
    <div class="w-75 text-left mx-auto mt-4">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>Name</td>
                <td>{{ $website->name }}</td>
            </tr>
            <tr>
                <td>URL</td>
                <td>{{ $website->url }}</td>
            </tr>
            <tr>
                <td>Title</td>
                <td>{{ $website->title }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>{{ $website->description }}</td>
            </tr>
            <tr>
                <td>Welcome text</td>
                <td>{{ $website->welcome_text }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
