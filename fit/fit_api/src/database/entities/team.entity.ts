import { Column, Entity, ManyToMany, ManyToOne, OneToMany, PrimaryGeneratedColumn } from "typeorm";
import { Project } from "./project.entity";
import { Task } from "./tasks/task.entity";
import { TeamMember } from "./team-member.entity";
import { User } from "./user.entity";

@Entity()
export class Team {
    @PrimaryGeneratedColumn()
    id: number;

    @OneToMany(type => TeamMember, teamMember => teamMember.team)
    teamMembers: TeamMember[];

    @OneToMany(() => Task, task => task.teams)
    tasks: Task[];

    @ManyToOne(() => Project, project => project.teams)
    project: Project;

    @Column()
    name: string;

    @Column()
    dailyTargetDetails: string;

    @Column({ default: false })
    isActive: boolean;
}