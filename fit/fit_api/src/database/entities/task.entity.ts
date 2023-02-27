import { Column, Entity, ManyToOne, PrimaryGeneratedColumn } from "typeorm";
import { Team } from "./team.entity";

@Entity()
export class Task {
    @PrimaryGeneratedColumn()
    id: number;

    @Column()
    name: string;

    @Column()
    description: string;

    @Column()
    dueDate: Date;

    @Column()
    status: string;

    @ManyToOne(() => Team, team => team.tasks)
    assignedTeam: Team;
}