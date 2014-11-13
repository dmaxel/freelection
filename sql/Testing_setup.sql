-- ----------------------------------------------------------------------------
-- These are the insertions necessary to perform all of our validation tests
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS=0;

-- Actual Users (one admin, one monitor)
	-- INSERT INTO user_accounts VALUES (1,1,'test@admin.com','John','Doe','admintest',
	-- '$2a$08$4T6xs5pUBbd1zA1GqkACuuveG0ZY3SmgCH0IYJXc9BNWN2eReLP9S','129.120.2.130',
	-- 'dq8ZTVn69P','','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00 00:00:00',
	-- '2014-11-13 01:07:06','2014-11-06 20:07:09',1,''),(2,2,'test@monitor.com','Jane','Doe',
	-- 'monitortest','$2a$08$x0UTJHxmJZTJc121rJrKhuQ/bjAtFY29v3H3MNXK7aOV5qpl8CmL6','129.120.2.131',
	-- 'K9FK9MtCwZ','','','0000-00-00 00:00:00','','',1,0,0,'','0000-00-00 00:00:00',
	-- '2014-11-13 00:52:11','2014-11-06 20:07:47',1,'');

-- Elections

	-- Election currently in voting window (2 voters (3-4), 4 candidates (candidates 1-4, users 5-8))
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end, voting_window_start, voting_window_end)
	VALUES (1, 'Eng Student Body \'14','This election is for the engineering student body',
	'2014-11-01 00:00:00','2014-11-06 00:00:00', '2014-11-07 00:00:00',
	'2014-12-25 00:00:00');
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (1, 0, 1, 'President', 0);
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (2, 0, 1, 'Vice-President', 1);
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (1, 1, 'John', 'Doe', 13, 'John Doe\'s profile');
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (2, 1, 'Jane', 'Doe', 14, 'Jane Doe\'s profile');
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (3, 2, 'Adam', 'Peltier', 15, 'Adam Peltier\'s profile');
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (4, 2, 'Bob', 'Amble', 16, 'Bob Amble\'s profile');
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (1, 1);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (2, 1);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (1, 2);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (2, 2);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (1, 1, 0, 1);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (1, 2, 0, 3);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (2, 1, 0, 2);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (2, 2, 0, 4);

	-- Election currently in registration window (1 voter (user 9), 2 candidates (candidates 5-6, users 10-11))
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end, voting_window_start, voting_window_end)
	VALUES (2, 'Distinguished Speaker','Vote for the next distinguished speaker.',
	'2014-11-01 00:00:00','2014-12-25 00:00:00', '2014-12-25 00:00:00',
	'2014-12-30 00:00:00');
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (3, 0, 2, 'Speaker', 0);
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (5, 3, 'Charles', 'Hampton', 17, 'Charles Hampton\'s profile');
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (6, 3, 'Dillan', 'Bard', 18, 'Dillan Bard\'s profile');
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (3, 3);

	-- Election has ended and there is a winner (3 voters (users 12-14), 2 candidates (candidates 7-8, users 15-16))
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end, voting_window_start, voting_window_end)
	VALUES (3, 'Student Representative','Vote for the student representative.',
	'2014-10-01 00:00:00','2014-10-25 00:00:00', '2014-10-25 00:00:00',
	'2014-10-30 00:00:00');
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (4, 0, 3, 'Representative', 0);
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (7, 4, 'Eric', 'Brady', 19, 'Eric Brady\'s profile');
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (8, 4, 'Fred', 'Smith', 20, 'Fred Smith\'s profile');
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (4, 4);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (4, 5);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (4, 6);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (4, 7);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (4, 8);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (4, 4, 0, 7);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (5, 4, 0, 7);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (6, 4, 0, 7);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (7, 4, 0, 8);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (8, 4, 0, 8);

	-- Election has ended and there is a tie (2 voters (users 17-18), 2 candidates (candidates 9-10, users 19-20))
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES (4, 'CSE Dean','Vote for the Dean.',
	'2014-10-01 00:00:00','2014-10-25 00:00:00', '2014-10-25 00:00:00',
	'2014-11-07 00:00:00');
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (5, 0, 4, 'Dean', 0);
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (9, 5, 'George', 'Wallace', 21, 'George Wallace\'s profile');
	-- INSERT INTO candidates (candidate_id, position, first_name, last_name, uacc_id, description)
	-- VALUES (10, 5, 'Henry', 'Jefferson', 22, 'Henry Jefferson\'s profile');
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (5, 9);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (5, 10);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (5, 11);
	-- INSERT INTO voting_eligibility (position, uacc_id)
	-- VALUES (5, 12);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (9, 5, 0, 9);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (10, 5, 0, 9);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (11, 5, 0, 10);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (12, 5, 0, 10);
