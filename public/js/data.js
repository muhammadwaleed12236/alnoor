/**
 * Clinic Data Store
 * Services, Doctors, Diagnostics, and Mock Patient Records
 */

const CLINIC_INFO = {
  name: "Al-Noor Mother & Child Health Clinic",
  tagline: "Comprehensive Maternity, Diagnostic & Family Healthcare Centre",
  phone: "+92 300 1234567",
  emergencyPhone: "+92 311 9876543",
  address: "Main Boulevard, Healthcare Plaza, Block C, Near Civil Hospital",
  timings: "Open 24/7 (Emergency & Pharmacy) | OPD: 09:00 AM - 10:00 PM",
  email: "info@alnoorclinic.com"
};

const SERVICES_DATA = [
  {
    id: "lady-doctor",
    title: "Lady Doctor & Gynae OPD",
    icon: "fa-user-doctor",
    badge: "Female Specialist",
    shortDesc: "Specialized female consultations for women's reproductive health, prenatal checkups, hormonal disorders, and family planning.",
    features: [
      "Experienced Female Gynecologist & MO",
      "PCOS, Infertility & Hormonal Counseling",
      "Confidential & Caring Atmosphere",
      "Regular Antenatal & Postnatal Checks"
    ],
    opdTimings: "Morning: 09:00 AM - 02:00 PM | Evening: 05:00 PM - 09:00 PM",
    startingFee: "Rs. 1,000"
  },
  {
    id: "maternity-care",
    title: "Maternity & Delivery Care",
    icon: "fa-baby-carriage",
    badge: "24/7 Labor Room",
    shortDesc: "Comprehensive maternal healthcare from conception to postpartum, with safe normal delivery suites and emergency C-section facilities.",
    features: [
      "24/7 On-Call Obstetrician Team",
      "Sterilized Modern Labor & Recovery Rooms",
      "Continuous Fetal Heart Rate Monitoring",
      "Neonatal Resuscitation & Newborn Care"
    ],
    opdTimings: "Emergency & Delivery: 24 Hours Open",
    startingFee: "Packages from Rs. 25,000"
  },
  {
    id: "pharmacy",
    title: "Medical Store (Pharmacy)",
    icon: "fa-pills",
    badge: "100% Genuine Medicines",
    shortDesc: "Well-stocked in-house pharmacy providing temperature-regulated medicines, maternity supplies, baby nutrition, and surgical items.",
    features: [
      "24/7 Emergency Medicine Availability",
      "Cold-chain Vaccine & Insulin Storage",
      "Computerized Invoicing & Discount for Regulars",
      "Qualified Licensed Pharmacist on Duty"
    ],
    opdTimings: "Open 24 Hours / 7 Days",
    startingFee: "Market Competitive & Discounted"
  },
  {
    id: "laboratory",
    title: "Laboratory Testing",
    icon: "fa-microscope",
    badge: "Accurate & Fast",
    shortDesc: "Computerized pathology and clinical laboratory equipped with automated analyzers for routine and specialized medical tests.",
    features: [
      "CBC, Blood Sugar, HbA1c & Lipid Panel",
      "Pregnancy / Beta-hCG & Hormonal Assays",
      "Urine R/E, Liver & Kidney Function Tests",
      "Online Report Verification & PDF Printing"
    ],
    opdTimings: "08:00 AM - 10:00 PM (Emergency Samples 24/7)",
    startingFee: "Tests from Rs. 350"
  },
  {
    id: "ultrasound",
    title: "Ultrasound Services (USG)",
    icon: "fa-wave-square",
    badge: "Female Sonologist",
    shortDesc: "High-resolution Doppler & pregnancy ultrasound scanning performed by a qualified female sonologist for maternal comfort.",
    features: [
      "Pelvic & Abdominal Ultrasound",
      "Early Pregnancy & Anomaly Scan (Level II)",
      "Growth Scan & Color Doppler",
      "High-Definition Thermal Film & Instant Reports"
    ],
    opdTimings: "Monday - Saturday: 10:00 AM - 07:00 PM",
    startingFee: "Rs. 1,500"
  },
  {
    id: "ecg",
    title: "ECG Services",
    icon: "fa-heart-pulse",
    badge: "Instant 12-Lead",
    shortDesc: "Fast and reliable 12-Lead computerized Electrocardiogram (ECG) for immediate heart rhythm evaluation and chest pain screening.",
    features: [
      "Instant 3-Minute 12-Lead Recording",
      "Pre-operative Cardiac Clearance",
      "Hypertension & Arrhythmia Assessment",
      "Immediate Physician Interpretation"
    ],
    opdTimings: "Available 24/7 in Emergency",
    startingFee: "Rs. 700"
  }
];

const DOCTORS_DATA = [
  {
    name: "Dr. Ayesha Fatima",
    qualification: "MBBS, FCPS (Obstetrics & Gynecology)",
    role: "Senior Consultant Gynecologist",
    experience: "14+ Years Experience",
    timings: "Mon - Fri: 10:00 AM - 02:00 PM",
    avatar: "https://images.unsplash.com/photo-1594824813576-905165d21a5a?auto=format&fit=crop&w=300&q=80"
  },
  {
    name: "Dr. Maryam Khan",
    qualification: "MBBS, MCPS (Maternal & Child Health)",
    role: "Lady Medical Officer & Antenatal Specialist",
    experience: "8+ Years Experience",
    timings: "Daily: 05:00 PM - 09:30 PM",
    avatar: "https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=300&q=80"
  },
  {
    name: "Dr. Saira Rehman",
    qualification: "MBBS, DMRD (Radiology & Sonology)",
    role: "Consultant Female Sonologist",
    experience: "10+ Years Experience",
    timings: "Mon - Sat: 11:00 AM - 06:00 PM",
    avatar: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80"
  },
  {
    name: "Dr. Bilal Ahmed",
    qualification: "MBBS, M.Phil (Pathology)",
    role: "Head of Diagnostic Laboratory",
    experience: "12+ Years Experience",
    timings: "Mon - Sat: 09:00 AM - 04:00 PM",
    avatar: "https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=300&q=80"
  }
];

const LAB_TESTS_CATALOG = [
  { code: "LT-01", name: "Complete Blood Count (CBC) with ESR", dept: "Hematology", time: "2 Hours", price: 650 },
  { code: "LT-02", name: "Beta hCG (Quantitative Pregnancy Test)", dept: "Biochemistry", time: "3 Hours", price: 1800 },
  { code: "LT-03", name: "Blood Glucose Fasting / Random", dept: "Biochemistry", time: "30 Mins", price: 200 },
  { code: "LT-04", name: "HbA1c (Glycated Hemoglobin)", dept: "Biochemistry", time: "4 Hours", price: 1400 },
  { code: "LT-05", name: "Urine Routine Examination (R/E)", dept: "Clinical Path", time: "1 Hour", price: 350 },
  { code: "LT-06", name: "Liver Function Test (LFT)", dept: "Biochemistry", time: "4 Hours", price: 1500 },
  { code: "LT-07", name: "Renal Function Test (RFT / Urea-Creatinine)", dept: "Biochemistry", time: "3 Hours", price: 1200 },
  { code: "LT-08", name: "Thyroid Profile (TSH, Free T3, Free T4)", dept: "Endocrinology", time: "6 Hours", price: 2800 },
  { code: "LT-09", name: "Pelvic / Obstetric Ultrasound (2D/3D)", dept: "Radiology", time: "30 Mins", price: 1500 },
  { code: "LT-10", name: "Anomaly Scan (Targeted Fetal Ultrasound)", dept: "Radiology", time: "1 Hour", price: 3000 },
  { code: "LT-11", name: "Digital 12-Lead ECG with Doctor Note", dept: "Cardiology", time: "15 Mins", price: 700 },
  { code: "LT-12", name: "Blood Grouping & Rh Factor", dept: "Serology", time: "30 Mins", price: 350 }
];

// Sample diagnostic records pre-loaded for demonstration lookup
const MOCK_PATIENT_REPORTS = {
  "REP-101": {
    tokenNumber: "TK-2026-101",
    mrn: "MR-8842",
    patientName: "Fatima Zahra",
    age: "27 Yrs",
    gender: "Female",
    doctor: "Dr. Ayesha Fatima",
    testName: "Obstetric Ultrasound (2nd Trimester)",
    category: "Ultrasound Services",
    date: "11-Oct-2026",
    status: "Ready",
    findings: [
      { param: "Gestational Age", value: "22 Weeks 4 Days", normal: "Calculated by BPD/FL" },
      { param: "Fetal Cardiac Activity", value: "Present (146 bpm)", normal: "120 - 160 bpm" },
      { param: "Placenta Position", value: "Anterior, Grade I, High", normal: "Normal" },
      { param: "Liquor Amnii (AFI)", value: "14.2 cm (Adequate)", normal: "10 - 20 cm" },
      { param: "Estimated Fetal Weight", value: "520 grams (+/- 10%)", normal: "Average for age" }
    ],
    impression: "Single live intrauterine pregnancy corresponding to 22+ weeks gestational age with normal fetal biometry and anatomy.",
    consultant: "Dr. Saira Rehman (Radiologist)"
  },
  "REP-102": {
    tokenNumber: "TK-2026-102",
    mrn: "MR-8845",
    patientName: "Zainab Bibi",
    age: "31 Yrs",
    gender: "Female",
    doctor: "Dr. Maryam Khan",
    testName: "Complete Blood Count & Beta hCG",
    category: "Laboratory Testing",
    date: "11-Oct-2026",
    status: "Ready",
    findings: [
      { param: "Hemoglobin (Hb)", value: "11.8 g/dL", normal: "11.5 - 15.5 g/dL" },
      { param: "WBC Count", value: "7,800 /mcL", normal: "4,000 - 11,000 /mcL" },
      { param: "Platelet Count", value: "265,000 /mcL", normal: "150,000 - 450,000 /mcL" },
      { param: "Serum Beta hCG", value: "24,500 mIU/mL", normal: "Positive for 6-8 wks gestation" }
    ],
    impression: "Normocytic normochromic blood picture. Strongly positive Beta hCG levels consistent with early viable pregnancy.",
    consultant: "Dr. Bilal Ahmed (Pathologist)"
  },
  "REP-103": {
    tokenNumber: "TK-2026-103",
    mrn: "MR-8850",
    patientName: "Muhammad Farooq",
    age: "52 Yrs",
    gender: "Male",
    doctor: "Duty Medical Officer",
    testName: "Digital 12-Lead Electrocardiogram (ECG)",
    category: "ECG Services",
    date: "11-Oct-2026",
    status: "Ready",
    findings: [
      { param: "Heart Rate", value: "74 bpm", normal: "60 - 100 bpm" },
      { param: "Rhythm", value: "Normal Sinus Rhythm", normal: "Sinus Rhythm" },
      { param: "PR Interval", value: "160 ms", normal: "120 - 200 ms" },
      { param: "QRS Duration", value: "88 ms", normal: "< 120 ms" },
      { param: "ST-T Segment", value: "No acute ischemic changes", normal: "Isoelectric" }
    ],
    impression: "Normal 12-Lead resting ECG. No acute ST-T elevation or pathological Q waves noted.",
    consultant: "Dr. T. Naveed (Cardiologist on Call)"
  }
};

const INITIAL_QUEUE = [
  { id: "TK-101", token: "TK-101", name: "Sumbul Tariq", service: "Lady Doctor", time: "09:30 AM", status: "In-Consultation" },
  { id: "TK-102", token: "TK-102", name: "Khadija Bibi", service: "Ultrasound", time: "09:45 AM", status: "Waiting" },
  { id: "TK-103", token: "TK-103", name: "Rashida Begum", service: "Laboratory", time: "10:00 AM", status: "Waiting" },
  { id: "TK-104", token: "TK-104", name: "Tariq Mehmood", service: "ECG", time: "10:15 AM", status: "Completed" }
];
