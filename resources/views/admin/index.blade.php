@extends('layouts.master')


@section('title', 'Admin Panel')
@section('header', 'Admin Panel')



@section('content')

    <a class="btn btn-primary" href="{{action('AdminController@refreshMigrations')}}/true">Refresh Migrations</a>
    <a class="btn btn-primary" href="{{action('AdminController@refreshMigrations')}}">Run Migrations</a>

@endsection

