import * as bcrypt from 'bcrypt';

export class password {

    private readonly saltRounds: Number = 10;
    private hashedPassword: string

    // Hashing a password
    public async hashPassword(password) {
        this.hashedPassword = await bcrypt.hash(password, this.saltRounds)
        return this.hashedPassword;
    }

    // Verifying a password
    private async verifyPassword(password, hashedPassword) {
        const isMatch = await bcrypt.compare(password, hashedPassword);
        return isMatch;
    }

}