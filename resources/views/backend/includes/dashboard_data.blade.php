<script>
    var page = {!! json_encode($pages) !!};
    var post = {!! json_encode($posts) !!};
    var user = {!! json_encode($users) !!};
</script>

@php

$pagesLength = 0;
foreach($pages as $page){
    $pagesLength += 1;
}

$postsLength = 0;
foreach($posts as $post){
    $postsLength += 1;
}

$usersLength = 0;
foreach($users as $user){
    $usersLength += 1;
}

@endphp


<div class="row">
    <div class="col-8 col-lg-4">
        <div class="card mb-4">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary text-white p-3 me-3">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-primary">{{$pagesLength}}</div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">@lang("Pages")</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="{{ route('backend.pages.index') }}"><span class="small fw-semibold">View More</span>
                    <i class="fa-solid fa-circle-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-8 col-lg-4">
        <div class="card mb-4">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-info text-white p-3 me-3">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-info">{{$postsLength}}</div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">@lang("Posts")</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="{{ route('backend.posts.index') }}"><span class="small fw-semibold">View More</span>
                    <i class="fa-solid fa-circle-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-8 col-lg-4">
        <div class="card mb-4">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-danger text-white p-3 me-3">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-danger">{{$usersLength}}</div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">@lang("Users")</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="{{ route('backend.users.index') }}"><span class="small fw-semibold">View More</span>
                    <i class="fa-solid fa-circle-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<!-- /.row-->


<div class="row">
    <div class="col-sm-8 col-lg-4">
        <div class="card mb-4 text-white bg-primary">
            <div class="card-body">
                <div class="fs-4 fw-semibold">{{$pagesLength}}</div>
                <div>@lang("Pages")</div>
                <div class="progress progress-white progress-thin my-2">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-medium-emphasis-inverse">Pages helper text</small>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-8 col-lg-4">
        <div class="card mb-4 text-white bg-warning">
            <div class="card-body">
                <div class="fs-4 fw-semibold">{{$postsLength}}</div>
                <div>@lang("Posts")</div>
                <div class="progress progress-white progress-thin my-2">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-medium-emphasis-inverse">Posts helper text</small>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-8 col-lg-4">
        <div class="card mb-4 text-white bg-info">
            <div class="card-body">
                <div class="fs-4 fw-semibold">{{$usersLength}}</div>
                <div>@lang("Users")</div>
                <div class="progress progress-white progress-thin my-2">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-medium-emphasis-inverse">Users helper text</small>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<!-- /.row-->


<div class="row">
    <div class="col-sm-8 col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="fs-4 fw-semibold">{{$pagesLength}}</div>
                <div>@lang("Pages")</div>
                <div class="progress progress-thin my-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-medium-emphasis">Pages helper text</small>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-8 col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="fs-4 fw-semibold">{{$postsLength}}</div>
                <div>@lang("Posts")</div>
                <div class="progress progress-thin my-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-medium-emphasis">Posts helper text</small>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-8 col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="fs-4 fw-semibold">{{$usersLength}}</div>
                <div>@lang("Users")</div>
                <div class="progress progress-thin my-2">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-medium-emphasis">Users helper text</small>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<!-- /.row-->