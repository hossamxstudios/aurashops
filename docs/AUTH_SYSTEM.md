# نظام المصادقة للعملاء (Client Authentication System)

## نظرة عامة
تم تطوير نظام مصادقة كامل للعملاء يتضمن:
- تسجيل الدخول (Login)
- التسجيل (Register)
- استعادة كلمة المرور (Forgot Password)
- تسجيل الخروج (Logout)

## الملفات المنشأة

### Controllers
1. **ClientLoginController.php**
   - الموقع: `app/Http/Controllers/Auth/ClientLoginController.php`
   - المسؤوليات:
     - عرض صفحة تسجيل الدخول
     - معالجة طلب تسجيل الدخول
     - تسجيل الخروج

2. **ClientRegisterController.php**
   - الموقع: `app/Http/Controllers/Auth/ClientRegisterController.php`
   - المسؤوليات:
     - عرض صفحة التسجيل
     - معالجة طلب التسجيل
     - إنشاء حساب عميل جديد

3. **ClientPasswordResetController.php**
   - الموقع: `app/Http/Controllers/Auth/ClientPasswordResetController.php`
   - المسؤوليات:
     - عرض صفحة استعادة كلمة المرور
     - إرسال رابط إعادة تعيين كلمة المرور

### Views
1. **login.blade.php**
   - الموقع: `resources/views/website/auth/login.blade.php`
   - يستخدم نفس تصميم HTML الموجود في الثيم

2. **register.blade.php**
   - الموقع: `resources/views/website/auth/register.blade.php`
   - يستخدم نفس تصميم HTML الموجود في الثيم

3. **forgot-password.blade.php**
   - الموقع: `resources/views/website/auth/forgot-password.blade.php`
   - صفحة بسيطة لاستعادة كلمة المرور

### Routes
تم إضافة Routes التالية في `routes/front-end.php`:

```php
// Authentication Routes
Route::middleware('guest:client')->group(function () {
    Route::get('/client/login', [ClientLoginController::class, 'showLoginForm'])->name('client.login');
    Route::post('/client/login', [ClientLoginController::class, 'login'])->name('client.login.post');
    Route::get('/client/register', [ClientRegisterController::class, 'showRegistrationForm'])->name('client.register');
    Route::post('/client/register', [ClientRegisterController::class, 'register'])->name('client.register.post');
    Route::get('/client/forgot-password', [ClientPasswordResetController::class, 'showLinkRequestForm'])->name('client.password.request');
    Route::post('/client/forgot-password', [ClientPasswordResetController::class, 'sendResetLinkEmail'])->name('client.password.email');
});

Route::post('/logout', [ClientLoginController::class, 'logout'])->name('logout')->middleware('auth:client');
```

**ملاحظة مهمة:** جميع routes المصادقة تبدأ بـ `/client/` للتمييز عن routes المصادقة الخاصة بالـ Admins.

## الـ Guard المستخدم
النظام يستخدم `client` guard للمصادقة، مما يعني:
- يتم حفظ بيانات المصادقة في جدول `clients`
- الـ middleware المستخدم: `auth:client`
- الـ guest middleware: `guest:client`

### ⚠️ تنبيه مهم: Guards المختلفة
يوجد في النظام **guards منفصلة**:
- **`client` guard**: للعملاء (Clients) - يستخدم جدول `clients`
- **`web` guard**: للمشرفين (Admins) - يستخدم جدول `users`

**يجب عدم الخلط بينهما!** كل guard له:
- جدول database مختلف
- routes مختلفة
- middleware مختلف
- صفحات مصادقة مختلفة

جميع ملفات المصادقة في `app/Http/Controllers/Auth/Client*` تستخدم `client` guard فقط.

## الحقول المطلوبة

### للتسجيل:
- `name` - الاسم الكامل (مطلوب)
- `email` - البريد الإلكتروني (مطلوب، يجب أن يكون فريداً)
- `password` - كلمة المرور (مطلوب، يجب تأكيدها)
- `password_confirmation` - تأكيد كلمة المرور (مطلوب)
- `agree_terms` - الموافقة على الشروط (مطلوب)

### لتسجيل الدخول:
- `email` - البريد الإلكتروني (مطلوب)
- `password` - كلمة المرور (مطلوب)
- `remember` - تذكرني (اختياري)

## رسائل الخطأ
جميع رسائل الخطأ باللغة العربية ويتم عرضها في:
- Alert Bootstrap في أعلى النموذج
- تحت كل حقل مباشرة (inline validation)

## التحقق من البريد الإلكتروني
Model الـ Client يطبق `MustVerifyEmail` interface، مما يعني:
- يجب على العميل تأكيد بريده الإلكتروني
- يتم إرسال إشعار تلقائي عند التسجيل

## الأمان
- جميع كلمات المرور يتم تشفيرها تلقائياً باستخدام Hash
- CSRF Protection مفعل على جميع النماذج
- Validation على جانب الـ Server

## كيفية الاستخدام

### في Blade Templates:
```blade
{{-- التحقق من تسجيل الدخول --}}
@auth('client')
    <p>مرحباً {{ Auth::guard('client')->user()->name }}</p>
@endauth

@guest('client')
    <a href="{{ route('client.login') }}">تسجيل الدخول</a>
    <a href="{{ route('client.register') }}">إنشاء حساب</a>
@endguest
```

### في Controllers:
```php
// الحصول على بيانات العميل المسجل
$client = Auth::guard('client')->user();

// التحقق من تسجيل الدخول
if (Auth::guard('client')->check()) {
    // العميل مسجل دخوله
}
```

## ملاحظات مهمة

1. **صورة page-title.jpg**:
   - يجب إضافة الصورة في: `public/website/images/section/page-title.jpg`
   - المسار المستخدم في الـ Views: `{{ asset('website/images/section/page-title.jpg') }}`

2. **Email Configuration**:
   - تأكد من إعداد SMTP في ملف `.env` لإرسال رسائل إعادة تعيين كلمة المرور

3. **Password Broker**:
   - تأكد من إعداد `clients` password broker في `config/auth.php`:
   ```php
   'passwords' => [
       'clients' => [
           'provider' => 'clients',
           'table' => 'password_reset_tokens',
           'expire' => 60,
           'throttle' => 60,
       ],
   ],
   ```

## التطوير المستقبلي
يمكن إضافة:
- Social Login (Google, Facebook)
- Two-Factor Authentication
- Email Verification required middleware
- Password strength meter
- Remember device functionality

## الدعم
في حالة وجود أي مشاكل، تأكد من:
1. تشغيل `php artisan config:clear`
2. تشغيل `php artisan cache:clear`
3. تشغيل `php artisan view:clear`
