@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/dt-global_style.css')}}">
    <link href="{{asset('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @livewire('habilitado.habilitado-index')
    
@endsection

@section('js')

    </script>
@endsection
