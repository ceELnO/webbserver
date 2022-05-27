const express = require("express");
const mysql = require("mysql");
const fs = require("fs");
const app = express();
app.listen(3000);
console.log("Webbservern körs på port 3000.");
con = mysql.createConnection({
    host: "localhost",    
    user: "root",
    password: "",
    database: "nodejsdb"
});

app.get("/table", function(req, res) {
    con.query("SELECT * FROM chatbot", function(err, result, fields) {
        if (err) throw err;
        console.log(result);
        res.send(result);
    });
});

app.get("/", function(req, res) {
    res.sendFile(__dirname + "/template.html");
});

app.use(express.urlencoded({extended: true}));
app.post("/processForm", function(req, res) {
    con.query(`SELECT * FROM chatbot WHERE input='${req.body.input}'`, function(err, result, fields) {
        if (err) throw err;
        fs.readFile("template.html", "utf-8", function(err, data) {
            if (err) throw err;
            let htmlArray = data.split("<!--NODE-->");
            let output = htmlArray[0];
            if (result.length == 0) {
                output += `Jag förstår inte detta: "${req.body.input}"`;
            }
            else {
                output += `<p>${result[0].output}.</p>`;
            }
            res.send(output);
        });
    });
}); 