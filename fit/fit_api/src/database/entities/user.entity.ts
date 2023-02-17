import { Entity, PrimaryGeneratedColumn, Column, CreateDateColumn, UpdateDateColumn, OneToMany, ManyToMany, JoinTable } from "typeorm"
// import { Project } from "./project.entity";
// import { Role } from "./role.entity";

@Entity()
export class User {

    @PrimaryGeneratedColumn()
    id: number

    // @ManyToMany(() => Role, role => role.users)
    // roles: Role[];

    // @ManyToMany(type => Project, project => project.users)
    // @JoinTable()
    // projects: Project[];
    
    @Column({ type: 'varchar', length: 50 })
    username: string

    @Column({ type: 'varchar', length: 150 })
    password: string
    
    @Column({ type: 'varchar', length: 50 })
    first_name: string

    @Column({ type: 'varchar', length: 50 })
    last_name: string

    @CreateDateColumn({ type: "timestamp", default: () => "CURRENT_TIMESTAMP(6)" })
    created_at: Date;

    @UpdateDateColumn({ type: "timestamp", default: () => "CURRENT_TIMESTAMP(6)", onUpdate: "CURRENT_TIMESTAMP(6)" })
    updated_at: Date;
}

// To drop a table when specified inside @Entity() upon changes in table
//   async function main() {
//     const connection = await createConnection();
//     await connection.query("DROP TABLE user_table");
//     await connection.synchronize();
//   }
  
//   main();
