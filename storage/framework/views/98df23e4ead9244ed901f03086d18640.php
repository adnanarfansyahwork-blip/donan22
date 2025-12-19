<footer class="bg-gray-900 text-gray-300 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <a href="<?php echo e(route('home')); ?>" class="inline-block">
                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Donan22" class="h-10 w-auto">
                </a>
                <p class="mt-4 text-gray-400 max-w-md">
                    Your trusted source for software downloads, mobile apps, and IT learning tutorials. 
                    Stay updated with the latest technology.
                </p>
                <div class="flex space-x-4 mt-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="bi bi-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="bi bi-twitter-x text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="bi bi-youtube text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="bi bi-instagram text-xl"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo e(route('software.index')); ?>" class="text-gray-400 hover:text-white transition-colors">Software</a></li>
                    <li><a href="<?php echo e(route('mobile-apps.index')); ?>" class="text-gray-400 hover:text-white transition-colors">Mobile Apps</a></li>
                    <li><a href="<?php echo e(route('tutorials.index')); ?>" class="text-gray-400 hover:text-white transition-colors">Tutorials</a></li>
                    <li><a href="<?php echo e(route('categories.index')); ?>" class="text-gray-400 hover:text-white transition-colors">Categories</a></li>
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h3 class="text-white font-semibold mb-4">Support</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo e(route('about')); ?>" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    <li><a href="<?php echo e(route('privacy')); ?>" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="<?php echo e(route('terms')); ?>" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                &copy; <?php echo e(date('Y')); ?> Donan22. All rights reserved.
            </p>
            <p class="text-gray-500 text-sm mt-2 md:mt-0">
                Built with <i class="bi bi-heart-fill text-red-500"></i> using Laravel
            </p>
        </div>
    </div>
</footer>
<?php /**PATH /home/u828471719/domains/donan22.com/public_html/resources/views/layouts/partials/footer.blade.php ENDPATH**/ ?>