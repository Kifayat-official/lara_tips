import { NextFunction, Request, Response, } from "express"
import { DataSource } from "typeorm";

const connections = {
    remote: new DataSource({
        type: 'mysql',
        host: "128.101.100.12",
        port: 3000,
        username: "enc_db",
        password: "wg3k2#339",
        database: "fit",
        synchronize: true,
        entities: [
            __dirname + "../../dist/database/entities/**/*.js", // Include JavaScript entity files
            __dirname + "./entities/**/*.ts"
            //Company, Permission, Project, Role, TeamMemberRole, TeamMember, , Team, User, MaintenanceTask, MeterReadingTask, Task  // Include TypeScript entity files
        ],
    }),
    local: new DataSource({
        type: 'postgres',
        host: "localhost",
        port: 3306,
        username: "root",
        password: "",
        database: "fit",
        synchronize: true,
        entities: [
            __dirname + "../../dist/database/entities/**/*.js", // Include JavaScript entity files
            __dirname + "./entities/**/*.ts"
            //Company, Permission, Project, Role, TeamMemberRole, TeamMember, , Team, User, MaintenanceTask, MeterReadingTask, Task  // Include TypeScript entity files
        ],
    }),
};

export const setConnectionMiddleware = async (req: Request, res: Response, next: NextFunction) => {
    const dbName = req.query.db;
    const connectionOptions = {
        type: 'mysql',
        host: 'localhost',
        port: 3306,
        username: 'user1',
        password: 'pass1',
        database: dbName,
        synchronize: true,
        entities: [__dirname + '/entities/*.js'],
    };
    try {
        const connection = await createConnection(connectionOptions);
        req.socket = connection;
        next();
    } catch (error) {
        console.error(error);
        res.status(400).send(`Failed to connect to database: ${dbName}`);
    }
}