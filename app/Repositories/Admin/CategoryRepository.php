<?php

namespace App\Repositories\Admin;

use App\Traits\Admin;
use App\Traits\Image;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Interfaces\Admin\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    use Admin;
    use Image;
    const directoryImage = 'public/categories/';

    /**
     * index
     *
     * @param mixed $request
     * @return $categories
     */
    public function index($request)
    {
        $categories = $this->indexQuery($request, Category::latest());
        return $categories;
    }

    /**
     * store
     * @param mixed $request
     * @return category
     */
    public function store($request)
    {
        // Upload the image
        $image =  $this->uploadImage($request, 'image', self::directoryImage);

        // Save to Database
        $category = Category::create([
            'image' => $image->hashName(),
            'name'  => $request->input('name'),
            'slug'  => Str::slug($request->input('name'), '-')
        ]);
        return $category;
    }

    /**
     * update
     * @param mixed $request
     * @return category
     */
    public function update($request, $category)
    {
        if ($request->file('image') == '') {
            // Update data don't image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name'), '-')
            ]);
        } else {

            // Delete image old
            $this->deleteImage('local', self::directoryImage, $category->image);

            // upload image baru
            $image = $this->uploadImage($request, 'image', self::directoryImage);

            // update dengan image baru
            $category = Category::findOrFail($category->id);
            $category->update([
                'image'  => $image->hashName(),
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);
        }
        return $category;
    }

    /**
     * destroy
     * @param mixed $category
     * @return category
     */
    public function destroy($category)
    {
        $this->deleteImage('local', self::directoryImage, $category->image);
        $category->delete();
        return $category;
    }
}
