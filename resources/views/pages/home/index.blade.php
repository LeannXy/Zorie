@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')
    @include('pages.home.sections.hero')
    @include('pages.home.sections.featured-products')
    @include('pages.home.sections.best-sellers')
    @include('pages.home.sections.banners')
    @include('pages.home.sections.features')
    @include('pages.home.sections.categories')
    @include('pages.home.sections.services')
    @include('pages.home.sections.testimonials') 
    @include('pages.home.sections.footer')
 

@endsection