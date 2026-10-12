<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\TokenQueue;
use App\Models\DiagnosticReport;
use App\Models\ReportItem;
use App\Models\PharmacyItem;
use Illuminate\Support\Facades\Hash;

class ClinicDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin & Receptionist User
        User::updateOrCreate(
            ['email' => 'admin@alnoorclinic.com'],
            [
                'name' => 'Clinic Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Services
        $services = [
            [
                'slug' => 'lady-doctor',
                'title' => 'Lady Doctor & Gynae OPD',
                'icon' => 'fa-user-doctor',
                'badge' => 'Female Specialist',
                'short_desc' => 'Specialized female consultations for reproductive health, antenatal checks, PCOS, and family planning.',
                'features' => [
                    'Experienced Female Gynecologist & MO',
                    'PCOS, Infertility & Hormonal Counseling',
                    'Confidential & Caring Atmosphere',
                    'Regular Antenatal & Postnatal Checks'
                ],
                'opd_timings' => 'Morning: 09:00 AM - 02:00 PM | Evening: 05:00 PM - 09:00 PM',
                'starting_fee' => 'Rs. 1,000'
            ],
            [
                'slug' => 'maternity-care',
                'title' => 'Maternity & Delivery Care',
                'icon' => 'fa-baby-carriage',
                'badge' => '24/7 Labor Room',
                'short_desc' => 'Comprehensive maternal healthcare from conception to postpartum with safe normal delivery suites and emergency C-section facilities.',
                'features' => [
                    '24/7 On-Call Obstetrician Team',
                    'Sterilized Modern Labor & Recovery Rooms',
                    'Continuous Fetal Heart Rate Monitoring',
                    'Neonatal Resuscitation & Newborn Care'
                ],
                'opd_timings' => 'Emergency & Delivery: 24 Hours Open',
                'starting_fee' => 'Packages from Rs. 25,000'
            ],
            [
                'slug' => 'pharmacy',
                'title' => 'Medical Store (Pharmacy)',
                'icon' => 'fa-pills',
                'badge' => '100% Genuine Medicines',
                'short_desc' => 'Well-stocked in-house pharmacy providing temperature-regulated medicines, maternity supplies, and baby nutrition.',
                'features' => [
                    '24/7 Emergency Medicine Availability',
                    'Cold-chain Vaccine & Insulin Storage',
                    'Computerized Invoicing & Discount for Regulars',
                    'Qualified Licensed Pharmacist on Duty'
                ],
                'opd_timings' => 'Open 24 Hours / 7 Days',
                'starting_fee' => 'Market Competitive & Discounted'
            ],
            [
                'slug' => 'laboratory',
                'title' => 'Laboratory Testing',
                'icon' => 'fa-microscope',
                'badge' => 'Accurate & Fast',
                'short_desc' => 'Computerized pathology and clinical laboratory equipped with automated analyzers for routine and specialized medical tests.',
                'features' => [
                    'CBC, Blood Sugar, HbA1c & Lipid Panel',
                    'Pregnancy / Beta-hCG & Hormonal Assays',
                    'Urine R/E, Liver & Kidney Function Tests',
                    'Online Report Verification & PDF Printing'
                ],
                'opd_timings' => '08:00 AM - 10:00 PM (Emergency Samples 24/7)',
                'starting_fee' => 'Tests from Rs. 350'
            ],
            [
                'slug' => 'ultrasound',
                'title' => 'Ultrasound Services (USG)',
                'icon' => 'fa-wave-square',
                'badge' => 'Female Sonologist',
                'short_desc' => 'High-resolution Doppler & pregnancy ultrasound scanning performed by a qualified female sonologist for maternal comfort.',
                'features' => [
                    'Pelvic & Abdominal Ultrasound',
                    'Early Pregnancy & Anomaly Scan (Level II)',
                    'Growth Scan & Color Doppler',
                    'High-Definition Thermal Film & Instant Reports'
                ],
                'opd_timings' => 'Monday - Saturday: 10:00 AM - 07:00 PM',
                'starting_fee' => 'Rs. 1,500'
            ],
            [
                'slug' => 'ecg',
                'title' => 'ECG Services',
                'icon' => 'fa-heart-pulse',
                'badge' => 'Instant 12-Lead',
                'short_desc' => 'Fast and reliable 12-Lead computerized Electrocardiogram (ECG) for immediate heart rhythm evaluation and chest pain screening.',
                'features' => [
                    'Instant 3-Minute 12-Lead Recording',
                    'Pre-operative Cardiac Clearance',
                    'Hypertension & Arrhythmia Assessment',
                    'Immediate Physician Interpretation'
                ],
                'opd_timings' => 'Available 24/7 in Emergency',
                'starting_fee' => 'Rs. 700'
            ]
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['slug' => $srv['slug']], $srv);
        }

        // 3. Doctors
        $doctors = [
            [
                'name' => 'Dr. Ayesha Fatima',
                'qualification' => 'MBBS, FCPS (Obstetrics & Gynecology)',
                'role' => 'Senior Consultant Gynecologist',
                'experience' => '14+ Years Experience',
                'timings' => 'Mon - Fri: 10:00 AM - 02:00 PM',
                'fee' => 'Rs. 1,500',
                'avatar' => 'https://images.unsplash.com/photo-1594824813576-905165d21a5a?auto=format&fit=crop&w=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Maryam Khan',
                'qualification' => 'MBBS, MCPS (Maternal & Child Health)',
                'role' => 'Lady Medical Officer & Antenatal Specialist',
                'experience' => '8+ Years Experience',
                'timings' => 'Daily: 05:00 PM - 09:30 PM',
                'fee' => 'Rs. 1,000',
                'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Saira Rehman',
                'qualification' => 'MBBS, DMRD (Radiology & Sonology)',
                'role' => 'Consultant Female Sonologist',
                'experience' => '10+ Years Experience',
                'timings' => 'Mon - Sat: 11:00 AM - 06:00 PM',
                'fee' => 'Rs. 1,500',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Bilal Ahmed',
                'qualification' => 'MBBS, M.Phil (Pathology)',
                'role' => 'Head of Diagnostic Laboratory',
                'experience' => '12+ Years Experience',
                'timings' => 'Mon - Sat: 09:00 AM - 04:00 PM',
                'fee' => 'Rs. 800',
                'avatar' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=300&q=80',
                'is_active' => true,
            ],
        ];

        foreach ($doctors as $doc) {
            Doctor::updateOrCreate(['name' => $doc['name']], $doc);
        }

        // 4. Patients
        $patients = [
            [
                'mr_number' => 'MR-8842',
                'name' => 'Fatima Zahra',
                'age' => '27 Yrs',
                'gender' => 'Female',
                'phone' => '0300-1122334',
                'address' => 'House 45, Street 8, Healthcare Colony',
                'medical_notes' => 'G2P1, 2nd Trimester, routine antenatal review.'
            ],
            [
                'mr_number' => 'MR-8845',
                'name' => 'Zainab Bibi',
                'age' => '31 Yrs',
                'gender' => 'Female',
                'phone' => '0312-5544332',
                'address' => 'Apartment 12-B, Green Avenue',
                'medical_notes' => 'Early pregnancy confirmation, Beta-hCG monitoring.'
            ],
            [
                'mr_number' => 'MR-8850',
                'name' => 'Muhammad Farooq',
                'age' => '52 Yrs',
                'gender' => 'Male',
                'phone' => '0333-9988776',
                'address' => 'Main Bazar, Model Town',
                'medical_notes' => 'Hypertension, routine chest pain cardiac ECG screening.'
            ]
        ];

        foreach ($patients as $pat) {
            Patient::updateOrCreate(['mr_number' => $pat['mr_number']], $pat);
        }

        // 5. Appointments & Tokens
        $appointments = [
            [
                'token_number' => 'TK-101',
                'patient_name' => 'Sumbul Tariq',
                'patient_phone' => '0300-9876543',
                'patient_age' => '29 Yrs',
                'patient_gender' => 'Female',
                'service_name' => 'Lady Doctor & Gynae OPD',
                'doctor_name' => 'Dr. Ayesha Fatima',
                'appointment_date' => now()->toDateString(),
                'slot' => 'Morning (10:00 AM - 01:00 PM)',
                'status' => 'In-Consultation',
                'fee' => 1500,
            ],
            [
                'token_number' => 'TK-102',
                'patient_name' => 'Khadija Bibi',
                'patient_phone' => '0311-2233445',
                'patient_age' => '24 Yrs',
                'patient_gender' => 'Female',
                'service_name' => 'Ultrasound Services (USG)',
                'doctor_name' => 'Dr. Saira Rehman',
                'appointment_date' => now()->toDateString(),
                'slot' => 'Morning (10:00 AM - 01:00 PM)',
                'status' => 'Waiting',
                'fee' => 1500,
            ],
            [
                'token_number' => 'TK-103',
                'patient_name' => 'Rashida Begum',
                'patient_phone' => '0345-6677889',
                'patient_age' => '38 Yrs',
                'patient_gender' => 'Female',
                'service_name' => 'Laboratory Testing',
                'doctor_name' => 'Dr. Bilal Ahmed',
                'appointment_date' => now()->toDateString(),
                'slot' => 'Evening (05:00 PM - 09:00 PM)',
                'status' => 'Waiting',
                'fee' => 850,
            ],
            [
                'token_number' => 'TK-104',
                'patient_name' => 'Tariq Mehmood',
                'patient_phone' => '0321-4455667',
                'patient_age' => '48 Yrs',
                'patient_gender' => 'Male',
                'service_name' => 'ECG Services',
                'doctor_name' => 'Duty Medical Officer',
                'appointment_date' => now()->toDateString(),
                'slot' => 'Morning (10:00 AM - 01:00 PM)',
                'status' => 'Completed',
                'fee' => 700,
            ]
        ];

        foreach ($appointments as $app) {
            Appointment::updateOrCreate(['token_number' => $app['token_number']], $app);
            TokenQueue::updateOrCreate(
                ['token_number' => $app['token_number']],
                [
                    'patient_name' => $app['patient_name'],
                    'phone' => $app['patient_phone'],
                    'service' => $app['service_name'],
                    'queue_time' => now()->format('h:i A'),
                    'status' => $app['status'],
                ]
            );
        }

        // 6. Diagnostic Reports with Items
        $report1 = DiagnosticReport::updateOrCreate(
            ['report_id' => 'REP-101'],
            [
                'token_number' => 'TK-2026-101',
                'mrn' => 'MR-8842',
                'patient_name' => 'Fatima Zahra',
                'age' => '27 Yrs',
                'gender' => 'Female',
                'doctor' => 'Dr. Ayesha Fatima',
                'category' => 'Ultrasound Services',
                'test_name' => 'Obstetric Ultrasound (2nd Trimester)',
                'report_date' => now()->subDay()->toDateString(),
                'status' => 'Ready',
                'impression' => 'Single live intrauterine pregnancy corresponding to 22+ weeks gestational age with normal fetal biometry and anatomy.',
                'consultant' => 'Dr. Saira Rehman (Radiologist)'
            ]
        );
        $report1->items()->delete();
        $report1->items()->createMany([
            ['param' => 'Gestational Age', 'value' => '22 Weeks 4 Days', 'normal_range' => 'Calculated by BPD/FL'],
            ['param' => 'Fetal Cardiac Activity', 'value' => 'Present (146 bpm)', 'normal_range' => '120 - 160 bpm'],
            ['param' => 'Placenta Position', 'value' => 'Anterior, Grade I, High', 'normal_range' => 'Normal'],
            ['param' => 'Liquor Amnii (AFI)', 'value' => '14.2 cm (Adequate)', 'normal_range' => '10 - 20 cm'],
            ['param' => 'Estimated Fetal Weight', 'value' => '520 grams (+/- 10%)', 'normal_range' => 'Average for age'],
        ]);

        $report2 = DiagnosticReport::updateOrCreate(
            ['report_id' => 'REP-102'],
            [
                'token_number' => 'TK-2026-102',
                'mrn' => 'MR-8845',
                'patient_name' => 'Zainab Bibi',
                'age' => '31 Yrs',
                'gender' => 'Female',
                'doctor' => 'Dr. Maryam Khan',
                'category' => 'Laboratory Testing',
                'test_name' => 'Complete Blood Count & Beta hCG',
                'report_date' => now()->subDay()->toDateString(),
                'status' => 'Ready',
                'impression' => 'Normocytic normochromic blood picture. Strongly positive Beta hCG levels consistent with early viable pregnancy.',
                'consultant' => 'Dr. Bilal Ahmed (Pathologist)'
            ]
        );
        $report2->items()->delete();
        $report2->items()->createMany([
            ['param' => 'Hemoglobin (Hb)', 'value' => '11.8 g/dL', 'normal_range' => '11.5 - 15.5 g/dL'],
            ['param' => 'WBC Count', 'value' => '7,800 /mcL', 'normal_range' => '4,000 - 11,000 /mcL'],
            ['param' => 'Platelet Count', 'value' => '265,000 /mcL', 'normal_range' => '150,000 - 450,000 /mcL'],
            ['param' => 'Serum Beta hCG', 'value' => '24,500 mIU/mL', 'normal_range' => 'Positive for 6-8 wks gestation'],
        ]);

        $report3 = DiagnosticReport::updateOrCreate(
            ['report_id' => 'REP-103'],
            [
                'token_number' => 'TK-2026-103',
                'mrn' => 'MR-8850',
                'patient_name' => 'Muhammad Farooq',
                'age' => '52 Yrs',
                'gender' => 'Male',
                'doctor' => 'Duty Medical Officer',
                'category' => 'ECG Services',
                'test_name' => 'Digital 12-Lead Electrocardiogram (ECG)',
                'report_date' => now()->subDay()->toDateString(),
                'status' => 'Ready',
                'impression' => 'Normal 12-Lead resting ECG. No acute ST-T elevation or pathological Q waves noted.',
                'consultant' => 'Dr. T. Naveed (Cardiologist on Call)'
            ]
        );
        $report3->items()->delete();
        $report3->items()->createMany([
            ['param' => 'Heart Rate', 'value' => '74 bpm', 'normal_range' => '60 - 100 bpm'],
            ['param' => 'Rhythm', 'value' => 'Normal Sinus Rhythm', 'normal_range' => 'Sinus Rhythm'],
            ['param' => 'PR Interval', 'value' => '160 ms', 'normal_range' => '120 - 200 ms'],
            ['param' => 'QRS Duration', 'value' => '88 ms', 'normal_range' => '< 120 ms'],
            ['param' => 'ST-T Segment', 'value' => 'No acute ischemic changes', 'normal_range' => 'Isoelectric'],
        ]);

        // 7. Pharmacy Items
        $medicines = [
            ['name' => 'Folic Acid 5mg', 'generic_name' => 'Folate Supplement', 'category' => 'Maternity', 'stock_qty' => 120, 'unit_price' => 120, 'expiry_date' => '2027-12-31'],
            ['name' => 'Pregnavit Plus Softgels', 'generic_name' => 'Multivitamins + DHA', 'category' => 'Maternity', 'stock_qty' => 45, 'unit_price' => 850, 'expiry_date' => '2027-08-30'],
            ['name' => 'Augmentin 625mg', 'generic_name' => 'Amoxicillin + Clavulanate', 'category' => 'Antibiotics', 'stock_qty' => 60, 'unit_price' => 420, 'expiry_date' => '2027-05-15'],
            ['name' => 'Panadol 500mg (Paracetamol)', 'generic_name' => 'Paracetamol', 'category' => 'Analgesic', 'stock_qty' => 350, 'unit_price' => 50, 'expiry_date' => '2028-01-01'],
            ['name' => 'Clexane 40mg Injection', 'generic_name' => 'Enoxaparin Sodium', 'category' => 'Emergency', 'stock_qty' => 25, 'unit_price' => 1400, 'expiry_date' => '2026-11-30'],
            ['name' => 'Duphaston 10mg', 'generic_name' => 'Dydrogesterone', 'category' => 'Gynecology', 'stock_qty' => 80, 'unit_price' => 950, 'expiry_date' => '2027-10-31'],
        ];

        foreach ($medicines as $med) {
            PharmacyItem::updateOrCreate(['name' => $med['name']], $med);
        }
    }
}
