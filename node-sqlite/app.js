const sqlite3 = require('sqlite3').verbose();

// open the database
let db = new sqlite3.Database('./db/UserDB.db', sqlite3.OPEN_READWRITE, (err) => {
    if (err) {
        console.error(err.message);
    }
    console.log('Connected to the UserDB database.');
})

let sql = `SELECT * 
           FROM User
           WHERE UserName=?`;

// Querying all row
db.all(sql, [15], (err, rows) => {
    if (err) throw err
    rows.forEach((row) => {
        console.log(row.RegionName);
    });
});

// If the result set is empty, the callback is never called. 
// In case there is an error, the err parameter contains detailed information.
db.each(sql, [15], (err, row) => {
    if (err) throw err
    console.log(`${row.FirstName} ${row.LastName} - ${row.Email}`);
});

// Query the first row in the result set (result set contains zero or one row)
db.get(sql, [15], (err, row) => {
    if (err) throw err;
    if (row !== undefined) console.log(row.UserName)
})

// db.serialize(() => {
//     db.each(`SELECT PlaylistId as id,
//                   Name as name
//            FROM playlists`, (err, row) => {
//         if (err) {
//             console.error(err.message);
//         }
//         console.log(row.id + "\t" + row.name);
//     })
// })

// close the database connection
db.close((err) => {
    if (err) {
        return console.error(err.message);
    }
    console.log('Close the database connection.');
})