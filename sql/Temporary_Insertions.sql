SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO voting_eligibility (position, uacc_id)
	VALUES (1, 1);
INSERT INTO voting_eligibility (position, uacc_id)
	VALUES (2, 1);
INSERT INTO elections (election_title, description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES ('Eng Student Body \'14','This election is for the engineering student body',
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
