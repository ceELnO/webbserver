let app = require("express")();
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
    database: "nodejsdb"
});

const COLUMNS = ["firstname", "lastname", "userId", "passwd"];

app.get("/users", function(req, res) {
    let sql = "SELECT * FROM users"; 
    let condition = createCondition(req.query);
    console.log(sql + condition); 
    
    con.query(sql+condition, function(err, result, fields) {
        res.send(result);
    });
});

let createCondition = function(query) {
    console.log(query);
    let output = " WHERE ";
    for (let key in query) {
        if (COLUMNS.includes(key)) {
            output += `${key}="${query[key]}" OR `;
        }
    }
    if (output.length == 7) {
        return "";
    }
    else {
        return output.substring(0, output.length - 4);
    }
}

app.get("/users/:id", function(req, res) {
    let sql = "SELECT * FROM users WHERE userId=" + req.params.id;
    console.log(sql);
    con.query(sql, function(err, result, fields) {
        if (result.length > 0) {
            res.send(result);
        }
        else {
            res.sendStatus(404);
        }
    });
});