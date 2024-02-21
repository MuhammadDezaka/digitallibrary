<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PeminjamanRequest;
use App\Repositories\PeminjamanRepository;

class PeminjamanController extends Controller
{

    protected $configrepo;

    public function __construct(PeminjamanRepository $repo)
    {
        $this->configrepo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard.peminjaman.index');
    }

    public function tables(Request $request)
    {
      
        $relasi = ['Buku'];
        $where = ['user_id' => Auth::user()->id];
        $where = ['buku.id' => 30];
        return $this->configrepo->getCmsTableWhere($relasi,$where);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeminjamanRequest $request)
    {
        $request = $request->validated();
        // dd($request);

        $request['tanggal_peminjaman'] = Carbon::now();
        $request['status'] = "Dipinjam";
        $store = $this->configrepo->create($request);
        return ['status' => 'success'];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PeminjamanRequest $request)
    {
        $request = $request->validated();
        $request['tanggal_pengembalian'] = Carbon::now();
        $request['status'] = "DiKembalikan";
        $update = $this->configrepo->update($request['id'], $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $data = $this->configrepo->find($request->id);
        if (is_null($data)) {
            abort(404);
        }

        $this->configrepo->delete($request->id);
        return ['status' => 'success'];
    }
}
