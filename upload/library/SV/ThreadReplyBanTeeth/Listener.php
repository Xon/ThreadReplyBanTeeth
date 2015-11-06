<?php

class SV_ThreadReplyBanTeeth_Listener
{
    const AddonNameSpace = 'SV_ThreadReplyBanTeeth_';

    public static function load_class($class, &$extend)
    {
        $extend[] = self::AddonNameSpace.$class;
    }
}
