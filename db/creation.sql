DROP DATABASE IF EXIST UniTrip;

CREATE DATABASE IF NOT EXIST UniTrip;

USE UniTrip;

CREATE TABLE Profile (
  nickname VARCHAR(20) PRIMARY KEY,
  password VARCHAR(20),
  name VARCHAR(20),
  surname VARCHAR(20),
  photo_url VARCHAR(255),
  description VARCHAR(500),
  birth_date DATE,
  join_date DATE
);

CREATE TABLE Follow (
  from_username VARCHAR(20),
  to_username VARCHAR(20),
  mutual BOOLEAN,
  PRIMARY KEY (from_username, to_username),
  FOREIGN KEY (from_username) REFERENCES Profile(nickname),
  FOREIGN KEY (to_username) REFERENCES Profile(nickname)
);

INSERT INTO Profile (nickname, password, name, surname, photo_url, description, birth_date, join_date)
VALUES ('admin', 'admin', 'admin', 'admin', '../img/gray.jpg', 'admin', '2000-01-01', '2020-01-01');