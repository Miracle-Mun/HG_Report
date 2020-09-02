@extends('layouts.container')

@section('contents')

<div class="card card-custom card-stretch" id="kt_page_stretched_card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">{{ $userData->name }}'s Profile</small></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="card-scroll">
            ...
        </div>
    </div>
</div>

@endsection