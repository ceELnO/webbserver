let app = require("express")();
app.listen(3000);
console.log("Servern körs på port 3000");

// ----------------------------- stock-html -----------------------------

app.get("/", function(req, res) {
    res.sendFile(__dirname + "/dokumentation.html");
});

// ----------------------------- test -----------------------------

app.get("/wat", function(req, res){
    res.send("wat")
})

app.get("/wat/:para", function(req, res){
    console.log(req.params);
    res.send(req.params)
})

// ----------------------------- eget api -----------------------------

let apitest = [
    {
        para1: "Q",
        para2: "W",
        para3: "E"
    },
    {
        para1: "R",
        para2: "T",
        para3: "Y"
    },
    {
        para1: "U",
        para2: "I",
        para3: "O"
    }
]


app.get("/test", function(req, res) {
    //res.send(users);
    console.log(req.query);
    if (Object.keys(req.query).length == 0) {
        res.send(apitest);
        return;
    }
    let output = [];
    for (let key in req.query) {
        for (let i = 0; i < apitest.length; i++) {
            if (apitest[i][key] == req.query[key]) {
                output.push(apitest[i]);
            }
        }
    }
    res.send(output);
});

app.get("/test/:para1", function(req, res) {
    console.log(req.params);
    for (let i = 0; i < apitest.length; i++) {
        if (apitest[i].para1 == req.params.para1) {
            res.send(apitest[i]);
            return;
        }
    }
    res.sendStatus(404);
});
