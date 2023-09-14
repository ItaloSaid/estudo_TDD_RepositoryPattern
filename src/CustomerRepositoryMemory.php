<?php

namespace app;

final class CustomerRepositoryMemory implements CustomerRepository
{
    private array $storage = [
        ['id' => 1, 'name' => 'João', 'email' => 'joao@gmail.com'],
        ['id' => 2, 'name' => 'Maria', 'email' => 'maria@gmail.com']
    ];
    public function findByID(int $id):? array
    {
        foreach ($this->storage as $row){
            if($row['id'] === $id){
                return $row;
            }
        }

        return null;
    }
}