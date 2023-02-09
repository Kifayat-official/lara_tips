import { Request, Response, Router } from "express"
import { UserEntityRequestPayload } from "../user/user.request"
import AuthService from "./auth.service"


const AuthRouter = Router()

AuthRouter.post("/sign-in", async (req: Request, res: Response) => {
    // res.json(await AuthService.signIn(req.body as UserEntityRequestPayload))
})

AuthRouter.post("/sign-up", async (req: Request, res: Response) => {
    res.json(await AuthService.signUp(req.body as UserEntityRequestPayload))
})

export default AuthRouter