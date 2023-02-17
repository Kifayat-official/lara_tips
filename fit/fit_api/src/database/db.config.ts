import { DataSource } from "typeorm";
import path, { join } from "path";
import { User } from "./entities/user.entity";

const MysqlFitDbDataSource = new DataSource({
    type: "mysql",
    // host: "128.101.100.12",
    // port: 3000,
    // username: "enc_db",
    // password: "wg3k2#339",
    host: "localhost",
    port: 3306,
    username: "root",
    password: "",
    database: "fit",
    synchronize: true,
    logging: true,
    entities: [
        join(__dirname, "../../dist/database/entities/**/*.js"), // Include JavaScript entity files
        join(__dirname, "entities/**/*.ts"), // Include TypeScript entity files
    ],
    //entities: [`${__dirname}\entities\*.ts`],
    migrations: [],
    subscribers: [],
})

console.log(join(__dirname, "../../dist/entities/**/*.js"))
console.log(join(__dirname, "entities/**/*.ts"))
// const initializeDb = () => {
//     MysqlFitDbDataSource.initialize().then(() => {
//         console.log("MySql Db Initialized!")
//     }).catch(() => {
//         console.log("Error occured while connecting to database.")
//     })
// }

export default MysqlFitDbDataSource