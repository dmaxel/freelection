-- ----------------------------------------------------------------------------
-- These are the insertions necessary to perform all of our validation tests
-- ----------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS=0;

-- Administrators



-- Voters



-- Election Monitors



-- Candidates



-- Pending Users



-- Elections

	-- Election currently in voting window
	INSERT INTO elections (election_id, election_title, description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES (20, 'Eng Student Body \'14','This election is for the engineering student body',
	'2014-11-01 00:00:00','2014-11-6 00:00:00', '2014-11-02 00:00:00',
	'2014-12-25 00:00:00');
	INSERT INTO ballots (election_id, title)
	VALUES (20, 'President');
	INSERT INTO ballots (election_id, title)
	VALUES (20, 'Vice President');

	-- Election currently in registration window
	INSERT INTO elections (election_title, description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES ('General Election \'14','General 2014 election for entire school',
	'2014-11-01 00:00:00','2014-12-25 00:00:00', '2014-12-25 00:00:00',
	'2014-12-30 00:00:00');

	--Election has ended and there is a winner
	INSERT INTO elections (election_title, description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES ('Student Body President \'14','Vote for the student body president',
	'2014-10-01 00:00:00','2014-10-25 00:00:00', '2014-10-25 00:00:00',
	'2014-10-30 00:00:00');

	-- Election has ended and there is a tie
	INSERT INTO elections (election_title, description, registration_window_start,
	registration_window_end,voting_window_start, voting_window_end)
	VALUES ('Student Body President \'14','Vote for the student body president',
	'2014-10-01 00:00:00','2014-10-25 00:00:00', '2014-10-25 00:00:00',
	'2014-11-07 00:00:00');

-- Votes
