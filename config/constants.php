<?php


use App\Models\studyexp;

return [
    'job_classification'=>[
        'Web/programming and software',//وب،‌ برنامه‌نویسی و نرم‌افزار
        'IT / DevOps / Server',
        'Education',//آموزش
        'inventory',//انبارداری
        'Medicine/ nursing and medicine',//پزشکی،‌ پرستاری و دارویی
        'Support and customer affairs',//پشتیبانی و امور مشتریان
        'Market research and economic analysis',//تحقیق بازار و تحلیل اقتصادی
        'Physical Education',//تربیت بدنی
        'Translate',//ترجمه
        'Technical technician/ repairman',//تکنسین فنی، تعمیرکار
        'Content production and management',//تولید و مدیریت محتوا
        'transport',//حمل و نقل
        'The field of cinema and image',//حوزه‌ سینما و تصویر
        'The field of music and sound',//حوزه‌ موسیقی و صدا
        'news writing',//خبر‌نگاری
        'Shopping and business',//خرید و بازرگانی
        'Digital marketing',//دیجیتال مارکتینگ
        'Driver/ courier',//راننده، پیک موتوری
        'public relations',//روابط عمومی
        'Chemistry/ pharmaceuticals',//شیمی، داروسازی
        'Food industry',//صنایع غذایی
        'Designing',//طراحی
        'Biological and laboratory sciences',//علوم زیستی و آزمایشگاهی
        'Sales & Marketing',//فروش و بازاریابی
        'Legal expert and lawyer',//کارشناس حقوقی،‌ وکالت
        'Simple worker/ service force',//کارگر ساده، نیروی خدماتی
        'Skilled worker/ industrial worker',//کارگر ماهر، کارگر صنعتی
        'Tourism',//گردشگری
        'financial and accounting',//مالی و حسابداری
        'Product manager',//مدیر محصول
        'Insurance Management',//مدیریت بیمه
        'Head of office/ executive and administrative',//مسئول دفتر، اجرائی و اداری
        'Human resources and recruitment',//منابع انسانی و کارگزینی
        'Biomedical Engineering',//مهندسی پزشکی
        'Polymer engineering',//مهندسی پلیمر
        'Chemical and petroleum engineering',//مهندسی شیمی و نفت
        'Industrial engineering and industrial management',//مهندسی صنایع و مدیریت صنعتی
        'Civil engineering and architecture',//مهندسی عمران و معماری
        'Agricultural Engineering',//مهندسی کشاورزی
        'Mining and metallurgical engineering',//مهندسی معدن و متالورژی
        'Mechanical and aerospace engineering',//مهندسی مکانیک و هوافضا
        'Textile engineering/ fabric and clothing design',//مهندسی نساجی، طراحی پارچه و لباس
        'Guard',//نگهبان
        'Hotel management',//هتلداری
        'CEO',
        'HSE',
        'Research and Development',//تحقیق و توسعه
        'Electrical and Electronic Engineering',//مهندسی برق و الکترونیک
    ],
    'states'=>['تهران','خراسان رضوی','اصفهان',
        'فارس','خوزستان','آذربایجان شرقی',
        'مازندران','آذربایجان غربی','کرمان',
        'سیستان و بلوچستان','البرز','گیلان',
        'کرمانشاه','گلستان','هرمزگان',
        'لرستان','همدان','کردستان',
        'مرکزی','قم','قزوین',
        'اردبیل','بوشهر','یزد',
        'زنجان','چهارمحال و بختیاری','خراسان شمالی',
        'خراسان جنوبی','کهگیلویه و بویراحمد','سمنان',
        'ایلام'
    ],
    'states-en'=>[
        'tehran','khorasan razavi','esfahan',
        'fars','khozestan','azarbayjan sharghi',
        'mazandaran','azarbayjan gharbi','kerman',
        'sistan O balochestan'
    ],
    'gender'=>['male','female','notmetter','others'],
    'grades'=>['diplom','kardani','karshnasi','karshnasiarshad','doktraandmore','other'],
    'desired_job_benefits'=>['upgratable','Insurance','studing','Flexible working hours','Shuttle service','food'],
    'types_of_acceptable_contracts'=>['fulltime','cripedtime','telecommuting','internship'],
    'level_of_activity'=>['newcomer','Expert','manager','Chief'],
    'military_service_status'=>['ended','permanent exemption','education pardon','in progress','included'],
    'languages' =>['fa','en','ar','fr','es','de','it','ru','ja','zh','ko','nl','hy','hi','fi','sv','tr','azari','ku'],
    'lang_mastery_level' =>['beginner','intermediate','advanced','native'],
    'job_status'=>['Looking for a job','Looking for better job','employed'],
    'post_status' => ['active','disabled','deleted','ended'],
    'post_type' => ['job seeker','entrepreneur'],
    'user_type' => ['personally','company']
];
