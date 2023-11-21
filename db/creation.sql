DROP DATABASE IF EXISTS UniTrip;

CREATE DATABASE IF NOT EXISTS UniTrip;

USE UniTrip;

CREATE TABLE Profile (
  nickname VARCHAR(20) PRIMARY KEY,
  mail VARCHAR(150),
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

CREATE TABLE FavoriteDestination (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255),
  city varchar(255),
  FOREIGN KEY (username) REFERENCES Profile(nickname),
  FOREIGN KEY (city) REFERENCES City(name)
);

CREATE TABLE Country (
  name PRIMARY KEY VARCHAR(255)
);

CREATE TABLE Region (
  country varchar(255),
  name PRIMARY KEY VARCHAR(255),
  FOREIGN KEY (country) REFERENCES Country(name)
);

CREATE TABLE Citie (
  region varchar(255),
  name PRIMARY KEY VARCHAR(255),
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
  id_post INT PRIMARY KEY AUTO_INCREMENT,
  trip_id INT,
  photo_url VARCHAR(255),
  description VARCHAR(255),
  city VARCHAR(255),
  FOREIGN KEY (trip_id) REFERENCES Trip(id),
  FOREIGN KEY (city) REFERENCES City(name)
);

CREATE TABLE Itineraries (
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

CREATE TABLE Messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  from_username VARCHAR(255),
  to_username NULL varchar(255),
  message VARCHAR(255),
  group_id NULL INT,
  datetime DATETIME,
  FOREIGN KEY (from_username) REFERENCES Chat(from_username),
  FOREIGN KEY (to_username) REFERENCES Chat(to_username),
  FOREIGN KEY (group_id) REFERENCES Groups(id)
);

CREATE TABLE Activity(
  id INT PRIMARY KEY AUTO_INCREMENT,
  itinerary_id INT,
  start_time TIME,
  end_time TIME,
  description VARCHAR(255),
  FOREIGN KEY (itinerary_id) REFERENCES Itinerary(id)
);

CREATE TABLE Like (
  id INT PRIMARY KEY AUTO_INCREMENT,
  from_username VARCHAR(255),
  trip_id INT,
  FOREIGN KEY (from_username) REFERENCES Profile(nickname),
  FOREIGN KEY (trip_id) REFERENCES Trip(id)
);

CREATE TABLE Groups (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  description VARCHAR(255)
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
  profile_username VARCHAR(255),
  FOREIGN KEY (post_id) REFERENCES Posts(id),
  FOREIGN KEY (profile_username) REFERENCES Profile(nickname),
  PRIMARY KEY (profile_username, post_id)
);

INSERT INTO Profile (nickname, password, name, surname, photo_url, description, birth_date, join_date)
VALUES ('admin', 'admin', 'admin', 'admin', '../img/gray.jpg', 'admin', '2000-01-01', '2020-01-01');