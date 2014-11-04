/*
	Freelection database definitions with flexi
*/

SET FOREIGN_KEY_CHECKS=0;

-- -----------------------------
-- Table structure for elections
-- -----------------------------
DROP TABLE IF EXISTS elections;
CREATE TABLE elections (
	election_id int(10) unsigned NOT NULL AUTO_INCREMENT,
	description varchar(150) NOT NULL,
	registration_window_start datetime NOT NULL,
	registration_window_end datetime NOT NULL,
	voting_window_start datetime NOT NULL,
	voting_window_end datetime NOT NULL,
	PRIMARY KEY (election_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------
-- List of all elections
-- -----------------------------

-- -----------------------------
-- Table structure for ballots
-- -----------------------------
DROP TABLE IF EXISTS ballots;
CREATE TABLE ballots (
	position int(10) unsigned NOT NULL AUTO_INCREMENT,
	type BIT(1) NOT NULL DEFAULT b'0', -- (0 means candidate, 1 means y/n)
	election_id int(10) unsigned NOT NULL,
	title varchar(40) NOT NULL,
	write_ins BIT(1) NOT NULL DEFAULT b'0', -- (0 means no, 1 means yes)
	PRIMARY KEY (position),
	FOREIGN KEY (election_id) REFERENCES elections(election_id) ON UPDATE CASCADE ON DELETE CASCADE -- New
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------
-- List of election positions and candidates
-- -----------------------------

-- -----------------------------
-- Table structure for votes
-- -----------------------------
DROP TABLE IF EXISTS votes;
CREATE TABLE votes (
	uacc_id int(11) unsigned NOT NULL,
	position int(10) unsigned NOT NULL,
	vote_type BIT(2) NOT NULL DEFAULT b'0', -- (0 means normal, 1 means write-in)
	candidate_id int(11) unsigned,
	first_name varchar(20) DEFAULT '',
	last_name varchar(20) DEFAULT '',
	PRIMARY KEY (uacc_id, position),
	FOREIGN KEY (position) REFERENCES ballots (position) ON UPDATE CASCADE ON DELETE CASCADE, -- New
	FOREIGN KEY (uacc_id) REFERENCES user_accounts (uacc_id) ON UPDATE CASCADE ON DELETE CASCADE, -- New
	FOREIGN KEY (candidate_id) REFERENCES candidates (candidate_id) ON UPDATE CASCADE ON DELETE CASCADE -- New
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
	
-- -----------------------------
-- List of every vote
-- -----------------------------

-- -----------------------------
-- Table structure for voting_eligibility
-- -----------------------------
DROP TABLE IF EXISTS voting_eligibility;
CREATE TABLE voting_eligibility (
	position int(10) unsigned NOT NULL,
	uacc_id int(11) unsigned NOT NULL,
	PRIMARY KEY (position, uacc_id),
	FOREIGN KEY (position) REFERENCES ballots (position) ON UPDATE CASCADE ON DELETE CASCADE, -- New
	FOREIGN KEY (uacc_id) REFERENCES user_accounts (uacc_id) ON UPDATE CASCADE ON DELETE CASCADE -- New
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------
-- List of every position voters can vote for
-- -----------------------------

-- -----------------------------
-- Table structure for candidates
-- -----------------------------
DROP TABLE IF EXISTS candidates;
CREATE TABLE candidates (
	candidate_id int(11) unsigned NOT NULL AUTO_INCREMENT,
	position int(10) unsigned NOT NULL,
	first_name varchar(20) NOT NULL,
	last_name varchar(20) NOT NULL,
	uacc_id int(11) unsigned NOT NULL,
	description varchar(600) NOT NULL, -- New
	PRIMARY KEY (candidate_id),
	FOREIGN KEY (uacc_id) REFERENCES user_accounts (uacc_id) ON UPDATE CASCADE ON DELETE CASCADE, -- New
	FOREIGN KEY (position) REFERENCES ballots (position) ON UPDATE CASCADE ON DELETE CASCADE -- New
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- -----------------------------
-- List of all approved candidates and their positions
-- -----------------------------

-- -------------------------------------------------------------------------------------------------------------
-- -------------------------------------------------------------------------------------------------------------

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS ci_sessions;
CREATE TABLE ci_sessions (
  session_id varchar(40) NOT NULL DEFAULT 0,
  ip_address varchar(16) NOT NULL DEFAULT 0,
  user_agent varchar(120) DEFAULT NULL,
  last_activity int(10) unsigned NOT NULL DEFAULT 0,
  user_data text NOT NULL DEFAULT '',
  PRIMARY KEY (session_id),
  KEY last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for user_accounts
-- ----------------------------
DROP TABLE IF EXISTS user_accounts;
CREATE TABLE user_accounts (
  uacc_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  uacc_group_fk smallint(5) unsigned NOT NULL DEFAULT 0,
  uacc_email varchar(100) NOT NULL DEFAULT '',
  uacc_firstname varchar(20) NOT NULL DEFAULT '', -- New
  uacc_lastname varchar(20) NOT NULL DEFAULT '', -- New
  uacc_username varchar(15) NOT NULL DEFAULT '',
  uacc_password varchar(60) NOT NULL DEFAULT '',
  uacc_password_plain varchar(60) DEFAULT NULL, -- New
  uacc_ip_address varchar(40) NOT NULL DEFAULT '',
  uacc_salt varchar(40) NOT NULL DEFAULT '',
  uacc_activation_token varchar(40) NOT NULL DEFAULT '',
  uacc_forgotten_password_token varchar(40) NOT NULL DEFAULT '',
  uacc_forgotten_password_expire datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  uacc_update_email_token varchar(40) NOT NULL DEFAULT '',
  uacc_update_email varchar(100) NOT NULL DEFAULT '',
  uacc_active tinyint(1) unsigned NOT NULL DEFAULT 0,
  uacc_suspend tinyint(1) unsigned NOT NULL DEFAULT 0,
  uacc_fail_login_attempts smallint(5) NOT NULL DEFAULT 0,
  uacc_fail_login_ip_address varchar(40) NOT NULL DEFAULT '',
  uacc_date_fail_login_ban datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Time user is banned until due to repeated failed logins',
  uacc_date_last_login datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  uacc_date_added datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (uacc_id),
  UNIQUE KEY uacc_id (uacc_id),
  KEY uacc_group_fk (uacc_group_fk),
  KEY uacc_email (uacc_email),
  KEY uacc_username (uacc_username),
  KEY uacc_fail_login_ip_address (uacc_fail_login_ip_address)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_accounts
-- ----------------------------

-- ----------------------------
-- Table structure for user_groups
-- ----------------------------
DROP TABLE IF EXISTS user_groups;
CREATE TABLE user_groups (
  ugrp_id smallint(5) NOT NULL AUTO_INCREMENT,
  ugrp_name varchar(20) NOT NULL DEFAULT '',
  ugrp_desc varchar(100) NOT NULL DEFAULT '',
  ugrp_admin tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (ugrp_id),
  UNIQUE KEY ugrp_id (ugrp_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_groups
-- ----------------------------

-- ----------------------------
-- Table structure for user_login_sessions
-- ----------------------------
DROP TABLE IF EXISTS user_login_sessions;
CREATE TABLE user_login_sessions (
  usess_uacc_fk int(11) NOT NULL DEFAULT 0,
  usess_series varchar(40) NOT NULL DEFAULT '',
  usess_token varchar(40) NOT NULL DEFAULT '',
  usess_login_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (usess_token),
  UNIQUE KEY usess_token (usess_token)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_login_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for user_privileges
-- ----------------------------
DROP TABLE IF EXISTS user_privileges;
CREATE TABLE user_privileges (
  upriv_id smallint(5) NOT NULL AUTO_INCREMENT,
  upriv_name varchar(20) NOT NULL DEFAULT '',
  upriv_desc varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (upriv_id),
  UNIQUE KEY upriv_id (upriv_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_privileges
-- ----------------------------

-- ----------------------------
-- Table structure for user_privilege_users
-- ----------------------------
DROP TABLE IF EXISTS user_privilege_users;
CREATE TABLE user_privilege_users (
  upriv_users_id smallint(5) NOT NULL AUTO_INCREMENT,
  upriv_users_uacc_fk int(11) NOT NULL DEFAULT 0,
  upriv_users_upriv_fk smallint(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (upriv_users_id),
  UNIQUE KEY upriv_users_id (upriv_users_id) USING BTREE,
  KEY upriv_users_uacc_fk (upriv_users_uacc_fk),
  KEY upriv_users_upriv_fk (upriv_users_upriv_fk)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_privilege_users
-- ----------------------------


-- ----------------------------
-- Table structure for user_privilege_groups
-- ----------------------------

DROP TABLE IF EXISTS user_privilege_groups;
CREATE TABLE user_privilege_groups (
  upriv_groups_id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  upriv_groups_ugrp_fk smallint(5) unsigned NOT NULL DEFAULT 0,
  upriv_groups_upriv_fk smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (upriv_groups_id),
  UNIQUE KEY upriv_groups_id (upriv_groups_id) USING BTREE,
  KEY upriv_groups_ugrp_fk (upriv_groups_ugrp_fk),
  KEY upriv_groups_upriv_fk (upriv_groups_upriv_fk)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- ----------------------------
-- Records of user_privilege_groups
-- ----------------------------

-- -------------------------------------------------------------------------------------------------------------------
-- -------------------------------------------------------------------------------------------------------------------

-- ------------------------------
-- Test entries
-- ------------------------------
INSERT INTO user_accounts VALUES (1,1,'hi@hi.com','bob', 'barker', 'hi','$2a$08$UQr3d1apyqW8uqKDQjSzAewZkuojYz0.TUWK7laYB0jtvu8nZujpq',NULL,'50.97.94.38','P7QSdBGnwj'
,'','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00 00:00:00','2014-11-04 16:49:53','2014-10-24 01:28:45'),(2,1,'mail@mail.com','jack', 'black','Adam','$2a$08$C6Mg
r5XLfuZQf/RIk6BNxepk135Sw8bJ1v9i3yBH.0sgxfexuLDyy',NULL,'71.123.247.3','TY8pF6kGpY','','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00 00:00:00','2
014-10-24 03:02:00','2014-10-24 03:02:00'),(3,1,'test','test','blah','blah','$2a$08$0UgfWwrDibpnrUvEzGR0Fe4xJI6Xdk3rGuv2dcWbeQUXw.jYgtOUG',NULL,'97.94.209.157','3Qc5
rTf9zm','','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00 00:00:00','2014-10-29 01:21:28','2014-10-28 03:26:28'),(4,1,'lrjaif @yahoo.com','asdf','asdf','dklrk',
'$2a$08$zjU8CmS.QpdJdnNh7q65Qu5mP9nzMXsUuozrsQV.qvqGXUKN2WF0q',NULL,'129.120.2.131','8s95Hxxcz5','','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00
 00:00:00','2014-10-28 15:20:17','2014-10-28 15:20:17'),(5,1,'roshan_drn@yhaoo.com','roshan','shrestha','roshan','$2a$08$ImIOHoqvYZ30yyzM1vGHIedRV7cBP1n6eii/FNgh9Z/b5S9WKb
iVK',NULL,'68.191.212.238','29RbGxNs4Y','','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00 00:00:00','2014-10-29 15:13:05','2014-10-28 15:20:53'),(
6,4,'adminemail','bob','joe','admin','$2a$08$pVYV8wLxytgIhqTWInuZee6tPE.L8dxbXmxYx6giG7.z9ISCEgeKa',NULL,'129.120.2.130','XdKBKxnMgC','','','0000-00-00 00:00:00','
','',1,0,0,'','0000-00-00 00:00:00','2014-11-04 16:41:16','2014-11-04 16:39:22');
INSERT INTO `user_groups` VALUES (1,'Administrators','',0),(2,'Monitors','',0),(3,'Candidates','',0),(4,'Voters','',0);
INSERT INTO voting_eligibility (position, uacc_id)
	VALUES (1, 1);
INSERT INTO voting_eligibility (position, uacc_id)
	VALUES (2, 1);
INSERT INTO elections (description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES ('This election is for the engineering student body',
	'2014-11-01 00:00:00','2014-11-10 00:00:00', '2014-11-02 00:00:00',
	'2014-11-11 00:00:00');
INSERT INTO ballots (election_id, title)
	VALUES (1, 'President');
INSERT INTO ballots (election_id, title)
	VALUES (1, 'Chair');
INSERT INTO candidates (position, first_name, last_name, uacc_id, description)
	VALUES (1, 'Alfred', 'Denver', 1, 'Fake profile info');
INSERT INTO candidates (position, first_name, last_name, uacc_id, description)
	VALUES (1, 'Donald', 'Bedford', 2, 'Fake profile info again');
INSERT INTO candidates (position, first_name, last_name, uacc_id, description)
	VALUES (2, 'Rick', 'Patterson', 3, 'Fake profiles are cool');
INSERT INTO candidates (position, first_name, last_name, uacc_id, description)
	VALUES (2, 'Brent', 'Coulder', 4, 'Blah blah blah');
