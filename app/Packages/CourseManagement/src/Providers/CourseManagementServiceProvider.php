<?php

namespace App\Packages\CourseManagement\Providers;

use App\Services\MenuItem;
use App\Services\MenuService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CourseManagementServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->loadViewsFrom(__DIR__.'/../Views', 'course-management');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->registerMenuItems();

        $this->callAfterResolving('migrator', function () {
            $this->registerPermissions();
        });
    }

    public function register(): void
    {
        //
    }

    private function registerMenuItems(): void
    {
        $this->booted(function () {
            if (! $this->app->bound(MenuService::class)) {
                return;
            }

            $menu = $this->app->make(MenuService::class);
            $icon = '<svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>';

            $menu->addItem('courses', new MenuItem('Courses', $icon, 'courses.index', 'courses', 'courses.*'));
            $menu->addItem('courses', new MenuItem('Enrollments', $icon, 'courses.enrollments.index', 'courses', 'courses.enrollments.*'));
        });
    }

    private function registerPermissions(): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('roles')) {
            return;
        }

        try {
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $permissions = [
                'view-courses' => 'View courses',
                'create-courses' => 'Create courses',
                'edit-courses' => 'Edit courses',
                'delete-courses' => 'Delete courses',
            ];

            foreach ($permissions as $name => $description) {
                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['description' => $description, 'module_name' => 'courses']
                );
            }

            $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
            $admin->givePermissionTo(array_keys($permissions));

            $teacher = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
            if (! $teacher->hasPermissionTo('view-courses')) {
                $teacher->givePermissionTo('view-courses');
            }
        } catch (\Exception) {
            // Silently skip — permissions will be seeded on next boot once DB is ready
        }
    }
}
