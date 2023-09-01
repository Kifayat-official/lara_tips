import { Router } from "express"
import AuthController from "./auth.controller"


const AuthRouter = Router()

AuthRouter.post("/signin", AuthController.signIn)
AuthRouter.post("/signup", AuthController.signUp)

export default AuthRouter