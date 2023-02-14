import { Router } from "express"
import AuthController from "./auth.controller"
import AuthService from "./auth.controller"


const AuthRouter = Router()

AuthRouter.post("/signin", AuthController.signIn)
AuthRouter.post("/signup", AuthService.signUp)

export default AuthRouter