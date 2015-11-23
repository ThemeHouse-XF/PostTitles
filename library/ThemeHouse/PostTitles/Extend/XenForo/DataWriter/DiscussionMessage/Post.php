<?php

/**
 *
 * @see XenForo_DataWriter_DiscussionMessage_Post
 */
class ThemeHouse_PostTitles_Extend_XenForo_DataWriter_DiscussionMessage_Post extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_DataWriter_DiscussionMessage_Post
{

    protected function _messagePostSave()
    {
        parent::_messagePostSave();
        
        /* @var $db Zend_Db_Adapter_Abstract */
        $db = $this->_db;
        
        $xenOptions = XenForo_Application::get('options');
        
        $discussionDw = $this->getDiscussionDataWriter();
        
        $forum = $this->_getForumInfo();
        
        // create a thread
        if ($forum['allow_post_titles_th'] && $xenOptions->th_postTitles_allowTitleInFirstPost) {
            if ($discussionDw->isInsert()) {
                $db->insert('xf_post_title_th',
                    array(
                        'post_id' => $this->get('post_id'),
                        'post_title' => $discussionDw->get('title')
                    ));
                $this->_updatePostTitleCount(1);
            }
        }
        
        // post a reply
        if ($forum['allow_post_titles_th']) {
            if (isset($GLOBALS['XenForo_ControllerPublic_Thread'])) {
                /* @var $controller XenForo_ControllerPublic_Thread */
                $controller = $GLOBALS['XenForo_ControllerPublic_Thread'];
                
                $postTitle = $controller->getInput()->filterSingle('post_title', XenForo_Input::STRING);
                
                if ($postTitle) {
                    $db->insert('xf_post_title_th',
                        array(
                            'post_id' => $this->get('post_id'),
                            'post_title' => $postTitle
                        ));
                    $this->_updatePostTitleCount(1);
                }
            }
        }
        
        // edit a post
        if (isset($GLOBALS['XenForo_ControllerPublic_Post'])) {
            /* @var $controller XenForo_ControllerPublic_Post */
            $controller = $GLOBALS['XenForo_ControllerPublic_Post'];
            
            $input = $controller->getInput()->filter(
                array(
                    'post_title' => XenForo_Input::STRING,
                    'post_title_shown' => XenForo_Input::UINT
                ));
            
            if ($input['post_title_shown']) {
                if ($input['post_title']) {
                    if ($forum['allow_post_titles_th'] && ($xenOptions->th_postTitles_allowTitleInFirstPost ||
                         $discussionDw->get('first_post_id') != $this->get('post_id'))) {
                        $stmt = $db->query(
                            '
                            INSERT INTO xf_post_title_th
                            (post_id, post_title)
                            VALUES (?, ?)
                            ON DUPLICATE KEY UPDATE post_title = VALUES(post_title)
                        ', 
                            array(
                                $this->get('post_id'),
                                $input['post_title']
                            ));
                        
                        $affectedRows = $stmt->rowCount();
                        if ($affectedRows == 1) {
                            $this->_updatePostTitleCount(1);
                        } else {
                            // duplicate key update, do nothing
                        }
                    } else {
                        $stmt = $db->update('xf_post_title_th',
                            array(
                                'post_title' => $input['post_title']
                            ), 'post_id = ' . $db->quote($this->get('post_id')));
                    }
                } else {
                    $affectedRows = $db->delete('xf_post_title_th',
                        'post_id = ' . $db->quote($this->get('post_id')));
                    
                    if ($affectedRows) {
                        $this->_updatePostTitleCount(-1);
                    }
                }
            }
        }
    }

    protected function _messagePostDelete()
    {
        parent::_messagePostDelete();
        
        /* @var $db Zend_Db_Adapter_Abstract */
        $db = $this->_db;
        
        $affectedRows = $db->delete('xf_post_title_th', 'post_id = ' . $db->quote($this->get('post_id')));
        
        if ($affectedRows) {
            $this->_updatePostTitleCount(-1);
        }
    }

    protected function _updatePostTitleCount($adjustment)
    {
        /* @var $db Zend_Db_Adapter_Abstract */
        $db = $this->_db;
        
        if ($adjustment > 0) {
            $stmt = $db->query(
                '
                    INSERT INTO xf_post_title_count_th
                    (thread_id, post_title_count)
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE post_title_count = post_title_count + VALUES(post_title_count)
                ', 
                array(
                    $this->get('thread_id'),
                    $adjustment
                ));
        } else {
            $stmt = $db->query(
                '
                    UPDATE xf_post_title_count_th
                    SET post_title_count = post_title_count - ?
                    WHERE thread_id = ?
                ', 
                array(
                    -$adjustment,
                    $this->get('thread_id')
                ));
        }
    }
}