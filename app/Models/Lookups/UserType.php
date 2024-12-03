<?php

namespace App\Models\Lookups;

use ReflectionClass;

abstract class UserType
{
    const TYPE_ADMINISTRATOR = 100;
    const TYPE_USER = 101;

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
                return str_replace('TYPE_', '', $key);
            }
        }
    }

    static function getList($exclude_learners = true)
    {
        $options = [];
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach($constants AS $key => $value)
        {
            $options[$value] = str_replace('TYPE_', '', $key);
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
