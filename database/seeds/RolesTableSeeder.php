<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('roles')->truncate();

        // Create Admin Role
        $admin = new Role();
        $admin->name = "admin";
        $admin->display_name = "Admin";
        $admin->save();

        // Create Editor Role
        $editor = new Role();
        $editor->name = "editor";
        $editor->display_name = "Editor";
        $editor->save();

        // Create Author Role
        $author = new Role();
        $author->name = "author";
        $author->display_name = "Author";
        $author->save();

        $user1 = User::find(1);
        $user1->detachRole($admin);
        $user1->attachRole($admin);

        $user1 = User::find(2);
        $user1->detachRole($editor);
        $user1->attachRole($editor);

        $user1 = User::find(3);
        $user1->detachRole($author);
        $user1->attachRole($author);
    }
}
