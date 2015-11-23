<?php

/**
 *
 * @see XenForo_DataWriter_Forum
 */
class ThemeHouse_PostTitles_Extend_XenForo_DataWriter_Forum extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_DataWriter_Forum
{

    /**
     *
     * @see XenForo_DataWriter_Forum::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
        
        $fields['xf_forum']['allow_post_titles_th'] = array(
            'type' => XenForo_DataWriter::TYPE_BOOLEAN,
            'default' => false
        );
        
        return $fields;
    }

    /**
     *
     * @see XenForo_DataWriter_Forum::_preSave()
     */
    protected function _preSave()
    {
        parent::_preSave();
        
        if (!empty($GLOBALS['XenForo_ControllerAdmin_Forum'])) {
            /* @var $controller XenForo_ControllerAdmin_Forum */
            $controller = $GLOBALS['XenForo_ControllerAdmin_Forum'];
            
            $input = $controller->getInput()->filter(
                array(
                    'allow_post_titles' => XenForo_Input::BOOLEAN,
                    'allow_post_titles_shown' => XenForo_Input::BOOLEAN
                ));
            
            if ($input['allow_post_titles_shown']) {
                $this->set('allow_post_titles_th', $input['allow_post_titles']);
            }
        }
    }
}