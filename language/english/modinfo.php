<?php
// $Id: modinfo.php,v 1.9 2007/03/24 17:51:05 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Module Info

// The name of this module
define('_MI_ASSESSMENT_NAME', 'Assessment');

// A brief description of this module
define('_MI_ASSESSMENT_DESC', 'This module enables you to create questions, answers and group them all together to create an exam/assessment');

// Names of admin menu items
define('_MI_ASSESSMENT_ADMENU1', 'Exams');
define('_MI_ASSESSMENT_ADMENU2', 'Results');
define('_MI_ASSESSMENT_ADMENU3', 'Documents');

//OP��es de configura��o
define('_MI_ASSESSMENT_CONFIG1_DESC', 'Number of items by row in questions.php');
define('_MI_ASSESSMENT_CONFIG1_TITLE', 'Size of Navigation bar');
define('_MI_ASSESSMENT_CONFIG2_DESC', 'Chose your favourite editor');
define('_MI_ASSESSMENT_CONFIG2_TITLE', 'Editor');
define('_MI_ASSESSMENT_CONFIG3_DESC', 'Would like to have your results directly <br />instead of waiting for the teachers correction?');
define('_MI_ASSESSMENT_CONFIG3_TITLE', 'Direct Result');
define('_MI_ASSESSMENT_CONFIG4_DESC', 'Quantity of exams, questions, documents or results<br />in the lists of the admin side of the module');
define('_MI_ASSESSMENT_CONFIG4_TITLE', 'Items per page');
define('_MI_ASSESSMENT_CONFIG5_DESC', 'Quantity of exams in the list of the main index.php page');
define('_MI_ASSESSMENT_CONFIG5_TITLE', 'Exams in index');

//Descri��o dos templates
define('_MI_ASSESSMENT_TPL1_TITLE', "Module's main page");
define('_MI_ASSESSMENT_TPL2_TITLE', 'Starting page of an exam');
define('_MI_ASSESSMENT_TPL3_TITLE', "Question's page");
define('_MI_ASSESSMENT_TPL4_TITLE', 'Confirmation of ending exam page');

//notifica��es
define('_MI_ASSESSMENT_PROVA_NOTIFY', 'Result');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_NOTIFY', 'Exam grading');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_NOTIFYCAP', 'Warn me when results are in');
define('_MI_ASSESSMENT_PROVA_NOTIFYDSC', 'Category of Results');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_ASSUNTOMAIL', 'The results are in!');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_NOTIFYDSC', 'Warn the student when the teacher has finish correcting the exam');
