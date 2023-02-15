import { Request, Response } from "express";
import { User } from "../../database/entities/user.entity";
import { Password } from "../../common/utilities/password.utility";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { IUserRequestPayload } from "./user.request";
import { IUserEndPointResponse, IUserResponsePayload } from "./user.response";
import ExceptionMapper from "../../common/exception/exception.mapper";

export default class UserController {

    public static userResponse: IUserResponsePayload

    // get single user by id
    public static async getUserById(req: Request, res: Response) {
        try {
            let id: number = Number(req.params.id)
            let user: User = await UserRepo.getUserById(id)

            UserController.userResponse = user ? UserMapper.entityToResponse(user) : null
            res.send(UserController.userResponse)
        }
        catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while getting user by it's ID", error)
            res.send(exception)
        }
    }

    // Get single user by username
    public static async getUserByUsername(req: Request, res: Response) {
        try {
            let username: string = req.body.username
            let user: User = await UserRepo.getUserByUsername(username)

            UserController.userResponse = user ? UserMapper.entityToResponse(user) : null
            res.send(UserController.userResponse)
        }
        catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while getting user by it's username", error)
            res.send(exception)
        }
    }

    // Get all users
    public static async all(req: Request, res: Response) {
        try {
            let UserResponseArr: IUserResponsePayload[] =
                (await UserRepo.all()).map((user) => { return UserMapper.entityToResponse(user) })
            res.send(UserResponseArr)
        } catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while fetching all users", error)
            res.send(exception)
        }
    }

    // Create user
    public static async create(req: Request, res: Response) {
        try {
            let userResponse: IUserResponsePayload
            let userEndPointResponse: IUserEndPointResponse
            let requestPayload: User = req.body

            requestPayload.password = await Password.hashPassword(requestPayload.password)
            userResponse = await UserMapper.entityToResponse(await UserRepo.create(requestPayload))
            userEndPointResponse = UserMapper.userCreationEndpointResponse(userResponse)
            res.send(userEndPointResponse)
        } catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while creating a user", error)
            res.send(exception)
        }
    }

    // Update user
    public static async update(req: Request, res: Response) {
        try {
            let requestPayload: IUserRequestPayload = req.body
            let User: User = await UserMapper.reqToEntity(requestPayload)

            res.send(await UserRepo.update(User))
        } catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while updating a user", error)
            res.send(exception)
        }
    }

    // Delete user
    public static async delete(req: Request, res: Response) {
        try {
            let id = Number(req.params.id)
            res.send(await UserRepo.delete(id))
        } catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while deleting a user", error)
            res.send(exception)
        }
    }
}