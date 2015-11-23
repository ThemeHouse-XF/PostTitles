<?php

class ThemeHouse_PostTitles_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/PostTitles/Extend/XenForo/ControllerAdmin/Forum.php' => '61318a5ce4cb5e7d6a8b04a08fd5169d',
                'library/ThemeHouse/PostTitles/Extend/XenForo/ControllerHelper/ForumThreadPost.php' => 'd57a0ebdbc870057c1b8420a7c4dac27',
                'library/ThemeHouse/PostTitles/Extend/XenForo/ControllerPublic/Post.php' => '3a1387a2f06a1260967c729f558a83ef',
                'library/ThemeHouse/PostTitles/Extend/XenForo/ControllerPublic/Thread.php' => '432e8a020127be4a51223237bca5e711',
                'library/ThemeHouse/PostTitles/Extend/XenForo/DataWriter/DiscussionMessage/Post.php' => '6618c6bfd5265f4c8d77c1e9dd9805e5',
                'library/ThemeHouse/PostTitles/Extend/XenForo/DataWriter/Forum.php' => '11b8a2618d17dabc5a01390c883a2b90',
                'library/ThemeHouse/PostTitles/Extend/XenForo/Model/Post.php' => '928d3ae372906640a83bd001f156d6a5',
                'library/ThemeHouse/PostTitles/Extend/XenForo/Model/Thread.php' => '9859c3f9a3841e2d8c5476adec2bae92',
                'library/ThemeHouse/PostTitles/Install/Controller.php' => 'f1982d2054e31417a2095595baa63893',
                'library/ThemeHouse/PostTitles/Listener/LoadClass.php' => '57b9492b5d5895badf203705d8a6d980',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
            ));
    }
}