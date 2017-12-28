<?php

class SV_ThreadReplyBanTeeth_Dark_PostRating_AlertHandler extends XFCP_SV_ThreadReplyBanTeeth_Dark_PostRating_AlertHandler
{
    public function getContentByIds(array $contentIds, $model, $userId, array $viewingUser)
    {
        SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId = $viewingUser['user_id'];
        try
        {
            return parent::getContentByIds($contentIds, $model, $userId, $viewingUser);
        }
        finally
        {
            SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId = null;
        }
    }
}

if (false)
{
    class XFCP_SV_ThreadReplyBanTeeth_Dark_PostRating_AlertHandler extends Dark_PostRating_AlertHandler {}
}
