<?php

/**
 *
 * @see XenForo_ControllerPublic_Thread
 */
class ThemeHouse_PostTitles_Extend_XenForo_ControllerPublic_Thread extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_ControllerPublic_Thread
{

    public function actionIndex()
    {
        $response = parent::actionIndex();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            if (isset($response->params['thread']) && isset($response->params['posts'])) {
                $thread = $response->params['thread'];
                $posts = $response->params['posts'];
                
                $pagePostTitleCount = 0;
                $lowestPosition = 0;
                $highestPosition = 0;
                foreach ($posts as $post) {
                    if (!$lowestPosition) {
                        $lowestPosition = $post['position'];
                    }
                    $highestPosition = $post['position'];
                    if ($post['post_title']) {
                        $pagePostTitleCount++;
                    }
                }
                $response->params['pagePostTitleCount'] = $pagePostTitleCount;
                
                $perPage = XenForo_Application::getOptions()->th_postTitles_postTitlesFromOtherThreads;
                if ($pagePostTitleCount < $thread['post_title_count'] && $perPage) {
                    /* @var $postModel XenForo_Model_Post */
                    $postModel = $this->_getPostModel();
                    
                    $postTitles = $postModel->getPostsWithTitlesInThread($thread['thread_id'], 
                        array(
                            'page' => 1,
                            'perPage' => $perPage
                        ), 
                        array(
                            $lowestPosition,
                            $highestPosition
                        ));
                    
                    $response->params['postTitles'] = $postTitles;
                }
            }
        }
        
        return $response;
    }

    protected function _getThreadForumFetchOptions()
    {
        list($threadFetchOptions, $forumFetchOptions) = parent::_getThreadForumFetchOptions();
        
        $this->_getThreadModel();
        
        $threadFetchOptions['th_postTitles_join'] = ThemeHouse_PostTitles_Extend_XenForo_Model_Thread::FETCH_POST_TITLE_COUNT;
        
        return array(
            $threadFetchOptions,
            $forumFetchOptions
        );
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::_getPostFetchOptions()
     */
    protected function _getPostFetchOptions(array $thread, array $forum)
    {
        $postFetchOptions = parent::_getPostFetchOptions($thread, $forum);
        
        $postFetchOptions['th_postTitles_join'] = ThemeHouse_PostTitles_Extend_XenForo_Model_Post::FETCH_POST_TITLES;
        
        return $postFetchOptions;
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionAddReply()
     */
    public function actionAddReply()
    {
        $GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
        
        return parent::actionAddReply();
    }

    public function actionPostTitles()
    {
        $threadId = $this->_input->filterSingle('thread_id', XenForo_Input::UINT);
        
        $ftpHelper = $this->getHelper('ForumThreadPost');
        list($threadFetchOptions, $forumFetchOptions) = $this->_getThreadForumFetchOptions();
        list($thread, $forum) = $ftpHelper->assertThreadValidAndViewable($threadId, $threadFetchOptions, 
            $forumFetchOptions);
        
        $page = max(1, $this->_input->filterSingle('page', XenForo_Input::UINT));
        $perPage = XenForo_Application::getOptions()->th_postTitles_titlesInOverlay;
        
        /* @var $postModel XenForo_Model_Post */
        $postModel = $this->_getPostModel();
        
        $posts = $postModel->getPostsWithTitlesInThread($thread['thread_id'], 
            array(
                'page' => $page,
                'perPage' => $perPage
            ));
        
        $viewParams = array(
            'thread' => $thread,
            'forum' => $forum,
            'posts' => $posts,
            
            'hasMore' => count($posts) == $perPage,
            'page' => $page,
            'perPage' => $perPage,
            
            'nodeBreadCrumbs' => $ftpHelper->getNodeBreadCrumbs($forum)
        );
        
        return $this->responseView('ThemeHouse_PostTitles_ViewPublic_Thread_PostTitles',
            'th_post_titles_posttitles', $viewParams);
    }
}