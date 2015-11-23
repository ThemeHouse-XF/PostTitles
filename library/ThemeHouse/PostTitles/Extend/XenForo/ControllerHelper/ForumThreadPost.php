<?php

/**
 *
 * @see XenForo_ControllerHelper_ForumThreadPost
 */
class ThemeHouse_PostTitles_Extend_XenForo_ControllerHelper_ForumThreadPost extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_ControllerHelper_ForumThreadPost
{

    /**
     *
     * @see XenForo_ControllerHelper_ForumThreadPost::getPostOrError()
     */
    public function getPostOrError($postId, array $fetchOptions = array())
    {
        $this->_controller->getModelFromCache('XenForo_Model_Post');
        
        $fetchOptions['th_postTitles_join'] = ThemeHouse_PostTitles_Extend_XenForo_Model_Post::FETCH_POST_TITLES;
        
        return parent::getPostOrError($postId, $fetchOptions);
    }
}