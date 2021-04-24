@extends('layouts.site')

@section('content')
    <h2 class="text-center">
        Conversations
    </h2>

    <div class="w-75 text-left mx-auto mt-4">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>
                    operator
                </td>
                <td>
                    time
                </td>
            </tr>
            @foreach($conversations as $conversation)
                <tr>
                    <td>
                        <a href="{{ route('admin.chat',[$website->id,$conversation->id]) }}">
                            {{ $conversation->operator->user->name }}
                        </a>
                    </td>
                    <td>
                        {{ $conversation->updated_at }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
