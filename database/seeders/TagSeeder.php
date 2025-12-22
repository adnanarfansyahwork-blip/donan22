<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Platform Tags
            ['name' => 'Windows', 'slug' => 'windows', 'description' => 'Windows operating system'],
            ['name' => 'Mac', 'slug' => 'mac', 'description' => 'macOS operating system'],
            ['name' => 'macOS', 'slug' => 'macos', 'description' => 'Apple macOS'],
            ['name' => 'Linux', 'slug' => 'linux', 'description' => 'Linux operating system'],
            ['name' => '64-bit', 'slug' => '64-bit', 'description' => '64-bit architecture'],
            ['name' => '32-bit', 'slug' => '32-bit', 'description' => '32-bit architecture'],
            
            // Software Type Tags
            ['name' => 'Full Version', 'slug' => 'full-version', 'description' => 'Full version software'],
            ['name' => 'Portable', 'slug' => 'portable', 'description' => 'Portable version without installation'],
            ['name' => 'Crack', 'slug' => 'crack', 'description' => 'Cracked software'],
            ['name' => 'Patch', 'slug' => 'patch', 'description' => 'Software patch'],
            ['name' => 'Keygen', 'slug' => 'keygen', 'description' => 'Key generator'],
            ['name' => 'Serial', 'slug' => 'serial', 'description' => 'Serial number'],
            ['name' => 'Free Download', 'slug' => 'free-download', 'description' => 'Free to download'],
            ['name' => 'Gratis', 'slug' => 'gratis', 'description' => 'Gratis/Free'],
            ['name' => 'Terbaru', 'slug' => 'terbaru', 'description' => 'Latest version'],
            ['name' => '2025', 'slug' => '2025', 'description' => 'Year 2025 version'],
            ['name' => 'Pre-Activated', 'slug' => 'pre-activated', 'description' => 'Pre-activated software'],
            ['name' => 'Repack', 'slug' => 'repack', 'description' => 'Repacked installer'],
            ['name' => 'Standalone', 'slug' => 'standalone', 'description' => 'Standalone installer'],
            ['name' => 'Offline Installer', 'slug' => 'offline-installer', 'description' => 'Offline installer'],
            
            // Popular Software Brands
            ['name' => 'Adobe', 'slug' => 'adobe', 'description' => 'Adobe software products'],
            ['name' => 'Microsoft', 'slug' => 'microsoft', 'description' => 'Microsoft products'],
            ['name' => 'Autodesk', 'slug' => 'autodesk', 'description' => 'Autodesk software'],
            ['name' => 'Corel', 'slug' => 'corel', 'description' => 'Corel products'],
            ['name' => 'Avast', 'slug' => 'avast', 'description' => 'Avast antivirus'],
            ['name' => 'Kaspersky', 'slug' => 'kaspersky', 'description' => 'Kaspersky antivirus'],
            ['name' => 'AVG', 'slug' => 'avg', 'description' => 'AVG antivirus'],
            
            // Tutorial & Tips Tags
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'description' => 'Tutorial and guides'],
            ['name' => 'How To', 'slug' => 'how-to', 'description' => 'How-to guides'],
            ['name' => 'Cara Install', 'slug' => 'cara-install', 'description' => 'Installation guide'],
            ['name' => 'Fix Error', 'slug' => 'fix-error', 'description' => 'Error fixing guides'],
            ['name' => 'Troubleshooting', 'slug' => 'troubleshooting', 'description' => 'Troubleshooting guides'],
            ['name' => 'Tips', 'slug' => 'tips', 'description' => 'Tips and tricks'],
            ['name' => 'Panduan', 'slug' => 'panduan', 'description' => 'Guide in Indonesian'],
            ['name' => 'Step by Step', 'slug' => 'step-by-step', 'description' => 'Step by step guides'],
            
            // Technical Tags
            ['name' => 'System Requirements', 'slug' => 'system-requirements', 'description' => 'System requirements'],
            ['name' => 'Minimum Spec', 'slug' => 'minimum-spec', 'description' => 'Minimum specifications'],
            ['name' => 'Recommended Spec', 'slug' => 'recommended-spec', 'description' => 'Recommended specifications'],
            ['name' => 'File Size', 'slug' => 'file-size', 'description' => 'File size information'],
            ['name' => 'Compressed', 'slug' => 'compressed', 'description' => 'Compressed file'],
            ['name' => 'Password Protected', 'slug' => 'password-protected', 'description' => 'Password protected archive'],
            
            // Software Categories as Tags
            ['name' => 'Video Editor', 'slug' => 'video-editor', 'description' => 'Video editing software'],
            ['name' => 'Photo Editor', 'slug' => 'photo-editor', 'description' => 'Photo editing software'],
            ['name' => 'Audio Editor', 'slug' => 'audio-editor', 'description' => 'Audio editing software'],
            ['name' => 'Office Suite', 'slug' => 'office-suite', 'description' => 'Office productivity suite'],
            ['name' => 'Antivirus', 'slug' => 'antivirus', 'description' => 'Antivirus software'],
            ['name' => 'Download Manager', 'slug' => 'download-manager', 'description' => 'Download manager tools'],
            ['name' => 'Screen Recorder', 'slug' => 'screen-recorder', 'description' => 'Screen recording software'],
            ['name' => 'IDE', 'slug' => 'ide', 'description' => 'Integrated Development Environment'],
            ['name' => 'Code Editor', 'slug' => 'code-editor', 'description' => 'Code editor'],
            ['name' => 'CAD', 'slug' => 'cad', 'description' => 'CAD software'],
            ['name' => '3D Modeling', 'slug' => '3d-modeling', 'description' => '3D modeling software'],
            ['name' => 'Animation', 'slug' => 'animation', 'description' => 'Animation software'],
            ['name' => 'VPN', 'slug' => 'vpn', 'description' => 'VPN software'],
            ['name' => 'Backup', 'slug' => 'backup', 'description' => 'Backup software'],
            ['name' => 'Data Recovery', 'slug' => 'data-recovery', 'description' => 'Data recovery tools'],
            ['name' => 'System Optimizer', 'slug' => 'system-optimizer', 'description' => 'System optimization tools'],
            ['name' => 'Cleaner', 'slug' => 'cleaner', 'description' => 'System cleaner tools'],
            
            // Game Tags
            ['name' => 'PC Game', 'slug' => 'pc-game', 'description' => 'PC games'],
            ['name' => 'Action', 'slug' => 'action', 'description' => 'Action games'],
            ['name' => 'Adventure', 'slug' => 'adventure', 'description' => 'Adventure games'],
            ['name' => 'RPG', 'slug' => 'rpg', 'description' => 'Role-playing games'],
            ['name' => 'Simulation', 'slug' => 'simulation', 'description' => 'Simulation games'],
            ['name' => 'Strategy', 'slug' => 'strategy', 'description' => 'Strategy games'],
            ['name' => 'Multiplayer', 'slug' => 'multiplayer', 'description' => 'Multiplayer games'],
            ['name' => 'Single Player', 'slug' => 'single-player', 'description' => 'Single player games'],
            
            // Popular Software Names
            ['name' => 'Photoshop', 'slug' => 'photoshop', 'description' => 'Adobe Photoshop'],
            ['name' => 'Illustrator', 'slug' => 'illustrator', 'description' => 'Adobe Illustrator'],
            ['name' => 'Premiere Pro', 'slug' => 'premiere-pro', 'description' => 'Adobe Premiere Pro'],
            ['name' => 'After Effects', 'slug' => 'after-effects', 'description' => 'Adobe After Effects'],
            ['name' => 'AutoCAD', 'slug' => 'autocad', 'description' => 'Autodesk AutoCAD'],
            ['name' => 'CorelDRAW', 'slug' => 'coreldraw', 'description' => 'CorelDRAW Graphics Suite'],
            ['name' => 'Microsoft Office', 'slug' => 'microsoft-office', 'description' => 'Microsoft Office'],
            ['name' => 'Visual Studio', 'slug' => 'visual-studio', 'description' => 'Microsoft Visual Studio'],
            ['name' => 'IDM', 'slug' => 'idm', 'description' => 'Internet Download Manager'],
            ['name' => 'WinRAR', 'slug' => 'winrar', 'description' => 'WinRAR archiver'],
            ['name' => 'CCleaner', 'slug' => 'ccleaner', 'description' => 'CCleaner system cleaner'],
            
            // Misc Tags
            ['name' => 'Beginner Friendly', 'slug' => 'beginner-friendly', 'description' => 'Suitable for beginners'],
            ['name' => 'Professional', 'slug' => 'professional', 'description' => 'Professional level software'],
            ['name' => 'Open Source', 'slug' => 'open-source', 'description' => 'Open source software'],
            ['name' => 'Multilingual', 'slug' => 'multilingual', 'description' => 'Supports multiple languages'],
            ['name' => 'Bahasa Indonesia', 'slug' => 'bahasa-indonesia', 'description' => 'Indonesian language support'],
        ];
        
        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
