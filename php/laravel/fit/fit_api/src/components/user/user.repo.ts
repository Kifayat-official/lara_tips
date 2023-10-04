import dbConnection from "../.."
import { User } from "../../database/entities/user.entity"

export default class UserRepo {

    public async all() {
        //return await this.userRepo.find()
        try {
            let users = null
            users = await dbConnection(async (manager) => {
                return await manager.find(User)
            })
            return users
        } catch (error) {
            console.error('Find all users operation failed:', error);
        }
    }
    public async getUserById(id: number) {
        //return await this.userRepo.findOne({ where: { id: id } })
        try {
            const user = await dbConnection(async (manager) => {
                const users = await manager.findOne(User, { where: { id } });
                return users
            })
            return user || null;
        } catch (error) {
            console.error('Find user by id operation failed:', error);
        }
    }
    public async getUserByUsername(username: string) {
        //return await this.userRepo.findOne({ where: { username: username } })
        let user = null
        try {
            user = await dbConnection(async (manager) => {
                return await manager.findOne(User, { where: { username: username } })
            })
            return user || null;
        } catch (error) {
            console.error('Find user by username operation failed:', error);
        }
    }

    public async createUser(user: User) {
        // return await this.userRepo.save(user)
        let newUser = null
        try {
            // check if user already exists
            const isUserAlreadyExists = await this.getUserByUsername(user.username)
            if (isUserAlreadyExists) return null

            console.log("User: ", user)
            newUser = await dbConnection.manager.transaction(async (transactionalEntityManager) => {
                return await transactionalEntityManager.save(user)
            })

            // newUser = await dbConnection(async (manager) => {
            //     return await manager.save(user)
            // })
            return newUser || null
        } catch (error) {
            console.error('Create new user operation failed:', error);
        }
    }

    public async deleteUser(id: number) {
        try {
            const user = await dbConnection(async (manager) => {
                return await manager.delete(User, id)
            })
            return user || null;
        } catch (error) {
            console.error('Delete user by id operation failed:', error);
        }
    }
    public async updateUser(updatedUser: User) {
        try {
            const user = await dbConnection(async (manager) => {
                return await manager.delete(User, updatedUser)
            })
            return user || null;
        } catch (error) {
            console.error('User update operation failed:', error);
        }
    }
}