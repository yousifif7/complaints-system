<?php

return [
    'organization_name' => env('COMPLAINTS_ORG_NAME', 'نظام الشكاوى'),
    'primary_color' => env('COMPLAINTS_PRIMARY_COLOR', '#0d6d8e'),
    'welcome_message' => env('COMPLAINTS_WELCOME_MESSAGE', 'من هنا يمكنك تقديم طلب أو شكوى تابعة لقسم محدد'),
    'footer_text' => env('COMPLAINTS_FOOTER_TEXT', 'جميع الحقوق محفوظة'),
    'default_admin_email' => env('COMPLAINTS_ADMIN_EMAIL', 'admin@example.com'),
    'default_admin_password' => env('COMPLAINTS_ADMIN_PASSWORD', 'password'),
    'auto_translate_enabled' => env('COMPLAINTS_AUTO_TRANSLATE', true),
];
