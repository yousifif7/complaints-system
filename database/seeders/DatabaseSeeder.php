<?php

namespace Database\Seeders;

use App\Enums\ComplaintStatus;
use App\Models\Category;
use App\Models\FormType;
use App\Models\RequestType;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate([], [
            'organization_name' => config('complaints.organization_name'),
            'organization_name_en' => 'Complaints Management System',
            'primary_color' => config('complaints.primary_color'),
            'welcome_message' => config('complaints.welcome_message'),
            'welcome_message_en' => 'From here you can submit a request or complaint for a specific department',
            'footer_text' => config('complaints.footer_text'),
            'footer_text_en' => 'All rights reserved',
            'website_url' => config('app.url'),
            'contact_email' => config('complaints.default_admin_email'),
            'tracking_enabled' => true,
        ]);

        User::firstOrCreate(
            ['email' => config('complaints.default_admin_email')],
            [
                'name' => 'System Admin',
                'password' => Hash::make(config('complaints.default_admin_password')),
                'role' => 'admin',
            ]
        );

        $categories = [
            'الخدمات العامة' => [
                'en' => 'Public Services',
                'types' => [
                    ['ar' => 'طلب خدمة', 'en' => 'Service Request'],
                    ['ar' => 'شكوى خدمة', 'en' => 'Service Complaint'],
                    ['ar' => 'اقتراح', 'en' => 'Suggestion'],
                ],
            ],
            'الأشغال والبنية التحتية' => [
                'en' => 'Public Works & Infrastructure',
                'types' => [
                    ['ar' => 'حفرة في الشارع', 'en' => 'Pothole in Street'],
                    ['ar' => 'إنارة', 'en' => 'Street Lighting'],
                    ['ar' => 'مياه وصرف صحي', 'en' => 'Water & Sewage'],
                ],
            ],
            'النظافة والبيئة' => [
                'en' => 'Sanitation & Environment',
                'types' => [
                    ['ar' => 'نفايات', 'en' => 'Waste'],
                    ['ar' => 'تلوث', 'en' => 'Pollution'],
                    ['ar' => 'حدائق', 'en' => 'Parks & Gardens'],
                ],
            ],
        ];

        foreach ($categories as $catName => $data) {
            $category = Category::firstOrCreate(
                ['catName' => $catName],
                ['catName_en' => $data['en']]
            );

            if (empty($category->catName_en)) {
                $category->update(['catName_en' => $data['en']]);
            }

            foreach ($data['types'] as $type) {
                $requestType = RequestType::firstOrCreate(
                    [
                        'request_name' => $type['ar'],
                        'category_id' => $category->id,
                    ],
                    ['request_name_en' => $type['en']]
                );

                if (empty($requestType->request_name_en)) {
                    $requestType->update(['request_name_en' => $type['en']]);
                }
            }
        }

        $this->seedCommonTranslations();

        if (FormType::count() === 0) {
            $sampleCategory = Category::first();
            $sampleType = RequestType::where('category_id', $sampleCategory->id)->first();

            FormType::create([
                'category_id' => $sampleCategory->id,
                'requesttype_id' => $sampleType->id,
                'name' => 'مواطن تجريبي',
                'address' => 'شارع الرئيسي',
                'phone' => '0599000000',
                'content' => 'هذا طلب تجريبي لعرض النظام',
                'file' => '',
                'status' => ComplaintStatus::ACTIVE,
                'priority' => 'medium',
            ]);
        }
    }

    private function seedCommonTranslations(): void
    {
        $requestTypeTranslations = [
            'تعقيم للأماكن العامة' => 'Public Place Disinfection',
            'متابعة الاعشاب والاشجار' => 'Weeds & Trees Follow-up',
        ];

        foreach ($requestTypeTranslations as $arabic => $english) {
            RequestType::where('request_name', $arabic)
                ->whereNull('request_name_en')
                ->update(['request_name_en' => $english]);
        }

        $categoryTranslations = [
            'الخدمات العامة' => 'Public Services',
        ];

        foreach ($categoryTranslations as $arabic => $english) {
            Category::where('catName', $arabic)
                ->whereNull('catName_en')
                ->update(['catName_en' => $english]);
        }
    }
}
