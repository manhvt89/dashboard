<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  pdf.config
*
* Version: 1.0.0
*
* Author: Pedro Ruiz Hidalgo
*		  ruizhidalgopedro@gmail.com
*         @pedroruizhidalg
*
* Location: application/third_party/fpdf/config/pdf.php
*
* Created:  2018-02-27
*
* Description:  This enables initial preferences for pdf library
*
* Requirements: PHP5 or above
*
*/

/*
| -------------------------------------------------------------------
|  Orientation
| -------------------------------------------------------------------
| Prototype:
|
|  'P' as "portrait", 'L' as "landscape"
|
*/
$config['orientation'] = 'P';

/*
| -------------------------------------------------------------------
|  Size
| -------------------------------------------------------------------
| Prototype:
|
|
|    A3
|    A4
|    A5
|    Letter
|    Legal
|
|   Or array, in units enabled by user, with no standarised size: array(with,hight)
*/
$config['size'] = 'A4';

/*
| -------------------------------------------------------------------
|  Rotation
| -------------------------------------------------------------------
| Prototype:
|
|  Integer multiple of 90 degrees: 0,90,180,270
|
*/
$config['rotation'] = '0';

/*
| -------------------------------------------------------------------
|  Units
| -------------------------------------------------------------------
| Prototype:
|
|   'mm' means milimetres
|   'pt' means points
|   'cm' means centimetre
|   'in' means inches
|
*/
$config['units'] = 'mm';

/*
| -------------------------------------------------------------------
|  convert logo as base_url() address
| -------------------------------------------------------------------
| Prototype:
|  TRUE , FALSE
|
| Behavior:
|   If false, logo addres will be passed as you declare
|   else, will be wrapped in base_url() function.
*/
$config['url_wrapper'] = FALSE;

/*
| -------------------------------------------------------------------
|  Logo
| -------------------------------------------------------------------
| Logo url
| the address of the logo will be subsequently converted to an absolute address
*/
$config['logo'] = 'assets/img/2ad3d3d6dfc657f65e52f33ab05eaafb.png';

/*
| -------------------------------------------------------------------
|  Head Title
| -------------------------------------------------------------------
|
| Main page's Title
*/
$config['head_title'] = '@vnpi';

/*
| -------------------------------------------------------------------
|  Head Subitle
| -------------------------------------------------------------------
|
| Main page's Subitle
*/
$config['head_subtitle'] = 'coding the world since 1983';

/*
| -------------------------------------------------------------------
|  Footer 'page' literal
| -------------------------------------------------------------------
|
| Set 'page' in your language
*/
$config['footer_page_literal'] = '';

/*
| -------------------------------------------------------------------
|  Format
| -------------------------------------------------------------------
|
| Prototype boolean
|  TRUE means UTF8.false means ISO-8959-1
*/
$config['format'] = FALSE;

/*
| -------------------------------------------------------------------
|  Font
| -------------------------------------------------------------------
|
| Prototype name of font: Arial, Times, ...
| 
*/
$config['font'] = 'Times';

$config['marginTop'] = '16'; //mm
$config['marginBottom'] = '16'; //mm
$config['marginLeft'] = '30'; //mm
$config['marginRight'] = '20'; //mm

$config['header_first_page'] = 'CHƯƠNG TRÌNH ĐÁNH GIÁ THỰC HÀNH TỐT 5S';

$config['left_signal'] = '011221';
$config['right_signal'] = 'F.16.06';

/*
* application/third_party/fpdf/config/pdf.php
*/
