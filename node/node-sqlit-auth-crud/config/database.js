const sqlite3 = require('sqlite3').verbose()

// open the database
const db = new sqlite3.Database('./assets/db/user_db_email_subscription.db', sqlite3.OPEN_READWRITE, (err) => {
    if (err) {
        console.error(err.message)
    }
    console.log('Connected to the UserDB database.');
})

module.exports = db