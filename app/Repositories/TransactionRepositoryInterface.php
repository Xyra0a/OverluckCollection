<?php

namespace App\Repositories;

use App\Models\Order;

interface TransactionRepositoryInterface
{
    public function createTransaction(array $data);
}


