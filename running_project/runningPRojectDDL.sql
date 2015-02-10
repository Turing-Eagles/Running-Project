CREATE TABLE organizer_account(
password VARCHAR(15),
username VARCHAR(15),
PRIMARY KEY (username)
);

CREATE TABLE racer_account(
password VARCHAR(15),
username VARCHAR(15),
sex VARCHAR(1),
last_name VARCHAR(15),
first_name VARCHAR(15),
birthdate DATE,
PRIMARY KEY (username)
);

CREATE TABLE races(
race_id MEDIUMINT AUTO_INCREMENT,
category VARCHAR(15),
name VARCHAR(15),
race_date DATE,
race_time TIME,
PRIMARY KEY (race_id )
);

CREATE TABLE race_categories(
category VARCHAR(15)
);

CREATE TABLE racer_participation(
racer_name VARCHAR(15),
race_name VARCHAR(15),
FOREIGN KEY (race_name) 
        REFERENCES races (race_id),
FOREIGN KEY (racer_name) 
        REFERENCES racer_account(username)
);

CREATE TABLE organizer_participation(
organizer_name VARCHAR(15),
race_name VARCHAR(15),
FOREIGN KEY (race_name) 
        REFERENCES races(name),
FOREIGN KEY (organizer_name) 
        REFERENCES organizer_account(username)
);