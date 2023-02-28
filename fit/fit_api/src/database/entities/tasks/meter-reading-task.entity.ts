import { Column, Entity } from "typeorm";
import { Task } from "./task.entity";

@Entity()
export class MeterReadingTask extends Task {
    @Column()
    meterNumber: string;

    @Column()
    lastReading: number;

    @Column()
    currentReading: number;
}