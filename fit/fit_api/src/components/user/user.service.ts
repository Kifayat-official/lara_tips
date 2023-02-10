import { UserEntity } from "../../database/entities/user.entity";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { UserEntityRequestPayload } from "./user.request";
import { IUserEntityResponse } from "./user.response";

export default class UserService {

    public static userEntityResponse: IUserEntityResponse

    // get single user by id
    public static async getUserById(id: number) {
        let user: UserEntity = await UserRepo.getUserById(id)
        return UserService.userEntityResponse = user ? UserMapper.entityToResponse(user) : null
    }

    // Get single user by username
    public static async getUserByUsername(username: string) {
        let user: UserEntity = await UserRepo.getUserByUsername(username)
        return UserService.userEntityResponse = user ? UserMapper.entityToResponse(user) : null
    }

    // Get all users
    public static async all() {
        let userEntityResponseArr: IUserEntityResponse[] = (await UserRepo.all()).map((user) => {
            return UserMapper.entityToResponse(user)
        })
        return userEntityResponseArr
    }

    // Create user
    public static async create(requestPayload: UserEntityRequestPayload) {
        let userEntity: UserEntity = await UserMapper.reqToEntity(requestPayload)
        return await UserRepo.create(userEntity);
    }

    // Update user
    public static async update(requestPayload: UserEntityRequestPayload) {
        let userEntity: UserEntity = await UserMapper.reqToEntity(requestPayload)
        return await UserRepo.update(userEntity)
    }

    // Delete user
    public static async delete(id: number) {
        return await UserRepo.delete(id)
    }
}