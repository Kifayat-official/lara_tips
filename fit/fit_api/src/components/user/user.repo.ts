import MysqlFitDbDataSource from "../../database/db.config"
import { UserEntity } from "../../database/entities/user.entity"

export default class UserRepo {

    public static async all() {
        return await MysqlFitDbDataSource.getRepository(UserEntity).find()
    }
    public static async getUserById(id: number) {
        return await MysqlFitDbDataSource.getRepository(UserEntity).findOne({ where: { id: id } })
    }
    public static async getUserByUsername(username: string) {
        return await MysqlFitDbDataSource.getRepository(UserEntity).findOne({ where: { username: username } })
    }
    public static async create(user: UserEntity) {
        return await MysqlFitDbDataSource.getRepository(UserEntity).save(user)
    }
    public static async delete(id: number) {
        return await MysqlFitDbDataSource.getRepository(UserEntity).delete(id)
    }
    public static async update(updatedUser: UserEntity) {
        return await MysqlFitDbDataSource.getRepository(UserEntity).update({ id: updatedUser.id }, updatedUser)
    }
}