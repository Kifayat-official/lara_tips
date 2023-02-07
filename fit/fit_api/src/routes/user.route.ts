import { Request, Response, Router } from "express"
import { UserEntityRequestPayload } from "../payload/request/user.payload"
import UserService from "../services/user.service"

const UserRouter = Router()

UserRouter.post("/create", (req: Request, res: Response) => {
    res.json(UserService.createUser(req.body as UserEntityRequestPayload))
})

UserRouter.get("/:id", (req: Request, res: Response) => {
    res.json(UserService.getUser(Number(req.params.id)))
})

UserRouter.get("/all", async (req: Request, res: Response) => {
    res.send(await UserService.getAll())
})

UserRouter.put("/update", (req: Request, res: Response) => {
    res.send(UserService.updateUser(req.body as UserEntityRequestPayload))
})

UserRouter.delete("/delete/:id", (req: Request, res: Response) => {
    res.send(UserService.deleteUser(Number(req.params.id)))
})

export default UserRouter