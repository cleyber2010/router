<?php

class UserController 
{
    public function index(array $data)
    {
        echo "Hello Word " . $data["id"] . " - " . $data["user"];
    }
}