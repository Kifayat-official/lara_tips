import { Request, Response } from "express";
import UserMapper from "../../components/user/user.mapper";
import UserRepo from "../../components/user/user.repo";
import { IUserRequestPayload } from "../../components/user/user.request";
import { IUserResponsePayload } from "../../components/user/user.response";
import { User } from "../../database/entities/user.entity";
import { Password } from "../../common/utilities/password.utility";
import AuthMapper from "./auth.mapper";
import ExceptionMapper from "../../common/exception/exception.mapper";
import UserController from "../../components/user/user.controller";

export default class AuthController {

    private static userRepo: UserRepo = new UserRepo();
    // User login
    public static async signIn(req: Request, res: Response) {
        try {
            let requestPayload: IUserRequestPayload = req.body as { username, password }
            let existingUser: User = await this.userRepo.getUserByUsername(requestPayload.username)
            if (!existingUser) {
                return await AuthMapper.userDoesNotExistsResponse()
            }

            let isPasswordMatches = await Password.verifyPassword(requestPayload.password, existingUser.password)
            if (!isPasswordMatches) {
                return await AuthMapper.passwordDoesNotMatchResponse()
            }

            let userResponse = UserMapper.entityToResponse(existingUser)
            res.send(await AuthMapper.signInSuccessResponse(userResponse))
        }
        catch (error) {
            console.log(error)

            let exception = ExceptionMapper.errorToResponse("An exception occured while logging in", error)
            res.send(exception)
        }
    }

    public static async signUp(req: Request, res: Response) {
        let responsePayload: IUserResponsePayload
        let requestPayload: IUserRequestPayload = req.body as IUserRequestPayload

        try {
            // user creation
            const user: User = await UserMapper.reqToEntity(requestPayload)
            const newUser: User = await this.userRepo.createUser(user)

            if (newUser) {
                responsePayload = UserMapper.entityToResponse(newUser)
                //const signUpEndPointResponse = await AuthMapper.signUpSuccessEndPointResponse(responsePayload)
                res.send(responsePayload)
            }

            res.send(await AuthMapper.userAlreadyExistsResponse())
        } catch (error) {
            console.log(error)
            let exception = ExceptionMapper.errorToResponse("An exception occured while signing up", error)
            res.send(exception)
        }
    }
}