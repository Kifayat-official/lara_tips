import MysqlFitDbDataSource from "../../database/db.config"
import { User } from "../../database/entities/user.entity"

export default class UserRepo {

    public static async all() {
        return await MysqlFitDbDataSource.getRepository(User).find()
    }
    public static async getUserById(id: number) {
        return await MysqlFitDbDataSource.getRepository(User).findOne({ where: { id: id } })
    }
    public static async getUserByUsername(username: string) {
        return await MysqlFitDbDataSource.getRepository(User).findOne({ where: { username: username } })
    }
    public static async create(user: User) {
        return await MysqlFitDbDataSource.getRepository(User).save(user)
    }
    public static async delete(id: number) {
        return await MysqlFitDbDataSource.getRepository(User).delete(id)
    }
    public static async update(updatedUser: User) {
        return await MysqlFitDbDataSource.getRepository(User).update({ id: updatedUser.id }, updatedUser)
    }
}