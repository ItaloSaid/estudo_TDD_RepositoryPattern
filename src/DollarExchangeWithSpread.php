<?php

namespace app;
use InvalidArgumentException;

class DollarExchangeWithSpread
{

    public function __construct(
        private readonly DollarRealQuotationApi $dollarRealQuotationApi,
        private readonly CustomerRepository $customerRepository
    )
    {
    }

    public function execute(InputData $inputData) : array
    {
        if(!isset($inputData->customerId)){
            throw new InvalidArgumentException();
        }

        $customer = $this->customerRepository->findByID($inputData->customerId);
        if(is_null($customer)){
            return throw new CustomerNotFoundException();
        }

        //5 R$
        $dollarRealQuotation = $this->dollarRealQuotationApi->getQuotation();
        $amountWithSpread = 0;

        if ($inputData->amountUsd < 100) {
            $amountWithSpread = $inputData->amountUsd * ($dollarRealQuotation + ($dollarRealQuotation * 0.035));
        }

        if ($inputData->amountUsd >= 100 && $inputData->amountUsd < 200)  {
            $amountWithSpread = $inputData->amountUsd * ($dollarRealQuotation + ($dollarRealQuotation * 0.025));
        }

        if ($inputData->amountUsd >= 200)  {
            $amountWithSpread = $inputData->amountUsd * ($dollarRealQuotation + ($dollarRealQuotation * 0.015));
        }


        return [
            'id' => $customer['id'],
            'name' => $customer['name'],
            'email' => $customer['email'],
            'dollarQuotation' => $dollarRealQuotation,
            'amountWithoutSpread' => $inputData->amountUsd * $dollarRealQuotation,
            'amountWithSpread' =>  $amountWithSpread,
        ];
    }
}
