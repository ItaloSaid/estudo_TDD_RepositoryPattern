<?php

namespace app;
class MyQuotationApiFake implements DollarRealQuotationApi
{
    public function getQuotation(): float
    {
         return 5.00;
    }
}