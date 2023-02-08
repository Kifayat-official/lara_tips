import { DataSource } from "typeorm";
import path from "path";
import { User } from "./entities/user.entity";

const MysqlFitDbDataSource = new DataSource({
    type: "mysql",
    host: "128.101.100.12",
    port: 3000,
    username: "enc_db",
    password: "wg3k2#339",
    database: "fit",
    synchronize: true,
    logging: true,
    entities: [User],
    migrations: [],
    subscribers: [],
})

export default MysqlFitDbDataSource