<?php $__env->startSection('title', 'Sitemap & SEO'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Sitemap & SEO</h1>
    <p class="text-gray-500">Monitor and manage your sitemap and robots.txt</p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Published Posts</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_posts']); ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-file-earmark-text text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Active Categories</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_categories']); ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-folder text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Sitemap URLs</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['sitemap_urls']); ?></p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-link-45deg text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Sitemap Status</p>
                <?php if($sitemapExists): ?>
                    <p class="text-lg font-bold text-green-600"><i class="bi bi-check-circle"></i> Active</p>
                <?php else: ?>
                    <p class="text-lg font-bold text-red-600"><i class="bi bi-x-circle"></i> Missing</p>
                <?php endif; ?>
            </div>
            <div class="w-10 h-10 <?php echo e($sitemapExists ? 'bg-green-100' : 'bg-red-100'); ?> rounded-lg flex items-center justify-center">
                <i class="bi bi-map <?php echo e($sitemapExists ? 'text-green-600' : 'text-red-600'); ?>"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Sitemap Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="bi bi-map text-primary-600 mr-2"></i>Sitemap
                    </h2>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="bi bi-check-circle mr-1"></i> Auto-generate enabled (on post create/update/delete)
                    </p>
                </div>
                <form action="<?php echo e(route('admin.sitemap.generate')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                        <i class="bi bi-arrow-clockwise mr-1"></i> Regenerate
                    </button>
                </form>
            </div>
        </div>
        
        <div class="p-6">
            <?php if($sitemapExists): ?>
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">File Size</span>
                        <span class="font-medium"><?php echo e(number_format($sitemapInfo['size'] / 1024, 2)); ?> KB</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Last Modified</span>
                        <span class="font-medium"><?php echo e(date('d M Y, H:i:s', $sitemapInfo['modified'])); ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-500">Total URLs</span>
                        <span class="font-medium"><?php echo e(count($urls)); ?></span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Public URL</span>
                        <a href="<?php echo e(url('sitemap.xml')); ?>" target="_blank" class="text-primary-600 hover:text-primary-700">
                            <?php echo e(url('sitemap.xml')); ?> <i class="bi bi-box-arrow-up-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- URL Preview -->
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900 mb-3">All URLs (<?php echo e(count($urls)); ?>)</h3>
                    <div class="bg-gray-50 rounded-lg p-4 max-h-96 overflow-y-auto">
                        <ul class="space-y-2 text-sm">
                            <?php $__currentLoopData = $urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-start">
                                    <i class="bi bi-link text-gray-400 mt-0.5 mr-2"></i>
                                    <div>
                                        <a href="<?php echo e($url['loc']); ?>" target="_blank" class="text-primary-600 hover:underline break-all">
                                            <?php echo e($url['loc']); ?>

                                        </a>
                                        <?php if($url['priority']): ?>
                                            <span class="ml-2 text-xs bg-gray-200 px-2 py-0.5 rounded">P: <?php echo e($url['priority']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="bi bi-map text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">Sitemap not found. Click the button above to generate it.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Robots.txt -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                <i class="bi bi-robot text-primary-600 mr-2"></i>Robots.txt
            </h2>
        </div>
        
        <div class="p-6">
            <?php if($robotsExists): ?>
                <form action="<?php echo e(route('admin.sitemap.robots')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Edit robots.txt</label>
                        <textarea name="content" rows="12" class="w-full font-mono text-sm border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"><?php echo e($robotsContent); ?></textarea>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="<?php echo e(url('robots.txt')); ?>" target="_blank" class="text-sm text-primary-600 hover:text-primary-700">
                            <i class="bi bi-box-arrow-up-right mr-1"></i> View public file
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                            <i class="bi bi-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="bi bi-robot text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">robots.txt not found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- SEO Tools -->
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">
            <i class="bi bi-tools text-primary-600 mr-2"></i>SEO Tools
        </h2>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="https://search.google.com/search-console" target="_blank" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="bi bi-google text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Google Search Console</h3>
                    <p class="text-sm text-gray-500">Monitor search performance</p>
                </div>
            </a>
            
            <a href="https://www.bing.com/webmasters" target="_blank" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="bi bi-microsoft text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Bing Webmaster</h3>
                    <p class="text-sm text-gray-500">Bing search tools</p>
                </div>
            </a>
            
            <a href="https://pagespeed.web.dev/analysis?url=<?php echo e(urlencode(config('app.url'))); ?>" target="_blank" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="bi bi-speedometer2 text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">PageSpeed Insights</h3>
                    <p class="text-sm text-gray-500">Check site performance</p>
                </div>
            </a>
        </div>
        
        <!-- Quick Links -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="font-medium text-gray-900 mb-3">Quick Submit URLs</h3>
            <div class="flex flex-wrap gap-2">
                <a href="https://www.google.com/ping?sitemap=<?php echo e(urlencode(url('sitemap.xml'))); ?>" target="_blank"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                    <i class="bi bi-send mr-1.5"></i> Ping Google
                </a>
                <a href="https://www.bing.com/indexnow?url=<?php echo e(urlencode(url('sitemap.xml'))); ?>&key=YOUR_KEY" target="_blank"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                    <i class="bi bi-send mr-1.5"></i> Submit to IndexNow
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/sitemap/index.blade.php ENDPATH**/ ?>