<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SeedAdminRoleAndUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $admin = DB::table('admin')->where("email", "=", "admin@admin.com")->first();
        if (Schema::hasTable('roles')) {
            DB::transaction(function () use ($admin) {
                $role = DB::table('roles')
                    ->where('name', "=", "administrator")
                    ->where("guard_name", "=", "admin")
                    ->first();
                if (!$role) {
                    $roleId = DB::table('roles')->insertGetId([
                        "name" => "administrator",
                        "guard_name" => "admin",
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                } else {
                    $roleId  = $role->id;
                }

                $admin = DB::table('admin')->where("email", "=", "admin@admin.com")->first();
                if (!$admin) {
                    $adminId = DB::table('admin')->insertGetId([
                        "name" => "Administrator",
                        "email" => "admin@admin.com",
                        "password" => Hash::make("password"),
                        "created_at" => now(),
                        "updated_at" => now(),
                        "email_verified_at" => now(),
                        "lang" => 'en',
                    ]);
                } else {
                    $adminId = $admin->id;
                }
                $exists = DB::table("model_has_roles")->where("role_id","=", $roleId)->where("model_id","=", $adminId)->where("model_type","=",\App\Models\Admin::class)->exists();
                if (!$exists) {
                    DB::table('model_has_roles')->insert([
                        "role_id" => $roleId,
                        "model_id" => $adminId,
                        "model_type" => \App\Models\Admin::class,
                    ]);
                }
            });
        } else {
            abort(500, "The roles table does not exist. Ensure you run the permissions migration before running this seeder.");
        } 
        
        $user = DB::table('users')->where("email", "=", "user@admin.com")->first();
        if (Schema::hasTable('roles')) {
            DB::transaction(function () use ($user) {
                
                $user = DB::table('users')->where("email", "=", "admin@admin.com")->first();
                if (!$user) {
                    $userId = DB::table('users')->insertGetId([
                        "name" => "User",
                        "email" => "user@user.com",
                        "password" => Hash::make("123123"),
                        "created_at" => now(),
                        "updated_at" => now(),
                        "email_verified_at" => now(),
                        "lang" => 'en',
                    ]);
                } else {
                    $userId = $user->id;
                }
                
                $role = DB::table('roles')
                    ->where('name', "=", "user")
                    ->where("guard_name", "=", "web")
                    ->first();
                if (!$role) {
                    $roleId = DB::table('roles')->insertGetId([
                        "name" => "user",
                        "guard_name" => "web",
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                } else {
                    $roleId  = $role->id;
                }

                
                $exists = DB::table("model_has_roles")->where("role_id","=", $roleId)->where("model_id","=", $userId)->where("model_type","=",\App\Models\User::class)->exists();
                if (!$exists) {
                    DB::table('model_has_roles')->insert([
                        "role_id" => $roleId,
                        "model_id" => $userId,
                        "model_type" => \App\Models\User::class,
                    ]);
                }
            });
        } else {
            abort(500, "The roles table does not exist. Ensure you run the permissions migration before running this seeder.");
        }
    }
}
