<?php

namespace App\Model;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Img;

class ImageImport extends Model
{
    protected $guarded = ['id'];

    protected $table = 'images';

    public function uploadImage($photoPath, Model $model)
    {
        $className = get_class($model);
        $paths = $this->saveUploadedPhoto($photoPath,$model);
        $attributes['path'] = $paths['path'];
        $attributes['thumbnail'] = $paths['thumbnail'];
        $attributes['imageable_type'] = $className;
        $attributes['imageable_id'] = $model->id;
        $this->create($attributes);
    }

    private function saveUploadedPhoto($photoPath,$model)
    {
        $className = get_class($model);
        $modelNamespaceArr = explode('\\',$className);
        $modelName = strtolower(array_pop($modelNamespaceArr));

        $name = pathinfo($photoPath, PATHINFO_BASENAME);
//        $name = $photoPath->getClientOriginalName() ?? Str::random(8);
        $path = public_path().'/'.$modelName.'/'.$model->id;
        $fullPath = $path . '/' . $name;
        $thumbnailPath = $path. '/'. 'thumbnail_' . $name;

        if(!File::exists($path)) mkdir($path, 0777, true);

        $image = Img::make($photoPath);
        $image->save($fullPath);
        $image->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbnailPath);

        return ['path' => $modelName.'/'.$model->id . '/' . $name , 'thumbnail' => $modelName.'/'.$model->id . '/'. 'thumbnail_' . $name];
    }
}
