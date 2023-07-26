const express = require('express')
const app = express()

app.get("/api", (req, res) => {
    res.json({
        sucess: 1,
        message: "Working"
    })
})

app.listen(3000, () => {
    console.log("Server up and Running")
})