const db = require("../../config/database")

module.exports = {
    create: (data, callback) => {
        let sql = `SELECT * 
           FROM User
           WHERE UserName=?`;

        db.all()
        // Querying all row
        db.all(sql, [15], (err, rows) => {
            if (err) throw err
            if (rows.length > 0) {

                rows.forEach((row) => {
                    console.log(row.RegionName);
                });
            }
        });

        // close the database connection
        db.close((err) => {
            if (err) {
                return console.error(err.message);
            }
            console.log('Database Connection Closed!');
        })
    }



}