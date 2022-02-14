<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=RolePermissionSeeder
     *
     * @return void
     */
    public function run()
    {
        $role = config('backpack.permissionmanager.models.role');

        $admin = $role::updateOrCreate(['id' => 1], ['name' => 'Super Admin'])->id;
        $school = $role::updateOrCreate(['id' => 4], ['name' => 'School'])->id;
        $editor = $role::updateOrCreate(['id' => 5], ['name' => 'Editor'])->id;
        $student = $role::updateOrCreate(['id' => 3], ['name' => 'Student'])->id;
        $creator = $role::updateOrCreate(['id' => 6], ['name' => 'Creator'])->id;
        $member = $role::updateOrCreate(['id' => 2], ['name' => 'Member'])->id;

        $this->generatePermission(['id' => 1, 'name' => 'users list'], [$admin]);
        $this->generatePermission(['id' => 2, 'name' => 'users create'], [$admin]);
        $this->generatePermission(['id' => 3, 'name' => 'users update'], [$admin]);
        $this->generatePermission(['id' => 4, 'name' => 'users delete'], [$admin]);
        $this->generatePermission(['id' => 5, 'name' => 'users show'], [$admin]);
        $this->generatePermission(['id' => 6, 'name' => 'users force delete'], [$admin]);
        $this->generatePermission(['id' => 7, 'name' => 'users restore'], [$admin]);

        $this->generatePermission(['id' => 21, 'name' => 'contests list'], [$admin, $school, $student, $editor, $creator]);
        $this->generatePermission(['id' => 22, 'name' => 'contests create'], [$admin, $creator]);
        $this->generatePermission(['id' => 23, 'name' => 'contests update'], [$admin, $creator]);
        $this->generatePermission(['id' => 24, 'name' => 'contests delete'], [$admin, $creator]);
        $this->generatePermission(['id' => 25, 'name' => 'contests show'], [$admin, $school, $student, $editor, $creator]);
        $this->generatePermission(['id' => 26, 'name' => 'contests force delete'], [$admin]);
        $this->generatePermission(['id' => 27, 'name' => 'contests restore'], [$admin]);
        $this->generatePermission(['id' => 28, 'name' => 'contests approve'], [$admin, $editor]);
        $this->generatePermission(['id' => 29, 'name' => 'contests reject'], [$admin, $editor]);

        $this->generatePermission(['id' => 41, 'name' => 'questions list'], [$admin, $school, $editor, $creator]);
        $this->generatePermission(['id' => 42, 'name' => 'questions create'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 43, 'name' => 'questions update'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 44, 'name' => 'questions delete'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 45, 'name' => 'questions show'], [$admin, $school, $editor, $creator]);
        $this->generatePermission(['id' => 46, 'name' => 'questions force delete'], [$admin]);
        $this->generatePermission(['id' => 47, 'name' => 'questions restore'], [$admin]);
        $this->generatePermission(['id' => 48, 'name' => 'questions approve'], [$admin, $editor]);
        $this->generatePermission(['id' => 49, 'name' => 'questions reject'], [$admin, $editor]);

        $this->generatePermission(['id' => 61, 'name' => 'answers list'], [$admin, $school, $editor, $creator]);
        $this->generatePermission(['id' => 62, 'name' => 'answers create'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 63, 'name' => 'answers update'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 64, 'name' => 'answers delete'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 65, 'name' => 'answers show'], [$admin, $school, $editor, $creator]);
        $this->generatePermission(['id' => 66, 'name' => 'answers force delete'], [$admin]);
        $this->generatePermission(['id' => 67, 'name' => 'answers restore'], [$admin]);
        $this->generatePermission(['id' => 68, 'name' => 'answers approve'], [$admin, $editor]);
        $this->generatePermission(['id' => 69, 'name' => 'answers reject'], [$admin, $editor]);

        $this->generatePermission(['id' => 81, 'name' => 'levels list'], [$admin, $school, $editor, $creator]);
        $this->generatePermission(['id' => 82, 'name' => 'levels create'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 83, 'name' => 'levels update'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 84, 'name' => 'levels delete'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 85, 'name' => 'levels show'], [$admin, $editor, $school, $creator]);
        $this->generatePermission(['id' => 86, 'name' => 'levels force delete'], [$admin]);
        $this->generatePermission(['id' => 87, 'name' => 'levels restore'], [$admin]);

        $this->generatePermission(['id' => 101, 'name' => 'workshop list'], [$admin, $editor, $creator]);
        $this->generatePermission(['id' => 102, 'name' => 'workshop create'], [$admin, $creator]);
        $this->generatePermission(['id' => 103, 'name' => 'workshop update'], [$admin, $creator]);
        $this->generatePermission(['id' => 104, 'name' => 'workshop delete'], [$admin, $creator]);
        $this->generatePermission(['id' => 105, 'name' => 'workshop show'], [$admin, $editor, $creator]);
        $this->generatePermission(['id' => 106, 'name' => 'workshop force delete'], [$admin]);
        $this->generatePermission(['id' => 107, 'name' => 'workshop restore'], [$admin]);
        $this->generatePermission(['id' => 108, 'name' => 'workshop approve'], [$admin, $editor]);
        $this->generatePermission(['id' => 109, 'name' => 'workshop reject'], [$admin, $editor]);

        $this->generatePermission(['id' => 121, 'name' => 'documents list'], [$admin, $member, $creator, $editor]);
        $this->generatePermission(['id' => 122, 'name' => 'documents create'], [$admin, $member, $creator]);
        $this->generatePermission(['id' => 123, 'name' => 'documents update'], [$admin, $member, $creator]);
        $this->generatePermission(['id' => 124, 'name' => 'documents delete'], [$admin, $member, $creator]);
        $this->generatePermission(['id' => 125, 'name' => 'documents show'], [$admin, $member, $creator, $editor]);
        $this->generatePermission(['id' => 126, 'name' => 'documents force delete'], [$admin]);
        $this->generatePermission(['id' => 127, 'name' => 'documents restore'], [$admin]);
        $this->generatePermission(['id' => 128, 'name' => 'documents approve'], [$admin, $editor]);
        $this->generatePermission(['id' => 129, 'name' => 'documents reject'], [$admin, $editor]);

        $this->generatePermission(['id' => 141, 'name' => 'students list'], [$admin, $editor, $school, $creator]);
        $this->generatePermission(['id' => 142, 'name' => 'students create'], [$admin, $school]);
        $this->generatePermission(['id' => 143, 'name' => 'students update'], [$admin, $school]);
        $this->generatePermission(['id' => 144, 'name' => 'students delete'], [$admin, $school]);
        $this->generatePermission(['id' => 145, 'name' => 'students show'], [$admin, $editor, $school, $creator]);
        $this->generatePermission(['id' => 146, 'name' => 'students force delete'], [$admin, $school]);
        $this->generatePermission(['id' => 147, 'name' => 'students restore'], [$admin, $school]);

        $this->generatePermission(['id' => 161, 'name' => 'registered contests list'], [$admin, $school, $student]);
        $this->generatePermission(['id' => 162, 'name' => 'registered contests create'], [$admin, $school, $student]);
        $this->generatePermission(['id' => 163, 'name' => 'registered contests update'], [$admin, $school, $student]);
        $this->generatePermission(['id' => 164, 'name' => 'registered contests delete'], [$admin, $school, $student]);
        $this->generatePermission(['id' => 165, 'name' => 'registered contests show'], [$admin, $school, $student]);
        $this->generatePermission(['id' => 166, 'name' => 'registered contests force delete'], [$admin, $school, $student]);
        $this->generatePermission(['id' => 167, 'name' => 'registered contests restore'], [$admin, $school, $student]);

        $this->generatePermission(['id' => 181, 'name' => 'categories list'], [$admin, $school, $editor, $creator]);
        $this->generatePermission(['id' => 182, 'name' => 'categories create'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 183, 'name' => 'categories update'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 184, 'name' => 'categories delete'], [$admin, $school, $creator]);
        $this->generatePermission(['id' => 185, 'name' => 'categories show'], [$admin, $editor, $school, $creator]);
        $this->generatePermission(['id' => 186, 'name' => 'categories force delete'], [$admin]);
        $this->generatePermission(['id' => 187, 'name' => 'categories restore'], [$admin]);

        $this->generatePermission(['id' => 201, 'name' => 'faq list'], [$admin]);
        $this->generatePermission(['id' => 202, 'name' => 'faq create'], [$admin]);
        $this->generatePermission(['id' => 203, 'name' => 'faq update'], [$admin]);
        $this->generatePermission(['id' => 204, 'name' => 'faq delete'], [$admin]);
        $this->generatePermission(['id' => 205, 'name' => 'faq show'], [$admin]);
        $this->generatePermission(['id' => 206, 'name' => 'faq force delete'], [$admin]);
        $this->generatePermission(['id' => 207, 'name' => 'faq restore'], [$admin]);

        $this->generatePermission(['id' => 221, 'name' => 'news list'], [$admin, $editor, $creator]);
        $this->generatePermission(['id' => 222, 'name' => 'news create'], [$admin, $creator]);
        $this->generatePermission(['id' => 223, 'name' => 'news update'], [$admin, $creator]);
        $this->generatePermission(['id' => 224, 'name' => 'news delete'], [$admin, $creator]);
        $this->generatePermission(['id' => 225, 'name' => 'news show'], [$admin, $editor, $creator]);
        $this->generatePermission(['id' => 226, 'name' => 'news force delete'], [$admin]);
        $this->generatePermission(['id' => 227, 'name' => 'news restore'], [$admin]);
        $this->generatePermission(['id' => 228, 'name' => 'news approve'], [$admin, $editor]);
        $this->generatePermission(['id' => 229, 'name' => 'news reject'], [$admin, $editor]);
    }

    protected function generatePermission($data, $roles = [], $updateData = [])
    {
        $perm = config('backpack.permissionmanager.models.permission');

        if (is_array($roles) && count($roles)) {
            if (is_array($updateData) && count($updateData)) {
                $perm::updateOrCreate($data, $updateData)->roles()->sync($roles);
            } else {
                $perm::firstOrCreate($data)->roles()->sync($roles);
            }
        } else {
            if (is_array($updateData) && count($updateData)) {
                $perm::updateOrCreate($data, $updateData);
            } else {
                $perm::firstOrCreate($data);
            }
        }
    }
}
