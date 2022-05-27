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
function isValidError422 (errormessage){
    console.log(errormessage);
    res.status(422).send(errormessage);
}

// -------------------------------- main --------------------------------

// -------------------------------- post --------------------------------

app.post("/users", function(req, res) {
//data ligger i req.body. Kontrollera att det är korrekt.
    if (isValidUserData1(req.body)){
        let sql = `INSERT INTO realusers (userId, firstname, lastname, passwd) 
        VALUES (
        '${req.body.userId}',
        '${req.body.firstname}',
        '${req.body.lastname}',
        '${req.body.passwd}');
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
function isValidUserData1(body){
    // debug:
    // console.log("Firstname: " + body.firstname + "; Lastname: " + body.lastname + "; Password: " + body.passwd + "; userId: " + body.userId)

    if (typeof body.firstname !== 'undefined' && typeof body.firstname !== 'string') {
        isValidError422("wrong datatype of firstname, lastname or passwd");
        return false;
    }
    if (typeof body.lastname !== 'undefined' && typeof body.lastname !== 'string'){
        isValidError422("wrong datatype of firstname, lastname or passwd");
        return false;
    }
    if (typeof body.passwd !== 'undefined' && typeof body.passwd !== 'string'){
        isValidError422("wrong datatype of firstname, lastname or passwd");
        return false;
    }

    let text = body.passwd;
    let passwordlength = text.length;
    if (passwordlength < 4){
        isValidError422("passwd is not < 4 charackters");
        return false;
    }
    // if [body.userId is not a string --> error]
    if (typeof body.userId == 'string'){
        str = body.userId;
        str1 = body.firstname.substring(0, 2);
        str2 = body.lastname.substring(0, 2);
        strfak = str1.concat(str2)
        if (str !== strfak){
            isValidError422("wrong format on userId")
            return false;
        }
    }
    else {
        isValidError422("userId uses the wrong datatype or format");
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
    else if (body.lastname == ''){
        body.firstname == null
    }

    // if no error --> conntinue
    console.log("passed 'isvalid'");
    return body && (body.firstname || body.lastname);
};