<?php
/*************************************************************************
*  2020-2022 Shopiro Ltd.
*  All Rights Reserved.
* 
* NOTICE:  All information contained herein is, and remains the 
* property of Shopiro Ltd. and its suppliers, if any. The 
* intellectual and technical concepts contained herein are 
* proprietary to Shopiro Ltd. and its suppliers and may be 
* covered by Canadian and Foreign Patents, patents in process, and 
* are protected by trade secret or copyright law. Dissemination of 
* this information or reproduction of this material is strictly 
* forbidden unless prior written permission is obtained from Shopiro Ltd..
*/

$stopwords=array(
'آباد', 'آره', 'آری', 'آزادهٓ', 'آسیب', 'آن', 'آنان', 'آنجا', 'آنرا', 'آنطور', 'آنقدر', 'آنها', 'آنچه',
'آنکه', 'آهان', 'آورد', 'آی', 'آیا', 'ابتدا', 'اخیر', 'اری', 'از', 'ازجمله', 'ازاینرو', 'است', 'استفاد', 'استفاده',
'اش', 'اصلا', 'اصولا', 'اعلام', 'اغلب', 'افزود', 'اکنون', 'البته', 'البتّه', 'ام', 'اما', 'امروز', 'امسال',
'ان', 'اند', 'انشاالله', 'انطور', 'انقدر', 'انها', 'انکه', 'اه', 'او', 'اوست', 'اول', 'اولین', 'اکثر', 'اکثرا',
'اکثریت', 'اگر', 'ای', 'ایا', 'اید', 'ایشان', 'ایم', 'این', 'اینجا', 'اینچنین', 'اینطور', 'اینقدر', 'اینک',
'اینکه', 'اینها', 'اینچه', 'ایی', 'با', 'بار', 'بارة', 'باره', 'باز', 'بازهم', 'باش', 'باشد', 'باشم', 'باشند',
'باشی', 'باشید', 'باشیم', 'بالا', 'بالایِ', 'باورند', 'باید', 'بتوان', 'بتواند', 'بتوانی', 'بتوانیم', 'بدهی',
'بدهید', 'بدهیم', 'بدون', 'بر', 'برابر', 'برابرِ', 'براساس', 'براستی', 'برای', 'برایِ', 'برخوردار', 'برخی',
'برداری', 'بروز', 'بزرگ', 'بزرگوار', 'بسا', 'بسادگی', 'بسیار', 'بسیاری', 'بعد', 'بعری', 'بعضی', 'بل', 'بلکه',
'بله', 'بلکه', 'بلی', 'بنابراین', 'بندی', 'به', 'بهتر', 'بهترین', 'بهترینها', 'بود', 'بودم', 'بودن', 'بودند', 'بوده',
'بودی', 'بودید', 'بودیم', 'بویژه', 'بپا', 'بکار', 'بکن', 'بکند', 'بکنم', 'بکنند',
'بکنی', 'بکنید', 'بکنیم', 'بگیر', 'بگیرد', 'بگیرم', 'بگیرند', 'بگیری', 'بگیرید', 'بگیریم', 'بگو', 'بگوید', 'بگویم',
'بگویند', 'بگویی', 'بگویید', 'بگوییم', 'بی', 'بیا', 'بیاب', 'بیابد', 'بیابم', 'بیابند', 'بیابی', 'بیابید', 'بیابیم',
'بیاید', 'بیایم', 'بیایند', 'بیایی', 'بیایید', 'بیاییم', 'بیرون', 'بیست', 'بیش', 'بیشتر', 'بیشتری', 'بین', 'تا',
'تازه', 'تان', 'تاکید', 'تحت', 'تر', 'تربیت', 'ترین', 'تصریح', 'تعدادی', 'تعمدا', 'تقریبا', 'تقریباً', 'تمام', 'تماما',
'تمامی', 'تنها', 'تو', 'توان', 'تواند', 'توانست', 'توانستم', 'توانستن', 'توانستند', 'توانسته', 'توانستی', 'توانستید',
'توانستیم', 'توانم', 'توانند', 'توانی', 'توانید', 'توانیم', 'توسط', 'تولِ', 'توی', 'جا', 'جای', 'جایی', 'جدا', 'جدی',
'جریان', 'جز', 'جلو', 'جلوگیری', 'جلوی', 'جلویِ', 'حاضر', 'حال', 'حالا', 'حتما', 'حتی', 'حداکثر', 'حدود', 'حدودا',
'حق', 'خارج', 'خالی', 'خب', 'خداحافظ', 'خصوصا', 'خلاصه', 'خواست', 'خواستم', 'خواستن', 'خواستند', 'خواسته', 'خواستی',
'خواستید', 'خواستیم', 'خواه', 'خواهد', 'خواهم', 'خواهم', 'خواهند', 'خواهی', 'خواهید', 
'خواهیم', 'خوب', 'خود', 'خودت', 'خودتان', 'خودش', 'خودشان', 'خوش',
'خوشبختانه', 'خویش', 'خویشتن', 'خیاه', 'خیر', 'خیلی', 'داشت', 'داشتم', 'داشتن', 'داشتند', 'داشته', 'داشتی', 'داشتید',
'داشتیم', 'دامن', 'دانست', 'دانند', 'در', 'درباره', 'درمجموع', 'درواقع', 'درون', 'دریغ', 'دقیقا', 'دنبالِ', 'ده', 'دهد',
'دهم', 'دهند', 'دهی', 'دهید', 'دهیم', 'دو', 'دوباره', 'دوم', 'دیده', 'دیروز', 'دیگر', 'دیگران', 'دیگری', 'دیگه', 'را',
'راه', 'رسید', 'رسیده', 'رو', 'روب', 'روز', 'روزهای', 'روی', 'رویِ', 'رفت', 'رفتارها', 'رفته', 'رنجند', 'ره', 'ریزی',
'زمان', 'زمانی', 'زمینه', 'زند', 'زود', 'زودی', 'زیاد', 'زیادی', 'سابق', 'ساخته', 'سازی', 'سر', 'سراسر', 'سری', 'سریع',
'سریعا', 'سعی', 'سمتِ', 'سه', 'سوم', 'سوی', 'سویِ', 'سپس', 'شان', 'شاهدند', 'شاهدیم', 'شاید', 'شبه', 'شخصا', 'شد',
'شدم', 'شدن', 'شدند', 'شده', 'شدی', 'شدید', 'شدیدا', 'شدیم', 'شش', 'شما', 'شماری', 'شناسی', 'شود', 'شوم', 'شوند',
'شوید', 'شویم', 'صرفا', 'ضدِّ', 'ضمن', 'طبعا', 'طبقِ', 'طرف', 'طور', 'طی', 'ظاهرا', 'عدم', 'عقبِ', 'علّتِ', 'عنوان',
'غیر', 'فردا', 'فعلا', 'فقط', 'فکر', 'فکری', 'قابل', 'قبل', 'قبلا', 'قبلِ', 'قدری', 'قصدِ', 'قطعا', 'کامل', 'کاملا', 'کرد', 'کردم', 'کردن', 'کردند', 'کرده',
'کردی', 'کردید', 'کردیم', 'کری', 'کس', 'کسانی', 'کسی', 'کلا', 'کلی', 'کم', 'کماکان', 'کمتر', 'کمتری', 'کمی', 'کن', 'کنار',
'کنارِ', 'کند', 'کنم', 'کنند', 'کنی', 'کنید', 'کنیم', 'که', 'کی', 'گاه', 'گاهی', 'گذاری', 'گذاشته', 'گردد', 'گرفت',
'گرفتارند', 'گرفتم', 'گرفتن', 'گرفته', 'گروهی', 'گفت', 'گفته', 'گو', 'گونه', 'گوی', 'گوید', 'گویم', 'گویند', 'گویی',
'گویید', 'گوییم', 'گیر', 'گیرد', 'گیرم', 'گیرند', 'گیری', 'گیرید', 'گیریم', 'یا', 'یاب', 'یابد', 'یابم', 'یابند',
'یابی', 'یابید', 'یابیم', 'یاد', 'یارب', 'یافت', 'یافته', 'یعنی', 'یک', 'یکی', 'ّه', 'ها', 'های', 'هایی', 'هبچ',
'هر', 'هراسان', 'هرچه', 'هرگز', 'هزار', 'هست', 'هستم', 'هستند', 'هستی', 'هستید', 'هستیم', 'هفت', 'هم', 'همان',
'همه', 'همواره', 'همچنان', 'همچنین', 'همچون', 'همگان', 'همیشه', 'همین', 'هنوز', 'هنگام', 'هنگامِ', 'هی', 'هیچ',
'هیچکس', 'هیچگاه', 'و', 'واقعا', 'وجود', 'وسطِ', 'وضوح', 'وقتی', 'وقتیکه', 'ول', 'ولی', 'وی', 'ویژه', 'یک',
'یکجا', 'یکی', 'یکیک', 'یکیکی', 'ّی');
	