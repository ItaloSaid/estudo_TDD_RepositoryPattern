<?php

namespace app;

final class CustomerRepositoryJson implements CustomerRepository
{
    public function findByID(int $id): ?array
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../database.json'), true);
        foreach ($data as $row){
            if($row['id'] === $id){
                return $row;
            }
        }

        return null;
    }
}