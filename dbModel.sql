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
  title VARCHAR(255),
  URL VARCHAR(255)
);

INSERT INTO users VALUES(1, 'ex_user', 'p@ssword');
INSERT INTO category VALUES(1, 1, 'basketball');
INSERT INTO category VALUES(2, 1, 'music');
INSERT INTO feed VALUES(1, 1, 'reddit nba', 'http://inline-reddit.com/feed/?subreddit=nba');
INSERT INTO feed VALUES(2, 2, 'reddit jazz', 'http://inline-reddit.com/feed/?subreddit=Jazz');