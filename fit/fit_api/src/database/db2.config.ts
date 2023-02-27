import { join } from "path";
import { DataSource } from "typeorm";
import { Company } from "./entities/company.entity";
import { Permission } from "./entities/permission.entity";
import { Project } from "./entities/project.entity";
import { Role } from "./entities/role.entity";
import { TeamMemberRole } from "./entities/team-member-role.entity";
import { TeamMember } from "./entities/team-member.entity";
import { Team } from "./entities/team.entity";
import { User } from "./entities/user.entity";

interface IdbConnConfigArray {
    [key: string]: any;
}

export const dbConnConfigArr: IdbConnConfigArray = {
    "remote": {
        host: "128.101.100.12",
        port: 3000,
        username: "enc_db",
        password: "wg3k2#339",
    },
    "local": {
        host: "localhost",
        port: 3306,
        username: "root",
        password: "",
    }
};

// Define a function that creates a new database connection based on the provided configuration options
export const createNewConnection = (dbConfigName: string) => {
    return new DataSource({
        ...dbConnConfigArr[dbConfigName],
        type: "mysql",
        database: "fit",
        entities: [
            join(__dirname, "../../dist/database/entities/**/*.js"), // Include JavaScript entity files
            User, Role, Permission, Project, Team, TeamMember, TeamMemberRole, Company, // Include TypeScript entity files
        ],
        synchronize: true, // automatically synchronize database schema with the entities
        logging: true,
    })
}