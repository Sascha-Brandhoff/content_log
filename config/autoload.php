<?php

ClassLoader::addNamespaces(array
(
	'Contao'
));
 
ClassLoader::addClasses(array
(
	'Contao\ClassContentLog'  => 'system/modules/content_log/classes/ClassContentLog.php',
	'Contao\ModuleContentLog' => 'system/modules/content_log/modules/ModuleContentLog.php'
));

TemplateLoader::addFiles(array
(
	'mod_content_log' => 'system/modules/content_log/templates/modules',

	'cl_list'         => 'system/modules/content_log/templates/log',
	'cl_element'      => 'system/modules/content_log/templates/log',
));
