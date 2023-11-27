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
  author VARCHAR(255),
  trip_id INT,
  photo_url VARCHAR(255),
  description VARCHAR(255),
  city VARCHAR(255),
  date DATE DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (trip_id) REFERENCES Trip(id),
  FOREIGN KEY (author) REFERENCES Profile(nickname),
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

INSERT INTO Trip (city, organizer_username, photo_url, description) VALUES ('Milan', 'a', 'img/trip/milan.jpg', 'Milan trip');
INSERT INTO Trip (city, organizer_username, photo_url, description) VALUES ('Florence', 'a', 'img/trip/florence.jpg', 'Florence trip');
INSERT INTO Trip (city, organizer_username, photo_url, description) VALUES ('Marseille', 'c', 'img/trip/marseille.jpg', 'Marseille trip');
INSERT INTO Trip (city, organizer_username, photo_url, description) VALUES ('Barcelona', 'b', 'img/trip/barcelona.jpg', 'Barcelona trip');

INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('a', 1, 'img/post/milan1.jpg', 'Milan post 1', 'Milan');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('a', 1, 'img/post/milan2.jpg', 'Milan post 2', 'Milan');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('a', 2, 'img/post/florence1.jpg', 'Florence post 1', 'Florence');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('a', 2, 'img/post/florence2.jpg', 'Florence post 2', 'Florence');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('c', 3, 'img/post/marseille1.jpg', 'Marseille post 1', 'Marseille');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('c', 3, 'img/post/marseille2.jpg', 'Marseille post 2', 'Marseille');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('b', 4, 'img/post/barcelona1.jpg', 'Barcelona post 1', 'Barcelona');
INSERT INTO Post (author, trip_id, photo_url, description, city) VALUES ('b', 4, 'img/post/barcelona2.jpg', 'Barcelona post 2', 'Barcelona');