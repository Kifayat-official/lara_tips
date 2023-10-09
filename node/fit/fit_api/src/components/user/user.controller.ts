import { Request, Response } from "express";
import { User } from "../../database/entities/user.entity";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { IUserRequestPayload } from "./user.request";
import { IUserResponsePayload } from "./user.response";
import ExceptionMapper from "../../common/exception/exception.mapper";
import { DeleteResult, UpdateResult } from "typeorm";
import ExceptionResponse from "../../common/exception/exception.mapper";

export default class UserController {

    //private userRepo: UserRepo = new UserRepo();
    //public static userResponse: IUserResponsePayload
    private userResponse: IUserResponsePayload
    constructor(
        private userRepo: UserRepo
    ) {
        this.userRepo = userRepo
    }

    // get single user by id
    public async getUserById(req: Request, res: Response) {
        try {
            let id: number = Number(req.params.id)
            let user: User = await this.userRepo.getUserById(id)

            this.userResponse = user ? UserMapper.entityToResponse(user) : null
            res.send(this.userResponse)
        }
        catch (error) {
            console.log({ "message": error })
            res.send(new ExceptionResponse("An exception occured while fetching a user by it's ID", 500))
        }
    }

    // Get single user by username
    public async getUserByUsername(req: Request, res: Response) {
        try {
            let username: string = req.body.username
            let user: User = await this.userRepo.getUserByUsername(username)

            this.userResponse = user ? UserMapper.entityToResponse(user) : null
            res.send(this.userResponse)
        }
        catch (error) {
            console.log({ "message": error })
            res.send(new ExceptionResponse("An exception occured while fetching a user by it's username", 500))
        }
    }

    // Get all users
    public async all(req: Request, res: Response) {
        try {
            let UserResponseArr: IUserResponsePayload[] =
                (await this.userRepo.all()).map((user) => { return UserMapper.entityToResponse(user) })
            res.send(UserResponseArr)
        } catch (error) {
            console.log({ "message": error })
            res.send(new ExceptionResponse("An exception occured while fetching a user", 500))
        }
    }

    // Create user
    public async create(req: Request, res: Response) {
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
            res.send(new ExceptionResponse("An exception occured while creating a user", 500))
        }
    }

    // Update user
    public async update(req: Request, res: Response) {
        try {
            const requestPayload: IUserRequestPayload = req.body
            const user: User = await UserMapper.reqToEntity(requestPayload)
            const updateResult = await this.userRepo.updateUser(user) as UpdateResult
            const userEndPointResponse = UserMapper.userUpdateEndpointResponse(updateResult)
            res.send(userEndPointResponse)
        } catch (error) {
            console.log({ "message": error })
            res.send(new ExceptionResponse("An exception occured while updating a user", 500))
        }
    }

    // Delete user
    public async delete(req: Request, res: Response) {
        try {
            const id = Number(req.params.id)
            const result: DeleteResult = await this.userRepo.deleteUser(id)
            const userEndPointResponse = UserMapper.userDeleteEndpointResponse(result)
            res.send(userEndPointResponse)
        } catch (error) {
            console.log({ "message": error })
            res.send(new ExceptionResponse("An exception occured while deleting a user", 500))
        }
    }
}


