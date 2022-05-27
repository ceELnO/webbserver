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


// -------------------------------- misc --------------------------------

// vill ta med felmeddelandet i konsolen
function isValidError422 (errormessage, res){
    console.log(errormessage);
    res.status(422).send(errormessage);
}

// Hash
// Funktion som tar någon form av indata, t.ex. ett lösenord i klartext; hashar det och returnerar hashvärdet som en sträng.
app.use(express.json());
const crypto = require("crypto"); //INSTALLERA MED "npm install crypto" I KOMMANDOTOLKEN
function hash(data) {
    const hash = crypto.createHash("sha256");
    hash.update(data);
    return hash.digest("hex");
}

// -------------------------------- -------------------------------- main  -------------------------------- --------------------------------

// -------------------------------- post --------------------------------

app.post("/users", function(req, res) {
//data ligger i req.body. Kontrollera att det är korrekt.
    if (isValidUserData1(req.body, res)){
        let sql = `INSERT INTO realusers (userId, firstname, lastname, passwd) 
        VALUES (
        '${req.body.userId}',
        '${req.body.firstname}',
        '${req.body.lastname}',
        '${hash(req.body.passwd)}');
        SELECT LAST_INSERT_ID();`;  // behövs
        console.log(sql);

        con.query(sql, function(err, result, fields){
            if (err) {
                console.log(err);
                res.status(500).send("Fel i databasanropet!");
                throw err;
            }
            // hantera retur av data
            console.log(result);
            let output = {
                id: result[0].insertId,
                firstname: req.body.firstname,
                lastname: req.body.lastname,
                userId: req.body.userId,
                passwd: req.body.passwd
            };
            res.json(output);
        });
    }
});

// funktion för att kontrollera att användardata finns
function isValidUserData1(body, res){
    // debug:
    // console.log("Firstname: " + body.firstname + "; Lastname: " + body.lastname + "; Password: " + body.passwd + "; userId: " + body.userId)

    if (typeof body.firstname !== 'undefined' && typeof body.firstname !== 'string') {
        isValidError422("wrong datatype of firstname, lastname or passwd", res);
        return false;
    }
    else if (typeof body.lastname !== 'undefined' && typeof body.lastname !== 'string'){
        isValidError422("wrong datatype of firstname, lastname or passwd", res);
        return false;
    }
    else if (typeof body.passwd !== 'undefined' && typeof body.passwd !== 'string'){
        isValidError422("wrong datatype of firstname, lastname or passwd", res);
        return false;
    }
    else if (typeof body.userId !== 'undefined' && typeof body.userId !== 'string'){
        isValidError422("userId is required", res);
        return false;
    }

    let text = body.passwd;
    let passwordlength = text.length;
    if (passwordlength < 4){
        isValidError422("passwd is not < 4 charackters", res);
        return false;
    }
    // if [body.userId is not a string --> error]
    else if (typeof body.userId == 'string'){
        str = body.userId;
        str1 = body.firstname.substring(0, 2);
        str2 = body.lastname.substring(0, 2);
        strfak = str1.concat(str2)
        if (str !== strfak){
            isValidError422("wrong format on userId", res)
            return false;
        }
    }
    else {
        isValidError422("userId uses the wrong datatype or format", res);
        return false;
    }
    // if no error --> conntinue
    console.log("passed 'isvalid'")
    return body && body.userId;
};

// -------------------------------- put --------------------------------

app.put('/users/:id', function(req, res) {
    //data ligger i req.body. Kontrollera att det är korrekt.
    if (isValidUserData2(req.body)) {
        //skriv till databas
        //kod här för att hantera anrop...
        let sql = `UPDATE realusers `;
        if (req.body.firstname && req.body.lastname) {  // båda fälten finns med
            sql += `SET firstname = '${req.body.firstname}', lastname = '${req.body.lastname}'`;
        }
        else {
            if (req.body.firstname) {  // endast firstname finns med
                sql += `SET firstname = '${req.body.firstname}'`;
            }
            else {  // endast lastname finns med
                sql += `SET lastname = '${req.body.lastname}'`;
            }
        }

        if (typeof req.body.passwd !== 'undefined'){
            if (typeof req.body.passwd == 'string'){
                sql += `, SET passwd = '${hash(req.body.passwd)}'`;
            }
            else {
                isValidError422("passwd must be in string format", res)
            }
        }

  	    sql += ` WHERE userId = '${req.params.id}'`;
        console.log(sql);

        con.query(sql, function(err, result, fields) {
            if (err) {
                console.log(err);
                res.status(500).send("Fel i databasanropet!");
                throw err;
            }
            res.status(200).send(); // OK
        });
    }
    else {
        res.status(422).send("Måste innehålla firstname eller lastname!");
    }
});

// put:s isvalid 
function isValidUserData2(body){
    if (body.firstname == ''){
        body.firstname == null
    }
    if (body.lastname == ''){
        body.firstname == null
    }

    // if no error --> conntinue
    console.log("passed 'isvalid'");
    return body && (body.firstname || body.lastname);
};

// -------------------------------- login --------------------------------

app.post("/login", function(req, res) {
    //kod här för att hantera anrop…
    let sql = `SELECT * FROM realusers WHERE userId='${req.body.userId}'`

    con.query(sql, function(err, result, fields) {
        if (err) throw err;
        let passwordHash = hash(req.body.passwd);
        console.log(passwordHash);
        console.log(result[0].passwd);
        if (result[0].passwd == passwordHash) {
            res.send({  // OBS: returnera inte passwd!
                firstname: result[0].firstname, 
                lastname: result[0].lastname,
                userId: result[0].userId
            });
        }
        else {
            res.sendStatus(401);
        }
    });
});