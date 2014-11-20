-- ----------------------------------------------------------------------------
-- These are the insertions necessary to perform all of our validation tests
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS=0;

-- Elections

	-- Election currently in voting window (2 voters (3-4), 4 candidates (candidates 1-4, users 5-8))
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end, voting_window_start, voting_window_end)
	VALUES (1, 'Eng Student Body \'14','This election is for the engineering student body',
	'2014-11-01 00:00:00','2014-12-20 00:00:00', '2014-11-07 00:00:00',
	'2014-12-25 00:00:00');
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (1, 0, 1, 'President', 0);
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (2, 0, 1, 'Vice-President', 1);
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

	-- Election has ended and there is a winner (3 voters (users 12-14), 2 candidates (candidates 7-8, users 15-16))
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end, voting_window_start, voting_window_end)
	VALUES (3, 'Student Representative','Vote for the student representative.',
	'2014-10-01 00:00:00','2014-10-25 00:00:00', '2014-10-25 00:00:00',
	'2014-10-30 00:00:00');
	INSERT INTO ballots (position, type, election_id, title, write_ins)
	VALUES (4, 0, 3, 'Representative', 0);
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
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (9, 5, 0, 9);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (10, 5, 0, 9);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (11, 5, 0, 10);
	-- INSERT INTO votes (uacc_id, position, vote_type, candidate_id)
	-- VALUES (12, 5, 0, 10);
