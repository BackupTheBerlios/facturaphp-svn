-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 07-04-2005 a las 19:25:18
-- Versión del servidor: 4.1.7
-- Versión de PHP: 5.0.2
-- 
-- Base de datos: `transporte`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_clients`
-- 

CREATE TABLE IF NOT EXISTS `cat_clients` (
  `id_cat_client` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_cat_client`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `cat_clients`
-- 

INSERT INTO `cat_clients` VALUES (2, 'cate2', 'asdfadfadfadf');
INSERT INTO `cat_clients` VALUES (3, 'cat3', 'decripcion de cat3');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_emps`
-- 

CREATE TABLE IF NOT EXISTS `cat_emps` (
  `id_cat_emp` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_cat_emp`)
) ENGINE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Volcar la base de datos para la tabla `cat_emps`
-- 

INSERT INTO `cat_emps` VALUES (1, 'Gestor', 'Gestor de empleados');
INSERT INTO `cat_emps` VALUES (2, 'Director jefe', 'Director Jefe en funciones');
INSERT INTO `cat_emps` VALUES (3, 'Transportista', 'Persona que conduce los veh?culos de la empresa');
INSERT INTO `cat_emps` VALUES (4, 'Limpiador', 'Personal de limpieza');
INSERT INTO `cat_emps` VALUES (5, 'Contable', 'Contable de la empresa');
INSERT INTO `cat_emps` VALUES (7, 'Pe&oacute;n de carga', 'Persona encargada de la carga y descarga de veh?culos de la empresa');
INSERT INTO `cat_emps` VALUES (8, 'fasaaaa', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_prods`
-- 

CREATE TABLE IF NOT EXISTS `cat_prods` (
  `id_cat_prod` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `descrip` varchar(255) NOT NULL default '',
  `id_parent_cat` int(11) NOT NULL default '0',
  `path_photo` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_cat_prod`)
) ENGINE=MyISAM AUTO_INCREMENT=36 ;

-- 
-- Volcar la base de datos para la tabla `cat_prods`
-- 

INSERT INTO `cat_prods` VALUES (24, 'categoriafdsfdg', 'afdafafdfff', 0, 'images/cat_prods/24.JPG');
INSERT INTO `cat_prods` VALUES (25, 'asdfadfadf', 'fojdoijffiojfiojfiojfioj', 24, 'images/cat_prods/25.GIF');
INSERT INTO `cat_prods` VALUES (26, 'categoria_padre2', 'dfiosfaiofd', 0, 'images/cat_prods/26.PNG');
INSERT INTO `cat_prods` VALUES (27, 'categoria_hiija_2', 'fdaffdsf', 26, 'images/cat_prods/27.PNG');
INSERT INTO `cat_prods` VALUES (28, 'categoria_hija_hija', 'adsfadf', 27, 'images/cat_prods/28.PNG');
INSERT INTO `cat_prods` VALUES (29, 'categoria_hija3', '', 26, 'images/cat_prods/29.JPG');
INSERT INTO `cat_prods` VALUES (30, 'categoria nueva', 'affaaf', 0, 'images/cat_prods/30.GIF');
INSERT INTO `cat_prods` VALUES (31, 'categoria hija nueva', 'afdadfadf', 30, 'images/cat_prods/31.GIF');
INSERT INTO `cat_prods` VALUES (32, 'categoria padre 4', 'adfadfadf', 0, 'images/cat_prods/32.GIF');
INSERT INTO `cat_prods` VALUES (33, 'categoria hija 4', 'adfadfaf', 32, '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_servs`
-- 

CREATE TABLE IF NOT EXISTS `cat_servs` (
  `id_cat_serv` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `descrip` varchar(255) NOT NULL default '',
  `id_parent_cat` int(11) NOT NULL default '0',
  `path_photo` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_cat_serv`)
) ENGINE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `cat_servs`
-- 

INSERT INTO `cat_servs` VALUES (3, 'Categor&iacute;a', '', 0, 'pics/no-image.gif');
INSERT INTO `cat_servs` VALUES (2, 'adfasdfadfa', 'fdsadfsaf', 0, 'images/cat_servs/2.PNG');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_vehicles`
-- 

CREATE TABLE IF NOT EXISTS `cat_vehicles` (
  `id_cat_vehicle` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `name_web` varchar(50) NOT NULL default '',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_cat_vehicle`)
) ENGINE=MyISAM AUTO_INCREMENT=12 ;

-- 
-- Volcar la base de datos para la tabla `cat_vehicles`
-- 

INSERT INTO `cat_vehicles` VALUES (1, 'mi veh&iacute;culo', 'mi veh&iacute;culo', ' s&oacute;lo m&iacute;o quien lo toque se las ver&aacute; con la poli');
INSERT INTO `cat_vehicles` VALUES (10, 'Otra', 'ota', 'sdfafafasdf');
INSERT INTO `cat_vehicles` VALUES (11, 'categori', 'adf', 'afdaf');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clients`
-- 

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL auto_increment,
  `id_corp` int(11) NOT NULL default '0',
  `id_cat_client` int(11) NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `full_name` varchar(50) NOT NULL default '',
  `cif_nif` varchar(10) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `fiscal_address` varchar(255) NOT NULL default '',
  `postal_address` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `mail` varchar(100) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `postal_code` varchar(10) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `phone` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `mobile_phone` varchar(15) NOT NULL default '',
  `notes` text NOT NULL,
  `id_pay_type` int(11) NOT NULL default '0',
  `payday` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `clients`
-- 

INSERT INTO `clients` VALUES (2, 1, 2, 'pepe', 'pepe', '23423', 'sfdadsf', 'bads', 'bads', 'sdgf', 'sfdgsfdg', 'ggsaf', 'fgfd', 'ggg', 'sdfgsf', 'dsgfsfgd', 'sgfsfdg', 'sgf', 'asdfaf', 0, 0x303030302d30302d3030);
INSERT INTO `clients` VALUES (3, 1, 2, 'cliente 2', 'Cliente 2 S.L.', 'afdadsf', 'adsf', 'adfs', 'adfs', 'fafd', 'afd', 'afda', 'dfadsf', 'adsfadf', 'adfsa', 'fdafds', 'afdsa', 'adfasfd', 'fdsadfs', 0, 0x303030302d30302d3030);
INSERT INTO `clients` VALUES (4, 1, 3, 'cliente 3', 'cliente 3 S.L.', 'asdfad', 'fasdf', 'adfadsf', 'fdasdf', 'dfadfasfd', 'adsfadsf', 'fasdf', 'asdfasdf', 'asfas', 'asdfadsf', 'adsfa', 'adsfa', 'dfasfdafds', 'adfsadfasdfadsf', 0, 0x323030352d30342d3238);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `contacts`
-- 

CREATE TABLE IF NOT EXISTS `contacts` (
  `id_contact` int(11) NOT NULL auto_increment,
  `id_client` int(11) NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `last_name` varchar(20) NOT NULL default '',
  `last_name2` varchar(20) NOT NULL default '',
  `birthday` date NOT NULL default '0000-00-00',
  `phone` varchar(15) NOT NULL default '',
  `mobile_phone` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `postal_code` varchar(10) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id_contact`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `contacts`
-- 

INSERT INTO `contacts` VALUES (2, 3, 'luis', 'apoidfj', 'odfjpaojid', 0x323030352d30342d3232, 'adfadf', 'adfadfadf', 'dfafds', 'adfa', 'adfadfaf', 'adfadfadf', 'adfadfadfa', 'adfadfadf', 'adfafdadfa');
INSERT INTO `contacts` VALUES (3, 2, 'antonio', 'ppadpfoiajdf', 'dpfaoifja', 0x323030352d30342d3232, 'afdadaf', 'fad', 'adfadfa', 'adfsasdfdf', 'adfadsf', 'adfadfa', 'fdafddfafa', 'adfadfafad', 'fadfadsfa');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `corps`
-- 

CREATE TABLE IF NOT EXISTS `corps` (
  `id_corp` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `full_name` varchar(50) NOT NULL default '',
  `cif_nif` varchar(10) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `fiscal_address` varchar(255) NOT NULL default '',
  `postal_address` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `mail` varchar(100) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `postal_code` varchar(10) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `phone` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `mobile_phone` varchar(15) NOT NULL default '',
  `notes` text NOT NULL,
  PRIMARY KEY  (`id_corp`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `corps`
-- 

INSERT INTO `corps` VALUES (1, 'Resuival', 'Resuival', '76915846-L', 'Avd Portugal', 'Avd Portugal', 'Avd Portugal', 'www.resuival.es', 'elena@resuival.es', 'Salamanca', 'Salamanca', '37009', 'Espa&ntilde;a', '923487512', '923487512', '659326789', 'Empresa de limpieza y transporte');
INSERT INTO `corps` VALUES (2, 'Copiar-pegar', 'Copiar-Pegar Salamanca', '70952648', 'Alfonso IX', 'Alfonso IX', 'Alfonso IX', 'www.copiar-pegar.com', 'david@copiar-pegar.com', 'Salamanca', 'CyL', '37008', 'Espa?a', '923180512', '923180512', '656661478', 'Empresa de desarrollo basado en el software libre. Impulsadora de conocimientos mediante la ense?anza.');
INSERT INTO `corps` VALUES (3, 'Drag and Drop', 'Drag and Drop Salamanca', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `drivers`
-- 

CREATE TABLE IF NOT EXISTS `drivers` (
  `id_driver` int(11) unsigned NOT NULL auto_increment,
  `id_emp` int(11) unsigned NOT NULL default '0',
  `id_vehicle` int(11) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_driver`)
) ENGINE=MyISAM AUTO_INCREMENT=15 ;

-- 
-- Volcar la base de datos para la tabla `drivers`
-- 

INSERT INTO `drivers` VALUES (1, 1, 206, 0x323030352d31322d3330);
INSERT INTO `drivers` VALUES (2, 1, 208, 0x303030302d30302d3030);
INSERT INTO `drivers` VALUES (12, 1, 206, 0x323030352d30322d3032);
INSERT INTO `drivers` VALUES (8, 1, 206, 0x303030302d30302d3030);
INSERT INTO `drivers` VALUES (5, 2, 208, 0x323030352d30332d3136);
INSERT INTO `drivers` VALUES (7, 1, 206, 0x323030352d30322d3238);
INSERT INTO `drivers` VALUES (13, 1, 208, 0x323030352d30332d3233);
INSERT INTO `drivers` VALUES (14, 1, 206, 0x323030352d30332d3234);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `emps`
-- 

CREATE TABLE IF NOT EXISTS `emps` (
  `id_emp` int(11) NOT NULL auto_increment,
  `id_corp` int(11) NOT NULL default '0',
  `id_user` int(11) NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `last_name` varchar(20) NOT NULL default '',
  `last_name2` varchar(20) NOT NULL default '',
  `birthday` date NOT NULL default '0000-00-00',
  `phone` varchar(15) NOT NULL default '',
  `mobile_phone` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `postal_code` varchar(10) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `license` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_emp`),
  KEY `id_corp` (`id_corp`,`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=11 ;

-- 
-- Volcar la base de datos para la tabla `emps`
-- 

INSERT INTO `emps` VALUES (1, 1, 3, 'Elena', 'Resuival', 'Resuival', 0x303030302d30302d3030, '923564871', '665123489', '923564871', 'elena@hotmail.com', 'Calle ancha 63', 'Salamanca', 'Salamanca', '37006', 'Espa?a', 0x303030302d30302d3030);
INSERT INTO `emps` VALUES (2, 1, 1, 'David', 'Vaquero', 'Santiago', 0x303030302d30302d3030, '923247845', '646754340', '923247845', 'david@copiar-pegar.com', 'M&uacute;sico Antonio Jos', 'Salamanca', 'Salamanca', '37004', 'Espa&ntilde;a', 0x303030302d30302d3030);
INSERT INTO `emps` VALUES (3, 2, 1, 'David', 'Vaquero', 'Santiago', 0x323030342d31302d3235, '923247845', '646754340', '923247845', 'david@copiar-pegar.com', 'M?sico Antonio Jos', 'Salamanca', 'Salamanca', '37004', 'Espa?a', 0x303030302d30302d3030);
INSERT INTO `emps` VALUES (4, 2, 2, 'Daniel', 'Gonz?lez', 'Zaballos', 0x303030302d30302d3030, '923654875', '646754340', '923654875', 'daniel@copiar-pegar.com', 'Calle larga 26', 'Do?inos', 'Salamanca', '37009', 'Espa?a', 0x303030302d30302d3030);
INSERT INTO `emps` VALUES (5, 2, 4, 'Roc', 'Guti?rrez', 'Gonz?lez', 0x303030302d30302d3030, '923268475', '665053440', '', 'rocio_gg15@hotmail.com', 'Camino de Miranda 38', 'Salamanca', 'CyL', '37008', 'Espa?a', 0x303030302d30302d3030);
INSERT INTO `emps` VALUES (10, 1, 5, 'Prueba', 'pru', 'pru', 0x303030302d30302d3030, '', '', '', '', '', '', '', '', '', 0x303030302d30302d3030);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `group_users`
-- 

CREATE TABLE IF NOT EXISTS `group_users` (
  `id_group_user` int(11) unsigned NOT NULL auto_increment,
  `id_group` int(11) unsigned NOT NULL default '0',
  `id_user` int(11) unsigned NOT NULL default '0',
  `up` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_group_user`)
) ENGINE=MyISAM AUTO_INCREMENT=60 ;

-- 
-- Volcar la base de datos para la tabla `group_users`
-- 

INSERT INTO `group_users` VALUES (1, 1, 1, 0x323030342d31322d3132);
INSERT INTO `group_users` VALUES (45, 2, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (46, 3, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (47, 4, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (48, 5, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (49, 6, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (50, 7, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (51, 8, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (52, 9, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (53, 10, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (54, 11, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (55, 12, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (56, 13, 1, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (57, 1, 2, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (58, 2, 3, 0x303030302d30302d3030);
INSERT INTO `group_users` VALUES (59, 9, 4, 0x303030302d30302d3030);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `groups`
-- 

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `name_web` varchar(100) NOT NULL default '',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_group`)
) ENGINE=MyISAM AUTO_INCREMENT=16 ;

-- 
-- Volcar la base de datos para la tabla `groups`
-- 

INSERT INTO `groups` VALUES (1, 'superadmin', 'Super Administrador', 'Persona con capacidad de acceso a todas las herremientas de la aplicacion');
INSERT INTO `groups` VALUES (2, 'admin', 'Administrador', 'Personal con permiso de acceso en todos los m?dulos internos de la aplicaci?n con peque?as restricciones');
INSERT INTO `groups` VALUES (3, 'conductor', 'Conductores', '');
INSERT INTO `groups` VALUES (4, 'user', 'Usuario', '');
INSERT INTO `groups` VALUES (5, 'Grupo de Pr?cticas', 'Grupo de Pr&aacute;cticas', 'Personal de pr?cticas en empresa que tendr?n acceso a la aplicaci?n');
INSERT INTO `groups` VALUES (6, 'contable', 'Contables', '');
INSERT INTO `groups` VALUES (7, 'limpieza', 'Limpieza', '');
INSERT INTO `groups` VALUES (8, 'root', 'Root', '');
INSERT INTO `groups` VALUES (9, 'simple_user', 'Usuario Simple', '');
INSERT INTO `groups` VALUES (10, 'test', 'Test', '');
INSERT INTO `groups` VALUES (11, 'guest', 'Invitado', '');
INSERT INTO `groups` VALUES (12, 'gerente', 'Gerente', '');
INSERT INTO `groups` VALUES (13, 'administrativo', 'Administrativo', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `holydays`
-- 

CREATE TABLE IF NOT EXISTS `holydays` (
  `id_holy` int(11) NOT NULL auto_increment,
  `id_emp` int(11) NOT NULL default '0',
  `gone` date NOT NULL default '0000-00-00',
  `come` date NOT NULL default '0000-00-00',
  `ill` tinyint(3) NOT NULL default '0',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_holy`),
  KEY `id_emp` (`id_emp`)
) ENGINE=MyISAM AUTO_INCREMENT=10 ;

-- 
-- Volcar la base de datos para la tabla `holydays`
-- 

INSERT INTO `holydays` VALUES (1, 1, 0x323030342d30382d3036, 0x323030342d30382d3139, 0, 'sdasdfar');
INSERT INTO `holydays` VALUES (3, 0, 0x303030302d30302d3030, 0x323030342d31322d3037, 2, '');
INSERT INTO `holydays` VALUES (8, 0, 0x303030302d30302d3030, 0x303030302d30302d3030, 2, '');
INSERT INTO `holydays` VALUES (9, 2, 0x303030302d30302d3030, 0x323030352d30332d3233, 2, '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ins`
-- 

CREATE TABLE IF NOT EXISTS `ins` (
  `id_in` int(11) unsigned NOT NULL default '0',
  `id_vendor` int(11) unsigned NOT NULL default '0',
  `id_corp` int(11) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `subtotal_value` double NOT NULL default '0',
  `iva` int(11) NOT NULL default '0',
  `re` int(11) NOT NULL default '0',
  `total_value` double NOT NULL default '0',
  PRIMARY KEY  (`id_in`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `ins`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `laborers`
-- 

CREATE TABLE IF NOT EXISTS `laborers` (
  `id_laborer` int(11) unsigned NOT NULL auto_increment,
  `id_emp` int(11) unsigned NOT NULL default '0',
  `id_vehicle` int(11) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_laborer`)
) ENGINE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- Volcar la base de datos para la tabla `laborers`
-- 

INSERT INTO `laborers` VALUES (3, 2, 206, 0x323030332d30322d3032);
INSERT INTO `laborers` VALUES (4, 2, 206, 0x303030302d30302d3030);
INSERT INTO `laborers` VALUES (8, 1, 208, 0x323030352d30332d3138);
INSERT INTO `laborers` VALUES (9, 1, 208, 0x323030352d30332d3138);
INSERT INTO `laborers` VALUES (10, 1, 208, 0x323030352d30332d3235);
INSERT INTO `laborers` VALUES (11, 2, 206, 0x323030352d30332d3033);
INSERT INTO `laborers` VALUES (16, 1, 206, 0x323030352d30332d3136);
INSERT INTO `laborers` VALUES (14, 2, 206, 0x323030352d30332d3234);
INSERT INTO `laborers` VALUES (15, 1, 208, 0x323030352d30332d3137);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `log_methods`
-- 

CREATE TABLE IF NOT EXISTS `log_methods` (
  `id_log_method` int(11) unsigned NOT NULL auto_increment,
  `id_user` int(11) unsigned NOT NULL default '0',
  `id_method` int(11) unsigned NOT NULL default '0',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `id_method_type` tinyint(3) unsigned NOT NULL default '0',
  `sql_sentence` text NOT NULL,
  `afected` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_log_method`)
) ENGINE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `log_methods`
-- 

INSERT INTO `log_methods` VALUES (1, 1, 1, '0000-00-00 00:00:00', 2, '', 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `log_sessions`
-- 

CREATE TABLE IF NOT EXISTS `log_sessions` (
  `id_log_session` int(11) unsigned NOT NULL auto_increment,
  `id_session` int(11) unsigned NOT NULL default '0',
  `date_in` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_out` datetime NOT NULL default '0000-00-00 00:00:00',
  `timeout` time NOT NULL default '00:00:00',
  `ip` varchar(20) NOT NULL default '',
  `id_user` int(11) unsigned NOT NULL default '0',
  `country` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id_log_session`)
) ENGINE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `log_sessions`
-- 

INSERT INTO `log_sessions` VALUES (1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0x30303a30303a3030, '127.0.0.1', 1, 'espa?a');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `methods`
-- 

CREATE TABLE IF NOT EXISTS `methods` (
  `id_method` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `name_web` varchar(50) NOT NULL default '',
  `id_module` int(11) unsigned NOT NULL default '0',
  `id_type_method` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id_method`)
) ENGINE=MyISAM AUTO_INCREMENT=123 ;

-- 
-- Volcar la base de datos para la tabla `methods`
-- 

INSERT INTO `methods` VALUES (1, 'add', 'A&ntilde;adir', 1, 1);
INSERT INTO `methods` VALUES (2, 'modify', 'Modificar', 1, 1);
INSERT INTO `methods` VALUES (3, 'delete', 'Borrar', 1, 0);
INSERT INTO `methods` VALUES (4, 'list', 'Listar', 1, 0);
INSERT INTO `methods` VALUES (5, 'view', 'Ver', 1, 0);
INSERT INTO `methods` VALUES (7, 'add', 'A&ntilde;adir', 4, 1);
INSERT INTO `methods` VALUES (8, 'modify', 'Modificar', 4, 1);
INSERT INTO `methods` VALUES (9, 'delete', 'Borrar', 4, 0);
INSERT INTO `methods` VALUES (10, 'list', 'Listar', 4, 0);
INSERT INTO `methods` VALUES (11, 'view', 'Ver', 4, 0);
INSERT INTO `methods` VALUES (13, 'add', 'A&ntilde;adir', 5, 1);
INSERT INTO `methods` VALUES (14, 'modify', 'Modificar', 5, 1);
INSERT INTO `methods` VALUES (15, 'delete', 'Borrar', 5, 0);
INSERT INTO `methods` VALUES (16, 'list', 'Listar', 5, 0);
INSERT INTO `methods` VALUES (17, 'view', 'Ver', 5, 0);
INSERT INTO `methods` VALUES (19, 'add', 'A&ntilde;adir', 6, 1);
INSERT INTO `methods` VALUES (20, 'modify', 'Modificar', 6, 1);
INSERT INTO `methods` VALUES (21, 'delete', 'Borrar', 6, 0);
INSERT INTO `methods` VALUES (22, 'list', 'Listar', 6, 0);
INSERT INTO `methods` VALUES (23, 'view', 'Ver', 6, 0);
INSERT INTO `methods` VALUES (24, 'add', 'A&ntilde;adir', 8, 1);
INSERT INTO `methods` VALUES (25, 'modify', 'Modificar', 8, 1);
INSERT INTO `methods` VALUES (26, 'delete', 'Borrar', 8, 0);
INSERT INTO `methods` VALUES (27, 'list', 'Listar', 8, 0);
INSERT INTO `methods` VALUES (28, 'view', 'Ver', 8, 0);
INSERT INTO `methods` VALUES (29, 'add', 'A&ntilde;adir', 9, 1);
INSERT INTO `methods` VALUES (30, 'modify', 'Modificar', 9, 1);
INSERT INTO `methods` VALUES (31, 'delete', 'Borrar', 9, 0);
INSERT INTO `methods` VALUES (32, 'list', 'Listar', 9, 0);
INSERT INTO `methods` VALUES (33, 'view', 'Ver', 9, 0);
INSERT INTO `methods` VALUES (34, 'select', 'Seleccionar', 7, 1);
INSERT INTO `methods` VALUES (35, 'list', 'Listar', 20, 0);
INSERT INTO `methods` VALUES (36, 'add', 'A?adir', 20, 0);
INSERT INTO `methods` VALUES (37, 'modify', 'Modificar', 20, 0);
INSERT INTO `methods` VALUES (38, 'delete', 'Borrar', 20, 0);
INSERT INTO `methods` VALUES (40, 'list', 'Listar', 22, 0);
INSERT INTO `methods` VALUES (58, 'list', 'Listar', 37, 0);
INSERT INTO `methods` VALUES (59, 'view', 'Ver', 37, 0);
INSERT INTO `methods` VALUES (60, 'add', 'Añadir', 37, 0);
INSERT INTO `methods` VALUES (61, 'modify', 'Modificar', 37, 0);
INSERT INTO `methods` VALUES (62, 'delete', 'Borrar', 37, 0);
INSERT INTO `methods` VALUES (68, 'view', 'Ver', 43, 0);
INSERT INTO `methods` VALUES (67, 'list', 'Listar', 43, 0);
INSERT INTO `methods` VALUES (69, 'add', 'Añadir', 43, 0);
INSERT INTO `methods` VALUES (70, 'modify', 'Modificar', 43, 0);
INSERT INTO `methods` VALUES (71, 'delete', 'Borrar', 43, 0);
INSERT INTO `methods` VALUES (72, 'list', 'Listar', 44, 0);
INSERT INTO `methods` VALUES (73, 'view', 'Ver', 44, 0);
INSERT INTO `methods` VALUES (74, 'add', 'Añadir', 44, 0);
INSERT INTO `methods` VALUES (75, 'modify', 'Modificar', 44, 0);
INSERT INTO `methods` VALUES (76, 'delete', 'Borrar', 44, 0);
INSERT INTO `methods` VALUES (77, 'list', 'Listar', 16, 0);
INSERT INTO `methods` VALUES (78, 'view', 'Ver', 16, 0);
INSERT INTO `methods` VALUES (79, 'add', 'Añadir', 16, 0);
INSERT INTO `methods` VALUES (80, 'modify', 'Modificar', 16, 0);
INSERT INTO `methods` VALUES (81, 'delete', 'Borrar', 16, 0);
INSERT INTO `methods` VALUES (82, 'list', 'Listar', 10, 0);
INSERT INTO `methods` VALUES (83, 'view', 'Ver', 10, 0);
INSERT INTO `methods` VALUES (84, 'add', 'Añadir', 10, 0);
INSERT INTO `methods` VALUES (85, 'modify', 'Modificar', 10, 0);
INSERT INTO `methods` VALUES (86, 'delete', 'Borrar', 10, 0);
INSERT INTO `methods` VALUES (87, 'list', 'Listar', 11, 0);
INSERT INTO `methods` VALUES (88, 'view', 'Ver', 11, 0);
INSERT INTO `methods` VALUES (89, 'add', 'Añadir', 11, 0);
INSERT INTO `methods` VALUES (90, 'modify', 'Modificar', 11, 0);
INSERT INTO `methods` VALUES (91, 'delete', 'Borrar', 11, 0);
INSERT INTO `methods` VALUES (92, 'list', 'Listar', 12, 0);
INSERT INTO `methods` VALUES (93, 'view', 'Ver', 12, 0);
INSERT INTO `methods` VALUES (94, 'add', 'Añadir', 12, 0);
INSERT INTO `methods` VALUES (95, 'modify', 'Modificar', 12, 0);
INSERT INTO `methods` VALUES (96, 'delete', 'Borrar', 12, 0);
INSERT INTO `methods` VALUES (97, 'list', 'Listar', 15, 0);
INSERT INTO `methods` VALUES (98, 'view', 'Ver', 15, 0);
INSERT INTO `methods` VALUES (99, 'add', 'Añadir', 15, 0);
INSERT INTO `methods` VALUES (100, 'modify', 'Modificar', 15, 0);
INSERT INTO `methods` VALUES (101, 'delete', 'Borrar', 15, 0);
INSERT INTO `methods` VALUES (102, 'list', 'Listar', 19, 0);
INSERT INTO `methods` VALUES (103, 'view', 'Ver', 19, 0);
INSERT INTO `methods` VALUES (104, 'add', 'Añadir', 19, 0);
INSERT INTO `methods` VALUES (105, 'modify', 'Modificar', 19, 0);
INSERT INTO `methods` VALUES (106, 'delete', 'Borrar', 19, 0);
INSERT INTO `methods` VALUES (107, 'list', 'Listar', 31, 0);
INSERT INTO `methods` VALUES (108, 'view', 'Ver', 31, 0);
INSERT INTO `methods` VALUES (109, 'add', 'Añadir', 31, 0);
INSERT INTO `methods` VALUES (110, 'modify', 'Modificar', 31, 0);
INSERT INTO `methods` VALUES (111, 'delete', 'Borrar', 31, 0);
INSERT INTO `methods` VALUES (112, 'list', 'Listar', 30, 0);
INSERT INTO `methods` VALUES (113, 'view', 'Ver', 30, 0);
INSERT INTO `methods` VALUES (114, 'add', 'Añadir', 30, 0);
INSERT INTO `methods` VALUES (115, 'modify', 'Modificar', 30, 0);
INSERT INTO `methods` VALUES (116, 'delete', 'Borrar', 30, 0);
INSERT INTO `methods` VALUES (117, 'list', 'Listar', 33, 0);
INSERT INTO `methods` VALUES (118, 'view', 'Ver', 33, 0);
INSERT INTO `methods` VALUES (119, 'add', 'Añadir', 33, 0);
INSERT INTO `methods` VALUES (120, 'modify', 'Modificar', 33, 0);
INSERT INTO `methods` VALUES (121, 'delete', 'Borrar', 33, 0);
INSERT INTO `methods` VALUES (122, 'select', 'Seleccionar', 3, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modules`
-- 

CREATE TABLE IF NOT EXISTS `modules` (
  `id_module` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `name_web` varchar(50) NOT NULL default '',
  `path` varchar(255) NOT NULL default '',
  `active` tinyint(3) unsigned NOT NULL default '0',
  `public` tinyint(3) unsigned NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  `order` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_module`),
  UNIQUE KEY `nombre` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=45 ;

-- 
-- Volcar la base de datos para la tabla `modules`
-- 

INSERT INTO `modules` VALUES (1, 'users', 'Usuarios', 'index.php?module=users', 1, 0, 18, 11);
INSERT INTO `modules` VALUES (2, 'news', 'Noticias', 'index.php?module=news', 1, 1, 0, 1);
INSERT INTO `modules` VALUES (3, 'user_corps', 'Elegir empresa', 'index.php?module=user_corps', 1, 0, 34, 31);
INSERT INTO `modules` VALUES (4, 'corps', 'Empresas', 'index.php?module=corps', 1, 0, 34, 32);
INSERT INTO `modules` VALUES (5, 'groups', 'Grupos', 'index.php?module=groups', 1, 0, 18, 12);
INSERT INTO `modules` VALUES (6, 'emps', 'Empleados', 'index.php?module=emps', 1, 0, 34, 33);
INSERT INTO `modules` VALUES (7, 'error', 'Errores', 'index.php?module=error', 0, 0, 0, 0);
INSERT INTO `modules` VALUES (8, 'modules', 'M&oacute;dulos', 'index.php?module=modules', 1, 0, 29, 21);
INSERT INTO `modules` VALUES (9, 'cat_emps', 'Categor&iacute;as de Empleados', 'index.php?module=cat_emps', 1, 0, 6, 34);
INSERT INTO `modules` VALUES (10, 'holydays', 'Altas/Bajas', 'index.php?module=holydays', 0, 0, 34, 35);
INSERT INTO `modules` VALUES (11, 'products', 'Productos', 'index.php?module=products', 1, 1, 35, 2);
INSERT INTO `modules` VALUES (12, 'services', 'Servicios', 'index.php?module=services', 1, 1, 36, 3);
INSERT INTO `modules` VALUES (13, 'vehicles_gestion', 'Gesti&oacute;n de veh&iacute;culos', '', 1, 0, -2, 40);
INSERT INTO `modules` VALUES (14, 'cat_vehicles', 'Categor&iacute;as de veh&iacute;culos', 'index.php?module=cat_vehicles', 1, 0, 19, 42);
INSERT INTO `modules` VALUES (15, 'drivers', 'Conductores', 'index.php?module=drivers', 1, 0, 13, 43);
INSERT INTO `modules` VALUES (16, 'contacts', 'Contactos', 'index.php?module=contacts', 1, 0, 42, 4);
INSERT INTO `modules` VALUES (17, 'sessions', 'Sesiones', 'index.php?module=sessions', 1, 0, 18, 13);
INSERT INTO `modules` VALUES (18, 'access_gestion', 'Acceso', '', 1, 0, -2, 10);
INSERT INTO `modules` VALUES (19, 'vehicles', 'Veh&iacute;culos de la empresa', 'index.php?module=vehicles', 1, 0, 13, 41);
INSERT INTO `modules` VALUES (29, 'modules_gestion', 'Módulos', '', 1, 1, -2, 20);
INSERT INTO `modules` VALUES (30, 'cat_prods', 'Categor&iacute;as de Productos', 'index.php?module=cat_prods', 1, 0, 11, 0);
INSERT INTO `modules` VALUES (31, 'laborers', 'Peones', 'index.php?module=laborers', 1, 0, 13, 44);
INSERT INTO `modules` VALUES (32, 'stock_gestion', 'Gesti&oacute;n de stock', '', 1, 0, -2, 50);
INSERT INTO `modules` VALUES (33, 'vendors', 'Proveedores', 'index.php?module=vendors', 1, 0, 32, 51);
INSERT INTO `modules` VALUES (34, 'corps_gestion', 'Empresas', '', 1, 0, -2, 30);
INSERT INTO `modules` VALUES (35, 'products_gestion', 'Ges. Productos', '', 1, 0, -2, 0);
INSERT INTO `modules` VALUES (36, 'services_gestion', 'Ges. Servicios', '', 1, 0, -2, 0);
INSERT INTO `modules` VALUES (37, 'cat_servs', 'Categor&iacute;as de Servicios', 'index.php?module=cat_servs', 1, 0, 12, 0);
INSERT INTO `modules` VALUES (43, 'cat_clients', 'Categor&iacute;as de clientes', 'index.php?module=cat_clients', 1, 0, 42, 0);
INSERT INTO `modules` VALUES (42, 'clients_gestion', 'Ges. Clientes', 'index.php?module=clients', 1, 0, -2, 0);
INSERT INTO `modules` VALUES (44, 'clients', 'Clientes', 'index.php?module=clients', 1, 0, 42, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `out_lines`
-- 

CREATE TABLE IF NOT EXISTS `out_lines` (
  `id_out_line` int(11) unsigned NOT NULL default '0',
  `id_out` int(11) unsigned NOT NULL default '0',
  `id_prod` int(11) unsigned NOT NULL default '0',
  `number` int(20) unsigned NOT NULL default '0',
  `price` double unsigned NOT NULL default '0',
  `iva` int(10) unsigned NOT NULL default '0',
  `re` int(10) unsigned NOT NULL default '0',
  `subtotal` double unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_out_line`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `out_lines`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `outs`
-- 

CREATE TABLE IF NOT EXISTS `outs` (
  `id_out` int(11) unsigned NOT NULL default '0',
  `id_client` int(11) unsigned NOT NULL default '0',
  `id_corp` mediumint(11) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `subtotal_value` double NOT NULL default '0',
  `iva` int(11) NOT NULL default '0',
  `re` int(11) NOT NULL default '0',
  `total_value` double NOT NULL default '0',
  PRIMARY KEY  (`id_out`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `outs`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `per_group_methods`
-- 

CREATE TABLE IF NOT EXISTS `per_group_methods` (
  `id_per_group_method` int(11) unsigned NOT NULL auto_increment,
  `id_group` int(11) unsigned NOT NULL default '0',
  `id_method` int(11) unsigned NOT NULL default '0',
  `per` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_per_group_method`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Volcar la base de datos para la tabla `per_group_methods`
-- 

INSERT INTO `per_group_methods` VALUES (1, 9, 2, 1);
INSERT INTO `per_group_methods` VALUES (2, 9, 5, 1);
INSERT INTO `per_group_methods` VALUES (3, 9, 20, 1);
INSERT INTO `per_group_methods` VALUES (4, 9, 23, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `per_group_modules`
-- 

CREATE TABLE IF NOT EXISTS `per_group_modules` (
  `id_per_group_module` int(10) unsigned NOT NULL auto_increment,
  `id_group` int(10) unsigned NOT NULL default '0',
  `id_module` int(10) unsigned NOT NULL default '0',
  `per` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_per_group_module`)
) ENGINE=MyISAM AUTO_INCREMENT=90 ;

-- 
-- Volcar la base de datos para la tabla `per_group_modules`
-- 

INSERT INTO `per_group_modules` VALUES (1, 9, 1, 1);
INSERT INTO `per_group_modules` VALUES (68, 9, 6, 1);
INSERT INTO `per_group_modules` VALUES (69, 1, 1, 1);
INSERT INTO `per_group_modules` VALUES (70, 1, 2, 1);
INSERT INTO `per_group_modules` VALUES (71, 1, 3, 1);
INSERT INTO `per_group_modules` VALUES (72, 1, 4, 1);
INSERT INTO `per_group_modules` VALUES (73, 1, 5, 1);
INSERT INTO `per_group_modules` VALUES (74, 1, 6, 1);
INSERT INTO `per_group_modules` VALUES (75, 1, 7, 1);
INSERT INTO `per_group_modules` VALUES (76, 1, 8, 1);
INSERT INTO `per_group_modules` VALUES (77, 1, 9, 1);
INSERT INTO `per_group_modules` VALUES (78, 1, 20, 1);
INSERT INTO `per_group_modules` VALUES (79, 2, 1, 1);
INSERT INTO `per_group_modules` VALUES (80, 2, 2, 1);
INSERT INTO `per_group_modules` VALUES (81, 2, 3, 1);
INSERT INTO `per_group_modules` VALUES (82, 2, 4, 1);
INSERT INTO `per_group_modules` VALUES (83, 2, 5, 1);
INSERT INTO `per_group_modules` VALUES (84, 2, 6, 1);
INSERT INTO `per_group_modules` VALUES (85, 2, 7, 1);
INSERT INTO `per_group_modules` VALUES (86, 2, 9, 1);
INSERT INTO `per_group_modules` VALUES (87, 2, 20, 1);
INSERT INTO `per_group_modules` VALUES (88, 2, 21, 1);
INSERT INTO `per_group_modules` VALUES (89, 2, 22, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `per_user_methods`
-- 

CREATE TABLE IF NOT EXISTS `per_user_methods` (
  `id_per_user_method` int(11) unsigned NOT NULL auto_increment,
  `id_user` int(11) unsigned NOT NULL default '0',
  `id_method` int(11) unsigned NOT NULL default '0',
  `per` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_per_user_method`)
) ENGINE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `per_user_methods`
-- 

INSERT INTO `per_user_methods` VALUES (1, 4, 17, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `per_user_modules`
-- 

CREATE TABLE IF NOT EXISTS `per_user_modules` (
  `id_per_user_module` int(10) unsigned NOT NULL auto_increment,
  `id_user` int(10) unsigned NOT NULL default '0',
  `id_module` int(10) unsigned NOT NULL default '0',
  `per` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_per_user_module`)
) ENGINE=MyISAM AUTO_INCREMENT=88 ;

-- 
-- Volcar la base de datos para la tabla `per_user_modules`
-- 

INSERT INTO `per_user_modules` VALUES (67, 1, 7, 0);
INSERT INTO `per_user_modules` VALUES (68, 2, 7, 1);
INSERT INTO `per_user_modules` VALUES (72, 4, 5, 1);
INSERT INTO `per_user_modules` VALUES (74, 3, 7, 1);
INSERT INTO `per_user_modules` VALUES (87, 4, 7, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `products`
-- 

CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int(11) NOT NULL auto_increment,
  `id_corp` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `name_web` varchar(50) NOT NULL default '',
  `path_photo` varchar(255) NOT NULL default '',
  `pvp` decimal(10,2) NOT NULL default '0.00',
  `tax` decimal(10,2) NOT NULL default '0.00',
  `pvp_tax` decimal(10,2) NOT NULL default '0.00',
  `minimun_stock` decimal(10,2) NOT NULL default '0.00',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_product`),
  KEY `id_corp` (`id_corp`)
) ENGINE=MyISAM AUTO_INCREMENT=16 ;

-- 
-- Volcar la base de datos para la tabla `products`
-- 

INSERT INTO `products` VALUES (6, 1, 'dasfaafd', 'adafdafd', 'images/products/6.GIF', 33.00, 3333.00, 3333.00, 0.00, '');
INSERT INTO `products` VALUES (5, 1, 'wer', 'wer', 'images/products/5.JPG', 3.00, 3.00, 3.00, 0.00, '');
INSERT INTO `products` VALUES (9, 1, 'Producto3', 'producto 3', 'images/products/9.GIF', 3.00, 3.00, 3.00, 0.00, '');
INSERT INTO `products` VALUES (12, 1, 'adfadfdddd', 'adfsafaffd', 'images/products/12.JPG', 44.00, 4.00, 44.00, 0.00, '');
INSERT INTO `products` VALUES (13, 1, 'adfad', 'afadf', 'images/products/13.JPG', 3.00, 3.00, 3.00, 0.00, '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `refs`
-- 

CREATE TABLE IF NOT EXISTS `refs` (
  `id_ref` int(11) unsigned NOT NULL default '0',
  `id_prod` int(11) unsigned NOT NULL default '0',
  `id_vendor` int(11) unsigned NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `last_pvd` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_ref`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `refs`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_emps_cats`
-- 

CREATE TABLE IF NOT EXISTS `rel_emps_cats` (
  `id_rel_emp_cat` int(11) NOT NULL auto_increment,
  `id_emp` int(11) NOT NULL default '0',
  `id_cat_emp` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_rel_emp_cat`),
  KEY `id_emp` (`id_emp`,`id_cat_emp`)
) ENGINE=MyISAM AUTO_INCREMENT=16 ;

-- 
-- Volcar la base de datos para la tabla `rel_emps_cats`
-- 

INSERT INTO `rel_emps_cats` VALUES (6, 7, 1);
INSERT INTO `rel_emps_cats` VALUES (9, 9, 1);
INSERT INTO `rel_emps_cats` VALUES (10, 2, 1);
INSERT INTO `rel_emps_cats` VALUES (11, 10, 3);
INSERT INTO `rel_emps_cats` VALUES (12, 1, 3);
INSERT INTO `rel_emps_cats` VALUES (13, 1, 7);
INSERT INTO `rel_emps_cats` VALUES (14, 2, 7);
INSERT INTO `rel_emps_cats` VALUES (15, 10, 7);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_prods_cats`
-- 

CREATE TABLE IF NOT EXISTS `rel_prods_cats` (
  `id_rel_prod_cat` int(11) NOT NULL auto_increment,
  `id_product` int(11) NOT NULL default '0',
  `id_cat_prod` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_rel_prod_cat`),
  KEY `id_prod` (`id_product`,`id_cat_prod`)
) ENGINE=MyISAM AUTO_INCREMENT=26 ;

-- 
-- Volcar la base de datos para la tabla `rel_prods_cats`
-- 

INSERT INTO `rel_prods_cats` VALUES (16, 12, 24);
INSERT INTO `rel_prods_cats` VALUES (17, 12, 26);
INSERT INTO `rel_prods_cats` VALUES (18, 12, 27);
INSERT INTO `rel_prods_cats` VALUES (19, 13, 31);
INSERT INTO `rel_prods_cats` VALUES (20, 13, 32);
INSERT INTO `rel_prods_cats` VALUES (21, 13, 33);
INSERT INTO `rel_prods_cats` VALUES (22, 6, 24);
INSERT INTO `rel_prods_cats` VALUES (23, 6, 25);
INSERT INTO `rel_prods_cats` VALUES (24, 6, 26);
INSERT INTO `rel_prods_cats` VALUES (25, 6, 27);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_servs_cats`
-- 

CREATE TABLE IF NOT EXISTS `rel_servs_cats` (
  `id_rel_serv_cat` int(11) NOT NULL auto_increment,
  `id_service` int(11) NOT NULL default '0',
  `id_cat_serv` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_rel_serv_cat`),
  KEY `id_service` (`id_service`,`id_cat_serv`)
) ENGINE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `rel_servs_cats`
-- 

INSERT INTO `rel_servs_cats` VALUES (2, 2, 2);
INSERT INTO `rel_servs_cats` VALUES (3, 4, 3);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_vehicles_cats`
-- 

CREATE TABLE IF NOT EXISTS `rel_vehicles_cats` (
  `id_rel_vehicle_cat` int(11) unsigned NOT NULL auto_increment,
  `id_vehicle` int(11) unsigned NOT NULL default '0',
  `id_cat_vehicle` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_rel_vehicle_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=62 ;

-- 
-- Volcar la base de datos para la tabla `rel_vehicles_cats`
-- 

INSERT INTO `rel_vehicles_cats` VALUES (46, 205, 1);
INSERT INTO `rel_vehicles_cats` VALUES (7, 2, 10);
INSERT INTO `rel_vehicles_cats` VALUES (8, 3, 1);
INSERT INTO `rel_vehicles_cats` VALUES (9, 4, 1);
INSERT INTO `rel_vehicles_cats` VALUES (45, 204, 1);
INSERT INTO `rel_vehicles_cats` VALUES (26, 185, 0);
INSERT INTO `rel_vehicles_cats` VALUES (27, 186, 1);
INSERT INTO `rel_vehicles_cats` VALUES (25, 184, 0);
INSERT INTO `rel_vehicles_cats` VALUES (36, 195, 1);
INSERT INTO `rel_vehicles_cats` VALUES (44, 203, 1);
INSERT INTO `rel_vehicles_cats` VALUES (47, 206, 1);
INSERT INTO `rel_vehicles_cats` VALUES (48, 207, 1);
INSERT INTO `rel_vehicles_cats` VALUES (49, 208, 1);
INSERT INTO `rel_vehicles_cats` VALUES (50, 209, 1);
INSERT INTO `rel_vehicles_cats` VALUES (51, 210, 1);
INSERT INTO `rel_vehicles_cats` VALUES (58, 217, 1);
INSERT INTO `rel_vehicles_cats` VALUES (60, 217, 10);
INSERT INTO `rel_vehicles_cats` VALUES (61, 217, 11);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `services`
-- 

CREATE TABLE IF NOT EXISTS `services` (
  `id_service` int(11) NOT NULL auto_increment,
  `id_corp` int(11) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `name_web` varchar(50) NOT NULL default '',
  `path_photo` varchar(255) NOT NULL default '',
  `pvp` decimal(10,0) NOT NULL default '0',
  `tax` decimal(10,0) NOT NULL default '0',
  `pvp_tax` decimal(10,0) NOT NULL default '0',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_service`),
  KEY `id_corp` (`id_corp`)
) ENGINE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Volcar la base de datos para la tabla `services`
-- 

INSERT INTO `services` VALUES (2, 1, 'asdfadsf', 'asdfadfasdf', 'images/services/2.GIF', 33, 44, 5, '');
INSERT INTO `services` VALUES (3, 1, 'ffdsa', 'fadsfasd', '', 4234, 234234, 23423423, '');
INSERT INTO `services` VALUES (4, 1, 'adfa', 'adfsafa', '', 4345, 354, 345, '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `sessions`
-- 

CREATE TABLE IF NOT EXISTS `sessions` (
  `id_session` int(10) unsigned NOT NULL auto_increment,
  `id_session_php` varchar(255) NOT NULL default '',
  `id_user` int(11) NOT NULL default '0',
  `up` datetime NOT NULL default '0000-00-00 00:00:00',
  `down` datetime default '0000-00-00 00:00:00',
  `expire` int(25) NOT NULL default '0',
  PRIMARY KEY  (`id_session`)
) ENGINE=MyISAM AUTO_INCREMENT=21 ;

-- 
-- Volcar la base de datos para la tabla `sessions`
-- 

INSERT INTO `sessions` VALUES (1, '3ae37e9e6260f4d10e2837b5163ac421', 1, '2005-03-30 07:53:08', '2005-03-30 08:20:27', 0);
INSERT INTO `sessions` VALUES (2, '233137bab2c9186ef05e19285122a7e6', 1, '2005-03-30 08:20:55', '2005-03-30 09:16:28', 1112173206);
INSERT INTO `sessions` VALUES (3, '3dac58e04880e747ef42de93be9b30af', 1, '2005-03-30 08:44:06', '2005-03-30 09:46:15', 1112175453);
INSERT INTO `sessions` VALUES (4, '7ab9af3549891bfc5c8792ffb565c4be', 1, '2005-03-30 09:46:25', '2005-03-31 08:00:14', 1112177382);
INSERT INTO `sessions` VALUES (5, '0e69ba315f619fb9f59902eab3a0ad73', 1, '2005-03-31 08:00:21', '2005-03-31 08:50:33', 1112257635);
INSERT INTO `sessions` VALUES (6, 'c490c8693d5fd748e02f300faf8032f7', 1, '2005-03-31 08:50:39', '2005-03-31 11:03:03', 1112262750);
INSERT INTO `sessions` VALUES (7, '8b55538fa09d19cb8a55ad3791e301d5', 1, '2005-03-31 11:03:14', '2005-04-05 08:09:56', 1112268197);
INSERT INTO `sessions` VALUES (8, '602055aae546c47a1a3090ba246d9d53', 1, '2005-04-05 08:10:03', '2005-04-05 08:36:40', 1112691385);
INSERT INTO `sessions` VALUES (9, '386167381c7dcd066399d729d8692d42', 1, '2005-04-05 08:36:44', '2005-04-05 08:43:01', 1112691768);
INSERT INTO `sessions` VALUES (10, 'ba14f557743e56105c7e8002d71ec5d8', 1, '2005-04-05 08:43:05', '2005-04-05 09:26:09', 1112692100);
INSERT INTO `sessions` VALUES (11, '154e9035c82477e3486780c54df61f16', 1, '2005-04-05 09:26:14', '2005-04-06 09:16:36', 1112696647);
INSERT INTO `sessions` VALUES (12, 'f01e3c12f91b1c3756707543fd6faacf', 1, '2005-04-06 09:16:42', '2005-04-06 09:18:00', 1112780247);
INSERT INTO `sessions` VALUES (13, '60edfee73b910a267a7853c7e9973f05', 1, '2005-04-06 09:18:04', '2005-04-06 10:27:10', 1112780326);
INSERT INTO `sessions` VALUES (14, '88e720e8864a385027bab3f06f80967c', 1, '2005-04-06 10:27:17', '2005-04-06 11:02:24', 1112784851);
INSERT INTO `sessions` VALUES (15, '01a2bcda85c000d5ba4f5bd129efbb34', 1, '2005-04-06 11:02:33', '2005-04-07 07:41:48', 1112789436);
INSERT INTO `sessions` VALUES (16, '67937f58aa25e05041a26e72c77929b4', 1, '2005-04-07 07:42:04', '2005-04-07 09:33:58', 1112861590);
INSERT INTO `sessions` VALUES (17, '90aee60bdc63b19f51738da177a34650', 1, '2005-04-07 09:34:03', '2005-04-07 09:58:34', 1112867755);
INSERT INTO `sessions` VALUES (18, 'f984ce6601f86ac9f6b7b309d4db3a43', 1, '2005-04-07 09:58:38', '2005-04-07 15:32:34', 1112871927);
INSERT INTO `sessions` VALUES (19, '7fa5259348c49b8e9dbc18a542601c96', 1, '2005-04-07 15:32:42', '2005-04-07 17:03:48', 1112893411);
INSERT INTO `sessions` VALUES (20, 'c810714d9dbe4793fa292ff37acb2cdb', 1, '2005-04-07 17:03:53', '0000-00-00 00:00:00', 1112895766);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `stock`
-- 

CREATE TABLE IF NOT EXISTS `stock` (
  `id_stock` int(11) unsigned NOT NULL default '0',
  `id_storage` int(11) unsigned NOT NULL default '0',
  `id_prod` int(11) unsigned NOT NULL default '0',
  `actual_number` int(20) NOT NULL default '0',
  PRIMARY KEY  (`id_stock`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `stock`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `storages`
-- 

CREATE TABLE IF NOT EXISTS `storages` (
  `id_storage` int(11) unsigned NOT NULL default '0',
  `id_corp` int(11) unsigned NOT NULL default '0',
  `address` varchar(255) NOT NULL default '',
  `descrip` text NOT NULL,
  PRIMARY KEY  (`id_storage`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `storages`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `users`
-- 

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(20) NOT NULL default '',
  `passwd` varchar(20) NOT NULL default '',
  `name` varchar(20) NOT NULL default '',
  `last_name` varchar(20) NOT NULL default '',
  `last_name2` varchar(20) NOT NULL default '',
  `full_name` varchar(100) NOT NULL default '',
  `internal` tinyint(3) NOT NULL default '0',
  `active` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Volcar la base de datos para la tabla `users`
-- 

INSERT INTO `users` VALUES (1, 'admin', 'sta3war2', 'David', 'Vaquero', 'Santiago', 'David Vaquero Santiago', 0, 0);
INSERT INTO `users` VALUES (2, 'admin2', 'sta3war2', 'Daniel', 'González', 'Zaballos', 'Daniel González Zaballos', 1, 1);
INSERT INTO `users` VALUES (3, 'Elena', 'elena', 'Elena', 'Resuival', '', '', 0, 0);
INSERT INTO `users` VALUES (4, 'rocio', 'rocio', 'Roc', 'Guti?rrez', 'Gonz?lez', 'Roc?o Guti?rrez Gonz?lez', 0, 0);
INSERT INTO `users` VALUES (5, 'prueba', 'prueba', 'usuario_prueba', '', '', '', 0, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `vehicles`
-- 

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id_vehicle` int(11) unsigned NOT NULL auto_increment,
  `id_corp` int(11) unsigned NOT NULL default '0',
  `number_plate` varchar(10) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `path_photo` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_vehicle`)
) ENGINE=MyISAM AUTO_INCREMENT=218 ;

-- 
-- Volcar la base de datos para la tabla `vehicles`
-- 

INSERT INTO `vehicles` VALUES (205, 2, 'asdfas', 'sadfasf', 'images/vehicles/205.JPG');
INSERT INTO `vehicles` VALUES (203, 2, 'afd', 'dsafas', 'images/vehicles/203.JPG');
INSERT INTO `vehicles` VALUES (204, 2, 'sdfas', 'asfdsda', 'images/vehicles/204.JPG');
INSERT INTO `vehicles` VALUES (206, 1, 'adfasf', 'sdfsaf', 'images/vehicles/206.JPG');
INSERT INTO `vehicles` VALUES (208, 1, 'fgsdfg', 'gfdsg', 'images/vehicles/208.JPG');
INSERT INTO `vehicles` VALUES (217, 1, '493992', 'peepe', 'images/vehicles/217.GIF');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `vendors`
-- 

CREATE TABLE IF NOT EXISTS `vendors` (
  `id_vendor` int(11) unsigned NOT NULL auto_increment,
  `id_corp` int(11) unsigned NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `full_name` varchar(50) NOT NULL default '',
  `cif_nif` varchar(10) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `fiscal_address` varchar(255) NOT NULL default '',
  `postal_address` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `mail` varchar(100) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `postal_code` varchar(10) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `phone` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `mobile_phone` varchar(15) NOT NULL default '',
  `notes` text NOT NULL,
  PRIMARY KEY  (`id_vendor`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Volcar la base de datos para la tabla `vendors`
-- 

