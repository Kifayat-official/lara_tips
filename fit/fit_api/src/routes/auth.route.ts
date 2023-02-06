import { Request, Response, Router } from "express"
import { RegisterUserRequestPayload } from "../payload/request/auth.payload"
import AuthService from "../services/auth.service"

const AuthRouter = Router()

AuthRouter.post("/registration", (req: Request, res: Response) => {
    res.json(AuthService.registerUser(req.body as RegisterUserRequestPayload))
})

AuthRouter.get("/login", (req: Request, res: Response) => {
    res.send("User Login Route!")
})

export default AuthRouter