<?php
// $Id: editarprova.php,v 1.9 2007/03/24 20:08:53 marcellobrandao Exp $
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
include dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
include_once(XOOPS_ROOT_PATH . '/Frameworks/art/functions.admin.php');
include dirname(__DIR__) . '/class/assessment_perguntas.php';
include dirname(__DIR__) . '/class/assessment_provas.php';

/**
 * Verifica��o de seguran�a validando o TOKEN
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header($_SERVER['HTTP_REFERER'], 5, _AM_ASSESSMENT_TOKENEXPIRED);
}
$fabrica_de_provas      = new Xoopsassessment_provasHandler($xoopsDB);
$instrucoes             = $_POST['campo_instrucoes'];
$descricao              = $_POST['campo_descricao'];
$titulo                 = $_POST['campo_titulo'];
$cod_prova              = $_POST['campo_cod_prova'];
$acesso                 = $_POST['campo_grupo'];
$tempo                  = $_POST['campo_tempo'];
$datahorainicio         = $_POST['campo_data_inicio'];
$horainicio             = $fabrica_de_provas->converte_segundos($datahorainicio['time'], 'H');
$data_hora_inicio_MYSQL = $datahorainicio['date'] . ' ' . $horainicio['horas'] . ':' . $horainicio['minutos'] . ':' . $horainicio['segundos'];
$datahorafim            = $_POST['campo_data_fim'];
$horafim                = $fabrica_de_provas->converte_segundos($datahorafim['time'], 'H');
$data_hora_fim_MYSQL    = $datahorafim['date'] . ' ' . $horafim['horas'] . ':' . $horafim['minutos'] . ':' . $horainicio['segundos'];

$data_hora_inicio_UNIX = $fabrica_de_provas->dataMysql2dataUnix($data_hora_inicio_MYSQL);
$data_hora_fim_UNIX    = $fabrica_de_provas->dataMysql2dataUnix($data_hora_fim_MYSQL);

if ($data_hora_inicio_UNIX > $data_hora_fim_UNIX) {
    redirect_header($_SERVER['HTTP_REFERER'], 5, _AM_ASSESSMENT_DATAINICIOMAIORQFIM);
}
/*if (!(is_int($tempo) & $tempo>0 )) {

                 redirect_header($_SERVER['HTTP_REFERER'], 5, $tempo." n�o � um n�mero inteiro. ");
                    }*/
$uid_elaborador = $xoopsUser->getVar('uid');

$prova =& $fabrica_de_provas->create(false);
$prova->load($cod_prova);
$prova->setVar('descricao', $descricao);
$prova->setVar('instrucoes', $instrucoes);
$prova->setVar('titulo', $titulo);
$prova->setVar('tempo', $tempo);
$prova->setVar('acesso', implode(',', $acesso));
$prova->setVar('uid_elaboradores', $uid_elaborador);
$prova->setVar('data_inicio', $data_hora_inicio_MYSQL);
$prova->setVar('data_fim', $data_hora_fim_MYSQL);
//$prova->unsetNew();

//$prova->setVar("data_update",$agora);
if ($fabrica_de_provas->insert($prova)) {
    redirect_header('main.php?op=editar_prova&amp;cod_prova=' . $cod_prova, 2, _AM_ASSESSMENT_SUCESSO);
}
