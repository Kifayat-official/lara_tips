import { Request, Response, Router } from "express"
import { UserEntityRequestPayload } from "../payload/request/user.payload"
import UserService from "../services/user.service"

const UserRouter = Router()

UserRouter.post("/create", async (req: Request, res: Response) => {
    res.json(await UserService.create(req.body as UserEntityRequestPayload))
})

UserRouter.get("/:id", async (req: Request, res: Response) => {
    res.json(await UserService.get(Number(req.params.id)))
})

UserRouter.get("/all", async (req: Request, res: Response) => {
    res.send(await UserService.all())
})

UserRouter.put("/update", async (req: Request, res: Response) => {
    res.send(await UserService.update(req.body as UserEntityRequestPayload))
})

UserRouter.delete("/delete/:id", async (req: Request, res: Response) => {
    res.send(await UserService.delete(Number(req.params.id)))
})

export default UserRouter