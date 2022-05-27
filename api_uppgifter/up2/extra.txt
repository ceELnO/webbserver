Database: nodejsdb

CREATE TABLE users(
    userId int NOT NULL AUTO_INCREMENT,
    firstname varchar(256),
    lastname varchar(256),
    passwd varchar(256),
    PRIMARY KEY (userId)
)

Exempel på värden:
insert into users (firstname, lastname, passwd) VALUES("ha", "ha", "no"), ("fah", "ca", "heh"), ("gg", "jj", "gg")