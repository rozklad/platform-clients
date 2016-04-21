@extends('layouts/default')

@section('page')

@foreach ( $clients as $client )

<?php var_dump($client->name); ?>

@endforeach

@stop