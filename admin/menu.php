<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 * @version      $Id $
 */
defined('XOOPS_ROOT_PATH') or die('XOOPS root path not defined');

//$path = dirname(dirname(dirname(__DIR__)));
//include_once $path . '/mainfile.php';

$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname(basename(dirname(__DIR__)));
$pathIcon32    = '../../' . $module->getInfo('icons32');
xoops_loadLanguage('modinfo', $module->dirname());

$pathModuleAdmin = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin') . '/moduleadmin';
if (!file_exists($fileinc = $pathModuleAdmin . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $pathModuleAdmin . '/language/english/main.php';
}
include_once $fileinc;

$adminmenu              = array();
$i                      = 0;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/home.png';
++$i;
$adminmenu[$i]['title'] = _MI_ASSESSMENT_ADMENU1;
$adminmenu[$i]['link']  = 'admin/main.php?op=manter_provas';
$adminmenu[$i]['icon']  = $pathIcon32 . '/manage.png';
++$i;
$adminmenu[$i]['title'] = _MI_ASSESSMENT_ADMENU2;
$adminmenu[$i]['link']  = 'admin/main.php?op=manter_resultados';
$adminmenu[$i]['icon']  = $pathIcon32 . '/button_ok.png';
++$i;
$adminmenu[$i]['title'] = _MI_ASSESSMENT_ADMENU3;
$adminmenu[$i]['link']  = 'admin/main.php?op=manter_documentos';
$adminmenu[$i]['icon']  = $pathIcon32 . '/content.png';
++$i;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/about.png';
