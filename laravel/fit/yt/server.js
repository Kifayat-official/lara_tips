const express = require('express')
const { dirname } = require('path')
const path = require('path')
const app = express()
const { logger } = require('./middleware/logger')
const errorHandler = require('./middleware/errorHandler')
const cors = require('cors')
const corsOptions = require('./config/corsOptions')
const PORT = process.env.PORT || 3500

app.use(logger)
app.use(cors(corsOptions))
app.use(express.json())
app.use('/', express.static(path.join(__dirname, 'public')))

app.use(errorHandler)
app.listen(PORT, () => console.log(`Server running on port ${PORT}`))
