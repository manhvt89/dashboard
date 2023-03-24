<?php
/**
 * System messages translation for CodeIgniter(tm)
 * @author	CodeIgniter community
 * @copyright	Copyright (c) 2014-2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = "Phương thức xác thực email chỉ chấp nhận mảng liên kết (mảng).";
$lang['email_invalid_address'] = "Địa chỉ email không hợp lệ:% s";
$lang['email_attachment_missing'] = "Không thể tìm thấy tệp đính kèm sau:% s";
$lang['email_attachment_unreadable'] = "Không thể mở tệp đính kèm này:% s";
$lang['email_no_from'] = "Không thể gửi email mà không có tiêu đề \" Từ \".";
$lang['email_no_recipilities'] = "Bạn phải chỉ định người nhận: To, Cc hoặc Bcc";
$lang['email_send_failure_phpmail'] = "Không thể gửi email bằng hàm mail () của PHP. Máy chủ của bạn không được cấu hình để sử dụng phương pháp này.";
$lang['email_send_failure_sendmail'] = "Không thể gửi email bằng phương thức Sendmail của PHP. Máy chủ của bạn không được cấu hình để có thể sử dụng phương pháp này.";
$lang['email_send_failure_smtp'] = "Không thể gửi email bằng phương thức SMTP của PHP. Máy chủ của bạn không được cấu hình để sử dụng phương pháp này.";
$lang['email_sent'] = "Thư của bạn đã được gửi bằng giao thức sau:% s";
$lang['email_no_socket'] = "Không thể mở ổ cắm bằng Sendmail. Vui lòng kiểm tra cấu hình môi trường của bạn.";
$lang['email_no_hostname'] = "Bạn chưa chỉ định máy chủ SMTP.";
$lang['email_smtp_error'] = "Đã xảy ra lỗi SMTP sau:% s";
$lang['email_no_smtp_unpw'] = "Lỗi: Bạn phải chỉ định tên người dùng và mật khẩu SMTP.";
$lang['email_failed_smtp_login'] = "Không gửi được lệnh AUTH LOGIN. Lỗi:% s";
$lang['email_smtp_auth_un'] = "Không thể xác định tên người dùng. Lỗi:% s";
$lang['email_smtp_auth_pw'] = "Không xác định được mật khẩu. Lỗi:% s";
$lang['email_smtp_data_failure'] = "Không thể gửi dữ liệu:% s";
$lang['email_exit_status'] = "Mã trả về:% s"; 
