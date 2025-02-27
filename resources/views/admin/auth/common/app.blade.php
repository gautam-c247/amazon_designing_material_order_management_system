@include('admin.auth.common.header', ['title' => $title])

@yield('content')

@include('admin.common.footer')
@yield('scripts')
