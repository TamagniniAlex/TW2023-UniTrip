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
  title VARCHAR(255),
  description VARCHAR(255),
  country VARCHAR(255),
  datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (itinerary_id) REFERENCES Itinerary(id),
  FOREIGN KEY (author) REFERENCES Profile(nickname),
  FOREIGN KEY (country) REFERENCES Country(name)
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

CREATE TABLE PostLike (
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
GRANT DELETE ON `unitrip`.`PostLike` TO 'secure_user'@'localhost';
GRANT DELETE ON `unitrip`.`PostFavourites` TO 'secure_user'@'localhost';
GRANT DELETE ON `unitrip`.`Follow` TO 'secure_user'@'localhost';

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('a', 'a@a.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'A_Nome', 'A_Cognome', '../img/profile/gray.jpg',
  'a.', '1990-01-01', '2023-11-20');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('marco', 'MarcoRossi@gmail.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'Marco', 'Rossi', '../img/profile/marco.jpg',
  'Ciao mi chiamo marco rossi.', '1992-06-01', '2023-11-21');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('alessia', 'AlessiaConti@gmail.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'Alessia', 'Conti', '../img/profile/alessia.jpg',
  'Ciao mi chiamo Alessia Conti.', '1992-02-01', '2023-11-26');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('francesco', 'FrancescoDeLuca@gmail.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'Francesco', 'De Luca', '../img/profile/francesco.jpg',
  'Ciao mi chiamo francesco de luca.', '1998-07-01', '2023-11-30');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('chiara', 'ChiaraMoretti@gmail.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'Chiara', 'Moretti', '../img/profile/chiara.jpg',
  'Ciao mi chiamo Chiara Moretti.', '1997-05-01', '2023-12-09');

INSERT INTO Profile (nickname, mail, password, salt, name, surname, photo_url, description, birth_date, join_date)
VALUES ('roby', 'RobertoBianchi@gmail.com', '194de7803c093146a7931905306403ed4c4e2c334f35607fc66d58aaacb1559a958489748abdce3a1a303b08c71f649abb49a69cae09be113166542857279454',
  '8f8c796ca4563395a8810b6116b502799dd3ac04e3cc488c3d7c7bcf66a4cda715e09dd0788aaff25e42e9fb08f11f3baca6f396a47c037393e86289c2af028b', 'Roberto', 'Bianchi', '../img/profile/roby.jpg',
  'Ciao mi chiamo Roberto Bianchi, detto roby.', '2000-04-01', '2023-12-10');

INSERT INTO Follow (from_username, to_username) VALUES ('a', 'marco');
INSERT INTO Follow (from_username, to_username) VALUES ('a', 'alessia');
INSERT INTO Follow (from_username, to_username) VALUES ('marco', 'alessia');
INSERT INTO Follow (from_username, to_username) VALUES ('alessia', 'marco');
INSERT INTO Follow (from_username, to_username) VALUES ('alessia', 'francesco');
INSERT INTO Follow (from_username, to_username) VALUES ('francesco', 'marco');
INSERT INTO Follow (from_username, to_username) VALUES ('francesco', 'roby');
INSERT INTO Follow (from_username, to_username) VALUES ('chiara', 'a');
INSERT INTO Follow (from_username, to_username) VALUES ('chiara', 'marco');
INSERT INTO Follow (from_username, to_username) VALUES ('roby', 'alessia');
INSERT INTO Follow (from_username, to_username) VALUES ('roby', 'francesco');

INSERT INTO Country (name) VALUES ('Italia');
INSERT INTO Country (name) VALUES ('Francia');
INSERT INTO Country (name) VALUES ('Spagna');
INSERT INTO Country (name) VALUES ('Germania');
INSERT INTO Country (name) VALUES ('Regno Unito');
INSERT INTO Country (name) VALUES ('Olanda');
INSERT INTO Country (name) VALUES ('Portogallo');
INSERT INTO Country (name) VALUES ('Svizzera');
INSERT INTO Country (name) VALUES ('Svezia');
INSERT INTO Country (name) VALUES ('Austria');

INSERT INTO City (country, name) VALUES ('Italia', 'Roma');
INSERT INTO City (country, name) VALUES ('Italia', 'Milano');
INSERT INTO City (country, name) VALUES ('Italia', 'Napoli');
INSERT INTO City (country, name) VALUES ('Italia', 'Firenze');
INSERT INTO City (country, name) VALUES ('Francia', 'Parigi');
INSERT INTO City (country, name) VALUES ('Francia', 'Marsiglia');
INSERT INTO City (country, name) VALUES ('Francia', 'Lione');
INSERT INTO City (country, name) VALUES ('Francia', 'Nizza');
INSERT INTO City (country, name) VALUES ('Spagna', 'Madrid');
INSERT INTO City (country, name) VALUES ('Spagna', 'Barcellona');
INSERT INTO City (country, name) VALUES ('Spagna', 'Siviglia');
INSERT INTO City (country, name) VALUES ('Spagna', 'Valencia');
INSERT INTO City (country, name) VALUES ('Germania', 'Berlino');
INSERT INTO City (country, name) VALUES ('Germania', 'Monaco');
INSERT INTO City (country, name) VALUES ('Germania', 'Amburgo');
INSERT INTO City (country, name) VALUES ('Germania', 'Francoforte');
INSERT INTO City (country, name) VALUES ('Regno Unito', 'Londra');
INSERT INTO City (country, name) VALUES ('Regno Unito', 'Manchester');
INSERT INTO City (country, name) VALUES ('Regno Unito', 'Liverpool');
INSERT INTO City (country, name) VALUES ('Regno Unito', 'Edimburgo');
INSERT INTO City (country, name) VALUES ('Olanda', 'Amsterdam');
INSERT INTO City (country, name) VALUES ('Olanda', 'Rotterdam');
INSERT INTO City (country, name) VALUES ('Olanda', 'LAia');
INSERT INTO City (country, name) VALUES ('Olanda', 'Utrecht');
INSERT INTO City (country, name) VALUES ('Portogallo', 'Lisbona');
INSERT INTO City (country, name) VALUES ('Portogallo', 'Porto');
INSERT INTO City (country, name) VALUES ('Portogallo', 'Faro');
INSERT INTO City (country, name) VALUES ('Portogallo', 'Coimbra');
INSERT INTO City (country, name) VALUES ('Svizzera', 'Zurigo');
INSERT INTO City (country, name) VALUES ('Svizzera', 'Ginevra');
INSERT INTO City (country, name) VALUES ('Svizzera', 'Berna');
INSERT INTO City (country, name) VALUES ('Svizzera', 'Losanna');
INSERT INTO City (country, name) VALUES ('Svezia', 'Stoccolma');
INSERT INTO City (country, name) VALUES ('Svezia', 'Goteborg');
INSERT INTO City (country, name) VALUES ('Svezia', 'Malmö');
INSERT INTO City (country, name) VALUES ('Svezia', 'Uppsala');
INSERT INTO City (country, name) VALUES ('Austria', 'Vienna');
INSERT INTO City (country, name) VALUES ('Austria', 'Salisburgo');
INSERT INTO City (country, name) VALUES ('Austria', 'Innsbruck');
INSERT INTO City (country, name) VALUES ('Austria', 'Graz');

INSERT INTO Itinerary (organizer_username, description) VALUES ('marco', 'Viaggio in Italia');
INSERT INTO Itinerary (organizer_username, description) VALUES ('alessia', 'Tour della Francia');
INSERT INTO Itinerary (organizer_username, description) VALUES ('francesco', 'Esplorazione della Spagna');
INSERT INTO Itinerary (organizer_username, description) VALUES ('chiara', 'Avventura in Germania');
INSERT INTO Itinerary (organizer_username, description) VALUES ('roby', 'Scoperta dell''Austria');

INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (1, 'Roma', '10:00:00', 'Milano', '12:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (1, 'Milano', '14:00:00', 'Napoli', '16:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (2, 'Parigi', '10:00:00', 'Marsiglia', '12:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (2, 'Marsiglia', '14:00:00', 'Lione', '16:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (3, 'Madrid', '10:00:00', 'Barcellona', '12:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (3, 'Barcellona', '14:00:00', 'Siviglia', '16:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (4, 'Berlino', '10:00:00', 'Monaco', '12:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (4, 'Monaco', '14:00:00', 'Amburgo', '16:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (5, 'Vienna', '10:00:00', 'Salisburgo', '12:00:00');
INSERT INTO ItineraryBetweenCities (itinerary_id, departure_city, departure_time, arrival_city, arrival_time) VALUES (5, 'Salisburgo', '14:00:00', 'Innsbruck', '16:00:00');

INSERT INTO Post (author, itinerary_id, title, description, country) VALUES ('marco', 1, 'Esplorando l''Italia', 'Un viaggio attraverso le bellezze d''Italia, visitando Roma, Milano, Napoli.', 'Italia');
INSERT INTO Post (author, itinerary_id, title, description, country) VALUES ('alessia', 2, 'Tour della Francia', 'Un tour affascinante attraverso la Francia, toccando Parigi, Marsiglia, Lione.', 'Francia');
INSERT INTO Post (author, itinerary_id, title, description, country) VALUES ('francesco', 3, 'Scoprendo la Spagna', 'Un''avventura emozionante in Spagna, visitando Madrid, Barcellona, Siviglia.', 'Spagna');
INSERT INTO Post (author, itinerary_id, title, description, country) VALUES ('chiara', 4, 'Avventura in Germania', 'Esplorazione delle meraviglie della Germania, attraverso Berlino, Monaco, Amburgo.', 'Germania');
INSERT INTO Post (author, itinerary_id, title, description, country) VALUES ('roby', 5, 'Viaggio in Austria', 'Scoperta dell''Austria con un itinerario che include Vienna, Salisburgo, Innsbruck.', 'Austria');

INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, '../img/post/marco_1.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, '../img/post/marco_2.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, '../img/post/marco_3.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, '../img/post/marco_4.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, '../img/post/marco_5.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (1, '../img/post/marco_6.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (2, '../img/post/alessia_1.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (2, '../img/post/alessia_2.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (2, '../img/post/alessia_3.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (2, '../img/post/alessia_4.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (3, '../img/post/francesco_1.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (3, '../img/post/francesco_2.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (3, '../img/post/francesco_3.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (4, '../img/post/chiara_1.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (4, '../img/post/chiara_2.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (4, '../img/post/chiara_3.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (4, '../img/post/chiara_4.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (5, '../img/post/roby_1.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (5, '../img/post/roby_2.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (5, '../img/post/roby_3.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (5, '../img/post/roby_4.jpg');
INSERT INTO PostPhoto (post_id, photo_url) VALUES (5, '../img/post/roby_5.jpg');

INSERT INTO PostLike (post_id, profile_username) VALUES (1, 'a');
INSERT INTO PostLike (post_id, profile_username) VALUES (1, 'marco');
INSERT INTO PostLike (post_id, profile_username) VALUES (2, 'a');
INSERT INTO PostLike (post_id, profile_username) VALUES (2, 'alessia');
INSERT INTO PostLike (post_id, profile_username) VALUES (2, 'francesco');
INSERT INTO PostLike (post_id, profile_username) VALUES (3, 'marco');
INSERT INTO PostLike (post_id, profile_username) VALUES (3, 'alessia');
INSERT INTO PostLike (post_id, profile_username) VALUES (3, 'roby');
INSERT INTO PostLike (post_id, profile_username) VALUES (4, 'a');
INSERT INTO PostLike (post_id, profile_username) VALUES (4, 'marco');
INSERT INTO PostLike (post_id, profile_username) VALUES (4, 'alessia');
INSERT INTO PostLike (post_id, profile_username) VALUES (4, 'francesco');
INSERT INTO PostLike (post_id, profile_username) VALUES (4, 'roby');
INSERT INTO PostLike (post_id, profile_username) VALUES (5, 'a');
INSERT INTO PostLike (post_id, profile_username) VALUES (5, 'francesco');

INSERT INTO PostFavourites (post_id, profile_username) VALUES (1, 'a');
INSERT INTO PostFavourites (post_id, profile_username) VALUES (1, 'alessia');
INSERT INTO PostFavourites (post_id, profile_username) VALUES (2, 'marco');
INSERT INTO PostFavourites (post_id, profile_username) VALUES (3, 'roby');
INSERT INTO PostFavourites (post_id, profile_username) VALUES (4, 'alessia');
INSERT INTO PostFavourites (post_id, profile_username) VALUES (4, 'francesco');
INSERT INTO PostFavourites (post_id, profile_username) VALUES (5, 'a');

INSERT INTO PostComment (post_id, author, comment) VALUES (1, 'alessia', 'Bello!');
INSERT INTO PostComment (post_id, author, comment) VALUES (1, 'francesco', 'Che bello!');
INSERT INTO PostComment (post_id, author, comment) VALUES (2, 'roby', 'Che viaggio stupendo, mi piacerebbe farlo!');
INSERT INTO PostComment (post_id, author, comment) VALUES (2, 'francesco', 'Sono stata a Parigi, è bellissima!');
INSERT INTO PostComment (post_id, author, comment) VALUES (3, 'alessia', 'Che bello, mi piacerebbe andarci!');
INSERT INTO PostComment (post_id, author, comment) VALUES (3, 'marco', 'Wow, che bello!, mi piacerebbe andarci!');
INSERT INTO PostComment (post_id, author, comment) VALUES (4, 'marco', 'Sono stato anche io a Berlino, è bellissima!');
INSERT INTO PostComment (post_id, author, comment) VALUES (4, 'chiara', 'Si, è bellissima!');
INSERT INTO PostComment (post_id, author, comment) VALUES (5, 'alessia', 'Molto particolare Innsbruck, mi piacerebbe andarci!');
INSERT INTO PostComment (post_id, author, comment) VALUES (5, 'roby', 'Si, è molto bella!');
INSERT INTO PostComment (post_id, author, comment) VALUES (5, 'chiara', 'Viaggio incredibile, ci andrò l''anno prossimo!');