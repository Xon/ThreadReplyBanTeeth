<?php

class SV_ThreadReplyBanTeeth_Dark_PostRating_Model extends XFCP_SV_ThreadReplyBanTeeth_Dark_PostRating_Model
{

	public function canRatePost(array $post, array $thread, array $forum = array(), &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
	{
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canRatePost($post, $thread, $forum, $errorPhraseKey, $nodePermissions, $viewingUser);
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


	public function canDeleteRating(array $post, array $thread, array $forum = array(), &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
	{
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);

        $result = parent::canDeleteRating($post, $thread, $forum, $errorPhraseKey, $nodePermissions, $viewingUser);
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

	protected function _getThreadModel()
	{
		return $this->getModelFromCache('XenForo_Model_Thread');
	}
}