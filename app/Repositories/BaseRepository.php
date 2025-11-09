<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Ambil semua data dengan fitur pencarian, sorting, dan pagination
     */
    public function all(Request $request, $perPage = 10)
    {
        $query = $this->model::query();

        $this->applySearch($query, $request);
        $this->applySort($query, $request);

        return $query->paginate($perPage)->appends($request->query());
    }

    /**
     * 🔍 Pencarian fleksibel (berdasarkan kolom umum)
     */
    protected function applySearch($query, Request $request)
    {
        if (!$request->filled('q')) return;

        $keyword = $request->q;
        $table = $this->model->getTable();
        $columns = Schema::getColumnListing($table);

        // Kolom yang dianggap relevan untuk pencarian
        $searchable = ['name', 'title', 'slug', 'email', 'description'];
        $available = array_intersect($columns, $searchable);

        if (!empty($available)) {
            $query->where(function ($q) use ($available, $keyword) {
                foreach ($available as $col) {
                    $q->orWhere($col, 'like', "%{$keyword}%");
                }
            });
        }
    }

    /**
     * 🔽 Sorting fleksibel
     */
    protected function applySort($query, Request $request)
    {
        $table = $this->model->getTable();
        $columns = Schema::getColumnListing($table);

        $sortBy = $request->get('sort_by', 'id');
        $order = $request->get('order', 'desc');

        if (in_array($sortBy, $columns)) {
            $query->orderBy($sortBy, $order);
        } else {
            $query->orderBy('id', 'desc');
        }
    }

    /**
     * 🧱 CRUD Helper
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = $this->find($id);
        return $item->delete();
    }
    public function getModel()
    {
        return $this->model;
    }
}
