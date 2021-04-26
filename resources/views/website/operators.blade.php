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
                        <a href="{{ route('site.operators.attach', ['website' => $website->id]) }}"
                           class="btn btn-primary dropdown-item {{ null == $attach ? 'disabled' : '' }}">
                            Attach Existed Operator
                        </a>
                        <a href="{{ route('site.showOperator', ['website' => $website->id]) }}" class="btn btn-primary dropdown-item">
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
                <td>
                    Action
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
                    <td>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $websiteOperator->user->id }}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Your Token</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">https://t.me/livechatappbot?start={{ $websiteOperator->user->telegram_start_token }}
                                            </textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="text-dark" data-toggle="modal" data-target="#exampleModal{{ $websiteOperator->user->id }}"><i
                                class="bi bi-eye-fill"></i></a>
                        <a href="{{ route('site.operators.toggle', [$website->id, $websiteOperator->user->id]) }}" class="text-dark"><i
                                class="bi bi-toggle2-{{ 1 == $websiteOperator->status ? 'on' : 'off' }}"></i></a>
                        <a href="{{ route('site.operators.delete', [$website->id, $websiteOperator->user->id]) }}" class="text-danger"><i
                                class="bi bi-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
