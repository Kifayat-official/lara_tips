import { Column, Entity, ManyToOne, PrimaryGeneratedColumn } from "typeorm";
import { TeamMemberRole } from "./team-member-role.entity";
import { Team } from "./team.entity";

@Entity()
export class TeamMember {
    @PrimaryGeneratedColumn()
    id: number;

    @Column()
    memberName: string;

    @Column()
    isTeamLead: boolean;

    @Column()
    isTeamSupervisor: boolean;

    @Column({ default: true })
    isActive: boolean;

    @ManyToOne(type => Team, team => team.teamMembers)
    team: Team;

    @ManyToOne(type => TeamMemberRole, memberRole => memberRole.teamMembers)
    memberRole: TeamMemberRole;
}