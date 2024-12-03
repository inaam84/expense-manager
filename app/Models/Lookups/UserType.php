<?php

namespace App\Models\Lookups;

use ReflectionClass;

abstract class UserType
{
    const TYPE_ADMINISTRATOR = 100;

    const TYPE_USER = 101;

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
                return str_replace('TYPE_', '', $key);
            }
        }
    }

    public static function getList($exclude_learners = true)
    {
        $options = [];
        $oClass = new ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $key => $value) {
            $options[$value] = str_replace('TYPE_', '', $key);
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
