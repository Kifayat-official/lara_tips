import { Router } from "express"
import { authMiddleware } from "../../features/auth/auth.middleware"
import UserController from "./user.controller"

const UserRouter = Router()

UserRouter.get("/all", UserController.all)

UserRouter.post("/create", UserController.create)

UserRouter.get("/:id", UserController.getUserById)

UserRouter.put("/update", UserController.update)

UserRouter.delete("/:id", authMiddleware, UserController.delete)

export default UserRouter