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
  PRIMARY KEY (from_username, to_username),
  FOREIGN KEY (from_username) REFERENCES Profile(nickname),
  FOREIGN KEY (to_username) REFERENCES Profile(nickname)
);

CREATE TABLE Country (
  name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE City (
  country varchar(255),
  name VARCHAR(255) PRIMARY KEY ,
  FOREIGN KEY (country) REFERENCES Country(name)
);

CREATE TABLE Itinerary (
  id INT PRIMARY KEY AUTO_INCREMENT,
  organizer_username VARCHAR(255),
  description VARCHAR(255),
  FOREIGN KEY (organizer_username) REFERENCES Profile(nickname)
);

CREATE TABLE ItineraryBetweenCities (
  itinerary_id INT,
  departure_city VARCHAR(255),
  departure_time TIME,
  arrival_city VARCHAR(255),
  arrival_time TIME,
  PRIMARY KEY (itinerary_id, departure_city),
  FOREIGN KEY (itinerary_id) REFERENCES Itinerary(id),
  FOREIGN KEY (departure_city) REFERENCES City(name),
  FOREIGN KEY (arrival_city) REFERENCES City(name)
);

CREATE TABLE Post (
  id INT PRIMARY KEY AUTO_INCREMENT,
  author VARCHAR(255),
  itinerary_id INT,
  description VARCHAR(255),
  city VARCHAR(255),
  date DATE DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (itinerary_id) REFERENCES Itinerary(id),
  FOREIGN KEY (author) REFERENCES Profile(nickname),
  FOREIGN KEY (city) REFERENCES City(name)
);

CREATE TABLE PostPhoto (
  post_id INT,
  photo_url VARCHAR(255),
  FOREIGN KEY (post_id) REFERENCES Post(id),
  PRIMARY KEY (post_id, photo_url)
);

CREATE TABLE PostComment (
  post_id INT,
  author VARCHAR(255),
  comment VARCHAR(255),
  datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (post_id, author, datetime),
  FOREIGN KEY (post_id) REFERENCES Post(id),
  FOREIGN KEY (author) REFERENCES Profile(nickname)
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

CREATE TABLE Groups (
  id INT PRIMARY KEY AUTO_INCREMENT,
  organizer_user VARCHAR(255),
  name VARCHAR(255),
  description VARCHAR(255),
  FOREIGN KEY (organizer_user) REFERENCES Profile(nickname)
);

CREATE TABLE Messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  from_username VARCHAR(255),
  to_username varchar(255) NULL,
  group_id INT NULL,
  message VARCHAR(255),
  datetime DATETIME,
  FOREIGN KEY (from_username) REFERENCES Profile(nickname),
  FOREIGN KEY (to_username) REFERENCES Profile(nickname),
  FOREIGN KEY (group_id) REFERENCES Groups(id)
);

CREATE TABLE GroupParticipations (
  partecipant_user VARCHAR(255),
  group_id INT,
  FOREIGN KEY (partecipant_user) REFERENCES Profile(nickname),
  FOREIGN KEY (group_id) REFERENCES Groups(id),
  PRIMARY KEY (partecipant_user, group_id)
);

CREATE TABLE LoginAttempts (
  nickname VARCHAR(50) NOT NULL,
  time VARCHAR(30) NOT NULL 
);

DROP USER 'secure_user'@'localhost';
CREATE USER 'secure_user'@'localhost' IDENTIFIED BY 'roHdLmnCs35P0Ssl2Q4';
GRANT SELECT, INSERT, UPDATE ON `unitrip`.* TO 'secure_user'@'localhost';

INSERT INTO Country (name) VALUES ('Italy');
INSERT INTO Country (name) VALUES ('France');
INSERT INTO Country (name) VALUES ('Spain');

INSERT INTO City (country, name) VALUES ('Italy', 'Milan');
INSERT INTO City (country, name) VALUES ('Italy', 'Bergamo');
INSERT INTO City (country, name) VALUES ('Italy', 'Florence');
INSERT INTO City (country, name) VALUES ('Italy', 'Pisa');
INSERT INTO City (country, name) VALUES ('France', 'Marseille');
INSERT INTO City (country, name) VALUES ('Spain', 'Barcelona');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('a', 'a@a.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'a', 'a', 'img/profile/gray.jpg',
  'A.', '1990-01-01', '2023-11-21');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('b', 'b@b.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'a', 'a', 'img/profile/gray.jpg',
  'A.', '1990-01-01', '2023-11-21');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('c', 'c@b.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'a', 'a', 'img/profile/gray.jpg',
  'A.', '1990-01-01', '2023-11-21');

INSERT INTO Follow (from_username, to_username) VALUES ('a', 'b');
INSERT INTO Follow (from_username, to_username) VALUES ('b', 'c');

INSERT INTO Itinerary (organizer_username, description) VALUES ('a', 'Milan trip');
INSERT INTO Itinerary (organizer_username, description) VALUES ('a', 'Florence trip');
INSERT INTO Itinerary (organizer_username, description) VALUES ('c', 'Marseille trip');
INSERT INTO Itinerary (organizer_username, description) VALUES ('b', 'Barcelona trip');

INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (1, 'Milan', '2018-01-01 10:00:00', 'Bergamo', '2018-01-01 11:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (1, 'Bergamo', '2018-01-01 12:00:00', 'Milan', '2018-01-01 13:00:00');

INSERT INTO Post (author, itinerary_id, description, city) VALUES ('a', 1, 'Milan post 1', 'Milan');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('a', 1, 'Milan post 2', 'Milan');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('a', 2, 'Florence post 1', 'Florence');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('a', 2, 'Florence post 2', 'Florence');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('c', 3, 'Marseille post 1', 'Marseille');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('c', 3, 'Marseille post 2', 'Marseille');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('b', 4, 'Barcelona post 1', 'Barcelona');
INSERT INTO Post (author, itinerary_id, description, city) VALUES ('b', 4, 'Barcelona post 2', 'Barcelona');

INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, 'img/post/milan1.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, 'img/post/milan2.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (2, 'img/post/milan3.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (2, 'img/post/milan4.jpg');

INSERT INTO PostLikes (post_id, profile_username) VALUES (5, 'a');
INSERT INTO PostLikes (post_id, profile_username) VALUES (6, 'a');

INSERT INTO PostFavourites (post_id, profile_username) VALUES (5, 'a');