@extends('layouts.app')

@section('content')
    <!--begin: Wizard-->
    <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="first" data-wizard-clickable="true">

        <!--begin: Wizard Body-->
        <div class="row justify-content-center py-10 px-8 py-lg-12 px-lg-10">
            @yield('contents')
        </div>
        <!--end: Wizard Body-->
    </div>
    <!--end: Wizard-->
@endsection
