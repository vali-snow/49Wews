CREATE TABLE Feeds (
    FeedID int NOT NULL AUTO_INCREMENT,
    Name varchar(255) NOT NULL,
    Description varchar(255) NOT NULL,
    Link varchar(255) NOT NULL,
    PRIMARY KEY (FeedID)
);

CREATE TABLE Readers (
    ReaderID int NOT NULL AUTO_INCREMENT,
    Username varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Password varchar(255) NOT NULL,
    SessionID int NOT NULL,
    PRIMARY KEY (ReaderID),
    UNIQUE (Username),
    UNIQUE (Email)
);

CREATE TABLE Subscriptions (
    SubscriptionID int NOT NULL AUTO_INCREMENT,
    FeedID int NOT NULL,
    ReaderID int NOT NULL,
    PRIMARY KEY (SubscriptionID),
    FOREIGN KEY (FeedID) REFERENCES Feeds(FeedID),
    FOREIGN KEY (ReaderID) REFERENCES Readers(ReaderID)
);

INSERT INTO Readers (Username, Email, Password) VALUES
('admin','admin@dv.feed','admin'),
('valen','valentin@sarghi.com','valen'),
('dorina','dorina@cabac.com','dorina');

REVOKE ALL PRIVILEGES ON *.* FROM 'readerBee'@'localhost';
GRANT ALL PRIVILEGES ON *.* TO 'readerBee'@'localhost' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;