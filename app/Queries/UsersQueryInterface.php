<?php


namespace App\Queries;


interface UsersQueryInterface
{
    public function execute();

    public function setEmail(string $email);

    public function setName(string $name);

    public function setQuerySearch(string $querySearch);
}
