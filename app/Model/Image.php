<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Img;

class Image extends Model
{
    protected $guarded = ['id'];

    public function uploadImage(UploadedFile $photo, Model $model)
    {
        $className = get_class($model);
        $paths = $this->saveUploadedPhoto($photo,$model);
        $attributes['path'] = $paths['path'];
        $attributes['thumbnail'] = $paths['thumbnail'];
        $attributes['imageable_type'] = $className;
        $attributes['imageable_id'] = $model->id;
        $this->create($attributes);
    }

    private function saveUploadedPhoto(UploadedFile $photo,$model)
    {
        $className = get_class($model);
        $modelNamespaceArr = explode('\\',$className);
        $modelName = strtolower(array_pop($modelNamespaceArr));

        $name = $photo->getClientOriginalName() ?? Str::random(8);
        $path = public_path().'/'.$modelName.'/'.$model->id;
        $fullPath = $path . '/' . $name;
        $thumbnailPath = $path. '/'. 'thumbnail_' . $name;

        if(!File::exists($path)) File::makeDirectory($path, 777,true);
        $image = Img::make($photo);
        $image->save($fullPath);
        $image->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbnailPath);

        return ['path' => $modelName.'/'.$model->id . '/' . $name , 'thumbnail' => $modelName.'/'.$model->id . '/'. 'thumbnail_' . $name];
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function(Image $image)
        {
            $path = public_path() . '/' . $image->path;
            $thumbPath = public_path() . '/' . $image->thumbnail;
            File::delete($path);
            File::delete($thumbPath);
        });
    }
}
