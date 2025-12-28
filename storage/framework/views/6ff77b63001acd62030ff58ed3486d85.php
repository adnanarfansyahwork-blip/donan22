

<?php $__env->startSection('title', 'Broadcast Newsletter'); ?>
<?php $__env->startSection('page-title', 'Broadcast to Subscribers'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Broadcast Information</h3>
                <p class="text-sm text-blue-700 mt-1">
                    This email will be sent to <strong><?php echo e($activeCount); ?> active subscriber(s)</strong>. 
                    Make sure your email content is ready before sending.
                </p>
            </div>
        </div>
    </div>

    <!-- Broadcast Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Compose Broadcast Email</h2>
            <p class="text-sm text-gray-500 mt-1">Send a newsletter to all active subscribers</p>
        </div>

        <form action="<?php echo e(route('admin.subscribers.broadcast.send')); ?>" method="POST" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Template Type -->
            <div>
                <label for="template-type" class="block text-sm font-medium text-gray-700 mb-2">
                    Broadcast Type <span class="text-red-500">*</span>
                </label>
                <select id="template-type" onchange="changeTemplate()" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">-- Select Type --</option>
                    <option value="new_release">New Software Release</option>
                    <option value="update">Software Update</option>
                    <option value="tutorial">New Tutorial</option>
                    <option value="announcement">General Announcement</option>
                </select>
            </div>

            <!-- Dynamic Fields Container -->
            <div id="dynamic-fields" class="space-y-6"></div>

            <!-- Hidden Subject (Auto Generated) -->
            <input type="hidden" name="subject" id="subject">

            <!-- Hidden Content (Auto Generated) -->
            <textarea name="content" id="content" class="hidden"></textarea>

            <!-- Actions -->
            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                <a href="<?php echo e(route('admin.subscribers.index')); ?>" 
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                
                <div class="flex gap-3">
                    <button type="button" onclick="previewEmail()" 
                            class="px-4 py-2 border border-primary-600 text-primary-600 rounded-lg hover:bg-primary-50 transition-colors">
                        <i class="bi bi-eye mr-2"></i>Preview
                    </button>
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to send this email to <?php echo e($activeCount); ?> subscribers?')"
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <i class="bi bi-send mr-2"></i>Send Broadcast
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold">Email Preview</h3>
            <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4 overflow-y-auto max-h-[60vh]">
            <div class="border rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-primary-600 to-purple-600 text-white p-6 text-center">
                    <h2 class="text-xl font-bold"><?php echo e(config('app.name')); ?></h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-2">Subject: <span id="preview-subject" class="font-medium text-gray-900"></span></p>
                    <hr class="my-4">
                    <div id="preview-content" class="prose prose-sm max-w-none"></div>
                </div>
                <div class="bg-gray-50 p-4 text-center text-sm text-gray-500 border-t">
                    <p>Unsubscribe link will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
var appName = '<?php echo config("app.name"); ?>';
var siteUrl = '<?php echo config("app.url"); ?>';

var templateFields = {
    new_release: [
        {name: 'software_name', label: 'Software Name', type: 'text', required: true, placeholder: 'e.g., Adobe Photoshop'},
        {name: 'version', label: 'Version', type: 'text', required: true, placeholder: 'e.g., 2024.1'},
        {name: 'download_url', label: 'Download URL', type: 'url', required: true, placeholder: 'e.g., https://yoursite.com/post/software-slug'},
        {name: 'features', label: 'Key Features (one per line)', type: 'textarea', required: true, placeholder: 'New AI tools\nImproved performance\nBug fixes'},
        {name: 'description', label: 'Short Description', type: 'textarea', required: false, placeholder: 'Additional info...'}
    ],
    update: [
        {name: 'software_name', label: 'Software Name', type: 'text', required: true, placeholder: 'e.g., WinRAR'},
        {name: 'version', label: 'New Version', type: 'text', required: true, placeholder: 'e.g., 6.24'},
        {name: 'update_url', label: 'Update Page URL', type: 'url', required: true, placeholder: 'https://yoursite.com/post/update-slug'},
        {name: 'whats_new', label: 'What\'s New (one per line)', type: 'textarea', required: true, placeholder: 'Security patches\nNew features\nPerformance improvements'}
    ],
    tutorial: [
        {name: 'tutorial_title', label: 'Tutorial Title', type: 'text', required: true, placeholder: 'e.g., How to Use Photoshop for Beginners'},
        {name: 'tutorial_url', label: 'Tutorial URL', type: 'url', required: true, placeholder: 'https://yoursite.com/post/tutorial-slug'},
        {name: 'topics', label: 'Topics Covered (one per line)', type: 'textarea', required: true, placeholder: 'Basic tools\nLayers and masks\nColor correction'},
        {name: 'level', label: 'Difficulty Level', type: 'select', required: true, options: ['Beginner', 'Intermediate', 'Advanced']}
    ],
    announcement: [
        {name: 'title', label: 'Announcement Title', type: 'text', required: true, placeholder: 'e.g., Website Maintenance Notice'},
        {name: 'message', label: 'Message', type: 'textarea', required: true, placeholder: 'Your announcement message...'},
        {name: 'link_url', label: 'Link URL (optional)', type: 'url', required: false, placeholder: 'https://yoursite.com/more-info'},
        {name: 'link_text', label: 'Link Text', type: 'text', required: false, placeholder: 'Learn More'}
    ]
};

function changeTemplate() {
    var type = document.getElementById('template-type').value;
    var container = document.getElementById('dynamic-fields');
    
    if (!type) {
        container.innerHTML = '';
        return;
    }
    
    var fields = templateFields[type];
    var html = '<div class="bg-gray-50 p-4 rounded-lg space-y-4">';
    
    fields.forEach(function(field) {
        html += '<div>';
        html += '<label for="' + field.name + '" class="block text-sm font-medium text-gray-700 mb-2">';
        html += field.label;
        if (field.required) html += ' <span class="text-red-500">*</span>';
        html += '</label>';
        
        if (field.type === 'textarea') {
            html += '<textarea id="' + field.name + '" ' + (field.required ? 'required' : '') + ' rows="4" ';
            html += 'placeholder="' + field.placeholder + '" ';
            html += 'class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">';
            html += '</textarea>';
        } else if (field.type === 'select') {
            html += '<select id="' + field.name + '" ' + (field.required ? 'required' : '') + ' ';
            html += 'class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">';
            html += '<option value="">-- Select --</option>';
            field.options.forEach(function(opt) {
                html += '<option value="' + opt + '">' + opt + '</option>';
            });
            html += '</select>';
        } else {
            html += '<input type="' + field.type + '" id="' + field.name + '" ' + (field.required ? 'required' : '') + ' ';
            html += 'placeholder="' + field.placeholder + '" ';
            html += 'class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">';
        }
        html += '</div>';
    });
    
    html += '</div>';
    html += '<button type="button" onclick="generateEmail()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">';
    html += '<i class="bi bi-magic mr-2"></i>Generate Email';
    html += '</button>';
    
    container.innerHTML = html;
}

function generateEmail() {
    var type = document.getElementById('template-type').value;
    var subject = '';
    var content = '';
    
    if (type === 'new_release') {
        var name = document.getElementById('software_name').value;
        var version = document.getElementById('version').value;
        var url = document.getElementById('download_url').value;
        var features = document.getElementById('features').value;
        var desc = document.getElementById('description').value || '';
        
        subject = '🎉 New Release: ' + name + ' v' + version + ' Now Available!';
        content = 'Hi there!\n\n';
        content += 'We\'re excited to announce that ' + name + ' version ' + version + ' is now available for download!\n\n';
        if (desc) content += desc + '\n\n';
        content += '✨ What\'s New:\n';
        features.split('\n').forEach(function(f) {
            if (f.trim()) content += '• ' + f.trim() + '\n';
        });
        content += '\n📥 Download Now:\n' + url + '\n\n';
        content += 'Get it now and enjoy the latest features!\n\n';
        content += 'Best regards,\n' + appName + ' Team';
        
    } else if (type === 'update') {
        var name = document.getElementById('software_name').value;
        var version = document.getElementById('version').value;
        var url = document.getElementById('update_url').value;
        var whatsNew = document.getElementById('whats_new').value;
        
        subject = '🔔 Update Available: ' + name + ' v' + version;
        content = 'Hello!\n\n';
        content += name + ' has been updated to version ' + version + '!\n\n';
        content += '🆕 What\'s New:\n';
        whatsNew.split('\n').forEach(function(w) {
            if (w.trim()) content += '• ' + w.trim() + '\n';
        });
        content += '\n📥 Get the Update:\n' + url + '\n\n';
        content += 'Update now to get the latest improvements!\n\n';
        content += 'Best regards,\n' + appName + ' Team';
        
    } else if (type === 'tutorial') {
        var title = document.getElementById('tutorial_title').value;
        var url = document.getElementById('tutorial_url').value;
        var topics = document.getElementById('topics').value;
        var level = document.getElementById('level').value;
        
        subject = '📚 New Tutorial: ' + title;
        content = 'Hi there!\n\n';
        content += 'We\'ve just published a new ' + level.toLowerCase() + ' tutorial that you might find helpful!\n\n';
        content += '📖 Tutorial: ' + title + '\n\n';
        content += '✅ Topics Covered:\n';
        topics.split('\n').forEach(function(t) {
            if (t.trim()) content += '• ' + t.trim() + '\n';
        });
        content += '\n🔗 Read the Tutorial:\n' + url + '\n\n';
        content += 'Happy learning!\n\n';
        content += 'Best regards,\n' + appName + ' Team';
        
    } else if (type === 'announcement') {
        var title = document.getElementById('title').value;
        var message = document.getElementById('message').value;
        var linkUrl = document.getElementById('link_url').value;
        var linkText = document.getElementById('link_text').value || 'Learn More';
        
        subject = '📢 ' + title;
        content = 'Hello!\n\n';
        content += message + '\n\n';
        if (linkUrl) {
            content += '🔗 ' + linkText + ':\n' + linkUrl + '\n\n';
        }
        content += 'Thank you for being part of our community!\n\n';
        content += 'Best regards,\n' + appName + ' Team';
    }
    
    document.getElementById('subject').value = subject;
    document.getElementById('content').value = content;
    
    // Show success message
    alert('✅ Email generated successfully! You can preview before sending.');
}

function previewEmail() {
    const subject = document.getElementById('subject').value || '(No subject)';
    const content = document.getElementById('content').value || '(No content)';
    
    document.getElementById('preview-subject').textContent = subject;
    document.getElementById('preview-content').innerHTML = content.replace(/\n/g, '<br>');
    document.getElementById('preview-modal').classList.remove('hidden');
}

function closePreview() {
    document.getElementById('preview-modal').classList.add('hidden');
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePreview();
    }
});

// Close modal on backdrop click
document.getElementById('preview-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePreview();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/subscribers/broadcast.blade.php ENDPATH**/ ?>