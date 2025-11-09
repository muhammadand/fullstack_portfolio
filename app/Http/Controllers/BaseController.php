<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $repository;
    protected $viewPath;
    protected $routeName;

    public function index(Request $request)
    {
        $items = $this->repository->all($request);
        return view("{$this->viewPath}.index", compact('items'));
    }

    public function create()
    {
        return view("{$this->viewPath}.create");
    }

    public function store(Request $request)
    {
       
        $validated = $request->validate($this->repository->getModel()::rules());
        $this->repository->create($validated);
        dd($validated); 

        return redirect()->route("{$this->routeName}.index")
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = $this->repository->find($id);
        return view("{$this->viewPath}.edit", compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->repository->model::rules($id));
        $this->repository->update($id, $validated);

        return redirect()->route("{$this->routeName}.index")
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route("{$this->routeName}.index")
            ->with('success', 'Data berhasil dihapus!');
    }
}
