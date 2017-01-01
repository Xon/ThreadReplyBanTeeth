<?php

class SV_ThreadReplyBanTeeth_XenForo_AlertHandler_DiscussionMessage_Post extends XFCP_SV_ThreadReplyBanTeeth_XenForo_AlertHandler_DiscussionMessage_Post
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