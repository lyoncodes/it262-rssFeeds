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
INSERT INTO category VALUES(1, 1, 'finance');
INSERT INTO category VALUES(2, 1, 'technology');
INSERT INTO category VALUES(3, 1, 'sports');

INSERT INTO feed VALUES(1, 1, 'cryptocurrency', 'https://news.google.com/rss/search?q=crypto+currency&hl=en-US&gl=US&ceid=US:en');
INSERT INTO feed VALUES(2, 1, 'exchange rates', 'https://news.google.com/rss/search?q=exchange+rates&hl=en-US&gl=US&ceid=US:en');
INSERT INTO feed VALUES(3, 1, 'stock market', 'https://news.google.com/rss/search?q=stock+market&hl=en-US&gl=US&ceid=US:en');

INSERT INTO feed VALUES(4, 2, 'artificial intelligence', 'https://news.google.com/rss/search?q=artificial+intelligence&hl=en-US&gl=US&ceid=US:en');
INSERT INTO feed VALUES(5, 2, 'cybersecurity', 'https://news.google.com/rss/search?q=cyber+security&hl=en-US&gl=US&ceid=US:en');
INSERT INTO feed VALUES(6, 2, 'robotics', 'https://news.google.com/rss/search?q=robotics&hl=en-US&gl=US&ceid=US:en');

INSERT INTO feed VALUES(7, 3, 'nfl', 'https://news.google.com/rss/search?q=national+football+league&hl=en-US&gl=US&ceid=US:en');
INSERT INTO feed VALUES(8, 3, 'nba', 'https://news.google.com/rss/search?q=national+basketball+association&hl=en-US&gl=US&ceid=US:en');
INSERT INTO feed VALUES(9, 3, 'mlb', 'https://news.google.com/rss/search?q=major+league+baseball&hl=en-US&gl=US&ceid=US:en');

