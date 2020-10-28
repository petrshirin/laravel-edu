@extends('layouts.base')

@section('title')
    Мой календарь
@stop


@section('content')
    @include('layouts.calendar')
    @include('layouts.taskForm')
@stop
