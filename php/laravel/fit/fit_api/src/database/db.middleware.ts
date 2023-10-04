const { getConnectionManagerOrThrow, createConnection } = require('typeorm');

async function setConnection(req, res, next) {

    const connectionManager = getConnectionManagerOrThrow();

    let connection = connectionManager.has('default')
        ? connectionManager.get('default')
        : await createConnection({
            name: 'default',
            type: 'mysql',
            host: 'localhost',
            port: 3306,
            username: 'user1',
            password: 'pass1',
            database: 'mydb',
            synchronize: true,
            entities: [__dirname + './entities/**/*.js'],
        });

    // Load all entities and synchronize with the database
    await connection.loadEntities();
    await connection.synchronize();

    // Set the connection object on the req object
    req.dbConnection = connection;
    next();
}
// const connections = {
//     remote: new DataSource({
//         type: 'mysql',
//         host: "128.101.100.12",
//         port: 3000,
//         username: "enc_db",
//         password: "wg3k2#339",
//         database: "fit",
//         synchronize: true,
//         entities: [
//             __dirname + "../../dist/database/entities/**/*.js", // Include JavaScript entity files
//             __dirname + "./entities/**/*.ts"
//             //Company, Permission, Project, Role, TeamMemberRole, TeamMember, , Team, User, MaintenanceTask, MeterReadingTask, Task  // Include TypeScript entity files
//         ],
//     }),
//     local: new DataSource({
//         type: 'postgres',
//         host: "localhost",
//         port: 3306,
//         username: "root",
//         password: "",
//         database: "fit",
//         synchronize: true,
//         entities: [
//             __dirname + "../../dist/database/entities/**/*.js", // Include JavaScript entity files
//             __dirname + "./entities/**/*.ts"
//             //Company, Permission, Project, Role, TeamMemberRole, TeamMember, , Team, User, MaintenanceTask, MeterReadingTask, Task  // Include TypeScript entity files
//         ],
//     }),
// };

// interface IdbConnConfigArray {
//     [key: string]: any;
// }
// export const setConnectionMiddleware = async (req: Request, res: Response, next: NextFunction) => {
//     const connName = req.query.dbName.toString()

//     const dbConnConfigArr: IdbConnConfigArray = {
//         "remote": {
//             host: "128.101.100.12",
//             port: 3000,
//             username: "enc_db",
//             password: "wg3k2#339",
//         },
//         "local": {
//             host: "localhost",
//             port: 3306,
//             username: "root",
//             password: "",
//         }
//     };


//     try {
//         //const connection = await createConnection(connectionOptions);
//         //req.socket = connection;
//         //next();

       
        
//         const dataSource = await new DataSource({
//             ...dbConnConfigArr[connName],
//             type: "mysql",
//             database: "fit",
//             entities: [
//                 __dirname + "../../dist/database/entities/**/*.js", // Include JavaScript entity files
//                 __dirname + "entities/**/*.ts"// Company, Permission, Project, Role, TeamMemberRole, TeamMember, , Team, User, MaintenanceTask, MeterReadingTask, Task  // Include TypeScript entity files
//             ],
//             synchronize: true, // automatically synchronize database schema with the entities
//             logging: true,
//         })
//         req.socket = dataSource.manager.connection
//         next();
//     } catch (error) {
//         console.error(error);
//         res.status(400).send(`Failed to connect : ${connName}`);
//     }
// }