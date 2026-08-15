@extends('errors::minimal')

@section('title', __('Terjadi Kesalahan Server'))
@section('code', '500')
@section('message', __('Kesalahan Internal Server'))
@section('description', __('Maaf, terjadi kesalahan tak terduga pada server kami. Tim teknis kami sedang memperbaikinya.'))

