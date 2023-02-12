import { Request, Response, Router } from "express"
import { User } from "../../database/entities/user.entity"
import { IUserRequestPayload } from "./user.request"
import UserService from "./user.service"

const UserRouter = Router()

UserRouter.get("/all", async (req: Request, res: Response) => {
    res.send(await UserService.all())
})

UserRouter.post("/create", async (req: Request, res: Response) => {
    res.json(await UserService.create(req.body as User))
})

UserRouter.get("/:id", async (req: Request, res: Response) => {
    res.json(await UserService.getUserById(Number(req.params.id)))
})

UserRouter.put("/update", async (req: Request, res: Response) => {
    res.send(await UserService.update(req.body as IUserRequestPayload))
})

UserRouter.delete("/:id", async (req: Request, res: Response) => {
    res.send(await UserService.delete(Number(req.params.id)))
})

export default UserRouter