import { Column, Entity, OneToMany, PrimaryGeneratedColumn } from "typeorm";
import { TeamMember } from "./team-member.entity";

@Entity()
export class TeamMemberRole {
    @PrimaryGeneratedColumn()
    id: number;

    @Column()
    name: string;

    @Column({ default: true })
    isActive: boolean;

    @OneToMany(type => TeamMember, teamMember => teamMember.memberRole)
    teamMembers: TeamMember[];
}