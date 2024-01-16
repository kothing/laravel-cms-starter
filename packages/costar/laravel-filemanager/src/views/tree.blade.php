<div class="m-3 d-block d-lg-none">
  <h1 style="font-size: 1.5rem;">Laravel File Manager</h1>
  <div class="row mt-3">
    <img src="{{ asset('vendor/laravel-filemanager/img/72px-color.png') }}" class="w-40">
  </div>
</div>

<ul class="nav nav-pills flex-column">
  @foreach($root_folders as $root_folder)
    <li class="nav-item">
      <a class="nav-link" href="#" data-type="0" data-path="{{ $root_folder->url }}">
        <i class="fa fa-folder fa-fw"></i> {{ $root_folder->name }}
      </a>
    </li>
    @foreach($root_folder->children as $directory)
    <li class="nav-item sub-item">
      <a class="nav-link" href="#" data-type="0" data-path="{{ $directory->url }}">
        <i class="fa fa-folder fa-fw"></i> {{ $directory->name }}
      </a>
    </li>
    @endforeach
  @endforeach
</ul>
