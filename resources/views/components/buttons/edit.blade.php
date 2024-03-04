@props(["route"=>"", "icon"=>"fas fa-edit", "title", "small"=>"", "class"=>""])

@if($route)
<a href='{{$route}}'
    class='btn btn-primary {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-toggle="tooltip"
    title="{{ __($title) }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</a>
@else
<button type="submit"
    class='btn btn-primary {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-toggle="tooltip"
    title="{{ __($title) }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif
