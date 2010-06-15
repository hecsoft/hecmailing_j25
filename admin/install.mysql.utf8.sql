CREATE TABLE IF NOT EXISTS `#__hecmailing_groupdetail` (
  `grp_id_groupe` int(11) NOT NULL COMMENT 'Id du groupe',
  `gdet_cd_type` tinyint(4) NOT NULL COMMENT 'Type de detail (1 : UserName, 2 : UserId, 3 : UserType, 4 : E-mail)',
  `gdet_id_value` int(11) NOT NULL COMMENT 'Code de la valeur',
  `gdet_vl_value` varchar(50) NOT NULL,
  KEY `grp_id_groupe` (`grp_id_groupe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Detail des groupe de diffusion';

CREATE TABLE IF NOT EXISTS `#__hecmailing_groups` (
  `grp_id_groupe` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id du groupe',
  `grp_nm_groupe` varchar(30) NOT NULL COMMENT 'nom du groupe',
  `grp_cm_groupe` varchar(250) NOT NULL COMMENT 'Commentaires',
  PRIMARY KEY (`grp_id_groupe`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Liste des groupes de mailing' ;

CREATE TABLE IF NOT EXISTS `#__hecmailing_save` (
  `msg_id_message` int(11) NOT NULL AUTO_INCREMENT,
  `msg_lb_message` varchar(30) NOT NULL,
  `msg_vl_subject` varchar(200) NOT NULL,
  `msg_vl_body` text NOT NULL,
  `msg_vl_from` varchar(150) NOT NULL,
  `grp_id_groupe` int(11) NOT NULL,
  PRIMARY KEY (`msg_id_message`),
  KEY `grp_id_groupe` (`grp_id_groupe`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Modeles de mail' ;

