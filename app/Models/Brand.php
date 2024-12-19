<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    protected $fillable = [

        'category_id',
        'sub_category_id',
        'name',
        'image_path'

    ];

    public function GetLogoImages(){

        return env('DOMAIN_URL').Storage::url(this->image_path);
    }

    public function DeleteLogoImage()
    {

        if (Storage::exists($this->image_path))
        {
            Storage::delete($this->image_path);
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');

    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');

    }
}
