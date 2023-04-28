import { Router } from "express"
import { authMiddleware } from "../../features/auth/auth.middleware"
import UserController from "./user.controller"
import { User } from "../../database/entities/user.entity"
import UserRepo from "./user.repo"

const UserRouter = Router()
const userController = new UserController(new UserRepo())

UserRouter.get("/all", userController.all)

UserRouter.post("/create", userController.create)

UserRouter.get("/:id", userController.getUserById)

UserRouter.put("/update", userController.update)

UserRouter.delete("/:id", authMiddleware, userController.delete)

export default UserRouter