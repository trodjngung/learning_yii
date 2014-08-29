learning_yii
============
Commit "extensions mail for yiiframework"

- Mô tả:
Chức năng gửi mail được thực minh họa trong phần gửi Contact của trang demo.
Khi nhấn Submit nội dung của Contact sẽ được gửi đến cho admin cua trang thông qua việc gửi mail (cụ thể là gmail).
- Hướng dẫn sử dụng:
+ Tải extensions yii-mail tại https://code.google.com/p/yii-mail/ và copy vào thu mục protected/extensions trong project
+ Thêm các khai báo cho extensions mail này trong protected/config/main.php như trong commit mình làm.
Thêm phần cấu hình mail để có thể gửi mail được.
+ Thực hiện gửi trong controller: Phần này sẽ làm mail gửi tới ai, nội dung mail là như thế nào, có thể cấu hình gửi tới kiểu Cc hay Bcc, gửi file đính kèm, cấu hình replyto tới một ai đó khác ...

===========
Commit "read, write csv file"

- Mô tả:
Chức năng đọc và ghi file csv được minh họa trong phần Csv của trang demo.
Người dùng có thể đưa một file csv lên để đọc dữ liệu trong đó và có thể tải dữ liệu về được ghi trong file csv.
- Hướng dẫn sử dụng:
+ Tạo file view protected/views/csv.php có một nút upload file và một nút download dùng để upload file csv lên hoặc tải dữ liệu về dưới dạng file csv.
+ Tạo một model protected/models/CsvForm.php để xét điều kiện cho form upload file csv. Trong đó có thể xét kiểu file upload, maxSize, tên khi gọi trong Form ...
+ Tạo một extensions protected/extensions/CsvExtensions.php dùng để ghi dữ liều ra file csv. Trong đó có function _fputcsv() có chức năng từ một mảng một chiều đọc và ghi thành một string mỗi phần tử trong mảng khi ghi ra string sẽ
được cách nhau bổi một dấu "," để đúng với định dang csv.
function setFilename() để đặt tên cho file.
function render() để tạo file tải xuống.
+ Trong controller SiteController.php:
function actionCsv(): nhận dữ liệu từ form gửi lên đọc file csv gửi sang function CsvFileToString() và ghi lại thành một mảng đa chiều.
function actionCsvDownload(): từ một dữ liệu có sẵn, sử dụng extensions đã thêm vào ở trên để ghi lại thành một file csv.

- Sử dụng khi nào:
Khi ta muốn nhập dữ liệu vào csdl nhưng không muốn phải viết nhiều lệnh INSERT, xuất dữ liệu nào đó từ csdl hoặc từ dữ liệu tổng hợp nào đó để người xem được dễ dàng và có thể dễ dàng INSERT vào một hệ thống khác có cấu trúc csdl tương tự.
Có thể dùng làm dữ liệu đầu vào về người cần gửi cho việc gửi mail cho nhiều người.
- Ưu điểm:
Có thể tạo thành một csdl tĩnh mà không cần một hệ quản trị csdl nào.
- Nhược điểm:
Nếu dữ liệu lớn thì việc đọc gì file csv sẽ lâu và file csv không có nhiều ý nghĩa.
