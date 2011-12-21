<?php
/**
 * Etherpads archivo de idioma Español
 */

$spanish = array(

	/**
	 * Menu items and titles
	 * Sería mejor cambiar Etherpads por Documentos Colaborativos o algo asi
	 */
	'etherpad' => "Etherpads",
	'etherpad:add' => "Nuevo etherpad",
	'etherpad:edit' => "Editar etherpad",
	'etherpad:owner' => "Etherpads de %s",
	'etherpad:friends' => "Etherpat de Amigos",
	'etherpad:everyone' => "Todos los etherpads",
	'etherpad:new' => "Un nuevo etherpad",
	'etherpad:via' => "v&iacute;a etherpad",
	'etherpad:address' => "Direcci&oacute;n de etherpad",
	'etherpad:none' => 'No hay etherpads',
	'etherpad:write' => 'Agregar etherpad',
	'etherpad:delete:confirm' => "&iquest;Est&aacute; seguro de eliminar este recurso?",
	'etherpad:fullscreen' => 'Pantalla completa',
	'etherpad:numbertodisplay' => 'N&uacute;mero de etherpad a mostrar',

	'etherpad:visit' => "Visitar este recurso",
	'etherpad:recent' => "Etherpad recientes",
	'etherpad:access:message' => "Por el momento todos los etherpads son p&uacute;blicos. Proximante se podr&aacute; cambiar esto",
	'river:create:object:etherpad' => '%s ha creado un nuevo etherpad llamado %s',
	'river:comment:object:etherpad' => '%s comento el etherpad llamado %s',
	'etherpad:river:annotate' => 'un comentario en este etherpad',

	'item:object:etherpad' => 'Etherpads',

	'etherpad:group' => 'Etherpads del Grupo',
	'etherpad:enabletherpads' => 'Activar etherpads del grupo',
	'etherpad:nogroup' => 'Este grupo no tiene etherpads a&uacute;n',
	'etherpad:more' => 'M&aacute;s etherpads',

	'etherpad:no_title' => 'Sin t&iacute;tulo',

	/**
	 * Status messages
	 */

	'etherpad:save:success' => "El etherpad se guardo correctamente.",
	'etherpad:delete:success' => "El etherpad se elimin&oacute; correctamente.",

	/**
	 * Error messages
	 */

	'etherpad:save:failed' => "El etherpad no se pudo guardar, aseg&uacute;rese que ha introducido el t&iacute;tulo y vuelva a intentarlo",
	'etherpad:delete:failed' => "Su etherpad no se pudo guardar, int&eacute;ntelo nuevamente.",
	
	/**
	 * Edit page
	 */
	 
	 'etherpad:edit:title' => "título",
	 'etherpad:edit:desc' => "descripción",
	 'etherpad:edit:tags' => "etiquetas",

	/**
	 * Admin settings
	 */

	'etherpad:etherpadhost' => "Direcci&oacute;n del Host de Etherpad Lite",
	'etherpad:etherpadkey' => "Etherpad lite api key:",
	'etherpad:showchat' => "&iquest;Mostrar Chat?",
	'etherpad:linenumbers' => "&iquest;Mostrar n&uacute;mero de l&iacute;neas?",
	'etherpad:showcontrols' => "&iquest;Mostrar controles?",
	'etherpad:monospace' => "&iquest;Usar fuentes mono espacio?",
	'etherpad:showcomments' => "&iquest;Mostrar comentarios?",
	'etherpad:newpadtext' => "Texo de bienvenida a mostrar dentro de los etherpad nuevos:",
	'etherpad:pad:message' => 'El nuevo etherpad se ha creado correctamente.',
	
	/**
	 * Widget
	 */
	'etherpad:profile:numbertodisplay' => "N&uacute;mero de etherpad a mostrar",
        'etherpad:profile:widgetdesc' => "Mostrar sus &uacute;ltimos etherpads",
);

add_translation('es', $spanish);
