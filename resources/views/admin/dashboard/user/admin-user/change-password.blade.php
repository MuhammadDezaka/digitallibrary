<div class="modal fade bs-example-modal-password" id="change-password" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mySmallModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-4 mt-lg-0">
                    <form action="{{ route('admin.admin-user.change-password') }}" method="POST" onsubmit="doChangePassword(this, event)">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id">
                        <div class="row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label">Password Baru</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control" id="horizontal-firstname-input">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="horizontal-email-input" class="col-sm-6 col-form-label">Konfirmasi Password Baru</label>
                            <div class="col-sm-6">
                                <input type="password" name="password_confirmation" class="form-control" id="horizontal-email-input">
                            </div>
                        </div>
                        <div class="row justify-content-end p-2">
                            <div class="col-sm-6">
                                <div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->