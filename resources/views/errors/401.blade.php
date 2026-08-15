@extends('errors::minimal')

@section('title', __('Tidak Terautentikasi'))
@section('code', '401')
@section('message', __('Otorisasi Diperlukan'))
@section('description', __('Anda harus masuk terlebih dahulu untuk mengakses sumber daya yang diminta.'))

