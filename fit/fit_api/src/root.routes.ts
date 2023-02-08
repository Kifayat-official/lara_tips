import { Router } from "express"
import UserRouter from "./components/user/user.routes"

const RootRouter = Router()

RootRouter.use("/user", UserRouter)

export default RootRouter