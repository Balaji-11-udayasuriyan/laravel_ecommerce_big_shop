<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'order_date',
        'total_amount',
        'order_status',
        'payment_method'

    ];

    protected $dates = ['order_date'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            
            $datePart = now()->format('Ymd');

            $sequentialPart = str_pad(static::max('order_number') % 1000 + 1, 3, '0', STR_PAD_LEFT);

            $order->order_number = $datePart . $sequentialPart;

            $order->order_date = now(); // Corrected this line to set the order date instead of the order number
        });
    }

    public function user()
    {

        return $this->belongsTo(User::class);

    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    //SGST CALCULATION

    public function calculaterSGST(): float
    {
        return $this->total_amount * 0.06; // Corrected the calculation
    }

    //CGST CALCULATION

    public function calculaterCGST(): float
    {
        return $this->total_amount * 0.06; // Corrected the calculation
    }

    //SGST AND CGST CALCULATION

    public function calculate_SGST_CGST(): float 
    {
        return $this->calculaterSGST() + $this->calculaterCGST();
    }


    public function total_amount_with_SGST_CGST(): float
    {
        // $total_amount = $this->total_amout;
        // $total_amount += $this->calculaterSGST();
        // $total_amount += $this->calculaterCGST();
        // return $total_amount;
        return $this->total_amount + $this->calculaterSGST() + $this->calculaterCGST();
    }

    public function getTotalAmountInWords(): string
    {
        $numberToWords = new NumberToWords();
        $transformer = $numberToWords->getNumberTransformer('en');
        return $transformer->toWords($this->total_amount);
    }

    public function convertTaxAmountInWords(): string
    {
        $numberToWords = new NumberToWords();
        $transformer = $numberToWords->getNumberTransformer('en');
        $taxAmount = $this->calculaterSGST() + $this->calculaterCGST(); // Calculated tax amount
        return $transformer->toWords($taxAmount);
    }
}
