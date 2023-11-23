DROP DATABASE IF EXISTS UniTrip;

CREATE DATABASE IF NOT EXISTS UniTrip;

USE UniTrip;

CREATE TABLE Profile (
  nickname VARCHAR(20) PRIMARY KEY,
  mail VARCHAR(150) UNIQUE,
  password CHAR(128) NOT NULL, 
  salt CHAR(128) NOT NULL,
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

CREATE TABLE Country (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Region (
  country varchar(255),
  name VARCHAR(255) PRIMARY KEY,
  FOREIGN KEY (country) REFERENCES Country(name)
);

CREATE TABLE City (
  region varchar(255),
  name VARCHAR(255) PRIMARY KEY ,
  FOREIGN KEY (region) REFERENCES Region(name)
);

CREATE TABLE Trip (
  id INT PRIMARY KEY AUTO_INCREMENT,
  city varchar(255),
  organizer_username VARCHAR(255),
  photo_url VARCHAR(255),
  description VARCHAR(255),
  FOREIGN KEY (city) REFERENCES City(name),
  FOREIGN KEY (organizer_username) REFERENCES Profile(nickname)
);

CREATE TABLE Post (
  id INT PRIMARY KEY AUTO_INCREMENT,
  trip_id INT,
  photo_url VARCHAR(255),
  description VARCHAR(255),
  city VARCHAR(255),
  FOREIGN KEY (trip_id) REFERENCES Trip(id),
  FOREIGN KEY (city) REFERENCES City(name)
);

CREATE TABLE Itinerary (
  id INT PRIMARY KEY AUTO_INCREMENT
);

CREATE TABLE TripBetweenCities (
  id INT PRIMARY KEY AUTO_INCREMENT,
  itinerary_id INT,
  departure_city VARCHAR(255),
  departure_time TIME,
  arrival_city VARCHAR(255),
  arrival_time TIME,
  FOREIGN KEY (itinerary_id) REFERENCES Itinerary(id),
  FOREIGN KEY (departure_city) REFERENCES City(name),
  FOREIGN KEY (arrival_city) REFERENCES City(name)
);

CREATE TABLE Chat (
  from_username VARCHAR(255),
  to_username VARCHAR(255),
  PRIMARY KEY (from_username, to_username),
  FOREIGN KEY (from_username) REFERENCES Profile(nickname),
  FOREIGN KEY (to_username) REFERENCES Profile(nickname)
);

CREATE TABLE Activity (
  id INT PRIMARY KEY AUTO_INCREMENT,
  itinerary_id INT,
  start_time TIME,
  end_time TIME,
  description VARCHAR(255),
  FOREIGN KEY (itinerary_id) REFERENCES Itinerary(id)
);

CREATE TABLE Groups (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  description VARCHAR(255)
);

CREATE TABLE Messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  from_username VARCHAR(255),
  to_username varchar(255) NULL,
  message VARCHAR(255),
  group_id INT NULL,
  datetime DATETIME,
  FOREIGN KEY (from_username) REFERENCES Chat(from_username),
  FOREIGN KEY (to_username) REFERENCES Chat(to_username),
  FOREIGN KEY (group_id) REFERENCES Groups(id)
);

CREATE TABLE GroupParticipations (
  profile_username VARCHAR(255),
  group_id INT,
  FOREIGN KEY (profile_username) REFERENCES Profile(nickname),
  FOREIGN KEY (group_id) REFERENCES Groups(id),
  PRIMARY KEY (profile_username, group_id)
);

CREATE TABLE PostLikes (
  post_id INT,
  profile_username VARCHAR(50),
  FOREIGN KEY (post_id) REFERENCES Post(id),
  FOREIGN KEY (profile_username) REFERENCES Profile(nickname),
  PRIMARY KEY (profile_username, post_id)
);

CREATE TABLE PostFavourites (
  post_id INT,
  profile_username VARCHAR(50),
  FOREIGN KEY (post_id) REFERENCES Post(id),
  FOREIGN KEY (profile_username) REFERENCES Profile(nickname),
  PRIMARY KEY (profile_username, post_id)
);

CREATE TABLE LoginAttempts (
  nickname INT(11) NOT NULL,
  time VARCHAR(30) NOT NULL 
);

DROP USER 'secure_user'@'localhost';
CREATE USER 'secure_user'@'localhost' IDENTIFIED BY 'roHdLmnCs35P0Ssl2Q4';
GRANT SELECT, INSERT, UPDATE ON `unitrip`.* TO 'secure_user'@'localhost';

INSERT INTO Country (name) VALUES ('Italy');
INSERT INTO Country (name) VALUES ('France');
INSERT INTO Country (name) VALUES ('Spain');

INSERT INTO Region (country, name) VALUES ('Italy', 'Lombardy');
INSERT INTO Region (country, name) VALUES ('Italy', 'Tuscany');
INSERT INTO Region (country, name) VALUES ('France', 'Provence');
INSERT INTO Region (country, name) VALUES ('Spain', 'Catalonia');

INSERT INTO City (region, name) VALUES ('Lombardy', 'Milan');
INSERT INTO City (region, name) VALUES ('Lombardy', 'Bergamo');
INSERT INTO City (region, name) VALUES ('Tuscany', 'Florence');
INSERT INTO City (region, name) VALUES ('Tuscany', 'Pisa');
INSERT INTO City (region, name) VALUES ('Provence', 'Marseille');
INSERT INTO City (region, name) VALUES ('Catalonia', 'Barcelona');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('a', 'a@a.com', 'faceb2153f201fbb3ae1dc926822281e1398670a9e4edcad3f6f31e8434f7ebc330511c6c5de1162a77919c1bcd0e3632ff2a18a70d5bb62925f64ecc83508e3',
 '3efebc57f4f5f445c88e904737c9182dfb43c3863f1958d340dc57eaaf3ba6d9cd7c4ec6473aa75ab9eb3b3f3b67eafa129aa2e2a29e961e544771077d6c7cb0', 'a', 'a', 'img/profile/a.jpg',
  'A.', '1990-01-01', '2023-11-21');

INSERT INTO Trip (city, organizer_username, photo_url, description) VALUES ('Milan', 'a', 'img/black.jpg', 'Milan trip');

INSERT INTO Post (trip_id, photo_url, description, city) VALUES (1, 'img/black.jpg', 'Post of Milan Trip', 'Milan');