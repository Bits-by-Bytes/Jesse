/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.1.0 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `login` (
	`CUST_ID` int (8),
	`EMAIL` text ,
	`PWORD` text ,
	`VERIFY_CODE` text ,
	`VERIFIED_AT` text ,
	`RESET_TOKEN` varchar (675),
	`RESET_TOKEN_EXP` text ,
	`ACC_TYPE` text 
); 
