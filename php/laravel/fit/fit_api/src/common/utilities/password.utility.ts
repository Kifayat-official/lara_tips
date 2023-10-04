const bcrypt = require('bcrypt');

export class Password {

    // Hashing a password
    public static async hashPassword(password) {
        const saltRounds: Number = 10
        let hashedPassword: string = await bcrypt.hash(password, saltRounds)
        return hashedPassword;
    }

    // Verifying a password
    public static async verifyPassword(password, hashedPassword) {
        const isMatch = await bcrypt.compare(password, hashedPassword);
        return isMatch;
    }

}