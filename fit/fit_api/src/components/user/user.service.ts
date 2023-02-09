import { User } from "../../database/entities/user.entity";
import UserMapper from "./user.mapper";
import UserRepo from "./user.repo";
import { UserEntityRequestPayload } from "./user.request";
import { UserEntityResponse } from "./user.response";

export default class UserService {
    // get single user by id
    public static async getUserById(id: number) {
        let user: User = await UserRepo.getUserById(id)
        if (user) {
            let userRes = UserMapper.entityToResponse(user)
            return userRes
        }
        else {
            return "Sorry, user does not exists!";
        }
    }
    public static async getUserByUsername(username: string) {
        let user: User = await UserRepo.getUserByUsername(username)
        if (user) {
            let userRes = UserMapper.entityToResponse(user)
            return userRes
        }
        else {
            return "Sorry, user does not exists!";
        }
    }
    // get all users
    public static async all() {
        let data: UserEntityResponse[] = (await UserRepo.all()).map((user) => {
            return UserMapper.entityToResponse(user)
        })
        return await UserRepo.all()
    }
    // create user
    public static async create(requestPayload: UserEntityRequestPayload) {
        //UserMapper.reqToEntity(requestPayload)
        return await UserRepo.create(requestPayload);
    }
    // update user
    public static async update(requestPayload: UserEntityRequestPayload) {
        return UserRepo.update(UserMapper.reqToEntity(requestPayload))
    }
    // delete user
    public static async delete(id: number) {
        return await UserRepo.delete(id)
    }
}