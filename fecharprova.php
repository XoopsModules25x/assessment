<?php
// $Id: fecharprova.php,v 1.9 2007/03/24 15:18:54 marcellobrandao Exp $
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
 * fecharprova.php, Respons�vel por processar o formul�rio de encerramento da prova
 *
 * Este arquivo processa os dados da prova do usu�rio e a fecha definitivamente
 *
 * @author  Marcello Brand�o <marcello.brandao@gmail.com>
 * @version 1.0
 * @package assessment
 */

/**
 * Arquivos de cabe�alho do Xoops para carregar ...
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
 * Pegando cod_prova do formul�rio
 */
$cod_resultado = $_POST['cod_resultado'];

/**
 * Verifica��o de seguran�a validando o TOKEN
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header($_SERVER['HTTP_REFERER'], 5, _MA_ASSESSMENT_TOKENEXPIRED);
}

/**
 * Cria��o da F�brica de resultados e perguntas (padr�o de projeto factory com DAO)
 */
$fabrica_resultados = new Xoopsassessment_resultadosHandler($xoopsDB);
$fabrica_perguntas  = new Xoopsassessment_perguntasHandler($xoopsDB);

/**
 * Buscando na F�brica o resultado (padr�o de projeto factory com DAO)
 */
$resultado = $fabrica_resultados->create(false);
$resultado = $fabrica_resultados->get($cod_resultado);

/**
 * Calculando a nota do individuo
 */
$resp_certas  = $resultado->getVar('resp_certas');
$resp_erradas = $resultado->getVar('resp_erradas');
$cod_prova    = $resultado->getVar('cod_prova');

$criteria      = new criteria('cod_prova', $cod_prova);
$qtd_perguntas = $fabrica_perguntas->getCount($criteria);

$qtd_acertos = count(explode(',', $resp_certas));
$qtd_erros   = count(explode(',', $resp_erradas));
if ($resp_certas[0] == '') {
    $qtd_acertos = 0;
}
if ($resp_erradas[0] == '') {
    $qtd_erros = 0;
}
$nota_sugest = round(100 * $qtd_acertos / $qtd_perguntas, 2);

/**
 * Atualizando o resultado para que a prova fique indispon�vel para o aluno ou
 * se assim for definido nas preferencias saia logo o resultado
 */
$resultado->setVar('nota_final', $nota_sugest);
$resultado->setVar('terminou', 1);
if ($xoopsModuleConfig['notadireta'] == 1) {
    $resultado->setVar('fechada', 1);
}
$resultado->unsetNew();

/**
 * Atualiza o resultado e d� uma mensagem de sucesso
 */
if ($fabrica_resultados->insert($resultado)) {
    redirect_header('index.php', 5, _MA_ASSESSMENT_CONGRATULATIONS);
}

/**
 * Inclus�o de arquivo de fechamento da p�gina
 */
include dirname(dirname(__DIR__)) . '/footer.php';
