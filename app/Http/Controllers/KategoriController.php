<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriBukuRequest;
use App\Repositories\KategoriRepository;
use Illuminate\Http\Request;

class KategoriController extends Controller
{

    protected $configrepo;

    public function __construct(KategoriRepository $repo)
    {
        $this->configrepo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard.kategori.index');
    }

    public function tables(Request $request)
    {
      

        return $this->configrepo->getCmsTableWhere();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriBukuRequest $request)
    {
        $request = $request->validated();
        // dd($request);
        $store = $this->configrepo->create($request);
        return ['status' => 'success'];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriBukuRequest $request)
    {
        $request = $request->validated();
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
