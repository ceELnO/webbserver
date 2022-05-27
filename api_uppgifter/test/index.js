/*
mer info:
    https://github.com/holgros/21-webbserv/blob/main/nodejs/v3/index.js

*/



// inportera express och starta en server
const express = require("express");
const app = express();

// port: localhost:3000
app.listen(3000);

// gör vissa saker enklare, statisk också
app.use(express.static("publik"));

// visa en html fil för anväändaren
app.get("/", function(req, res) {
   //res.send("Hejsan!");
   res.sendFile(__dirname + "/index.html");
});