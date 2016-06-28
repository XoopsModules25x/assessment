<?php
// $Id: perguntas.php,v 1.18 2007/03/24 20:08:53 marcellobrandao Exp $
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
 * perguntas.php, Respons�vel por exibir a pergunta da vez
 *
 * Este arquivo prepara o formul�rio com a pergunta e se houver um
 * documento para ele ele tamb�m o exibe
 *
 * @author  Marcello Brand�o <marcello.brandao@gmail.com>
 * @version 1.0
 * @package assessment
 */

/**
 * Arquivos de cabe�alho do Xoops para carregar ...
 */
include dirname(dirname(__DIR__)) . '/mainfile.php';

/**
 * Definindo arquivo de template da p�gina
 */
$xoopsOption['template_main'] = 'assessment_perguntas.tpl';

include dirname(dirname(__DIR__)) . '/header.php';

/**
 * Inclus�es das classes do m�dulo
 */
include __DIR__ . '/class/assessment_perguntas.php';
include __DIR__ . '/class/assessment_provas.php';
include __DIR__ . '/class/assessment_respostas.php';
include __DIR__ . '/class/assessment_resultados.php';
include __DIR__ . '/class/assessment_documentos.php';
include __DIR__ . '/class/navegacao.php'; // classe derivada da pagenav do xoops para exibir as perguntas que j� foram respondidas

/**
 * Inclus�o de classe de barra de navega��o
 */
include_once dirname(dirname(__DIR__)) . '/class/pagenav.php';

/**
 * Pegando cod_prova  e start do GET e uid do aluno da session
 * o start � a possi��o em que a prova est�, a quest�o
 */
$cod_prova = $_GET['cod_prova'];
$uid       = $xoopsUser->getVar('uid');
$start     = $_GET['start'];

/**
 * Cria��o das F�bricas de objetos que vamos precisar
 */
$fabrica_de_provas     = new Xoopsassessment_provasHandler($xoopsDB);
$fabrica_resultados    = new Xoopsassessment_resultadosHandler($xoopsDB);
$fabrica_de_respostas  = new Xoopsassessment_respostasHandler($xoopsDB);
$fabrica_de_perguntas  = new Xoopsassessment_perguntasHandler($xoopsDB);
$fabrica_de_documentos = new Xoopsassessment_documentosHandler($xoopsDB);

/**
 * Buscando na f�brica a prova a que esta pergunta pertence
 */
$prova = $fabrica_de_provas->get($cod_prova);

/**
 * Verificando privil�gios do aluno para esta prova
 */
if (!$prova->isAutorizado()) {
    redirect_header('index.php', 5, _MA_ASSESSMENT_PROIBIDO);
}

/**
 * Verificando prova j� expirou
 */
$fim          = $prova->getVar('data_fim', 'n');
$tempo        = $prova->getVar('tempo', 'n');
$fimmaistempo = $fabrica_de_provas->dataMysql2dataUnix($fim) + $tempo;

if ($fimmaistempo < time()) {
    redirect_header('index.php', 5, _MA_ASSESSMENT_PROIBIDO);
}

/**
 * Verificando se aluno j� tinha terminado a prova antes em caso positivo
 * informa atraves de mensagem
 */
$criteria_prova = new criteria('cod_prova', $cod_prova);
$criteria_prova->setOrder('ASC');
$criteria_prova->setSort('ordem');
$criteria_aluno     = new criteria('uid_aluno', $uid);
$criteria_terminou  = new criteria('terminou', 1);
$criteria_resultado = new criteriaCompo($criteria_aluno);
$criteria_resultado->add($criteria_prova);
$criteria_resultado->add($criteria_terminou);
if ($fabrica_resultados->getCount($criteria_resultado) > 0) {
    redirect_header('index.php', 5, _MA_ASSESSMENT_JATERMINOU);
}
/**
 * Verificando se a prova j� tem perguntas cadastradas se n�o
 * tiver , n�o deixa aluno ter acesso
 */
$qtd_perguntas = $fabrica_de_perguntas->getCount($criteria_prova);
if ($qtd_perguntas < 1) {
    redirect_header('index.php', 5, _MA_ASSESSMENT_PROVAVAZIA);
}

/**
 * Cria��o de objetos de crit�rio para passar para as F�bricas
 */
$criteria_compo = new criteriaCompo($criteria_prova);
$criteria_compo->add($criteria_aluno);

/**
 * Buscando na f�brica a quantidade de resultados desta prova para este aluno
 * para logo em seguida verificar se j� existe este objeto, n�o exisitndo
 * joga de volta para a introdu��o. O aluno n�o pode pular a instrocu��o por
 * quest�es funcionais
 */
$qtd_resultados = $fabrica_resultados->getCount($criteria_compo);
if ($qtd_resultados < 1) {
    redirect_header('verprova.php?cod_prova=' . $cod_prova, 5, 'Voc� n�o pode pular a parte de iniciar prova');
}

/**
 * Buscando o objeto resultado desta prova deste aluno na f�brica
 */
$resultados =& $fabrica_resultados->getObjects($criteria_compo);
$resultado  = $resultados[0];

/**
 * Calculos de tempo restante, tempo gasto e hor�rio do fim da prova
 * obs: cabe passar isso para dentro da classe resultado ou prova
 */
$horaatual = time() - 18000;
echo $horaatual . 'horaatual </br>';
$serverXX = abs((int)($GLOBALS['xoopsConfig']['server_TZ'] * 3600.0));
echo $serverXX . 'server TZ </br>';
echo 'Local: ' . date('r') . 'n<br />GMT: ' . gmdate('r') . '<br />';

$data_inicio_segundos = $fabrica_de_provas->dataMysql2dataUnix($resultado->getVar('data_inicio'));
echo $data_inicio_segundos . 'data_inicio_segundos </br>';

$tempo_prova = $prova->getVar('tempo');
echo $tempo_prova . 'tempo_prova   </br>';

$tempo_restante = $fabrica_de_provas->converte_segundos(($data_inicio_segundos + $tempo_prova) - $horaatual, 'H');
echo $tempo_restante . 'tempo_restante </br>';
var_dump($tempo_restante);

$tempo_gasto = $fabrica_de_provas->converte_segundos($horaatual - $data_inicio_segundos, 'H');
echo $tempo_gasto . 'tempo_gasto  </br>';
var_dump($$tempo_gasto);

$hora_fim_da_prova = $fabrica_de_provas->converte_segundos($data_inicio_segundos + $tempo_prova, 'H');
echo $hora_fim_da_prova . 'hora_fim_da_prova  </br>';
var_dump($hora_fim_da_prova);
/**
 * Verifica��o de tempo da prova: se estourar o tempo salvar o resultado e
 * avisar o aluno com a possibilidade de dar a nota direto pro aluno se assim
 * estiver definido na administra��o
 */
if ($tempo_restante['segundos'] < 0) {
    $resultado->setVar('terminou', 1);
    $resultado->unsetNew();
    if ($xoopsModuleConfig['notadireta'] == 1) {
        $resultado->setVar('fechada', 1);
    }
    $fabrica_resultados->insert($resultado, true);
    redirect_header('index.php', 5, _MA_ASSESSMENT_ACABOU);
}

//busca titulo da prova
$titulo_prova = $prova->getVar('titulo', 's');

/**
 * buscando as perguntas da prova, depois separando
 * a nossa pergunta e enfim pegando o c�digo dela que vamos precisar
 */
$perguntas    =& $fabrica_de_perguntas->getObjects($criteria_prova);
$pergunta     = $perguntas[$start];
$cod_pergunta = $pergunta->getVar('cod_pergunta');

/**
 * buscando documentos a serem exibidos antes da pergunta
 */
$documentos =& $fabrica_de_documentos->getDocumentosProvaPergunta($cod_prova, $cod_pergunta);

/**
 * Cria��o de objetos de crit�rio para passar para as F�bricas
 */
$criteria_pergunta = new criteria('cod_pergunta', $cod_pergunta);

/**
 * buscando as respostas a serem exibidas
 */
$respostas =& $fabrica_de_respostas->getObjects($criteria_pergunta);

/**
 * buscar resposta anterior a esta pergunta caso
 * o aluno j� a tenha respondido e o n�mero de perguntas que
 * ele j� respondeu
 */
$cod_resposta_anterior = $resultado->getRespostaUsuario($cod_pergunta);
$qtd_respostas         = $resultado->contarRespostas();

$cod_resultado = $resultado->getVar('cod_resultado');

/**
 * Vamos buscar os codigos das perguntas respondidas e os codigos das perguntas
 * para passar como parametros para a barra de navega��o que marca as perguntas
 * que j� foram respondidas em vermelho.
 */
$cod_perguntas_respondidas = $resultado->getCodPerguntasAsArray();
$cod_perguntas             =& $fabrica_de_perguntas->getCodObjects($criteria_prova);
$navegacao                 = new NavegadorProva($qtd_perguntas, 1, $start, 'start', 'cod_prova=' . $cod_prova);
$barra_navegacao           = $navegacao->renderImageNav($cod_perguntas, $cod_perguntas_respondidas, $xoopsModuleConfig['qtdmenu']);

//Montando o Formul�rio
$formulario = $fabrica_de_perguntas->renderFormResponder('form_resposta.php', $pergunta, $respostas, $cod_resposta_anterior);
$formulario->assign($xoopsTpl);

//sanitizing
//falta um if para n�o dar uma notice
foreach ($documentos as $doc) {
    //    $doc['documento'] = text_filter($doc['documento'],true);
    $doc['documento'] = $doc['documento'];
}
//nome do m�dulo
$nome_modulo = $xoopsModule->getVar('name');

//Repassando as vari�veis para o template
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' - ' . $titulo_prova);
$xoopsTpl->assign('nome_modulo', $nome_modulo);
$xoopsTpl->assign('documentos', $documentos);
$xoopsTpl->assign('barra_navegacao', $barra_navegacao);
$xoopsTpl->assign('start', $start);
$xoopsTpl->assign('titulo', $titulo_prova);
$xoopsTpl->assign('cod_prova', $cod_prova);
$xoopsTpl->assign('cod_resultado', $cod_resultado);
$xoopsTpl->assign('qtd_perguntas', $qtd_perguntas);
$xoopsTpl->assign('qtd_respostas', $qtd_respostas);
$xoopsTpl->assign('lang_andamento', sprintf(_MA_ASSESSMENT_ANDAMENTO, $qtd_respostas, $qtd_perguntas));
$xoopsTpl->assign('lang_encerrar', _MA_ASSESSMENT_ENCERRARPROVA);
$xoopsTpl->assign('lang_temporestante', sprintf(_MA_ASSESSMENT_TEMPORESTANTECOMPOSTO, $tempo_restante['horas'], $tempo_restante['minutos']));
$xoopsTpl->assign('lang_textosapoio', _MA_ASSESSMENT_TEXTOSAPOIO);
$xoopsTpl->assign('lang_pergunta', _MA_ASSESSMENT_PERGUNTA);
$xoopsTpl->assign('lang_respostas', _MA_ASSESSMENT_RESPOSTAS);
$xoopsTpl->assign('lang_legenda', _MA_ASSESSMENT_LEGENDA);
$xoopsTpl->assign('lang_jaresp', _MA_ASSESSMENT_JARESP);
$xoopsTpl->assign('lang_naoresp', _MA_ASSESSMENT_NAORESP);
$xoopsTpl->assign('lang_iconjaresp', _MA_ASSESSMENT_ICONJARESP);
$xoopsTpl->assign('lang_iconnaoresp', _MA_ASSESSMENT_ICONNAORESP);
$xoopsTpl->assign('tempo_restante', $tempo_restante);

//Fecha a p�gina com seu rodap�. Inclus�o Obrigat�ria
include dirname(dirname(__DIR__)) . '/footer.php';
