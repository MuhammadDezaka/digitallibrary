@extends('layouts.app')
@section('main')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
    

          <div class="row">
            <div class="col-md-6 col-sm-12">

            </div>
            <div class="col-md-6 col-sm-12 d-flex align-items-center justify-content-end">
                {{-- <a href="" class="" data-bs-toggle="modal"  data-bs-target="#myModal">Tambah Data</a> --}}
                <button type="button" onclick="showCreateModal(event)" class="btn btn-success waves-effect waves-light"
                    data-bs-toggle="modal" data-bs-target="#myModal">
                    Tambah Data
                </button>

            </div>
        </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="datatables" class="table table-bordered dt-responsive  nowrap w-100 text-center">
                <thead class="bg-green-pusaka text-white">
                    <tr>
                        <th>Nama Role</th>
                        <th>Managemen Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>
                </tbody>

            </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('role-pengguna.store') }}" method="POST"
                    onsubmit="createOrUpdate(this, event)">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="_method">
                    <input type="hidden" name="sekolah_id" value="{{ Auth::user()->sekolah_id }}">
                    <div class="modal-body">

                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="name">Nama Role</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="guard_name" class="form-label"><strong>Nama Guard</strong></label>
                            <select name="guard_name" id="guard_name" class="form-select form-control" required>
                                <option value="admin" selected>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Simpan Data</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Manage Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Permission checkboxes will be inserted here dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savePermissionsButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"
        integrity="sha512-/V6Lo0GhutHcr/GhXfz1P3nSdnIgXw6sv13FOWGvkgsc9CbZYq895ff+D2yubwZQoadSiEhYhEdEBYFrEvGFww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        const table = {
            baseURL: `{{ route('role-pengguna.tables') }}`,
            element: $('#datatables'),
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

                    // console.log(row);
                    let status = ''
                    if (row.status == "1") {
                        status = '<span class="badge bg-success">Aktif</span>'
                    } else {
                        status = '<span class="badge bg-danger">Tidak Aktif</span>'
                    }

                    let htmlRow = $(`
                        <tr>
                            <td class="td-nama-role"></td>
                            <td class="td-jumlah-user">
                                <a href="#" data-id="${row.id}" onclick="managePermissions(this, event)" class="btn btn-sm btn-primary">
                                    Manage Permissions
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="#" onclick="editRow(this, event)" data-json='${JSON.stringify(row)}' class="btn btn-sm btn-success">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <a href="#" data-id="${row.id}" onclick="deleteRow(this, event)" class="btn btn-sm btn-danger ${ row.total > 0 ? 'disabled' : '' }">
                                    <i class="fa fa-fw fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                    `);


                    // console.log(row)
                    htmlRow.find('.td-nama-role').text(row.name);
                    // htmlRow.find('.td-jumlah-user').text(row.guard_name);
                    htmlRows += '<tr>' + htmlRow.html() + '</tr>';
                });

                this.element.find('tbody').html(htmlRows);
            },
            loadDataTables(kurikulum_id = null) {
                this.setLoadingState();
                axios({
                        url: this.baseURL,
                        method: 'GET',
                        params: {
                            kurikulum_id: kurikulum_id,
                            keyword: $('input[name="keyword"]').val(),
                        }
                    })
                    .then(resultJson => {
                        this.render(resultJson.data.data);
                        renderPagination(resultJson.data.links, $('#pagination-container'), this);
                    })
                    .catch(errorResponse => {
                        handleErrorRequest(errorResponse);
                        console.log(errorResponse)
                    });
            }
        };

        table.loadDataTables();
    </script>

    <script>
        const modalElement = document.querySelector('#myModal');
        const modalBootstrap = new bootstrap.Modal(modalElement);
        const $modalElement = $(modalElement);

        const createOrUpdate = (form, event) => {
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
            data.append('name', $form.find('[name="name"]').val());
            data.append('guard_name', $form.find('[name="guard_name"]').val());

            axios({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: data
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
                    console.log(errorResponse)
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
         * Delete Row
         */
        const deleteRow = (element, event) => {
            event.preventDefault();
            showDeleteConfirmation()
                .then(result => {
                    if (result.status) {
                        showLoadingSwal();
                        axios({
                                url: `role-pengguna`,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: element.getAttribute('data-id')
                                }
                            })
                            .then(resultJson => {
                                Swal.close();
                                Swal.fire('Success', 'Berhasil Menghapus Data', 'success');
                                table.loadDataTables();
                            })
                            .catch(errorResponse => {
                                Swal.close();
                                handleErrorRequest(errorResponse);
                            });
                    }
                })
        };


        const editRow = (element, event) => {
            event.preventDefault();

            let json = JSON.parse(element.getAttribute('data-json'));

            $modalElement.find('.modal-title').html('Edit Data');
            $modalElement.find('[name="id"]').val(json.id);
            $modalElement.find('[name="_method"]').val('PUT');
            $modalElement.find('[name="name"]').val(json.name);
            modalBootstrap.show();

        };
    </script>

    <script>
        const showCreateModal = (event) => {
            event.preventDefault();

            $modalElement.find('.modal-title').html('Tambah Data');
            $modalElement.find('[name="id"]').val('');
            $modalElement.find('[name="_method"]').val('POST');
            $modalElement.find('[name="name"]').val('');

            modalBootstrap.show();
        };
    </script>

    <script>
        function managePermissions(button, event) {
            event.preventDefault();

            let roleId = $(button).data('id');
            $('#permissionsModal').data('role-id', roleId);

            axios.get(`/role-pengguna/permissions/${roleId}`)
                .then(response => {
                    let checkboxes = '';

                    response.data.permissions.forEach(permission => {
                        checkboxes += `
                        <div class="form-check">
                            <input class="form-check-input" name="input-permission" type="checkbox" id="permission_${permission.id}" value="${permission.id}" ${permission.checked ? 'checked' : ''}>
                            <label class="form-check-label" for="permission_${permission.id}">
                                ${permission.name}
                            </label>
                        </div>
                    `;
                    });

                    $('#permissionsModal .modal-body').html(checkboxes);

                    $('#permissionsModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching permissions:', error);
                });
        }

        // Add this after the existing code in your script
        document.getElementById('savePermissionsButton').addEventListener('click', savePermissions);

        function savePermissions() {

            showLoadingSwal();

            let roleId = $('#permissionsModal').data('role-id');

            let selectedPermissions = Array.from(new Set($('.form-check-input:checked').map(function() {
                return $(this).val();
            }).get()));

            console.log(selectedPermissions)

            console.log({
                selectedPermissions,
                roleId
            });


            axios.post(`/role-pengguna/permissions/${roleId}`, {
                    permissions: selectedPermissions
                })
                .then(response => {
                    // Handle success, maybe show a success message or close the modal
                    Swal.fire('Berhasil', 'Berhasil Mengubah Data', 'success');

                    $('#permissionsModal').modal('hide');
                })
                .catch(error => {
                    console.error('Error saving permissions:', error);
                    handleErrorRequest(error);
                    // Handle error, show error message or handle the error in another way
                });
        }
    </script>
@endpush