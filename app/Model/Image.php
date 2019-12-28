<?php

namespace App\Model;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
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

        if(!File::exists($path)) mkdir($path, 0777, true);
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
        $Filesystem = new \Illuminate\Filesystem\Filesystem();

        parent::boot();
        self::deleting(function(Image $image) use ($Filesystem)
        {
            $path = public_path() . '/' . $image->path;
            $thumbPath = public_path() . '/' . $image->thumbnail;

            //// Nadslozka slozky s obrazkem
	        $folders = explode('/', $path);
            unset($folders[count($folders) - 1]);

            //// Slozka obsahujici obrazky
            $imagesFolderPath = implode('/', $folders);

            File::delete($path);
            File::delete($thumbPath);

	        /// Kontrola jestli je slozka prazdna neobsahuje zadne soubory tak by mela byt smazana
	        $files = $Filesystem->files($imagesFolderPath);
            if(empty($files)) {
				$Filesystem->deleteDirectory($imagesFolderPath);
            }
        });
    }
}
