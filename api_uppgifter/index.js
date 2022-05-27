let express = require("express");
let app = express();
app.listen(3000);
console.log("Servern körs på port 3000");
console.log("--------------------------------------------- started ---------------------------------------------")

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
function isValidError422(errormessage, res){
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

// -------------------------------- jsonwebtoken --------------------------------
const jwt = require('jsonwebtoken');
const req = require("express/lib/request");
const secret_key = "TheSuperSecretKey";

// genererar token
function create_token(givenId, givenFirstName, givenLastName){
    return jwt.sign({id: givenId, givenFirstName: givenFirstName, givenLastName: givenLastName}, secret_key, {expiresIn: 2*60*60});
}

// kollar om tokensaken stämmer
function verify_token(givenToken){
    if(!givenToken){
        return false;
    }
    try{
        jwt.verify(givenToken, secret_key);
    }
    catch(err){
        return false;
    }
    return true;
}

// används i isValid-funktionerna för att bekräfta att användaren faktiskt har en token i sin json request
function isTokenHere(givenToken){
    if (typeof givenToken == 'undeifned'){
        return false;
    }
    else{
        return true;
    }
}

// -------------------------------- -------------------------------- main  -------------------------------- --------------------------------

// -------------------------------- post, skapa konto --------------------------------

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

// -------------------------------- put, ändrar data --------------------------------

app.put('/users/:id', function(req, res) {
    //data ligger i req.body. Kontrollera att det är korrekt.
    if (isValidUserData2(req.body)) {
        if (verify_token(req.body.token) == true){
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
                    res.status(500).send("error in contacting the server!");
                    throw err;
                }
                res.status(200).send(); // OK
            });
        }
        else{
            isValidError422("a token is required", res);
        }

    }
    else {
        isValidError422("Måste innehålla firstname eller lastname!", res);
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

    if (isTokenHere(body.token) == false){
        isValidError422("token is required, login and one will be generated for you", res)
    }

    // if no error --> conntinue
    console.log("passed 'isvalid'");
    return body && (body.firstname || body.lastname);
};

// -------------------------------- login, logga in --------------------------------

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
                userId: result[0].userId,
                token: create_token(result[0].userId, result[0].firstname, result[0].lastname) // token som användaren behöver
            });
        }
        else {
            res.sendStatus(401);
        }
    });
});

// -------------------------------- get, visa användare --------------------------------
app.get('/getusers', function(req, res){
    if (isValidUserData3(res, req.body.token)){
        let con2 = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "nodejsdb"
        });

        con2.connect(function(err) {
            if (err) throw err;
            con.query("SELECT userId, firstName, lastName FROM realusers", function (err, result, fields) {
              if (err) throw err;
              console.log(result);
              res.send(result);
            });
          });
    }
});

// isvalid
function isValidUserData3(res, givenToken){
    if (verify_token(givenToken) == false){
        isValidError422("a valid token is required", res);
        return false;
    }
    else {
        return true;
    }
}


// -------------------------------- get, me --------------------------------

app.get('/getuserme', function(req, res){
    if (isValidUserData4(res, req.body.token, req.body.userId)){
        let con3 = mysql.createConnection({
            host: "localhost",
            user: "root",
            password: "",
            database: "nodejsdb"
        });

        con3.connect(function(err) {
            if (err) throw err;
            con.query("SELECT userId, firstName, lastName FROM realusers WHERE userId = '" + req.body.userId + "';", function (err, result, fields) {
              if (err) throw err;
              console.log(result);
              res.send(result);
            });
          });
    }
});

// isvalid
function isValidUserData4(res, givenToken, givenUserId){
    if (verify_token(givenToken) == false){
        isValidError422("a valid token is required", res);
        return false;
    }
    else if (typeof givenUserId == "undefined"){
        isValidError422("userId is required", res);
        return false;
    }
    else{
        return true;
    }
}