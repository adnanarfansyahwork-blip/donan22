<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - Donan22</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <?php if(file_exists(public_path('build/manifest.json'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        <link rel="stylesheet" href="/build/assets/app-BwEXT_m1.css">
        <script src="/build/assets/app-CAiCLEjY.js" defer></script>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: true }" x-cloak>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-gray-900 text-white transition-all duration-300 flex flex-col fixed h-full z-30">
            <!-- Logo -->
            <div class="h-16 flex items-center px-4 border-b border-gray-800">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3">
                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Donan22" class="h-8 w-auto">
                    <span x-show="sidebarOpen" class="text-lg font-semibold">Admin Panel</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.dashboard*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-speedometer2 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </a>

                <!-- Posts -->
                <a href="<?php echo e(route('admin.posts.index')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.posts.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-file-earmark-text text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Posts</span>
                </a>

                <!-- Categories -->
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-folder text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Categories</span>
                </a>

                <!-- Tags -->
                <a href="<?php echo e(route('admin.tags.index')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.tags.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-tags text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Tags</span>
                </a>

                <!-- Comments -->
                <a href="<?php echo e(route('admin.comments.index')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.comments.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-chat-dots text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Comments</span>
                    <?php $pendingCount = \App\Models\Comment::pending()->count(); ?>
                    <?php if($pendingCount > 0): ?>
                        <span x-show="sidebarOpen" class="ml-auto bg-red-500 text-xs px-2 py-0.5 rounded-full"><?php echo e($pendingCount); ?></span>
                    <?php endif; ?>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-700">
                    <p x-show="sidebarOpen" class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Manage</p>
                </div>

                <!-- Users -->
                <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.users.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-people text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Users</span>
                </a>

                <!-- Analytics -->
                <a href="<?php echo e(route('admin.analytics')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.analytics*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-graph-up text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Analytics</span>
                </a>

                <!-- Sitemap & SEO -->
                <a href="<?php echo e(route('admin.sitemap.index')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.sitemap.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-map text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Sitemap</span>
                </a>

                <!-- Settings -->
                <a href="<?php echo e(route('admin.settings')); ?>" class="flex items-center px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.settings') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800'); ?>">
                    <i class="bi bi-gear text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3">Settings</span>
                </a>
            </nav>

            <!-- User -->
            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center">
                    <img src="<?php echo e($currentAdmin->avatar_url ?? '/assets/images/default-avatar.png'); ?>" class="w-10 h-10 rounded-full">
                    <div x-show="sidebarOpen" class="ml-3">
                        <div class="text-sm font-medium"><?php echo e($currentAdmin->name ?? 'Admin'); ?></div>
                        <a href="<?php echo e(route('home')); ?>" class="text-xs text-gray-400 hover:text-white">View Site</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="flex-1 transition-all duration-300">
            <!-- Top Bar -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 sticky top-0 z-20">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                    <i class="bi bi-list text-xl"></i>
                </button>

                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('home')); ?>" target="_blank" class="text-gray-500 hover:text-gray-700" title="View Site">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    <a href="<?php echo e(route('admin.profile')); ?>" class="text-gray-500 hover:text-gray-700" title="Profile">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-gray-500 hover:text-red-600" title="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <?php if(session('success')): ?>
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <!-- Alpine.js Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/u828471719/domains/donan22.com/public_html/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>