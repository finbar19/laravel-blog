<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\User;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('permissions')->truncate();
        //crud Post
        $crudPost = new Permission();
        $crudPost->name = "crud-post";
        $crudPost->save();

        //crud Post
        $updateOthersPost = new Permission();
        $updateOthersPost->name = "update-others-post";
        $updateOthersPost->save();

        //crud Post
        $deletOthersPost = new Permission();
        $deletOthersPost->name = "delete-others-post";
        $deletOthersPost->save();

        //crud Post
        $crudCategory = new Permission();
        $crudCategory->name = "crud-category";
        $crudCategory->save();

        //crud Post
        $crudUser = new Permission();
        $crudUser->name = "crud-user";
        $crudUser->save();

        $admin = Role::whereName('admin')->first();
        $editor = Role::whereName('editor')->first();
        $author = Role::whereName('author')->first();

        $admin->detachPermissions([$crudPost, $updateOthersPost, $deletOthersPost, $crudCategory, $crudUser]);
        $editor->detachPermissions([$crudPost, $updateOthersPost, $deletOthersPost, $crudCategory]);
        $author->detachPermission($crudPost);

        $admin->attachPermissions([$crudPost, $updateOthersPost, $deletOthersPost, $crudCategory, $crudUser]);
        $editor->attachPermissions([$crudPost, $updateOthersPost, $deletOthersPost, $crudCategory]);
        $author->attachPermission($crudPost);
    }
}
