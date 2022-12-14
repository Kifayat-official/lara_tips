const express = require('express')
const app = express()


require('dotenv').config()
var sqlite3 = require('sqlite3').verbose()
const cors = require('cors')
const jwt = require('jsonwebtoken')
const bcrypt = require('bcryptjs')
//const DBSOURCE = 'db/UserDB.db'
const DBSOURCE = "db/UsersDb.db";
const auth = require('./middleware')
const port = 3004

// parse application/x-www-form-urlencoded
app.use(express.urlencoded({ extended: true }))
app.use(express.json())
app.use(cors({ origin: 'http://localhost:3000' }))


let db = new sqlite3.Database(DBSOURCE, (err) => {
    if (err) {
        console.log(err.message)
        throw err
    }
    else {
        var salt = bcrypt.genSaltSync(10)
        db.run(`CREATE TABLE IF NOT EXISTS Users (
            Id INTEGER PRIMARY KEY AUTOINCREMENT,
            RegionCode TEXT,
            RegionName TEXT,
            Username TEXT NOT NULL UNIQUE, 
            Email TEXT, 
            Password TEXT,             
            Salt TEXT,    
            Token TEXT,
            DateLoggedIn DATE,
            DateCreated DATE)`,
            (err) => {
                if (err) {
                    console.log(err.message)
                    throw err
                } else {
                    // var insert = 'INSERT INTO Users (RegionCode, RegionName, Username, Email, Password, Salt, DateCreated) VALUES (?,?,?,?,?,?,?)'
                    // db.run(insert, ['15', 'MEPCO', 'mepco user0', 'mepco-user@gmail.com', bcrypt.hashSync('user@15', salt), salt, Date('now')])
                    // db.run(insert, ['15', 'MEPCO', 'mepco user1', 'mepco-user1@gmail.com', bcrypt.hashSync('user@15', salt), salt, Date('now')])
                    // db.run(insert, ['15', 'MEPCO', 'mepco user2', 'mepco-user2@gmail.com', bcrypt.hashSync('user@15', salt), salt, Date('now')])
                }
            }
        )
    }


})

app.post('/api/login', async (res, req) => {
    try {
        console.log(req)
        const { Username, Password } = req.body
        if (!(Username && Password)) {
            res.status(400).send('All inputs are required')
        }

        let user = []
        var sql = "SELECT * FROM Users Where Username = ?"
        db.all(sql, Username, (err, rows) => {
            if (err) {
                res.status(400).json({ "error": err.message })
                return
            }
            rows.forEach((row) => {
                user.push(row)
            })

            PHash = bcrypt.hashSync(Password, user[0].Salt)

            if (PHash == user[0].Password) {
                const token = jwt.sign(
                    { user_id: user[0].Id, username: user[0].Username },
                    process.env.TOKEN_KEY,
                    { expiresIn: "1h" }
                )
                user[0].Token = token
            } else {
                return res.status(400).send('No Match')
            }

            return res.status(200).send(user)
        })
    } catch (err) {
        console.log(err)
    }
})

app.listen(port, () => console.log(`API listening on port ${port}!`));
