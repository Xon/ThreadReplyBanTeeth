<?php

class SV_ThreadReplyBanTeeth_Listener
{
    public static function load_class($class, &$extend)
    {
        $extend[] = 'SV_ThreadReplyBanTeeth_' . $class;
    }
}
