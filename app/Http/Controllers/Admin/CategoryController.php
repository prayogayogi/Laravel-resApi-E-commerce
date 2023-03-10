<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\View\View as ViewAlias;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Interfaces\Admin\CategoryInterface;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * __construct()
     *
     * @return void
     */
    public function __construct(
        private CategoryInterface $category
    )
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return ViewAlias
     */
    public function index(Request $request): ViewAlias
    {
        $categories = $this->category->index($request);
        return view('admin.category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return ViewAlias
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param mixed $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = $this->category->store($request);
        if ($category) {
            return redirect()->route('admin.category.index')->with(['success', 'Data berhasil di simpan']);
        } else {
            return redirect()->route('admin.category.index')->with(['error', 'Data gagal di simpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return ViewAlias
     */
    public function edit(Category $category): ViewAlias
    {
        return view('admin.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category = $this->category->update($request, $category);
        if ($category) {
            return redirect()->route('admin.category.index')->with(['success' => 'Data berhasil di update']);
        } else {
            return redirect()->route('admin.category.index')->with(['error' => 'Data gagal di update']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): JsonResponse
    {
        $category = $this->category->destroy($category);
        if ($category) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
