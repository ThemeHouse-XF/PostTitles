<?php

/**
 *
 * @see XenForo_ControllerAdmin_Forum
 */
class ThemeHouse_PostTitles_Extend_XenForo_ControllerAdmin_Forum extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_ControllerAdmin_Forum
{

    /**
     *
     * @see XenForo_ControllerAdmin_Forum::actionSave()
     */
    public function actionSave()
    {
        $GLOBALS['XenForo_ControllerAdmin_Forum'] = $this;
        
        return parent::actionSave();
    }
}