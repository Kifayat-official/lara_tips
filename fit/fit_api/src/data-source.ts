import "reflect-metadata"
import { DataSource } from "typeorm"
import { TestUser } from "./entity/User"

export const MysqlFitDbDataSource = new DataSource({
    type: "mysql",
    host: "128.101.100.12",
    port: 3000,
    username: "enc_db",
    password: "wg3k2#339",
    database: "fit",
    synchronize: true,
    logging: false,
    entities: [TestUser],
    migrations: [],
    subscribers: [],
})


export const MySqlTestDbDataSource = new DataSource({
    type: "mysql",
    host: "128.101.100.12",
    port: 3000,
    username: "enc_db",
    password: "wg3k2#339",
    database: "z_lara_test_db",
    synchronize: true,
    logging: false,
    entities: [TestUser],
    migrations: [],
    subscribers: [],
})