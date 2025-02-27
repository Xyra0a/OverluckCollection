<?php

namespace App\Repositories;

use App\Models\Order;


class TransactionRepository implements TransactionRepositoryInterface
{
    public function createTransaction(array $data)
    {
        return Order::create($data);
    }
}
