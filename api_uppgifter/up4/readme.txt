CREATE TABLE realusers (
    userId varchar(256),
    firstname varchar(256),
    lastname varchar(256),
    passwd varchar(256),
    PRIMARY KEY (userId)
)

INSERT INTO realusers (userId, firstname, lastname, passwd) VALUES("kedo", "kej", "dnso", "nopassword")