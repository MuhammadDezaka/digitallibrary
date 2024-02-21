<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.admin-user.store') }}" method="POST" onsubmit="createOrUpdate(this, event)">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="_method">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama Pengguna <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Masukan nama">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Masukan username">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control" placeholder="Masukan email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Role <span class="text-danger">*</span></label>
                        <select name="role_id" id="role_id" class="form-control" onchange="updateForm(this.value)">
                            <option value="">Pilih Role</option>
                            @foreach (\Facades\App\Repositories\AdminRoleRepository::findAll() as $role)
                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="input-kcd" class="d-none">
                        <div class="form-group mb-3">
                            <label for="name">KCD <span class="text-danger">*</span></label>
                            <select name="kcd_id" id="kcd_id" class="form-control">
                                <option value="">Pilih KCD</option>
                                @foreach (\App\Models\KCD::select('id', 'name')->get()->toArray() as $kcd)
                                    <option value="{{ $kcd['id'] }}">{{ $kcd['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="input-sekolah" class="d-none">
                        <div class="form-group mb-3">
                            <label for="name">Sekolah <span class="text-danger">*</span></label>
                            <select name="sekolah_id[]" id="select2-dropdown" multiple="multiple" style="width: 100%;">

                            </select>
                        </div>
                    </div>
                    <div id="input-password">
                        <div class="form-group mb-3">
                            <label for="name">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Masukan password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Masukan konfirmasi password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
