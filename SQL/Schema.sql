CREATE TABLE users (
    uid VARCHAR (64) PRIMARY KEY,
    password VARCHAR (64) NOT NULL,
    points INTEGER NOT NULL
);

CREATE TABLE pets (
	pid VARCHAR (64) PRIMARY KEY,
	pname VARCHAR (64) NOT NULL,
	ptype VARCHAR (64) NOT NULL,
	oid VARCHAR (64) REFERENCES users(uid) NOT NULL
);

CREATE TABLE availability (
	cid VARCHAR(64) REFERENCES users(uid),
	ptype VARCHAR(64) NOT NULL,
	afrom DATE NOT NULL,
	ato DATE NOT NULL,
	aid SERIAL PRIMARY KEY
);

CREATE TABLE bid (
  bid VARCHAR(64) REFERENCES users(uid),
  aid INT REFERENCES availability(aid),
  pid VARCHAR(64) REFERENCES pets(pid),
  status VARCHAR(64) CHECK (status IN ('successful', 'failed', 'pending')),
  points INTEGER NOT NULL,
  PRIMARY KEY (bid, aid, pid)
);
