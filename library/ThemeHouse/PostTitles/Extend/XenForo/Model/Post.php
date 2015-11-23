<?php

/**
 *
 * @see XenForo_Model_Post
 */
class ThemeHouse_PostTitles_Extend_XenForo_Model_Post extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_Model_Post
{

    const FETCH_POST_TITLES = 0x01;

    /**
     *
     * @see XenForo_Model_Post::preparePostJoinOptions()
     */
    public function preparePostJoinOptions(array $fetchOptions)
    {
        $postJoinOptions = parent::preparePostJoinOptions($fetchOptions);
        
        $selectFields = $postJoinOptions['selectFields'];
        $joinTables = $postJoinOptions['joinTables'];
        
        $db = $this->_getDb();
        
        if (!empty($fetchOptions['th_postTitles_join'])) {
            if ($fetchOptions['th_postTitles_join'] & self::FETCH_POST_TITLES) {
                $selectFields .= ',
				    post_title.post_title';
                $joinTables .= '
    				LEFT JOIN xf_post_title_th AS post_title
    					ON (post_title.post_id = post.post_id)';
            }
        }
        
        return array(
            'selectFields' => $selectFields,
            'joinTables' => $joinTables
        );
    }

    public function getPostsWithTitlesInThread($threadId, array $fetchOptions = array(), $cutOffPositions = null)
    {
        $stateLimit = $this->prepareStateLimitFromConditions($fetchOptions, 'post');
        
        $fetchOptions['th_postTitles_join'] = self::FETCH_POST_TITLES;
        
        $joinOptions = $this->preparePostJoinOptions($fetchOptions);
        $limitOptions = $this->prepareLimitFetchOptions($fetchOptions);
        
        $skipThread = $cutOffPositions ? 'AND (post.position < ' . $this->_getDb()->quote($cutOffPositions[0]) .
             ' OR post.position > ' . $this->_getDb()->quote($cutOffPositions[1]) . ')' : '';
        
        return $this->fetchAllKeyed(
            $this->limitQueryResults(
                '
        			SELECT post.*
        				' . $joinOptions['selectFields'] . '
        			FROM xf_post AS post
        			' . $joinOptions['joinTables'] . '
        			WHERE post.thread_id = ?
        				AND (' . $stateLimit . ')
                        AND post_title IS NOT NULL
                        ' . $skipThread . '
        			ORDER BY post.position ASC, post.post_date ASC
			', $limitOptions['limit'], $limitOptions['offset']), 
            'post_id', $threadId);
    }
}