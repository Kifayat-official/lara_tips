import { DataSource, Repository } from 'typeorm';
import { IUserRepository } from './iuser-repository';
<<<<<<< HEAD
<<<<<<< HEAD
import { inject, injectable } from 'tsyringe';
import { Req } from 'routing-controllers';
import { Request } from 'express';
import { AppDataSource } from '../../middlewares/select-datasource';
=======
=======
>>>>>>> 16328190c028bafba53ffe9474ea398d997448dd
import { injectable } from 'tsyringe';
import { User } from '../../entities/user';
<<<<<<< HEAD
>>>>>>> 44e4a633d152ca1fad95db8e7f83be42f95b35ee
=======
import { Req } from 'routing-controllers';
import { Request } from 'express';
>>>>>>> 16328190c028bafba53ffe9474ea398d997448dd

@injectable()
class UserRepository implements IUserRepository {
    private user: Repository<User>;
    private req: Request;
    //constructor(@inject('UserRepository') private user: Repository<User>) {}

    constructor() {
        const dataSource: DataSource = this.req.app.locals.data_source;
        this.user = dataSource.getRepository(User);
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
