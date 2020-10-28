@extends('layouts.base')

@section('title')
    Мой календарь
@stop


@section('content')
    <div class="flex-row">
        <form method="POST" action="http://127.0.0.1:4000/logout" class="inline-flex">
            @csrf
            <button class="btn-primary" href="http://127.0.0.1:4000/logout" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                Logout
            </button>

        </form>
    </div>
    @include('layouts.taskList')
    @include('layouts.taskForm')
@stop
