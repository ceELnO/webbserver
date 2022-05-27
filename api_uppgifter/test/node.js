/* Extra:
var http = require('http');

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  res.end('Hello World!');
}).listen(8080);
*/

const express = require("express");
var mysql = require('mysql');
const app = express();
app.listen(3000);
console.log("Servern körs på port 3000.");

app.get("/", function(req, res) {   // lyssna på GET-anrop på routen "/", dvs. serverns rotadress
    //res.send("Hejsan!");            // skriv ett enkelt textmeddelande till klienten
    res.sendFile(__dirname + "/form.html");   // visa en webbsida för klienten
 });

// FORMULÄRHANTERING
app.get("/form", function(req, res) {
    res.sendFile(__dirname + "/form.html");
});


// hit kommer data när post-formuläret skickas
app.use(express.urlencoded({extended: true}));      // behövs för att processa body i req-objektet
app.post("/post-route", function(req, res) {        // skapa route, OBS: post istället för get
    res.write("Tog emot data med POST: ");
    // OBS: för POST använder vi attributet "body", men för GET använder vi attributet "query"
    console.log(req.body);
    // gör samma sak med req.body som vi gjorde ovan med req.query
        //let summa = Number(req.body.tal1) + Number(req.body.tal2);
        //let output = `${req.body.tal1}+${req.body.tal2}=${summa}`;

    let output = "${req.body.userinput}";

    res.write(output);
    res.send();
});














/*
    con = mysql.createConnection({
        host: "localhost",    
        user: "root",
        password: "",
        database: "nodejsdb"
    });
      
      con.connect(function(err) {
        if (err){
            throw err;
        }
        con.query("SELECT * FROM chatbot WHERE input = '${output}'", function (err, result) {
            if (err){
                throw err;
            }
            console.log(result);
            res.write(result)
            res.send();
        });
      });
*/

