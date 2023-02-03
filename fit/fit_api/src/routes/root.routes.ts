import { Router } from "express"
import AuthRouter from "./auth.route"

const RootRouter = Router()

RootRouter.use("/auth", AuthRouter)

export default RootRouter