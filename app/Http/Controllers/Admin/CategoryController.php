<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $categories = Category::latest()->when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);
        return view('admin.category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name' => 'required|unique:categories'
        ]);

        // Upload the image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // Save to Database
        $category = Category::create([
            'image' => $image->hashName(),
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-')
        ]);

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
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category): View
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        // In check image null
        if ($request->file('image') == '') {

            // Update data don't image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name'), '-')
            ]);
        } else {

            // Delete image old
            Storage::disk('local')->delete('public/categories/' . basename($category->image));

            // upload image baru
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // update dengan image baru
            $category = Category::findOrFail($category->id);
            $category->update([
                'image'  => $image->hashName(),
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);
        }

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
        Storage::disk('local')->delete('public/categories/' . basename($category->image));
        $category->delete();

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
