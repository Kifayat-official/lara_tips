import express from "express"
import MysqlFitDbDataSource from "./database/db.config"
import { createNewConnection } from "./database/db2.config"
import { authMiddleware } from "./features/auth/auth.middleware"
import RootRouter from "./root.routes"

const app = express()

app.use(express.json())
//app.use(authMiddleware)
app.use("/api/v1", RootRouter)

let dbConnection = null
let dbInitialize = null
const connectToDb = async (dbType: string) => {
    try {
        dbConnection = await createNewConnection(dbType)
        dbInitialize = dbConnection.initialize()
        console.log("Db connection established!")
        app.listen(5000, () => {
            console.log("Server is running on PORT: 5000")
        })
    }
    catch (error) {
        console.log("Error occured while connecting to database.", error)
    }
}
connectToDb("remote");

export default dbConnection
// MysqlFitDbDataSource.initialize().then(() => {
//     console.log("MySql Db Initialized!")

//     app.listen(5000, () => {
//         console.log("Server is running on PORT: 5000")
//     })
// }).catch(() => {
//     console.log("Error occured while connecting to database.")
// })

