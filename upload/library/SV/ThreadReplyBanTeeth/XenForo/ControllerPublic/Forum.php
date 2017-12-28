<?php

class SV_ThreadReplyBanTeeth_XenForo_ControllerPublic_Forum extends XFCP_SV_ThreadReplyBanTeeth_XenForo_ControllerPublic_Forum
{
    public function actionIndex()
    {
        SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId = XenForo_Visitor::getUserId();
        try
        {
            return parent::actionIndex();
        }
        finally
        {
            SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId = null;
        }
    }
}

if (false)
{
    class XFCP_SV_ThreadReplyBanTeeth_XenForo_ControllerPublic_Forum extends XenForo_ControllerPublic_Forum {}
}
