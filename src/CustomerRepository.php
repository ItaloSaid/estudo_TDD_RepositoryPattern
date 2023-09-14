<?php

namespace app;

interface CustomerRepository
{
    public function findByID(int $id):? array;
}