<?php

namespace app;

final class InputData
{
    public function __construct(
        public readonly int $customerId ,
        public readonly float $amountUsd
    ) {
    }
}