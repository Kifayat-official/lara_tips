import { Router } from "express"
import UserRouter from "./components/user/user.routes"
import AuthRouter from "./features/auth/auth.routes"

const RootRouter = Router()

RootRouter.use("/user", UserRouter)
RootRouter.use("/auth", AuthRouter)

export default RootRouter