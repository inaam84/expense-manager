<?php

namespace App\Models\Lookups;

use ReflectionClass;

abstract class UserWebAccess
{
    const ACCESS_ENABLED = 1;

    const ACCESS_DISABLED = 0;

    const ACCESS_READ_ONLY = 2;

    public static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }

    public static function getDescription($id)
    {
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $key => $value) {
            if ($value == $id) {
                return str_replace('ACCESS_', '', $key);
            }
        }
    }

    public static function getList()
    {
        $options = [];
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $key => $value) {
            $options[$value] = str_replace('ACCESS_', '', $key);
        }

        return $options;
    }

    public static function getIds()
    {
        $options = [];
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $key => $value) {
            $options[] = $value;
        }

        return $options;
    }
}
