import { Repository } from 'typeorm';
import { IUserRepository } from './iuser-repository';
<<<<<<< HEAD
import { inject, injectable } from 'tsyringe';
import { Req } from 'routing-controllers';
import { Request } from 'express';
import { AppDataSource } from '../../middlewares/select-datasource';
=======
import { injectable } from 'tsyringe';
import { AppDataSource } from '../../data_source';
import { User } from '../../entities/user';
>>>>>>> 44e4a633d152ca1fad95db8e7f83be42f95b35ee

@injectable()
class UserRepository implements IUserRepository {
    private user: Repository<User>;

    //constructor(@inject('UserRepository') private user: Repository<User>) {}

    constructor() {
        this.user = AppDataSource.getRepository(User)
    }

    public async getAllUsers(): Promise<User[]> {
        return this.user.find()
    }

    // async getUserById(id: number): Promise<User | undefined> {
    //     return this.userRepository.findOne(id);
    // }

    public async createUser(user: User): Promise<User> {
        return this.user.save(user)
    }

    // public async updateUser(id: number, updatedUser: User): Promise<User | undefined> {
    //     await this.userRepository.update(id, updatedUser);
    //     return this.getUserById(id);
    // }

    // public async deleteUser(id: number): Promise<void> {
    //     await this.userRepository.delete(id);
    // }
}

export { UserRepository };
