import { Column, Entity, JoinTable, ManyToMany, ManyToOne, PrimaryGeneratedColumn } from "typeorm";
import { Project } from "./project.entity";
import { Team } from "./team.entity";

@Entity()
export class Task {
    @PrimaryGeneratedColumn()
    id: number;

    @ManyToMany(() => Team, team => team.tasks)
    @JoinTable()
    teams: Team[];

    // @ManyToOne(() => Team, team => team.tasks)
    // team: Team;

    @ManyToOne(() => Project, project => project.tasks)
    project: Project;

    // entity 
    @Column({ type: 'json' })
    details: Record<string, any>;

    // @Column()
    // name: string;

    // @Column()
    // description: string;

    // @Column()
    // deadline: Date;

    // @Column()
    // status: string;
}