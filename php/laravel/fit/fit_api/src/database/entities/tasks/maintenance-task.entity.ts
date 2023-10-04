import { Column, Entity } from "typeorm";
import { Task } from "../task.entity";

@Entity()
export class MaintenanceTask extends Task {
    @Column()
    equipment: string;

    @Column()
    description: string;
}