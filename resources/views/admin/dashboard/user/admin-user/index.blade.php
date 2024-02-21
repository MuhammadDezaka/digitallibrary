@extends('admin::layouts.mainapp')

@section('title', 'Admin')

@push('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"
        integrity="sha512-is1TN9d5Tt0OFxQTczhF1BPaJRaNzbSRKjk9yvExCHuCgfROU67TpE+67x35lbHEaQmbUxZ1Xjq18pIFpxGNmg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h5 class="mb-sm-0 font-size-18">Data Pengguna Admin</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form onsubmit="doSearch(event)" class="row gx-3 gy-2 align-items-center mb-3">
                        <div class="col-sm-2">
                            <input type="text" name="keyword" class="form-control" id="specificSizeInputName"
                                placeholder="Cari Data ..." autocomplete="off">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-pink"><i class="fas fa-search"></i></button>
                            <a href="#" onclick="showCreateModal(event)" class="btn btn-soft-success"><i
                                    class="fas fa-plus"></i>
                                Buat Pengguna Baru</a>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="table">
                            <thead class="bg-green-pusaka text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Password</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="col-md-12 bg-light pt-2 pb-2 d-flex justify-content-between">
                            <div class="col-8">
                                <nav aria-label="Page navigation example" id="pagination-container">

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin::modules.admin-user.create')

    @include('admin::modules.admin-user.change-password')

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"
        integrity="sha512-/V6Lo0GhutHcr/GhXfz1P3nSdnIgXw6sv13FOWGvkgsc9CbZYq895ff+D2yubwZQoadSiEhYhEdEBYFrEvGFww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const modalElement = document.querySelector('#modal');
        const modalBootstrap = new bootstrap.Modal(modalElement);
        const $modalElement = $(modalElement);

        var modalChangePassword = new bootstrap.Modal(document.getElementById('change-password'));
        var $modalChangePassword = $(modalChangePassword._element);

        /**
         * Change Password
         */
        const changePassword = (element, event) => {
            event.preventDefault();
            let userId = element.getAttribute('data-id');
            $modalChangePassword.find('input[name="id"]').val(userId)
                .promise()
                .done(() => {
                    modalChangePassword.show();
                });
        };

        /**
         * Do Change Password
         */
        const doChangePassword = (element, event) => {
            event.preventDefault();
            element = $(element);
            element.find('button[type="submit"]')
                .addClass('disabled')
                .attr('disabled', 'disabled')
                .html(`<i class="fa fw-fw fa-circle-notch fa-spin"></i> Sedang mengirim data`);

            axios({
                    url: element.attr('action'),
                    method: 'POST',
                    data: element.serialize()
                })
                .then(resultJson => {
                    Swal.fire('Berhasil', 'Password Akun berhasil di reset', 'success');

                    element.find('input[name="id"]').val('');
                    element.find('input[name="password"]').val('');
                    element.find('input[name="password_confirmation"]').val('');

                    element.find('button[type="submit"]')
                        .removeClass('disabled')
                        .removeAttr('disabled')
                        .html(`Simpan`);

                    modalChangePassword.hide();
                })
                .catch(errorResponse => {
                    element.find('button[type="submit"]')
                        .removeClass('disabled')
                        .removeAttr('disabled')
                        .html(`Simpan`);

                    handleErrorRequest(errorResponse);
                })
        }

        /**
         * Show Create Modal
         */
        const showCreateModal = (event) => {
            event.preventDefault();

            $modalElement.find('.modal-title').html('Tambah Data Baru');
            $modalElement.find('[name="id"]').val('');
            $modalElement.find('[name="_method"]').val('POST');
            $modalElement.find('[name="name"]').val('');
            $modalElement.find('[name="email"]').val('');
            $modalElement.find('[name="username"]').val('');
            $modalElement.find('[name="role_id"]').val('');
            $modalElement.find('[name="password"]').val('');
            $modalElement.find('[name="password_confirmation"]').val('');
            $modalElement.find('[name="sekolah_id"]').val('');
            $modalElement.find('[name="kcd_id"]').val('');
            $('#select2-dropdown').val(null);

            $modalElement.find('#input-kcd')
                .addClass('d-none')
                .removeClass('d-block');

            $modalElement.find('#input-sekolah')
                .addClass('d-none')
                .removeClass('d-block');

            $modalElement.find('#input-password')
                .addClass('d-block')
                .removeClass('d-none');

            modalBootstrap.show();
        };

        /**
         * Create OR Update
         */
        const createOrUpdate = (form, event) => {
            event.preventDefault();
            $form = $(form);

            $form.find('[type="submit"]')
                .addClass('disabled')
                .attr('disabled', 'disabled')
                .html('Sedang Mengirim Data');

            axios({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: $form.serialize()
                })
                .then(responseJson => {
                    // Show Success Information
                    Swal.fire('Berhasil', 'Data Berhasil Ditambahkan', 'success');
                    // Close Modal
                    modalBootstrap.hide();
                    // Refresh Tables
                    table.loadDataTables();
                })
                .catch(errorResponse => {
                    handleErrorRequest(errorResponse);
                })
                .then(() => {
                    $form.find('[type="submit"]')
                        .removeClass('disabled')
                        .removeAttr('disabled')
                        .html('Simpan');
                });
        };

        /**
         * Edit Row
         */
        const editRow = (element, event) => {
            event.preventDefault();

            let json = JSON.parse(element.getAttribute('data-json'));

            $modalElement.find('.modal-title').html('Edit Data');
            $modalElement.find('[name="id"]').val(json.id);
            $modalElement.find('[name="_method"]').val('PUT');
            $modalElement.find('[name="name"]').val(json.name);
            $modalElement.find('[name="email"]').val(json.email);
            $modalElement.find('[name="username"]').val(json.username);
            $modalElement.find('[name="kcd_id"]').val(json.kcd_id);

            if (json.roles.length > 0) {
                $modalElement.find('[name="role_id"]').val(json.roles[0].id);
            } else {
                $modalElement.find('[name="role_id"]').val('');
            }

            let sekolahVal = ''
            
            if (json.pengawas) {
                json.pengawas.forEach((data) => {
                    sekolahVal += `<option value="${data.sekolah_id}" selected>${data.name}</option>`
                })
            }

            $('#select2-dropdown').html(sekolahVal);

            if (json.roles.length > 0) {

                updateForm(json.roles[0].id)

            }

            $modalElement.find('#input-password')
                .addClass('d-none')
                .removeClass('d-block');

            modalBootstrap.show();
        };

        /**
         * Delete Row
         */
        const deleteRow = (element, event) => {
            event.preventDefault();
            showDeleteConfirmation()
                .then(result => {
                    if (result.status) {
                        showLoadingSwal();
                        axios({
                                url: `/admin/admin-user`,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: element.getAttribute('data-id')
                                }
                            })
                            .then(resultJson => {
                                Swal.close();
                                Swal.fire('Success', 'Data Pengguna Berhasil Dihapus', 'success');
                                table.loadDataTables();
                            })
                            .catch(errorResponse => {
                                Swal.close();
                                handleErrorRequest(errorResponse);
                            });
                    }
                })
        };

        /**
         * Do Search
         */
        const doSearch = (event) => {
            event.preventDefault();
            table.loadDataTables();
        };

        /**
         * Table
         */
        const table = {
            baseURL: `{{ route('admin.admin-user.tables') }}`,
            element: $('#table'),
            setLoadingState() {
                this.element.find('tbody').html(`
                    <tr class="text-warning">
                        <td colspan="${this.element.find('thead th').length}">
                            <i class="fa fa-fw fa-circle-notch fa-spin"></i> Mohon tunggu, sedang memuat data ...
                        </td>
                    </tr>
                `);
            },
            render(resultJson) {
                let htmlRows = ``;
                resultJson.forEach(row => {
                    let htmlRow = $(`
                        <tr>
                            <td><input type="checkbox" value="${row.id}" name="id[]" /></td>
                            <td class="td-name"></td>
                            <td class="td-username"></td>
                            <td class="td-email"></td>
                            <td class="td-role text-center"></td>
                            <td class="td-password text-center">
                                <a href="#" onclick="changePassword(this, event)" data-id="${row.id}" class="btn btn-sm btn-warning waves-effect waves-light">
                                    <i class="fas fa-lock"></i> Ganti Password
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="#" onclick="editRow(this, event)" data-json='${JSON.stringify(row)}' class="btn btn-sm btn-info">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <a href="#" data-id="${row.id}" onclick="deleteRow(this, event)" class="btn btn-sm btn-danger">
                                    <i class="fa fa-fw fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    `);

                    role = ``;
                    $.each(row.roles, (_, item) => {
                        role += `<span class="badge bg-danger">${item.name}</span>`;
                    });

                    htmlRow.find('.td-name').text(row.name);
                    htmlRow.find('.td-username').text(row.username);
                    htmlRow.find('.td-email').text(row.email);
                    htmlRow.find('.td-role').html(role);

                    htmlRows += '<tr>' + htmlRow.html() + '</tr>';
                });

                this.element.find('tbody').html(htmlRows);
            },
            loadDataTables() {
                this.setLoadingState();
                axios({
                        url: this.baseURL,
                        method: 'GET',
                        params: {
                            keyword: $('input[name="keyword"]').val(),
                        }
                    })
                    .then(resultJson => {
                        this.render(resultJson.data.data);
                        renderPagination(resultJson.data.links, $('#pagination-container'), this);
                    })
                    .catch(errorResponse => {
                        handleErrorRequest(errorResponse);
                    });
            }
        };

        table.loadDataTables();
    </script>

    <script>
        // Initialize Select2 with default value and search functionality
        $(document).ready(function() {
            $('#modal').on('shown.bs.modal', function() {
                $('#select2-dropdown').select2({
                    dropdownParent: $('#modal'),
                    placeholder: 'Search or select options',
                    minimumInputLength: 2, // Minimum number of characters before triggering search
                    ajax: {
                        url: "{{ route('sekolah.get') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term // Pass the search query to the server
                            };
                        },
                        processResults: function(data) {
                            // Process the data returned by your AJAX call
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

            });
        });
    </script>

    <script>
        const updateForm = (value) => {

            // if (value && value != 20 && value != 21) {
            $modalElement.find('#input-kcd')
                .addClass('d-none')
                .removeClass('d-block');

            $modalElement.find('#input-sekolah')
                .addClass('d-none')
                .removeClass('d-block');
            // }

            if (value == 21) {
                $modalElement.find('#input-kcd')
                    .addClass('d-block')
                    .removeClass('d-none');
            }

            if (value == 20) {
                $modalElement.find('#input-kcd')
                    .addClass('d-block')
                    .removeClass('d-none');

                $modalElement.find('#input-sekolah')
                    .addClass('d-block')
                    .removeClass('d-none');
            }

        }
    </script>
@endpush
