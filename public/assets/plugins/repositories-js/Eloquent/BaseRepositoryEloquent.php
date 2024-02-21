<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Storage;

class BaseRepositoryEloquent
{
	/**
	 * Model
	 */
	protected $model;

	/**
	 * Find All
	 *
	 * @return array
	 */
	public function findAll()
	{
		return $this->model->all()->toArray();
	}

	/**
	 * Count
	 *
	 * @return integer
	 */
	public function count($where = null)
    {
        return $this->model->where($where)->count();
    }

	public function sum($where, $sum)
    {
        return $this->model->where($where)->selectRaw($sum)->first();
    }

    public function latest($where = null, $orderBy = 'id')
    {
        return $this->model
            ->where($where)
            ->orderBy($orderBy, 'desc')
            ->first();
    }


	/**
	 * Get Where
	 *
	 * @param  mix $column
	 * @param  mix $value
	 * @return mix
	 */
	public function getWhere($column, $value, $with = [])
	{
		$data = $this->model->query();
		$data = $data->with($with)->where($column, $value);
		$data = $data->first();

		if ($data) {
			return $data->toArray();
		}

		return null;
	}

    public function getWhereMultiple($column)
	{
		$data = $this->model->query();
		$data = $data->where($column);
		$data = $data->first();

		if ($data) {
			return $data->toArray();
		}

		return null;
	}

    public function getAllWhere($column, $value)
	{
		$data = $this->model->query();
		$data = $data->where($column, $value);
		$data = $data->get();

		if ($data) {
			return $data->toArray();
		}

		return null;
	}

	public function getWhereNotIn($column, $value)
	{
		$data = $this->model->query();
		$data = $data->whereNotIn($column, $value);
		$data = $data->get();

		if ($data) {
			return $data->toArray();
		}

		return null;
	}


    public function getCmsTableWhere($relasi = null, $where = null,$like = null, $label = null, $collection = null, $sort = null)
    {
        $query = $this->model->query();

        if ($relasi) {
            $query = $query->with($relasi);
        }

        if ($where) {
            $query = $query->where($where);
        }

		if($like){
            $query = $query->where($label, 'LIKE','%'.$like.'%');
        }

        if ($collection && $sort) {
            $query = $query->orderBy($collection, $sort);
        }

        return $query->paginate(10)->toArray();
    }


	/**
	 * Find
	 *
	 * @param  mix $id
	 * @return array
	 */
	public function find($id)
	{
		$data = $this->model->find($id);
		if (is_null($data)) {
			return null;
		}

		return $data->toArray();
	}

	/**
	 * Create
	 *
	 * @param  array
	 * @return array
	 */
	public function create($data)
	{
		return $this->model->create($data)->toArray();
	}

	/**
	 * Update
	 *
	 * @param  mix 		$id
	 * @param  array 	$data
	 * @return boolean
	 */
	public function update($id, $data)
	{
		return $this->model->where($this->model->getKeyName(), $id)->update($data);
	}

	/**
	 * Delete
	 *
	 * @param  mix $id
	 * @return boolean
	 */
	public function delete($id)
	{
		return $this->model->where($this->model->getKeyName(), $id)->delete();
	}

	public function updateOneColumn(string $column, $value, int $id){

		// dd($this->model->findOrFail($id), $value, $column);

        return $this->model->findOrFail($id)->update([
            $column => $value
        ]);

    }
	

    public function query()
    {
        return $this->model->query();
    }



}
