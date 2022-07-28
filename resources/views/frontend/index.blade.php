@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section class="section-header pb-4 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 text-center landing-box">
                <h1 class="display-1 mb-4"><img class="c-sidebar-brand-full" src="{{asset("img/iWork_5.svg")}}" height="50" alt="{{ app_name() }}"></a></h1>
                <p class="lead text-muted">
                    {!! setting('meta_description') !!}
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    
</section>



@endsection
