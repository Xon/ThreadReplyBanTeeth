<?php

class SV_ThreadReplyBanTeeth_XenForo_Model_Post extends XFCP_SV_ThreadReplyBanTeeth_XenForo_Model_Post
{
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