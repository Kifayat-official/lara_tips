
import { JsonController, Get, Post, Body } from 'routing-controllers';
import { IUserRepository } from '../repositories/user/IUserRepository';
import { User } from '../entities/User';
import { autoInjectable, inject, injectable } from 'tsyringe';

@injectable()
@JsonController('/users')
class UserController {

    constructor(@inject("IUserRepository") private userRepository: IUserRepository) { }

    @Get('/')
    public async getAllUsers(): Promise<User[]> {
        // const user = [{
        //     id: 1,
        //     firstName: "Kifayat",
        //     lastName: "Khan",
        //     age: 31
        // }]

        // return user;

        return this.userRepository.getAllUsers();
    }

    // @Get('/:id')
    // async getUserById(@Param('id') id: number) {
    //     return this.userRepository.getUserById(id);
    // }

    @Post('/')
    public async createUser(@Body() user: User) {
        return this.userRepository.createUser(user);
    }

    // @Put('/:id')
    // public async updateUser(@Param('id') id: number, @Body() updatedUser: User) {
    //     return this.userRepository.updateUser(id, updatedUser);
    // }

    // @Delete('/:id')
    // public async deleteUser(@Param('id') id: number) {
    //     await this.userRepository.deleteUser(id);
    //     return { message: 'User deleted successfully' };
    // }
}

export default UserController;
