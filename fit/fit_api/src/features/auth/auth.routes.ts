import { Request, Response, Router } from "express"
import { IUserRequestPayload } from "../../components/user/user.request"
import AuthService from "./auth.service"


const AuthRouter = Router()

AuthRouter.post("/signin", async (req: Request, res: Response) => {
    res.json(await AuthService.signIn(req.body as {username, password}))
})

AuthRouter.post("/signup", async (req: Request, res: Response) => {
    res.json(await AuthService.signUp(req.body as IUserRequestPayload))
})

export default AuthRouter