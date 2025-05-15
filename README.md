## 📦 `sattorbek/youtube-search` Foydalanish Qo‘llanmasi

`sattorbek/youtube-search` — bu PHP kutubxonasi YouTube’ning qidiruv sahifasidan **video natijalar** va **qidiruv tavsiyalari** (suggestions) ni **scraping** orqali olib keladi. Bu paket **API kaliti yoki login talab qilmaydi**.

---

### ✅ 1. Talablar

* PHP 8+ yoki undan yuqori versiya
* Composer o‘rnatilgan bo‘lishi kerak

---

### ⚙️ 2. O‘rnatish

Terminal orqali quyidagi buyruqni bajaring:

```bash
composer require sattorbek/youtube-search
```

Bu `vendor/` papkasiga barcha kerakli fayllarni yuklaydi.

---

### 🧠 3. Foydalanish

Loyihangiz katalogida PHP fayl yarating (masalan: `example.php`) va quyidagi kodni yozing:

```php
<?php

use Youtube\Search\Suggestion;
use Youtube\Search\Video;
use Youtube\Settings;

require_once __DIR__ . '/vendor/autoload.php';

// YouTube video qidiruv
$youtube = new Video(new Settings(array("hl" => "en", "fl" => "US")));
$results = $youtube->Search("test", length: 1, offset: 0)->results();
print_r($results);

// Qidiruv tavsiyalari (suggestions)
$youtube = new Suggestion(new Settings(array("hl" => "en", "fl" => "US")));
$results = $youtube->Search("test")->results();
print_r($results);
```

---

### 🔍 4. Natijani tushunish

#### `Video` qidiruvi:

```php
$youtube = new Video(new Settings(array()));
$results = $youtube->Search("test", length: 1, offset: 0)->results();
```

* `"test"` — qidiruv so‘zi
* `length: 1` — faqat 1 ta natija qaytaradi
* `offset: 0` — birinchi natijadan boshlab

**Natija** bu formatda bo‘ladi (misol uchun):

```php
Array
(
    [0] => Array
        (
            [title] => "Test Video"
            [url] => "https://www.youtube.com/watch?v=xxxx"
            [duration] => "4:20"
            [author] =>  Array ( [name] => "YouTube", [id] => "zzzzzzzzzzzzz")
        )
)
```

#### `Suggestion` qidiruvi:

```php
$youtube = new Suggestion(new Settings(array()));
$results = $youtube->Search("test")->results();
```

Bu kod `"test"` so‘ziga tegishli tavsiya so‘zlar ro‘yxatini chiqaradi, masalan:

```php
Array
(
    [0] => "test song"
    [1] => "test video"
    [2] => "test gameplay"
)
```

---

### ⚠️ 5. Eslatma

* Bu paket **YouTube’ning rasmiy API’sini ishlatmaydi**, u **scraping** usulidan foydalanadi.
* Paket **engil** va **API cheklovlarisiz** ishlaydi.
* **Ko‘p so‘rovlar** yuborilsa, YouTube vaqtincha bloklashi mumkin, shuning uchun ehtiyotkorlik bilan foydalaning.

---

### 💡 6. Custom Sozlamalar

`Settings` klassi orqali til (`hl`) yoki mintaqa (`gl`) sozlamalarini qo‘shishingiz mumkin:

```php
$settings = new Settings([
    "hl" => "en",  // Ingliz tili
    "gl" => "US"   // AQSH regioni
]);
$youtube = new Video($settings);
```
