DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS feed;

CREATE TABLE users(
  userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(55) UNIQUE,
  userpassword VARCHAR(255)
);
CREATE TABLE category(
  categoryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userID INT NOT NULL REFERENCES users(userID),
  title VARCHAR(55)
);
CREATE TABLE feed(
  feedID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  categoryID INT REFERENCES category(categoryID),
  name VARCHAR(255)
);

INSERT INTO users VALUES(1, 'ex_user', 'p@ssword');
INSERT INTO category VALUES(1, 1, 'finance');
INSERT INTO category VALUES(2, 1, 'technology');
INSERT INTO category VALUES(3, 1, 'sports');

INSERT INTO feed VALUES(1, 1, 'cryptocurrency');
INSERT INTO feed VALUES(2, 1, 'exchange rates');
INSERT INTO feed VALUES(3, 1, 'stock market');

INSERT INTO feed VALUES(4, 2, 'artificial intelligence');
INSERT INTO feed VALUES(5, 2, 'cybersecurity');
INSERT INTO feed VALUES(6, 2, 'robotics');

INSERT INTO feed VALUES(7, 3, 'nfl');
INSERT INTO feed VALUES(8, 3, 'nba');
INSERT INTO feed VALUES(9, 3, 'mlb');

