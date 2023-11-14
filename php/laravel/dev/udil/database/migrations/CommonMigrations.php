<?php

use Webpatser\Uuid\Uuid;

class CommonMigrations
{
    public static function five($table)
    {
        $table->boolean('status')->default(true)->nullable();
        $table->uuid('created_by')->nullable();
        $table->uuid('updated_by')->nullable();
        $table->timestamps();
    }

    public static function insertEntityPermissions($table_name, $permission_group, $order, $title_part, $idt_part, $s_es)
    {
        $plural_title_part = $title_part;
        $plural_idt_part = $idt_part;
        if($s_es == 'ies')
        {
            $plural_title_part = substr($title_part, 0, strlen($title_part) - 1) . $s_es;
            $plural_idt_part = substr($idt_part, 0, strlen($idt_part) - 1) . $s_es;
        } 
        else 
        {
            $plural_title_part = $title_part . $s_es;
            $plural_idt_part = $idt_part . $s_es;
        }

        \DB::table($table_name)
            ->insert([
                [
                    'group' => $permission_group,
                    'idt' => $plural_idt_part . '_list',
                    'name' => $plural_title_part . ' List',
                    'parent_idt' => null,
                    'order' => $order,
                    'id' => (string) Uuid::generate(4),
                ],
                [
                    'group' => $permission_group,
                    'idt' => 'add_' . $idt_part,
                    'name' => 'Add ' . $title_part,
                    'parent_idt' => $plural_idt_part . '_list',
                    'order' => $order,
                    'id' => (string) Uuid::generate(4),
                ],
                [
                    'group' => $permission_group,
                    'idt' => 'edit_' . $idt_part,
                    'name' => 'Edit ' . $title_part,
                    'parent_idt' => $plural_idt_part . '_list',
                    'order' => $order,
                    'id' => (string) Uuid::generate(4),
                ],
                [
                    'group' => $permission_group,
                    'idt' => 'delete_' . $idt_part,
                    'name' => 'Delete ' . $title_part,
                    'parent_idt' => $plural_idt_part . '_list',
                    'order' => $order,
                    'id' => (string) Uuid::generate(4),
                ],
            ]);
    }

    public static function insertPermission($table_name, $permission_group, $order, $title, $idt, $parent_idt)
    {
        \DB::table($table_name)
            ->insert([
                [
                    'group' => $permission_group,
                    'idt' => $idt,
                    'name' => $title,
                    'parent_idt' => $parent_idt,
                    'order' => $order,
                    'id' => (string) Uuid::generate(4),
                ]
            ]);
    }
}