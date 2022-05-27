let express = require("express");
let app = express();
app.listen(3000);
console.log("Servern körs på port 3000");

app.get("/", function(req, res) {
    res.sendFile(__dirname + "/dokumentation.html");
});

const mysql = require("mysql");
con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "nodejsdb",
    multipleStatements: true
});

app.use(express.json());

app.post("/postrequest", function(req, res) {
    if (!req.body.userId) {
        res.status(400).send("userId required!");
        return;
    }
    let fields = ["firstname", "lastname", "userId", "passwd"];
    for (let key in req.body) {
        if (!fields.includes(key)) {
            res.status(400).send("Unknown field: " + key);
            return;
        }
    }
    let sql = `INSERT INTO users (firstname, lastname, userId, passwd)
    VALUES ('${req.body.firstname}', 
    '${req.body.lastname}',
    '${req.body.userId}',
    '${req.body.passwd}');
    SELECT LAST_INSERT_ID();`;
    console.log(sql);
    
    con.query(sql, function(err, result, fields) {
        if (err) throw err;
        console.log(result);
        let output = {
            id: result[0].insertId,
            firstname: req.body.firstname,
            lastname: req.body.lastname,
            userId: req.body.userId,
            passwd: req.body.passwd
        }
        res.send(output);
    });
});