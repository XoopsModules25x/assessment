<?php
// $Id: modinfo.php,v 1.3 2007/03/24 17:51:05 marcellobrandao Exp $
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
define('_MI_ASSESSMENT_DESC', 'M�dulo que permite criar perguntas, respostas e agrup�-las no formato de uma prova');

// Names of admin menu items
define('_MI_ASSESSMENT_ADMENU1', 'Manter Provas');
define('_MI_ASSESSMENT_ADMENU2', 'Manter Resultados');
define('_MI_ASSESSMENT_ADMENU3', 'Manter Documentos');

//OP��es de configura��o
define('_MI_ASSESSMENT_CONFIG1_DESC', 'Quantidade de perguntas por linha na barra de navega��o');
define('_MI_ASSESSMENT_CONFIG1_TITLE', 'Tamanho barra de navega��o');
define('_MI_ASSESSMENT_CONFIG2_DESC', 'Escolha qual editor voc� prefere');
define('_MI_ASSESSMENT_CONFIG2_TITLE', 'Editor para documentos');
define('_MI_ASSESSMENT_CONFIG3_DESC', 'Resultado da prova imediatamente disponivel <br />sem precisar passar pela valida��o do professor');
define('_MI_ASSESSMENT_CONFIG3_TITLE', 'Resultado direto');
define('_MI_ASSESSMENT_CONFIG4_DESC', 'Quantidade de provas , perguntas , <br />documentos ou resultados nas listas da admninistra��o');
define('_MI_ASSESSMENT_CONFIG4_TITLE', 'Itens por p�gina');
define('_MI_ASSESSMENT_CONFIG5_DESC', 'Quantidade de provas na p�gina principal');
define('_MI_ASSESSMENT_CONFIG5_TITLE', 'Provas na p�gina principal');

//Descri��o dos templates
define('_MI_ASSESSMENT_TPL1_TITLE', 'P�gina principal do M�dulo');
define('_MI_ASSESSMENT_TPL2_TITLE', 'Folha de rosto da prova');
define('_MI_ASSESSMENT_TPL3_TITLE', 'P�gina com uma pergunta');
define('_MI_ASSESSMENT_TPL4_TITLE', 'P�gina de confirma��o de finaliza��o da prova');

//notifica��es
define('_MI_ASSESSMENT_PROVA_NOTIFY', 'Resultado');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_NOTIFY', 'Corre��o da Prova');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_NOTIFYCAP', 'Avise-me quando sair o resultado desta prova');
define('_MI_ASSESSMENT_PROVA_NOTIFYDSC', 'Categoria sobre resultados da prova');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_ASSUNTOMAIL', 'Saiu o resultado da sua prova!');
define('_MI_ASSESSMENT_PROVA_CORRIGIDA_NOTIFYDSC', 'Avisar o aluno qunado o professor liberar o resultado');
