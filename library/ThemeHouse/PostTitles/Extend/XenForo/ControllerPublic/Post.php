<?php

/**
 *
 * @see XenForo_ControllerPublic_Post
 */
class ThemeHouse_PostTitles_Extend_XenForo_ControllerPublic_Post extends XFCP_ThemeHouse_PostTitles_Extend_XenForo_ControllerPublic_Post
{

    /**
     *
     * @see XenForo_ControllerPublic_Post::actionSave()
     */
    public function actionSave()
    {
        $GLOBALS['XenForo_ControllerPublic_Post'] = $this;
        
        return parent::actionSave();
    }

    /**
     *
     * @see XenForo_ControllerPublic_Post::actionSave()
     */
    public function actionSaveInline()
    {
        $GLOBALS['XenForo_ControllerPublic_Post'] = $this;
        
        return parent::actionSaveInline();
    }
}