import { Router } from "express"
import UserRouter from "./user.route"

const RootRouter = Router()

RootRouter.use("/user", UserRouter)

export default RootRouter