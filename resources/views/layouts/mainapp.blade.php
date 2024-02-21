<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        @yield('title') &dash; {{ config('app.name') }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/assets-admin') }}/images/logo-pusaka.svg">
    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('/assets-admin') }}/css/preloader.min.css" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('/assets-admin') }}/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Choices.js -->
    <link href="{{ asset('/assets-admin') }}/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"
        integrity="sha512-is1TN9d5Tt0OFxQTczhF1BPaJRaNzbSRKjk9yvExCHuCgfROU67TpE+67x35lbHEaQmbUxZ1Xjq18pIFpxGNmg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Icons Css -->
    <link href="{{ asset('/assets-admin') }}/css/icons.min.css" rel="stylesheet" type="text/css" />

    @stack('stylesheets')

    <!-- App Css-->
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <link href="{{ asset('/assets-admin') }}/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets-admin') }}/css/custom.css" id="app-style" rel="stylesheet" type="text/css" />

    <script>
        window.baseURL = `{{ url('/') }}`;
        window.pemberdayaanURL = `{{ config('app.pemberdayaan_url') }}`;
        window.csrfToken = `{{ csrf_token() }}`;
    </script>
</head>

<body>
    <!-- <body data-layout="horizontal"> -->
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header border-bottom border-3 border-success">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('admin.index') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('/assets-admin') }}/images/logo-pusaka.svg" alt=""
                                    height="24">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('/assets-admin') }}/images/logo-pusaka.svg" alt=""
                                    height="24"> <span class="logo-txt">{{ config('app.name') }}</span>
                            </span>
                        </a>
                        <a href="{{ route('admin.index') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('/assets-admin') }}/images/logo-pusaka.svg" alt=""
                                    height="24">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('/assets-admin') }}/images/logo-pusaka.svg" alt=""
                                    height="24"> <span class="logo-txt">{{ config('app.name') }}</span>
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="search" class="icon-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Search Result">

                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" id="mode-setting-btn">
                            <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                            <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item bg-soft-light border-start border-end"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('/assets-admin') }}/images/users/avatar-10.jpg" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium">
                                {{-- @if (Auth::check() && Auth::user()->hasRole('admin_pusaka'))
                                    {{ Auth::user()->username }}
                                @else
                                    {{ Auth::user()->name }}
                                @endif --}}
                                {{ Auth::user()->name }}

                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="font-size-10 text-center mt-2">
                                <strong>{{ Auth::user()->sekolah_name }}</strong>
                            </div>
                            @if (Auth::user()->sekolah_npsn)
                                <div class="font-size-10 text-center">NPSN : {{ Auth::user()->sekolah_npsn }}</div>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.auth.login.logout') }}">
                                <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Keluar
                            </a>
                            <a class="dropdown-item" href="#" onclick="showPasswordModal(event)"
                                class="btn btn-md btn-soft-success rounded-3" data-bs-toggle="modal"
                                data-bs-target="#update-pw">
                                Update Password
                            </a>
                           
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="update-pw" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.update-password') }}" method="POST"
                        onsubmit="updatePassword(this, event)" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Update Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <input type="hidden" name="id"> --}}
                            <input type="hidden" name="_method">
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="mb-3">
                                <label class="form-label" for="password"><strong>Password</strong></label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation"><strong>Confirm
                                        Password</strong></label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light">Simpan
                                Data</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                @include('admin::partials.sidebar')
            </div>
        </div>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content min-vh-100">
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © PUSAKA DINAS PENDIDIKAN PROVINSI JAWA BARAT.
                        </div>
                        <div class="col-sm-6">
                            {{-- <div class="text-sm-end d-none d-sm-block">
                                    & Develop by <a href="#!" class="text-decoration-underline">BONET UTAMA</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('/assets-admin') }}/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('/assets-admin') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/assets-admin') }}/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('/assets-admin') }}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('/assets-admin') }}/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="{{ asset('/assets-admin') }}/libs/node-waves/waves.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- apexcharts js -->
    <script src="{{ asset('/assets-admin') }}/libs/apexcharts/apexcharts.min.js"></script>
    <!-- pace js -->
    <script src="{{ asset('/assets-admin') }}/libs/pace-js/pace.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"
        integrity="sha512-/V6Lo0GhutHcr/GhXfz1P3nSdnIgXw6sv13FOWGvkgsc9CbZYq895ff+D2yubwZQoadSiEhYhEdEBYFrEvGFww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/assets-admin') }}/js/app.js"></script>
    <script src="{{ asset('/assets-admin') }}/js/custom.js"></script>
    <script>
        const passwordElement = document.querySelector('#update-pw');
        const passwordBootstrap = new bootstrap.Modal(passwordElement);
        const $passwordElement = $(passwordElement);

        const showPasswordModal = (event) => {
            event.preventDefault();

            $passwordElement.find('.modal-title').html('Tambah Data');
            $passwordElement.find('[name="_method"]').val('POST');
            $passwordElement.find('[name="id"]').val({{ Auth::user()->id }});
            $passwordElement.find('[name="password"]').text('').val('');
            $passwordElement.find('[name="password_confirmation"]').text('').val('');

            passwordBootstrap.show();
        };

        const updatePassword = (form, event) => {
            event.preventDefault();
            $form = $(form);

            $form.find('[type="submit"]')
                .addClass('disabled')
                .attr('disabled', 'disabled')
                .html('Sedang Mengirim Data');
            let data = new FormData();

            data.append('_token', $form.find('[name="_token"]').val());
            data.append('_method', $form.find('[name="_method"]').val());
            data.append('id', $form.find('[name="id"]').val());
            data.append('password', $form.find('[name="password"]').val());
            data.append('password_confirmation', $form.find('[name="password_confirmation"]').val());
            axios({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: data
                })
                .then(responseJson => {
                    Swal.fire('Berhasil', 'Data Berhasil Ditambahkan', 'success');
                    passwordBootstrap.hide();
                })
                .catch(errorResponse => {
                    console.log(errorResponse)
                    handleErrorRequest(errorResponse);
                })
                .then(() => {
                    $form.find('[type="submit"]')
                        .removeClass('disabled')
                        .removeAttr('disabled')
                        .html('Simpan');
                });
        }
    </script>

    @if (Auth::user()->hasRole('pengawas'))
        @include('admin.layouts.pengawas-update-sekolah')
    @endif

    @stack('scripts')

</body>

</html>
