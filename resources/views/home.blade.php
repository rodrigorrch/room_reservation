@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                    <span class="col-md-4">Room Reservation</span>
                    <span class="col-md-4 text-center" id="week-selected"></span>
                    <span class="col-md-4 text-right box-datepicker-week">
                        <button class="btn btn-primary btn-sm datepicker-week">
                            <i class="fas fa-calendar-week"></i>
                        </button>
                    </span>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="table-reunion" class="table table-striped table-hover" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Horary</th>
                                <th scope="col">Monday</th>
                                <th scope="col">Tuesday</th>
                                <th scope="col">Wednesday</th>
                                <th scope="col">Thursday</th>
                                <th scope="col">Friday</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.modal')

@endsection
