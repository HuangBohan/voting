DROP TABLE IF EXISTS statistics;
DROP TABLE IF EXISTS position_candidate;
DROP TABLE IF EXISTS election_position;
DROP TABLE IF EXISTS session;
DROP TABLE IF EXISTS resident;

CREATE TABLE resident (
	r_matric	VARCHAR(10),
	r_name		VARCHAR(255) NOT NULL,
	r_room		VARCHAR(10)	 NOT NULL,
	r_photo		VARCHAR(255),
	PRIMARY KEY(r_matric)
);

CREATE TABLE session (
	s_id		VARCHAR(5),
	s_name		VARCHAR(255),
	s_opendate	DATE,
	s_closedate	DATE,
	PRIMARY KEY(s_id)
);

CREATE TABLE election_position (
	p_id		INT AUTO_INCREMENT,
	s_id		VARCHAR(5),
	p_slots		INT DEFAULT 1,
	p_name		VARCHAR(255) NOT NULL,
	PRIMARY KEY(p_id),
	FOREIGN KEY(s_id) REFERENCES session(s_id)
);

CREATE TABLE position_candidate(
	p_id 		INT,
	c_matric 	VARCHAR(10),
	PRIMARY KEY(p_id, c_matric),
	FOREIGN KEY(p_id) REFERENCES election_position(p_id),
	FOREIGN KEY(c_matric) REFERENCES resident(r_matric)
);

CREATE TABLE statistics(
	p_id 		INT,
	c_matric	VARCHAR(10),
	r_matric	VARCHAR(10),
	st_vote		INT,
	PRIMARY KEY(p_id, c_matric, r_matric),
	FOREIGN KEY(p_id, c_matric) REFERENCES position_candidate(p_id, c_matric),
	FOREIGN KEY(r_matric) REFERENCES resident(r_matric)
);

