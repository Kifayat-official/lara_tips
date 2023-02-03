import { Request, Response, Router } from "express"

const AuthRouter = Router()

AuthRouter.post("/sign-up", (req: Request, res: Response) => {
    res.send("User Registeration Route!")
})

AuthRouter.get("/sign-in", (req: Request, res: Response) => {
    res.send("User Login Route!")
})

export default AuthRouter