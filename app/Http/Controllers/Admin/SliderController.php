<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index():View
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index',[
            'sliders' => $sliders
        ]);
    }

    /**
     * store
     *
     * @params mixed $request
     * @return void
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'required'
        ]);

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        // Save to db
        $slider = Slider::create([
           'image' => $image->hashName(),
           'link' => $request->input('link')
        ]);

        if($slider){
            return redirect()->route('admin.slider.index')->with(['success' => 'Data berhsil di simpan']);
        }else{
            return redirect()->route('admin.slider.index')->with(['error' => 'Data gagal di simpan']);
        }
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy(Slider $slider): JsonResponse
    {
        $image = Storage::disk('local')->delete('public/sliders/'. basename($slider->image));
        $slider->delete();

        if($slider){
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
