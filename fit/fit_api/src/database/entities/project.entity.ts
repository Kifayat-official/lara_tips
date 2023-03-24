import { Column, CreateDateColumn, Entity, JoinColumn, ManyToMany, ManyToOne, OneToMany, OneToOne, PrimaryGeneratedColumn, UpdateDateColumn } from "typeorm";
import { Company } from "./company.entity";
import { Task } from "./task.entity";
import { Team } from "./team.entity";
import { User } from "./user.entity";

enum ProjectStatus {
    Completed = 'completed',
    Active = 'active',
    Inactive = 'inactive',
    Scrab = 'scrab'
}

@Entity()
export class Project {

    @PrimaryGeneratedColumn()
    id: number

    @ManyToOne(() => User, user => user.adminProjects)
    adminUser: User;

    @ManyToOne(() => User, user => user.managedProjects)
    manager: User;

    @OneToMany(() => Team, team => team.project)
    teams: Team[];

    @OneToMany(() => Task, task => task.project)
    tasks: Task[];

    @OneToOne(() => Company)
    @JoinColumn()
    company: Company;

    @Column({ type: 'varchar', length: 50, nullable: false })
    name: string

    @Column({ type: 'varchar', length: 50 })
    tender_ref_no: string

    @Column({ type: "varchar", length: 200 })
    description: string

    @Column({ type: 'date' })
    expected_start_date: Date

    @Column({ type: 'date' })
    expected_end_date: Date

    @Column({ type: 'date' })
    start_date: Date

    @Column({ type: 'date' })
    end_date: Date

    @Column({ type: 'float', nullable: false })
    latitude: number;

    @Column({ type: 'float', nullable: false })
    longitude: number

    @Column({ type: 'varchar', length: 200, nullable: false })
    job_card_accessory_label1: number

    @Column({ type: 'varchar', length: 200, nullable: false })
    job_card_accessory_label2: number

    @Column({ type: 'varchar', length: 200, nullable: false })
    job_card_accessory_label3: number

    @Column({ type: 'boolean', default: true, nullable: false })
    is_team_selectable: boolean

    @Column({ type: 'boolean', default: true, nullable: false })
    is_meter_assignable: boolean

    @Column({ type: 'enum', enum: ProjectStatus, default: ProjectStatus.Active, nullable: false })
    status: ProjectStatus

    @Column({ type: 'timestamp', default: () => 'CURRENT_TIMESTAMP' })
    created_at: Date

    @Column({ type: 'timestamp', default: () => 'CURRENT_TIMESTAMP', onUpdate: 'CURRENT_TIMESTAMP' })
    updated_at: Date

}