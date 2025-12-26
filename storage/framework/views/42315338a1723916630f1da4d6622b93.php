<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50" x-data="{ mobileMenu: false, searchOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Main Nav -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2">
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Donan22" class="h-8 w-auto">
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-8 sm:flex sm:space-x-1">
                    <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium <?php echo e(request()->routeIs('home') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors">
                        <i class="bi bi-house-door mr-1.5"></i> Home
                    </a>
                    <a href="<?php echo e(route('software.index')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium <?php echo e(request()->routeIs('software.*') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors">
                        <i class="bi bi-box-seam mr-1.5"></i> Software
                    </a>
                    <a href="<?php echo e(route('mobile-apps.index')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium <?php echo e(request()->routeIs('mobile-apps.*') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors">
                        <i class="bi bi-phone mr-1.5"></i> Mobile Apps
                    </a>
                    <a href="<?php echo e(route('tutorials.index')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium <?php echo e(request()->routeIs('tutorials.*') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors">
                        <i class="bi bi-book mr-1.5"></i> Tutorials
                    </a>
                    <a href="<?php echo e(route('categories.index')); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium <?php echo e(request()->routeIs('categories.*') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors">
                        <i class="bi bi-grid mr-1.5"></i> Categories
                    </a>
                </div>
            </div>
            
            <!-- Right Side -->
            <div class="flex items-center space-x-3">
                <!-- Search Button -->
                <button @click="searchOpen = !searchOpen" class="p-2 text-gray-500 hover:text-primary-600 transition-colors">
                    <i class="bi bi-search text-lg"></i>
                </button>
                
                <!-- Auth Buttons -->
                <?php if(auth()->guard()->guest()): ?>
                    
                <?php else: ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="w-8 h-8 rounded-full">
                            <span class="hidden sm:block text-sm font-medium text-gray-700"><?php echo e(auth()->user()->name); ?></span>
                            <i class="bi bi-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <?php if(auth()->user()->hasRole('admin')): ?>
                                <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                                </a>
                            <?php endif; ?>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="bi bi-person mr-2"></i> Profile
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="bi bi-box-arrow-right mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Mobile menu button -->
                <button @click="mobileMenu = !mobileMenu" class="sm:hidden p-2 text-gray-500 hover:text-primary-600">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Search Panel -->
    <div x-show="searchOpen" x-cloak @click.away="searchOpen = false" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="absolute left-0 right-0 bg-white border-b border-gray-200 shadow-lg p-4">
        <form action="<?php echo e(route('search')); ?>" method="GET" class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="search" name="q" placeholder="Search software, apps, tutorials..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       value="<?php echo e(request('q')); ?>" autofocus>
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </form>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak class="sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="<?php echo e(route('home')); ?>" class="block px-4 py-2 text-base font-medium <?php echo e(request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : 'text-gray-600'); ?>">
                <i class="bi bi-house-door mr-2"></i> Home
            </a>
            <a href="<?php echo e(route('software.index')); ?>" class="block px-4 py-2 text-base font-medium <?php echo e(request()->routeIs('software.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-600'); ?>">
                <i class="bi bi-box-seam mr-2"></i> Software
            </a>
            <a href="<?php echo e(route('mobile-apps.index')); ?>" class="block px-4 py-2 text-base font-medium <?php echo e(request()->routeIs('mobile-apps.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-600'); ?>">
                <i class="bi bi-phone mr-2"></i> Mobile Apps
            </a>
            <a href="<?php echo e(route('tutorials.index')); ?>" class="block px-4 py-2 text-base font-medium <?php echo e(request()->routeIs('tutorials.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-600'); ?>">
                <i class="bi bi-book mr-2"></i> Tutorials
            </a>
            <a href="<?php echo e(route('categories.index')); ?>" class="block px-4 py-2 text-base font-medium <?php echo e(request()->routeIs('categories.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-600'); ?>">
                <i class="bi bi-grid mr-2"></i> Categories
            </a>
        </div>
        <?php if(auth()->guard()->guest()): ?>
            
        <?php endif; ?>
    </div>
</nav>
<?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/layouts/partials/navigation.blade.php ENDPATH**/ ?>