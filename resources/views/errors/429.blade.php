@extends('errors::minimal')

@section('title', __('Terlalu Banyak Permintaan'))
@section('code', '429')
@section('message', __('Terlalu Banyak Permintaan'))
@section('description', __('Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. Mohon tunggu beberapa saat sebelum mencoba kembali.'))

