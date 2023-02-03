import express, { Request, Response } from "express"
import AuthRouter from "./routes/auth.route"
import RootRouter from "./routes/root.routes"

const app = express()

//app.use("/auth", AuthRouter)
app.use("/api/v1", RootRouter)

app.listen(5000, () => {
    console.log("Server is running on PORT: 5000")
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
