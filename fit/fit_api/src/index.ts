import express from "express"
import MysqlFitDbDataSource from "./database/db.config"
import RootRouter from "./root.routes"

const app = express()

app.use(express.json())
app.use("/api/v1", RootRouter)

MysqlFitDbDataSource.initialize().then(() => {
    console.log("MySql Db Initialized!")

    app.listen(5000, () => {
        console.log("Server is running on PORT: 5000")
    })
}).catch(() => {
    console.log("Error occured while connecting to database.")
})



//import { MysqlFitDbDataSource, MySqlTestDbDataSource } from "./data-source"
// import { TestUser } from "./entity/TestUser"


// MysqlFitDbDataSource.initialize().then(async () => {

//     console.log("Inserting a new user into the database...")
//     const user = new TestUser()
//     user.firstName = "Timber"
//     user.lastName = "Saw"
//     //user.age = 25
//     await MysqlFitDbDataSource.manager.save(user)
//     console.log("Saved a New user with id: " + user.id)

//     console.log("Loading users from the database...")
//     const users = await MysqlFitDbDataSource.manager.find(TestUser)
//     console.log("Loaded users: ", users)

//     console.log("Here you can setup and run express / fastify / any other framework.")

// }).catch(error => console.log(error))

//MySqlTestDbDataSource.initialize()
