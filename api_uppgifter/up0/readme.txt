dbname: nodejsdb

    create TABLE chatbot (
        input varchar(256),
        output varchar(256)
    )

    insert into chatbot (input, output)
    VALUES("Hej!", "Hej på dig! Jag heter Chatbot. Hur är läget?"), 
    ("Jag mår bra.", "Trevligt att höra! Mina egna kretsar är också fullt funktionella."),
    ("Hej", "Hej Hej")



const express = require("express");
const app = express();
app.listen(3000);
var mysql = require('mysql');

con = mysql.createConnection({
    host: "localhost",    
    user: "root",
    password: "",
    database: "nodejsdb"
});