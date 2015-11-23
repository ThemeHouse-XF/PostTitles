<?php

class ThemeHouse_PostTitles_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_PostTitles' => array(
                'datawriter' => array(
                    'XenForo_DataWriter_DiscussionMessage_Post',
                    'XenForo_DataWriter_Forum'
                ),
                'controller' => array(
                    'XenForo_ControllerPublic_Post',
                    'XenForo_ControllerPublic_Thread',
                    'XenForo_ControllerAdmin_Forum'
                ),
                'model' => array(
                    'XenForo_Model_Post',
                    'XenForo_Model_Thread'
                ),
                'helper' => array(
                    'XenForo_ControllerHelper_ForumThreadPost'
                ),
            ),
        );
    }

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_PostTitles_Listener_LoadClass', $class, $extend, 'datawriter');
    }

    public static function loadClassController($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_PostTitles_Listener_LoadClass', $class, $extend, 'controller');
    }

    public static function loadClassModel($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_PostTitles_Listener_LoadClass', $class, $extend, 'model');
    }

    public static function loadClassHelper($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_PostTitles_Listener_LoadClass', $class, $extend, 'helper');
    }
}