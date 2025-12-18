<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MigrateFromOriginalSeeder extends Seeder
{
    protected $sourceDb = 'donan22_original';
    protected $targetDb = 'donanlaravel';

    public function run(): void
    {
        $this->command->info('Starting data migration from donan22_original...');

        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // 1. Migrate Post Types
        $this->migratePostTypes();

        // 2. Migrate Categories
        $this->migrateCategories();

        // 3. Migrate Administrators
        $this->migrateAdministrators();

        // 4. Migrate Posts
        $this->migratePosts();

        // 5. Migrate Monetized Links
        $this->migrateMonetizedLinks();

        // 6. Migrate Page Views
        $this->migratePageViews();

        // 7. Migrate Settings
        $this->migrateSettings();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Data migration completed successfully!');
    }

    protected function migratePostTypes(): void
    {
        $this->command->info('Migrating post types...');

        $postTypes = DB::select("SELECT * FROM {$this->sourceDb}.post_types");
        
        foreach ($postTypes as $type) {
            DB::table('post_types')->updateOrInsert(
                ['slug' => $type->slug],
                [
                    'name' => $type->name,
                    'slug' => $type->slug,
                    'description' => $type->description ?? null,
                    'icon' => $type->icon ?? null,
                    'is_active' => $type->is_active ?? 1,
                    'created_at' => $type->created_at ?? now(),
                    'updated_at' => $type->updated_at ?? now(),
                ]
            );
        }

        $this->command->info('Post types migrated: ' . count($postTypes));
    }

    protected function migrateCategories(): void
    {
        $this->command->info('Migrating categories...');

        $categories = DB::select("SELECT * FROM {$this->sourceDb}.categories ORDER BY parent_id ASC, sort_order ASC");
        
        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat->slug],
                [
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'description' => $cat->description,
                    'icon_url' => $cat->icon_url,
                    'color_code' => $cat->color_code,
                    'parent_id' => $cat->parent_id,
                    'image' => $cat->image,
                    'sort_order' => $cat->sort_order ?? 0,
                    'meta_title' => $cat->meta_title,
                    'meta_description' => $cat->meta_description,
                    'is_active' => $cat->status === 'active' ? 1 : 0,
                    'created_at' => $cat->created_at ?? now(),
                    'updated_at' => $cat->updated_at ?? now(),
                ]
            );
        }

        $this->command->info('Categories migrated: ' . count($categories));
    }

    protected function migrateAdministrators(): void
    {
        $this->command->info('Migrating administrators...');

        $admins = DB::select("SELECT * FROM {$this->sourceDb}.administrators");
        
        foreach ($admins as $admin) {
            DB::table('administrators')->updateOrInsert(
                ['email' => $admin->email],
                [
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'password_hash' => $admin->password_hash ?? Hash::make('admin123'),
                    'full_name' => $admin->full_name ?? $admin->username,
                    'role' => $admin->role ?? 'admin',
                    'avatar' => $admin->avatar ?? null,
                    'status' => $admin->status ?? 'active',
                    'last_login' => $admin->last_login ?? null,
                    'login_attempts' => $admin->login_attempts ?? 0,
                    'last_login_ip' => $admin->last_login_ip ?? null,
                    'last_login_at' => $admin->last_login_at ?? null,
                    'failed_login_attempts' => $admin->failed_login_attempts ?? 0,
                    'two_factor_enabled' => $admin->two_factor_enabled ?? 0,
                    'two_factor_secret' => $admin->two_factor_secret ?? null,
                    'created_at' => $admin->created_at ?? now(),
                    'updated_at' => $admin->updated_at ?? now(),
                ]
            );
        }

        $this->command->info('Administrators migrated: ' . count($admins));
    }

    protected function migratePosts(): void
    {
        $this->command->info('Migrating posts...');

        // Get post type IDs mapping
        $postTypeMap = [];
        $postTypes = DB::table('post_types')->get();
        foreach ($postTypes as $pt) {
            $postTypeMap[$pt->slug] = $pt->id;
        }

        // Get category IDs mapping (by slug)
        $categoryMap = [];
        $oldCategories = DB::select("SELECT id, slug FROM {$this->sourceDb}.categories");
        $newCategories = DB::table('categories')->get();
        
        foreach ($oldCategories as $oldCat) {
            foreach ($newCategories as $newCat) {
                if ($oldCat->slug === $newCat->slug) {
                    $categoryMap[$oldCat->id] = $newCat->id;
                    break;
                }
            }
        }

        $posts = DB::select("SELECT * FROM {$this->sourceDb}.posts ORDER BY id ASC");
        $count = 0;

        foreach ($posts as $post) {
            // Map post_type to post_type_id
            $postTypeId = null;
            if (!empty($post->post_type)) {
                $postTypeId = $postTypeMap[$post->post_type] ?? null;
            } elseif (!empty($post->post_type_id)) {
                // Find the slug from old post_types table
                $oldType = DB::selectOne("SELECT slug FROM {$this->sourceDb}.post_types WHERE id = ?", [$post->post_type_id]);
                if ($oldType) {
                    $postTypeId = $postTypeMap[$oldType->slug] ?? null;
                }
            }

            // Map category_id
            $categoryId = null;
            if (!empty($post->category_id) && isset($categoryMap[$post->category_id])) {
                $categoryId = $categoryMap[$post->category_id];
            }

            DB::table('posts')->updateOrInsert(
                ['slug' => $post->slug],
                [
                    'post_type_id' => $postTypeId,
                    'category_id' => $categoryId,
                    'post_type' => $post->post_type ?? 'software',
                    'author_id' => $post->author_id ?? 1,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content' => $post->content,
                    'excerpt' => $post->excerpt,
                    'featured_image' => $post->featured_image,
                    'file_size' => $post->file_size,
                    'version' => $post->version,
                    'platform' => $post->platform,
                    'meta_title' => $post->meta_title,
                    'meta_description' => $post->meta_description,
                    'meta_keywords' => $post->meta_keywords,
                    'tags' => $post->meta_keywords, // Use keywords as tags initially
                    'focus_keyword' => $post->focus_keyword,
                    'seo_score' => $post->seo_score,
                    'status' => $post->status ?? 'draft',
                    'featured' => $post->featured ?? 0,
                    'allow_comments' => $post->allow_comments ?? 1,
                    'views' => $post->views ?? $post->view_count ?? 0,
                    'downloads' => $post->downloads ?? $post->download_count ?? 0,
                    'view_count' => $post->view_count ?? 0,
                    'download_count' => $post->download_count ?? 0,
                    'scheduled_at' => $post->scheduled_at,
                    'published_at' => $post->published_at,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'deleted_at' => $post->deleted_at,
                ]
            );
            $count++;
        }

        $this->command->info('Posts migrated: ' . $count);
    }

    protected function migrateMonetizedLinks(): void
    {
        $this->command->info('Migrating monetized links...');

        // Get post ID mapping
        $postMap = [];
        $oldPosts = DB::select("SELECT id, slug FROM {$this->sourceDb}.posts");
        $newPosts = DB::table('posts')->get();
        
        foreach ($oldPosts as $oldPost) {
            foreach ($newPosts as $newPost) {
                if ($oldPost->slug === $newPost->slug) {
                    $postMap[$oldPost->id] = $newPost->id;
                    break;
                }
            }
        }

        $links = DB::select("SELECT * FROM {$this->sourceDb}.monetized_links");
        $count = 0;

        foreach ($links as $link) {
            if (!isset($postMap[$link->post_id])) {
                continue;
            }

            DB::table('monetized_links')->updateOrInsert(
                [
                    'post_id' => $postMap[$link->post_id],
                    'original_url' => $link->original_url ?? $link->url ?? ''
                ],
                [
                    'post_id' => $postMap[$link->post_id],
                    'label' => $link->label ?? 'Download',
                    'original_url' => $link->original_url ?? $link->url ?? '',
                    'monetized_url' => $link->monetized_url ?? $link->url ?? '',
                    'file_size' => $link->file_size ?? null,
                    'click_count' => $link->click_count ?? 0,
                    'is_active' => $link->is_active ?? 1,
                    'created_at' => $link->created_at ?? now(),
                    'updated_at' => $link->updated_at ?? now(),
                ]
            );

            $count++;
        }

        $this->command->info('Monetized links migrated: ' . $count);
    }

    protected function migratePageViews(): void
    {
        $this->command->info('Migrating page views (last 1000)...');

        // Get post ID mapping
        $postMap = [];
        $oldPosts = DB::select("SELECT id, slug FROM {$this->sourceDb}.posts");
        $newPosts = DB::table('posts')->get();
        
        foreach ($oldPosts as $oldPost) {
            foreach ($newPosts as $newPost) {
                if ($oldPost->slug === $newPost->slug) {
                    $postMap[$oldPost->id] = $newPost->id;
                    break;
                }
            }
        }

        $views = DB::select("SELECT * FROM {$this->sourceDb}.page_views ORDER BY id DESC LIMIT 1000");
        $count = 0;

        foreach ($views as $view) {
            $postId = null;
            if (!empty($view->post_id) && isset($postMap[$view->post_id])) {
                $postId = $postMap[$view->post_id];
            }

            DB::table('page_views')->insert([
                'post_id' => $postId,
                'ip_address' => $view->ip_address ?? null,
                'user_agent' => $view->user_agent ?? null,
                'referer' => $view->referer ?? null,
                'device_type' => $view->device_type ?? 'desktop',
                'session_id' => $view->session_id ?? null,
                'created_at' => $view->created_at ?? now(),
            ]);
            $count++;
        }

        $this->command->info('Page views migrated: ' . $count);
    }

    protected function migrateSettings(): void
    {
        $this->command->info('Migrating settings...');

        $settings = DB::select("SELECT * FROM {$this->sourceDb}.settings");
        $count = 0;

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting->option_name ?? $setting->key ?? ''],
                [
                    'key' => $setting->option_name ?? $setting->key ?? '',
                    'value' => $setting->option_value ?? $setting->value ?? '',
                    'created_at' => $setting->created_at ?? now(),
                    'updated_at' => $setting->updated_at ?? now(),
                ]
            );
            $count++;
        }

        $this->command->info('Settings migrated: ' . $count);
    }
}
