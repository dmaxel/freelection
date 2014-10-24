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
	registration_window_start datetime NOT NULL,
	registration_window_end datetime NOT NULL,
	voting_window_start datetime NOT NULL,
	voting_window_end datetime NOT NULL,
	write_ins BIT(1) NOT NULL DEFAULT b'0',
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
	election_id int(10) unsigned NOT NULL,
	title varchar(40) NOT NULL,
	PRIMARY KEY (position),
	FOREIGN KEY (election_id)
		REFERENCES elections(election_id)
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
	candidate_id int(11) unsigned,
	first_name varchar(20) DEFAULT '',
	last_name varchar(20) DEFAULT '',
	PRIMARY KEY (uacc_id, position),
	FOREIGN KEY (position)
		REFERENCES ballots (position),
	FOREIGN KEY (uacc_id)
		REFERENCES user_accounts (uacc_id),
	FOREIGN KEY (candidate_id)
		REFERENCES candidates (candidate_id)
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
	FOREIGN KEY (position)
		REFERENCES ballots (position),
	FOREIGN KEY (uacc_id)
		REFERENCES user_accounts (uacc_id)
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
	PRIMARY KEY (candidate_id),
	FOREIGN KEY (uacc_id)
		REFERENCES user_accounts (uacc_id),
	FOREIGN KEY (position)
		REFERENCES ballots (position)
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
  uacc_username varchar(15) NOT NULL DEFAULT '',
  uacc_password varchar(60) NOT NULL DEFAULT '',
  uacc_password_plain varchar(60) DEFAULT NULL, -- This column added for temporary password storage
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

