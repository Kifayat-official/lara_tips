import { Request, Response } from "express";
import { User } from "../../database/entities/user.entity";
import { Password } from "../../utilities/password.utility";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { IUserRequestPayload } from "./user.request";
import { IUserResponse } from "./user.response";

export default class UserController {

    public static userResponse: IUserResponse

    // get single user by id
    public static async getUserById(req: Request, res: Response) {
        let id: number = Number(req.params.id)
        let user: User = await UserRepo.getUserById(id)
        this.userResponse = user ? UserMapper.entityToResponse(user) : null
        res.send(this.userResponse)
    }

    // Get single user by username
    public static async getUserByUsername(req: Request, res: Response) {
        let username: string = req.body.username
        let user: User = await UserRepo.getUserByUsername(username)
        this.userResponse = user ? UserMapper.entityToResponse(user) : null
        res.send(this.userResponse)
    }

    // Get all users
    public static async all(req: Request, res: Response) {
        let UserResponseArr: IUserResponse[] = (await UserRepo.all()).map((user) => {
            return UserMapper.entityToResponse(user)
        })
        res.send(UserResponseArr)
    }

    // Create user
    public static async create(req: Request, res: Response) {
        let requestPayload: User = req.body
        requestPayload.password = await Password.hashPassword(requestPayload.password)
        return await UserMapper.entityToResponse(await UserRepo.create(requestPayload))
    }

    // Update user
    public static async update(req: Request, res: Response) {
        let requestPayload: IUserRequestPayload = req.body
        let User: User = await UserMapper.reqToEntity(requestPayload)
        return await UserRepo.update(User)
    }

    // Delete user
    public static async delete(req: Request, res: Response) {
        let id = Number(req.params.id)
        res.send(await UserRepo.delete(id))
    }
}