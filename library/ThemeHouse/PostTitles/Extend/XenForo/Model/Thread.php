<?php

/**
 *
 * @see XenForo_Model_Thread
 */
class ThemeHouse_PostTitles_Extend_XenForo_Model_Thread extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_Model_Thread
{

    const FETCH_POST_TITLE_COUNT = 0x01;

    /**
     *
     * @see XenForo_Model_Thread::prepareThreadFetchOptions()
     */
    public function prepareThreadFetchOptions(array $fetchOptions)
    {
        $threadFetchOptions = parent::prepareThreadFetchOptions($fetchOptions);
        
        $selectFields = $threadFetchOptions['selectFields'];
        $joinTables = $threadFetchOptions['joinTables'];
        $orderClause = $threadFetchOptions['orderClause'];
        
        if (!empty($fetchOptions['th_postTitles_join'])) {
            if ($fetchOptions['th_postTitles_join'] & self::FETCH_POST_TITLE_COUNT) {
                $selectFields .= ',
					post_title_count.post_title_count';
                $joinTables .= '
					LEFT JOIN xf_post_title_count_th AS post_title_count ON
						(post_title_count.thread_id = thread.thread_id)';
            }
        }
        
        return array(
            'selectFields' => $selectFields,
            'joinTables' => $joinTables,
            'orderClause' => $orderClause
        );
    }
}