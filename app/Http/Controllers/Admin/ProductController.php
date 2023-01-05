<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $products = Product::latest()->when(request()->q, function ($products){
            $products = $products->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);
        return view('admin.product.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $categories = Category::latest()->get();
        return view('admin.product.create',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'image'          => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'          => 'required|unique:products',
            'category_id'    => 'required',
            'content'        => 'required',
            'weight'         => 'required',
            'price'          => 'required',
            'discount'       => 'required',
        ]);

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        // Save to db product
        $product = Product::create([
            'image'          => $image->hashName(),
            'title'          => $request->input('title'),
            'slug'           => Str::slug($request->input('title'), '-'),
            'category_id'    => $request->input('category_id'),
            'content'        => $request->input('content'),
            'unit'           => $request->input('unit'),
            'weight'         => $request->input('weight'),
            'price'          => $request->input('price'),
            'discount'       => $request->input('discount'),
            'keywords'       => $request->input('keywords'),
            'description'    => $request->input('description')
        ]);

        if($product){
            // Redirect success
            return redirect()->route('admin.product.index')->with(['success' => 'Data berhasil di simpan']);
        }else{
            // Redirect error
            return redirect()->route('admin.product.index')->with(['error' => 'Data gagal simpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product): View
    {
        $categories = Category::latest()->get();
        return view('admin.product.edit',[
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->validate($request,[
            'title'          => 'required|unique:products,title,'.$product->id,
            'category_id'    => 'required',
            'content'        => 'required',
            'weight'         => 'required',
            'price'          => 'required',
            'discount'       => 'required',
        ]);

        // Cek jika image kosong
        if($request->input('image') == ''){
            // Update tanpa image
            $product->update([
                'title'          => $request->input('title'),
                'slug'           => Str::slug($request->input('title'), '-'),
                'category_id'    => $request->input('category_id'),
                'content'        => $request->input('content'),
                'unit'           => $request->input('unit'),
                'weight'         => $request->input('weight'),
                'price'          => $request->input('price'),
                'discount'       => $request->input('discount'),
                'keywords'       => $request->input('keywords'),
                'description'    => $request->input('description')
            ]);
        }else{
            // Hapus image lama
            Storage::disk('local')->delete('public/products/' . basename($product->image));

            // Upload image baru
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());
        }

        if($product){
            //redirect dengan pesan sukses
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.product.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): JsonResponse
    {
        $image = Storage::disk('local')->delete('public/products/'. basename($product->image));
        $product->delete();

        if($product){
            return response()->json([
               'status' => 'success'
            ]);
        }else{
            return response()->json([
               'status' => 'error'
            ]);
        }
    }
}
