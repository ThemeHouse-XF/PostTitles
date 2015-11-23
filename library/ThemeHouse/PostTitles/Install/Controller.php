<?php

class ThemeHouse_PostTitles_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'https://xenforo.com/community/resources/post-titles-by-th.4158/';

    protected $_minVersionId = 1020000;

    protected $_minVersionString = '1.2.0';

    protected function _getTables()
    {
        return array(
            'xf_post_title_count_th' => array(
                'thread_id' => 'int UNSIGNED NOT NULL PRIMARY KEY',
                'post_title_count' => 'int UNSIGNED NOT NULL'
            ),
            'xf_post_title_th' => array(
                'post_id' => 'int UNSIGNED NOT NULL PRIMARY KEY',
                'post_title' => 'varchar(150)'
            )
        );
    }

    protected function _getTableChanges()
    {
        return array(
            'xf_forum' => array(
                'allow_post_titles_th' => 'tinyint UNSIGNED NOT NULL DEFAULT 0'
            )
        );
    }


    protected function _postInstall()
    {
        $addOn = $this->getModelFromCache('XenForo_Model_AddOn')->getAddOnById('YoYo_');
        if ($addOn) {
            $db->query("
                INSERT INTO xf_post_title_count_th (thread_id, post_title_count)
                    SELECT thread_id, post_title_count
                        FROM xf_post_title_count_waindigo"); 
            $db->query("
                INSERT INTO xf_post_title_th (post_id, post_title)
                    SELECT post_id, post_title
                        FROM xf_post_title_waindigo"); 
            $db->query("
                UPDATE xf_forum
                    SET allow_post_titles_th=allow_post_titles_waindigo");
        }
    }
}