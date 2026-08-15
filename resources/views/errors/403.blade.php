@extends('errors::minimal')

@section('title', __('Akses Ditolak'))
@section('code', '403')
@section('message', __('Akses Tidak Diizinkan'))
@section('description', __($exception->getMessage() ?: 'Anda tidak memiliki hak akses atau izin untuk melihat halaman ini.'))

