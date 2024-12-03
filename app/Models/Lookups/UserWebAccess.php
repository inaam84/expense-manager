<?php

namespace App\Models\Lookups;

use ReflectionClass;

abstract class UserWebAccess
{
    const ACCESS_ENABLED = 1;
    const ACCESS_DISABLED = 0;
    const ACCESS_READ_ONLY = 2;

    static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    static function getDescription($id)
    {
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach($constants AS $key => $value)
        {
            if($value == $id)
            {
                return str_replace('ACCESS_', '', $key);
            }
        }
    }

    static function getList()
    {
        $options = [];
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach($constants AS $key => $value)
        {
            $options[$value] = str_replace('ACCESS_', '', $key);
        }

        return $options;
    }

    static function getIds()
    {
        $options = [];
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach($constants AS $key => $value)
        {
            $options[] = $value;
        }

        return $options;
    }
}
