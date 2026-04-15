@include('layout.head')

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('layout.nave')

    {{-- Page Content --}}
    <div class="content-wrapper">
        @include('layout.header')

        {{-- Page-specific content --}}
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('layout.footer')

</div>

{{-- Scripts --}}
@include('layout.scripts')

{{-- Livewire --}}
@livewireScripts

</body>
</html>
