<?php

namespace App\Enums;

enum DiscountType: string{

    case COUPON_CODE = 'COUPON_CODE';

    case PROMOTION = 'PROMOTION';
    
    public static function getValue(): array 
    {

      return array_column(DiscountType::cases(),'value');

    }

    public static function getKeyValue(): array 
    {

      return array_column(DiscountType::cases(),'value','key');

    }
    
}