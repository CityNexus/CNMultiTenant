<?php
/**
 * Created by PhpStorm.
 * User: sean
 * Date: 10/25/16
 * Time: 3:42 PM
 */

namespace CityNexus\DataStore;

class DataStore
{
    public function __construct()
    {
        $this->aws = new AWS();
    }

    public function storeFile()
    {
        return 'Hello';
    }
}