<?php

return [
    [
        'icon' => 'home',
        'route' => 'dashboard',
        'current' => ['dashboard', 'staff.dashboard'],
        'title' => 'Dashboard',
    ],
    [
        'icon' => 'photo',
        'route' => 'admin.hero-banners.index',
        'current' => 'admin.hero-banners.*',
        'title' => 'Hero Banner',
    ],
    [
        'icon' => 'calendar-days',
        'route' => 'admin.activities.index',
        'current' => 'admin.activities.*',
        'title' => 'Kegiatan',
    ],
    [
        'icon' => 'newspaper',
        'route' => 'admin.beritas.index',
        'current' => 'admin.beritas.*',
        'title' => 'Berita',
    ],
    [
        'icon' => 'squares-2x2',
        'route' => 'admin.galleries.index',
        'current' => 'admin.galleries.*',
        'title' => 'Galeri',
    ],
    [
        'icon' => 'folder-open',
        'route' => 'staff.divisi.index',
        'current' => 'staff.divisi.*',
        'title' => 'Divisi',
    ],
    [
        'icon' => 'user-group',
        'route' => 'staff.pengurus.index',
        'current' => 'staff.pengurus.*',
        'title' => 'Pengurus',
    ],
    [
        'icon' => 'chart-bar',
        'route' => 'staff.reports.index',
        'current' => 'staff.reports.*',
        'title' => 'Laporan',
    ],
];
