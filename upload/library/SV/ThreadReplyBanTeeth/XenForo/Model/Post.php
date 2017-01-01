<?php

class SV_ThreadReplyBanTeeth_XenForo_Model_Post extends XFCP_SV_ThreadReplyBanTeeth_XenForo_Model_Post
{
    public function preparePostJoinOptions(array $fetchOptions)
    {
        $joinOptions = parent::preparePostJoinOptions($fetchOptions);
        if (SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId !== null)
        {
            if (!empty(SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId))
            {
                $joinOptions['selectFields'] .= ',
                    IF(reply_ban.user_id IS NULL, 0,
                        IF(reply_ban.expiry_date IS NULL OR reply_ban.expiry_date > '
                        . $this->_getDb()->quote(XenForo_Application::$time) . ', 1, 0)) AS thread_reply_banned';
                $joinOptions['joinTables'] .= '
                    LEFT JOIN xf_thread_reply_ban AS reply_ban
                        ON (reply_ban.thread_id = post.thread_id
                        AND reply_ban.user_id = ' . $this->_getDb()->quote(SV_ThreadReplyBanTeeth_Globals::$hintThreadBanUserId) . ')';
            }
            else
            {
                $joinOptions['selectFields'] .= ',
                    0 AS thread_reply_banned';
            }
        }

        return $joinOptions;
    }

    public function canEditPost(array $post, array $thread, array $forum, &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canEditPost($post, $thread, $forum, $errorPhraseKey, $nodePermissions, $viewingUser);
        if(empty($result))
        {
            return false;
        }

        if (XenForo_Application::get('options')->SV_ThreadReplyBanTeeth_EditBan)
        {
            $threadModel = $this->_getThreadModel();
            if ($threadModel->isReplyBanned($thread, $viewingUser))
            {
                return false;
            }
        }

        return true;
    }

    public function canDeletePost(array $post, array $thread, array $forum, $deleteType = 'soft', &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canDeletePost($post, $thread, $forum, $deleteType, $errorPhraseKey, $nodePermissions, $viewingUser);
        if(empty($result))
        {
            return false;
        }

        if (XenForo_Application::get('options')->SV_ThreadReplyBanTeeth_DeleteBan)
        {
            $threadModel = $this->_getThreadModel();
            if ($threadModel->isReplyBanned($thread, $viewingUser))
            {
                return false;
            }
        }

        return true;
    }

    public function canLikePost(array $post, array $thread, array $forum, &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canLikePost($post, $thread, $forum, $errorPhraseKey, $nodePermissions, $viewingUser);
        if(empty($result))
        {
            return false;
        }

        if (XenForo_Application::get('options')->SV_ThreadReplyBanTeeth_LikeBan)
        {
            $threadModel = $this->_getThreadModel();
            if ($threadModel->isReplyBanned($thread, $viewingUser))
            {
                return false;
            }
        }

        return true;
    }
}