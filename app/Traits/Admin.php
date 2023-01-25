<?php

namespace App\Traits;

trait Admin
{
    public function indexQuery($request, $model)
    {
        $result = $model->when(request()->q, function($result){
            $result =  $result->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);
        return $result;
    }
}
