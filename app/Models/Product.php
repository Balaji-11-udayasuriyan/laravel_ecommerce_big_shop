<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = [

        'name',
        'image_path',
        'price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'qty',
        'alert_stock',
        'description',
        'product_label_id',
        'product_tag_id',
        'stock_status',
        'is_featured',
        'min_order_qty',
        'max_order_qty'

    ];

    protected $casts = [

        'image_path' => 'array',

    ];

    public function brand()
    {

        return $this->belongsTo(Brand::class,'brand_id');

    }

    public function category()
    {

        return $this->belongsTo(Category::class,'category_id');

    }

    public function GetImagePath()
    {

        if (is_array($this->image_path)) {

            return array_map(function ($path) {

                return env('DOMAIN_URL') . Storage::url($path);

            }, $this->image_path);
        }

        return env('DOMAIN_URL') . Storage::url($this->image_path);
    }

    public function DeleteLogoImage()
    {      

        if (Storage::exists($this->image_path)) 
        {

            Storage::delete($this->image_path);

        }

    }

}
