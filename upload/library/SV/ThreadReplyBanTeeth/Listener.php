<?php

class SV_ThreadReplyBanTeeth_Listener
{
    const AddonNameSpace = 'SV_ThreadReplyBanTeeth';

    public static function load_class($class, &$extend)
    {
        switch ($class)
        {
            case 'Dark_PostRating_Model':
            case 'XenForo_Model_Post':
            case 'XenForo_Model_Thread':
                $extend[] = self::AddonNameSpace.'_'.$class;
                break;
        }
    }
}
