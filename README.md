# Hướng Dẫn Chi Tiết Thiết Lập Google Meet API cho ATN ToyCarsMeet

Tài liệu này cung cấp hướng dẫn chi tiết cách thiết lập và tích hợp Google Meet API vào hệ thống ATN ToyCarsMeet, cho phép nhân viên (Staff) tự động tạo link Google Meet cho các lớp học online.

## Mục Lục
1. [Đăng Ký và Thiết Lập Google Cloud](#đăng-ký-và-thiết-lập-google-cloud)
2. [Tạo và Cấu Hình Project](#tạo-và-cấu-hình-project)
3. [Bật API Cần Thiết](#bật-api-cần-thiết)
4. [Tạo Thông Tin Xác Thực OAuth](#tạo-thông-tin-xác-thực-oauth)
5. [Cấu Hình Dự Án Laravel](#cấu-hình-dự-án-laravel)
6. [Xác Thực và Ủy Quyền Google](#xác-thực-và-ủy-quyền-google)
7. [Kiểm Tra Tích Hợp](#kiểm-tra-tích-hợp)

## Đăng Ký và Thiết Lập Google Cloud

### 1. Đăng Ký Tài Khoản Google Cloud
1. Truy cập [console.cloud.google.com](https://console.cloud.google.com)
2. Đăng nhập bằng tài khoản Google của bạn
3. Nếu đây là lần đầu sử dụng Google Cloud, hãy đăng ký và cung cấp thông tin thanh toán (Google cung cấp gói miễn phí với hạn mức sử dụng)

### 2. Kích Hoạt Google Cloud Console
1. Sau khi đăng nhập, chấp nhận điều khoản dịch vụ
2. Hoàn tất thiết lập tài khoản nếu được yêu cầu

## Tạo và Cấu Hình Project

### 1. Tạo Project Mới
1. Trong Google Cloud Console, nhấp vào danh sách dropdown project ở góc trên cùng bên trái (có thể được ghi là "Select a project")
2. Nhấp vào "NEW PROJECT"
3. Đặt tên project là `ATN ToyCarsMeet` // thực ra là đặt tên tùy ý
4. Có thể để vị trí mặc định hoặc chọn một tổ chức nếu bạn đang sử dụng Google Workspace
5. Nhấp vào "CREATE"
6. Chờ vài giây để Google tạo project
7. Hệ thống sẽ tự động chuyển đến project mới; nếu không, chọn nó từ menu dropdown project

### 2. Cài Đặt Thông Tin Cơ Bản
1. Từ menu chính, chọn "IAM & Admin" > "Settings"
2. Xác minh thông tin project của bạn
3. Có thể đặt ID cho project nếu chưa đặt (Lưu ý: ID project không thể thay đổi sau khi đã đặt)

## Bật API Cần Thiết

### 1. Truy Cập Thư Viện API
1. Trong menu chính bên trái, chọn "APIs & Services" > "Library"
2. Bạn sẽ thấy danh sách các API có sẵn từ Google

### 2. Kích Hoạt Google Calendar API
1. Trong thanh tìm kiếm, nhập "Google Calendar API"
2. Chọn "Google Calendar API" từ kết quả tìm kiếm
3. Nhấp vào nút "ENABLE"
4. Chờ vài giây để API được kích hoạt

### 3. Kích Hoạt Google Meet API
1. Quay lại trang Thư viện API
2. Trong thanh tìm kiếm, nhập "Google Meet API"
3. Chọn "Google Meet API" từ kết quả tìm kiếm
4. Nhấp vào nút "ENABLE"
5. Chờ vài giây để API được kích hoạt

## Tạo Thông Tin Xác Thực OAuth

### 1. Thiết Lập OAuth Consent Screen
1. Trong menu chính bên trái, chọn "APIs & Services" > "OAuth consent screen"
2. Chọn loại người dùng:
   - "External" (nếu bạn không sử dụng Google Workspace hoặc muốn cấp quyền cho người dùng bên ngoài tổ chức)
   - "Internal" (nếu bạn đang sử dụng Google Workspace và chỉ muốn cấp quyền cho người dùng trong tổ chức)
3. Nhấp vào "CREATE"

### 2. Cấu Hình Ứng Dụng OAuth
1. Nhập thông tin ứng dụng:
   - App name: `ATN ToyCarsMeet`
   - User support email: [email của bạn]
   - Logo (không bắt buộc): Tải lên logo của ứng dụng
   - Application home page: URL của trang chủ ứng dụng (ví dụ: `https://your-domain.com`)
   - Application privacy policy link: Link đến chính sách bảo mật
   - Application terms of service link: Link đến điều khoản dịch vụ
   - Developer contact information: [email của bạn]
2. Nhấp vào "SAVE AND CONTINUE"

### 3. Thiết Lập Scopes
1. Nhấp vào "ADD OR REMOVE SCOPES"
2. Tìm và chọn các scopes sau:
   - `https://www.googleapis.com/auth/calendar` (Full access to Google Calendar)
   - `https://www.googleapis.com/auth/calendar.events` (View and edit events on all your calendars)
3. Nhấp vào "UPDATE"
4. Nhấp vào "SAVE AND CONTINUE"

### 4. Thêm Test Users (Chỉ Cho External User Type)
1. Nhấp vào "ADD USERS"
2. Thêm email của bạn và những người cần kiểm thử ứng dụng (tối đa 100 người dùng)
3. Nhấp vào "ADD"
4. Nhấp vào "SAVE AND CONTINUE"
5. Xem lại thông tin và nhấp vào "BACK TO DASHBOARD"

### 5. Tạo Thông Tin Xác Thực OAuth Client
1. Trong menu chính bên trái, chọn "APIs & Services" > "Credentials"
2. Nhấp vào "CREATE CREDENTIALS" > "OAuth client ID"
3. Chọn loại ứng dụng: "Web application"
4. Đặt tên: `ATN ToyCarsMeet Web Client`
5. Thêm JavaScript origins (nếu cần): 
   - `http://localhost:8000`
   - `https://your-domain.com`
6. Thêm Redirect URIs:
   - `http://localhost:8000/auth/google/callback`
   - `https://your-domain.com/auth/google/callback`
7. Nhấp vào "CREATE"
8. **QUAN TRỌNG**: Lưu lại Client ID và Client Secret được hiển thị. Bạn sẽ cần chúng để cấu hình ứng dụng Laravel.
9. Tải xuống file JSON credentials bằng cách nhấp vào nút tải xuống (sẽ cần cho cấu hình)

## Cấu Hình Dự Án Laravel

### 1. Cài Đặt Gói Google API Client
1. Mở terminal/command prompt
2. Di chuyển đến thư mục dự án ATN ToyCarsMeet:
   ```bash
   cd đường/dẫn/đến/dự/án/atn_toycars
   ```
3. Cài đặt gói Google API Client thông qua Composer:
   ```bash
   composer require google/apiclient:^2.12.1
   ```

### 2. Tạo Thư Mục Lưu Trữ
1. Tạo thư mục để lưu trữ thông tin xác thực và token:
   ```bash
   mkdir -p storage/app/google
   chmod 755 storage/app/google
   ```

### 3. Thiết Lập Thông Tin Xác Thực
1. Tạo thư mục cấu hình Google:
   ```bash
   mkdir -p config/google
   ```
2. Di chuyển file credentials.json (đã tải xuống từ Google Cloud Console) vào thư mục `config/google`
3. Cập nhật file .env với thông tin Client ID và Client Secret:
   ```
   GOOGLE_CLIENT_ID=your-client-id
   GOOGLE_CLIENT_SECRET=your-client-secret
   ```
   Thay `your-client-id` và `your-client-secret` bằng thông tin từ file credentials.json

### 4. Đảm Bảo Routes Đúng
1. Kiểm tra file `routes/web.php` để đảm bảo các routes sau đã được định nghĩa:
   ```php
   Route::middleware(['manual.auth'])->group(function () {
       Route::get('/auth/google', [GoogleMeetController::class, 'auth'])->name('auth.google');
       Route::get('/auth/google/callback', [GoogleMeetController::class, 'callback'])->name('auth.google.callback');
   });
   ```
2. Nếu cần, hãy thêm controller và routes để tạo Google Meet cho lịch học:
   ```php
   Route::middleware(['manual.auth', 'role:staff,admin'])->prefix('staff')->group(function () {
       Route::get('/timetable/create-meet/{id}', [TimetableController::class, 'createMeet'])->name('timetable.create-meet');
   });
   ```

## Xác Thực và Ủy Quyền Google

### 1. Tạo Command Để Hỗ Trợ Xác Thực

Nếu chưa có, hãy tạo một Artisan command để hỗ trợ xác thực:

1. Tạo file command mới:
   ```bash
   php artisan make:command GoogleAuth
   ```

2. Cập nhật file `app/Console/Commands/GoogleAuth.php`:
   ```php
   <?php

   namespace App\Console\Commands;

   use Illuminate\Console\Command;
   use Google\Client;
   use Google\Service\Calendar;

   class GoogleAuth extends Command
   {
       protected $signature = 'google:auth';
       protected $description = 'Authenticate with Google API';

       public function handle()
       {
           $client = new Client();
           $client->setApplicationName('ATN ToyCarsMeet');
           $client->setClientId(env('GOOGLE_CLIENT_ID'));
           $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
           $client->setRedirectUri(url('/auth/google/callback'));
           $client->setScopes([Calendar::CALENDAR_EVENTS]);
           $client->setAccessType('offline');
           $client->setPrompt('consent');

           // Tạo URL xác thực
           $authUrl = $client->createAuthUrl();
           $this->info("Truy cập URL sau để xác thực Google API:");
           $this->info($authUrl);

           // Yêu cầu người dùng nhập mã xác thực
           $authCode = $this->ask('Nhập mã xác thực từ trình duyệt:');

           // Lấy access token từ mã xác thực
           try {
               $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
               $client->setAccessToken($accessToken);

               // Lưu token vào file
               $tokenPath = storage_path('app/google/token.json');
               if (!file_exists(dirname($tokenPath))) {
                   mkdir(dirname($tokenPath), 0755, true);
               }
               file_put_contents($tokenPath, json_encode($accessToken));

               $this->info('Xác thực thành công! Token đã được lưu.');
           } catch (\Exception $e) {
               $this->error('Xác thực thất bại: ' . $e->getMessage());
           }
       }
   }
   ```

### 2. Thực Hiện Xác Thực

1. Chạy command để xác thực:
   ```bash
   php artisan google:auth
   ```

2. Một URL sẽ hiển thị. Sao chép URL này và mở trong trình duyệt web.

3. Đăng nhập vào tài khoản Google và cấp quyền cho ứng dụng.

4. Sau khi chấp thuận, bạn sẽ được chuyển hướng đến một trang với mã xác thực hoặc trang lỗi với mã trong URL.

5. Sao chép mã xác thực và dán vào terminal khi được nhắc.

6. Sau khi hoàn tất, token sẽ được lưu vào `storage/app/google/token.json`.

## Kiểm Tra Tích Hợp

### 1. Kiểm Tra Xem Token Đã Được Lưu

```bash
ls -la storage/app/google/
```

Bạn nên thấy file `token.json` trong thư mục này.

### 2. Tạo Route Kiểm Tra

Tạo một route tạm thời để kiểm tra tích hợp:

1. Thêm vào file `routes/web.php`:
   ```php
   Route::get('/test-google-meet', function () {
       try {
           $googleMeetService = app(\App\Services\GoogleMeetService::class);
           $now = \Carbon\Carbon::now();
           $meetLink = $googleMeetService->createMeetLink(
               'Test Meeting',
               $now->addMinutes(10)->toIso8601String(),
               $now->addMinutes(40)->toIso8601String(),
               'Meeting description'
           );
           
           return "Google Meet Link: " . ($meetLink ? $meetLink : "Không thể tạo link");
       } catch (\Exception $e) {
           return "Lỗi: " . $e->getMessage();
       }
   })->middleware('manual.auth');
   ```

2. Truy cập URL `http://your-domain.com/test-google-meet` hoặc `http://localhost:8000/test-google-meet`

3. Nếu tích hợp thành công, bạn sẽ thấy một link Google Meet được hiển thị.

### 3. Kiểm Tra Trong Giao Diện Staff

1. Đăng nhập với tài khoản Staff
2. Truy cập trang quản lý lịch học
3. Thử tạo một lịch học mới hoặc tạo Google Meet cho lịch học hiện có
4. Xác nhận rằng link Google Meet được tạo và hiển thị trong giao diện
