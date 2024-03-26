/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.1.0 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `order` (
	`ORDER_ID` int (8),
	`CUST_ID` int (10),
	`ORD_DATE` date ,
	`TOTAL` Decimal (12),
	`STATUS` text 
); 
