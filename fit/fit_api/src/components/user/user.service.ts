import { User } from "../../database/entities/user.entity";
import { Password } from "../../utilities/password.utility";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { IUserRequestPayload } from "./user.request";
import { IUserResponse } from "./user.response";

export default class UserService {

    public static UserResponse: IUserResponse

    // get single user by id
    public static async getUserById(id: number) {
        let user: User = await UserRepo.getUserById(id)
        return UserService.UserResponse = user ? UserMapper.entityToResponse(user) : null
    }

    // Get single user by username
    public static async getUserByUsername(username: string) {
        let user: User = await UserRepo.getUserByUsername(username)
        return UserService.UserResponse = user ? UserMapper.entityToResponse(user) : null
    }

    // Get all users
    public static async all() {
        let UserResponseArr: IUserResponse[] = (await UserRepo.all()).map((user) => {
            return UserMapper.entityToResponse(user)
        })
        return UserResponseArr
    }

    // Create user
    public static async create(requestPayload: User) {
        requestPayload.password = await Password.hashPassword(requestPayload.password)
        return await UserMapper.entityToResponse(await UserRepo.create(requestPayload)) 
    }

    // Update user
    public static async update(requestPayload: IUserRequestPayload) {
        let User: User = await UserMapper.reqToEntity(requestPayload)
        return await UserRepo.update(User)
    }

    // Delete user
    public static async delete(id: number) {
        return await UserRepo.delete(id)
    }
}