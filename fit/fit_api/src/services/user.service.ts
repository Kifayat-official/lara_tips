import { User } from "../entities/user.entity";
import UserMapper from "../mappers/user.mapper";
import { UserEntityRequestPayload } from "../payload/request/user.payload";
import { UserEntityResponse } from "../payload/response/user.response";
import UserRepo from "../repositories/user.repo";

export default class UserService {
    // get single user by id
    public static async get(id: number) {
        let user: User = await UserRepo.get(id)
        if(user) {
            let userRes = UserMapper.entityToResponse(user)
            return userRes
        }
        else {
            return "Sorry, user does not exists!";
        }
        
    }
    // get all users
    public static async all() {
        let data: UserEntityResponse[] = (await UserRepo.all()).map( (user) => {
            return UserMapper.entityToResponse(user)
        })
        return await UserRepo.all()
    }
    // create user
    public static async create(requestPayload: UserEntityRequestPayload) {
        return await UserRepo.create(UserMapper.reqToEntity(requestPayload));
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