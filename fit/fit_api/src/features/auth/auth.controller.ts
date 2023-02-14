import { Request, Response } from "express";
import UserMapper from "../../components/user/user.mapper";
import UserRepo from "../../components/user/user.repo";
import { IUserRequestPayload } from "../../components/user/user.request";
import { IUserResponse } from "../../components/user/user.response";
import { User } from "../../database/entities/user.entity";
import { Password } from "../../utilities/password.utility";
import AuthMapper from "./auth.mapper";

export default class AuthController {

    // User login
    public static async signIn(req: Request, res: Response) {
        try {
            let requestPayload: IUserRequestPayload = req.body as { username, password }
            let existingUser: User = await UserRepo.getUserByUsername(requestPayload.username)
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
        }
    }

    // User registrationuserResponse
    public static async signUp(req: Request, res: Response) {
        let userResponse: IUserResponse
        let requestPayload: IUserRequestPayload = req.body as IUserRequestPayload
        try {
            // check if user already exists
            userResponse = await UserRepo.getUserByUsername(requestPayload.username)
            if (userResponse) {
                return await AuthMapper.userAlreadyExistsResponse()
            }

            // user creation
            let user: User = await UserMapper.reqToEntity(requestPayload)
            let newDbUser: User = await UserRepo.create(user)
            userResponse = UserMapper.entityToResponse(newDbUser)

            res.send(await AuthMapper.signUpSuccessResponse(userResponse))

        } catch (error) {
            console.log(error)
        }
    }
}