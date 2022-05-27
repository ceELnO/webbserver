let express = require("express");
let app = express();
app.listen(3000);
console.log("Servern körs på port 3000");

app.get("/", function(req, res){
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

app.post('/users', function(req, res){
    //data ligger i req.body. Kontrollera att det är korrekt.
    if (isValidUserData(req.body)){
        let sql = `INSERT INTO users (userId, firstname, lastname, passwd) 
        VALUES ('${req.body.userId}',
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
    else{
        res.status(422).send("userId required!");
    }
});

// funktion för att kontrollera att användardata finns
function isValidUserData(body){
    console.log(body.firstname + ";" + body.lastname + ";" + body.passwd + ";" + body.userId)

    if (!typeof body.firstname == 'string' && !typeof body.lastname == 'string' && !typeof body.passwd == 'string'){
        console.log("wrong datatype of firstname, lastname or passwd");
        return false;
    }
    else{ console.log("passed_1")}
    let text = body.passwd;
    let passwordlength = text.length;
    if (passwordlength < 4){
        console.log("passwd is not < 4 charackters");
        return false;
    }
    else{ console.log("passed_2")}
    if (typeof body.userId == 'string'){
        str = body.userId;
        str1 = body.firstname.substring(0, 2);
        str2 = body.lastname.substring(0, 2);
        strfak = str1.concat(str2)
        if (str == strfak){
            // pass
        }
        else{
            console.log("wrong format on userId")
            return false;
        }
    }
    else {
        console.log("userId uses the wrong datatype or format");
        return false;
    }
    // if no error --> conntinue
    console.log("passed isvalid")
    return body && body.userId;
}