import { Entity, PrimaryGeneratedColumn, Column, CreateDateColumn, UpdateDateColumn } from "typeorm"

@Entity()
export class User {

    @PrimaryGeneratedColumn()
    id: number

    @Column({ type: 'varchar', length: 50 })
    username: string

    @Column({ type: 'varchar', length: 50 })
    password: string

    @Column({ type: 'varchar', length: 50 })
    firstName: string

    @Column({ type: 'varchar', length: 50 })
    lastName: string

    @CreateDateColumn()
    createdAt: Date;

    @UpdateDateColumn()
    updatedAt: Date;
}
