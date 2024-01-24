<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="{{route('backend.dashboard')}}">
            <img class="sidebar-brand-full" src="{{asset('images/logo.svg')}}" height="46" alt="{{ app_name() }}">
            <img class="sidebar-brand-narrow" src="{{asset('images/logo.svg')}}" height="46" alt="{{ app_name() }}">
        </a>
    </div>

    {!! $admin_sidebar->asDiv( ['class' => 'sidebar-nav', 'data-coreui'=>'navigation'], ['class' => 'nav-group-items'] ) !!}

    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>