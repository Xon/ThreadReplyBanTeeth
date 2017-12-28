<?php

class SV_ThreadReplyBanTeeth_XenForo_Model_Thread extends XFCP_SV_ThreadReplyBanTeeth_XenForo_Model_Thread
{
    public function prepareThreadFetchOptions(array $fetchOptions)
    {
        if (!isset($fetchOptions['replyBanUserId']))
        {
            if (isset($fetchOptions['readUserId']))
            {
                $fetchOptions['replyBanUserId'] = $fetchOptions['readUserId'];
            }
            else if (isset($fetchOptions['postCountUserId']))
            {
                $fetchOptions['replyBanUserId'] = $fetchOptions['postCountUserId'];
            }
            else if (SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId)
            {
                $fetchOptions['replyBanUserId'] = SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId;
            }
        }

        return parent::prepareThreadFetchOptions($fetchOptions);
    }

    public function isReplyBanned(array $thread, array &$viewingUser = null)
    {
        if ($viewingUser['user_id'])
        {
            if (!isset($thread['thread_reply_banned']))
            {
                $result = $this->_getDb()->fetchRow(
                    "
                    SELECT expiry_date
                    FROM xf_thread_reply_ban
                    WHERE thread_id = ?
                        AND user_id = ?
                ", [$thread['thread_id'], $viewingUser['user_id']]
                );
                $thread['thread_reply_banned'] = (
                    $result
                    && ($result['expiry_date'] === null || $result['expiry_date'] > XenForo_Application::$time)
                );
            }
            if ($thread['thread_reply_banned'])
            {
                return true;
            }
        }

        return false;
    }

    public function canEditThreadTitle(array $thread, array $forum, &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canEditThreadTitle($thread, $forum, $errorPhraseKey, $nodePermissions, $viewingUser);
        if (empty($result))
        {
            return false;
        }

        if (XenForo_Application::get('options')->SV_ThreadReplyBanTeeth_EditBan)
        {
            if ($this->isReplyBanned($thread, $viewingUser))
            {
                return false;
            }
        }

        return true;
    }

    public function canDeleteThread(array $thread, array $forum, $deleteType = 'soft', &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canDeleteThread($thread, $forum, $deleteType, $errorPhraseKey, $nodePermissions, $viewingUser);
        if (empty($result))
        {
            return false;
        }

        if (XenForo_Application::get('options')->SV_ThreadReplyBanTeeth_DeleteBan)
        {
            if ($this->isReplyBanned($thread, $viewingUser))
            {
                return false;
            }
        }

        return true;
    }
}

if (false)
{
    class XFCP_SV_ThreadReplyBanTeeth_XenForo_Model_Thread extends XenForo_Model_Thread {}
}
