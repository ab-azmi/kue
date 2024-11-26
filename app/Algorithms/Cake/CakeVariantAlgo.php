<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\CakeVariant;

class CakeVariantAlgo
{
    public function __construct(public CakeVariant|int|null $cakeVariant = null)
    {
        if(is_int($cakeVariant)) {
            $this->cakeVariant = CakeVariant::find($cakeVariant);
            if(!$this->cakeVariant) {
                errCakeVariantGet();
            }
        }
    }
}
