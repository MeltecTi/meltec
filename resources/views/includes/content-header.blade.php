<div class="container-fluid bg-primary py-5 bg-header"
    style="margin-bottom: 90px; background: linear-gradient(rgba(57, 81, 129, .7), rgba(57, 81, 129, .7)), url({{ asset('storage/pages/' . $page->image) }}), center center no-repeat; background-size: cover; ">
    <div class="row py-5">
        <div class="col-12 pt-lg-5 mt-lg-5 text-center">
            <h1 class="display-4 text-white animated zoomIn"> @yield('title') </h1>
            <p class="lead text-light">{{$page->subtitle}}</p>
        </div>
    </div>
</div>
