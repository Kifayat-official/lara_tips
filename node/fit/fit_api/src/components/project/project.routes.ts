import { Router } from "express"
import ProjectController from './project.controller'

const ProjectRouter = Router()

ProjectRouter.get("/all", ProjectController.all)

ProjectRouter.post("/create", ProjectController.create)

ProjectRouter.get("/:id", ProjectController.getProjectById)

ProjectRouter.put("/update", ProjectController.update)

ProjectRouter.delete("/:id", ProjectController.delete)

export default ProjectRouter