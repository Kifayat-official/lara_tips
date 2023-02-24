import { Request, Response } from "express";
import { User } from "../../database/entities/user.entity";
import { Password } from "../../common/utilities/password.utility";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { IUserRequestPayload } from "./user.request";
import { IUserEndPointResponse, IUserResponsePayload } from "./user.response";
import ExceptionMapper from "../../common/exception/exception.mapper";
import { DeleteResult, UpdateResult } from "typeorm";

export default class UserController {

    private static userRepo: UserRepo = new UserRepo();
    public static userResponse: IUserResponsePayload

    // get single user by id
    public static async getUserById(req: Request, res: Response) {
        try {
            let id: number = Number(req.params.id)
            let user: User = await this.userRepo.getUserById(id)

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
            let user: User = await this.userRepo.getUserByUsername(username)

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
                (await this.userRepo.all()).map((user) => { return UserMapper.entityToResponse(user) })
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
            let responsePayload: IUserResponsePayload
            let requestPayload: IUserRequestPayload = req.body as IUserRequestPayload

            const newUserReqToEntity = await UserMapper.reqToEntity(requestPayload)
            const newUserEntity = await this.userRepo.createUser(newUserReqToEntity)

            if (newUserEntity) {
                responsePayload = UserMapper.entityToResponse(newUserEntity)
                const userCreationEndpointResponse = UserMapper.userCreationEndpointResponse(responsePayload)
                res.send(userCreationEndpointResponse)
            }

            res.send(UserMapper.userAlreadyExistsResponse())
        } catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while creating a user", error)
            res.send(exception)
        }
    }

    // Update user
    public static async update(req: Request, res: Response) {
        try {
            const requestPayload: IUserRequestPayload = req.body
            const user: User = await UserMapper.reqToEntity(requestPayload)
            const updateResult = await this.userRepo.updateUser(user) as UpdateResult
            const userEndPointResponse = UserMapper.userUpdateEndpointResponse(updateResult)
            res.send(userEndPointResponse)
        } catch (error) {
            console.log({ "message": error })
            let exception = ExceptionMapper.errorToResponse("An exception occured while updating a user", error)
            res.send(exception)
        }
    }

    // Delete user
    public static async delete(req: Request, res: Response) {
        try {
            const id = Number(req.params.id)
            const result: DeleteResult = await this.userRepo.deleteUser(id)
            const userEndPointResponse = UserMapper.userDeleteEndpointResponse(result)
            res.send(userEndPointResponse)
        } catch (error) {
            console.log({ "message": error })
            const exception = ExceptionMapper.errorToResponse("An exception occured while deleting a user", error)
            res.send(exception)
        }
    }
}


