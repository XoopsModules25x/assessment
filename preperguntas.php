<?php
// $Id: preperguntas.php,v 1.5 2007/03/24 14:41:41 marcellobrandao Exp $
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
/**
 * preperguntas.php, Respons�vel pelo processamento da abertura de prova
 *
 * Este arquivo processa a abertura da prova criando um resultado para aluno
 * pela primeira vez. Este resultado ser� atualizado durante as respostas do ]
 * usu�rio e na adminsitra��o quando o aluno estiver recebendo a sua nota
 *
 * @author  Marcello Brand�o <marcello.brandao@gmail.com>
 * @version 1.0
 * @package assessment
 */

/**
 * Inclus�es do Xoops
 */
include dirname(dirname(__DIR__)) . '/mainfile.php';
include dirname(dirname(__DIR__)) . '/header.php';

/**
 * Inclus�es das classes do m�dulo
 */
include __DIR__ . '/class/assessment_perguntas.php';
include __DIR__ . '/class/assessment_provas.php';
include __DIR__ . '/class/assessment_respostas.php';
include __DIR__ . '/class/assessment_resultados.php';

/**
 * Pegando cod_prova do formul�rio e uid do aluno da session
 */
$cod_prova = $_POST['cod_prova'];
$uid       = $xoopsUser->getVar('uid');

/**
 * Verifica��o de seguran�a validando o TOKEN
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header($_SERVER['HTTP_REFERER'], 5, _MA_ASSESSMENT_TOKENEXPIRED);
}

/**
 * Cria��o da F�brica de resultados (padr�o de projeto factory com DAO)
 */
$fabrica_resultados = new Xoopsassessment_resultadosHandler($xoopsDB);

/**
 * Cria��o dos crit�rios para a f�brica produzir os objetos
 */
$criteria_prova = new criteria('cod_prova', $cod_prova);
$criteria_aluno = new criteria('uid_aluno', $uid);
$criteria       = new criteriaCompo($criteria_prova);
$criteria->add($criteria_aluno);

/**
 * Verifica se o resultado j� foi criado anteriormente e sen�o
 * cria o resultado, se sim informa que a prova est� em andamento j�
 */
if ($fabrica_resultados->getCount($criteria) < 1) {
    $resultado = $fabrica_resultados->create();
    $resultado->setVar('uid_aluno', $uid);
    $resultado->setVar('cod_prova', $cod_prova);
    $fabrica_resultados->insert($resultado);
    redirect_header('perguntas.php?cod_prova=' . $cod_prova . '&start=0', 8, _MA_ASSESSMENT_CONTAGEMSTART);
} else {
    redirect_header('perguntas.php?cod_prova=' . $cod_prova . '&start=0', 8, _MA_ASSESSMENT_PROVAEMANDAMENTO);
}

/**
 * Inclus�o de arquivo de fechamento da p�gina
 */
include dirname(dirname(__DIR__)) . '/footer.php';
