-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `savenepal`;
TRUNCATE agent_debug;
INSERT INTO `agent_debug` (`agent_id`, `agent_type`, `agent_name`, `agent_phone`, `agent_email`, `agent_address`, `agent_organization`, `agent_can_travel`, `agent_duration_available`, `agent_language_known`, `agent_can_provide`, `agent_status`, `agent_deployed_in`) VALUES
(1,	'ground',	'daayitwa (busan)',	'248697851',	'248697851@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Saurpani'),
(2,	'ground',	'daayitwa + nit students',	'723335106',	'723335106@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Gotikhel'),
(3,	'ground',	'daayitwa',	'503839787',	'503839787@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Sakhu'),
(4,	'ground',	'daayitwa',	'671185572',	'671185572@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Lele'),
(5,	'ground',	'daayitwa (busan and tara)',	'565507190',	'565507190@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Saurpani'),
(6,	'ground',	'meenu maharjan\\\'s friends',	'847122024',	'847122024@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Gorkha'),
(7,	'ground',	'daayitwa (tara)',	'510464323',	'510464323@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Warehouse in Daayitwa Office'),
(8,	'ground',	'dhanej (daayitwa fellow)',	'875510749',	'875510749@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Dhading'),
(9,	'ground',	'daayitwa (rotary)',	'519918169',	'519918169@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	''),
(10,	'ground',	'nima lama',	'459913495',	'459913495@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Kavre'),
(11,	'ground',	'prabin chandra subedi',	'59910606',	'59910606@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Nuwakot'),
(12,	'ground',	'samasty',	'201841605',	'201841605@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Lalitpur'),
(13,	'ground',	'daayitwa team',	'885552882',	'885552882@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Bhaktapur'),
(14,	'ground',	'friends of bonita sharma',	'712005065',	'712005065@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Nuwakot'),
(15,	'ground',	'n/a',	'103717734',	'103717734@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	''),
(16,	'ground',	'birbahadur ghale',	'800221496',	'800221496@yellowhouse.com',	'N/A',	'N/A',	'yes',	'N/A',	'N/A',	'N/A',	2,	'Barpak');
Truncate agent_detail_debug;
INSERT INTO `agent_detail_debug` (`agent_detail_id`, `agent_detail_timestamp`, `agent_id`, `agent_name`, `agent_status`, `agent_location`) VALUES
(1,	'2015-04-05 00:00:00',	'1',	'daayitwa (busan)',	2,	'Saurpani'),
(2,	'2015-04-05 00:00:00',	'2',	'daayitwa + nit students',	2,	'Gotikhel'),
(3,	'2015-04-05 00:00:00',	'3',	'daayitwa',	2,	'Sakhu'),
(4,	'2015-05-05 00:00:00',	'4',	'daayitwa',	2,	'Lele'),
(5,	'2015-05-05 00:00:00',	'5',	'daayitwa (busan and tara)',	2,	'Saurpani'),
(6,	'2015-05-05 00:00:00',	'6',	'meenu maharjan\\\'s friends',	2,	'Gorkha'),
(7,	'2015-06-05 00:00:00',	'7',	'daayitwa (tara)',	2,	'Warehouse in Daayitwa Office'),
(8,	'2015-05-20 21:25:21',	'8',	'dhanej (daayitwa fellow)',	2,	'Dhading'),
(9,	'2015-05-20 21:25:21',	'9',	'daayitwa (rotary)',	2,	''),
(10,	'2015-05-20 21:25:21',	'10',	'nima lama',	2,	'Kavre'),
(11,	'2015-05-20 21:25:21',	'11',	'prabin chandra subedi',	2,	'Nuwakot'),
(12,	'2015-05-20 21:25:21',	'12',	'samasty',	2,	'Lalitpur'),
(13,	'2015-05-20 21:25:21',	'13',	'daayitwa team',	2,	'Bhaktapur'),
(14,	'2015-05-20 21:25:21',	'14',	'friends of bonita sharma',	2,	'Nuwakot'),
(15,	'2015-05-20 21:25:21',	'15',	'n/a',	2,	''),
(16,	'2015-05-20 21:25:21',	'16',	'birbahadur ghale',	2,	'Barpak');
Truncate item_debug;
INSERT INTO `item_debug` (`item_id`, `item_name`, `item_qty`, `item_unit`, `w_id`, `item_cat_id`) VALUES
(1,	'chiura',	5700,	'Rs',	'8',	'17'),
(2,	'sakkhar, salt, soybean',	7950,	'Rs',	'8',	'17'),
(3,	'plastic bag',	1789,	'Rs',	'8',	'18'),
(4,	'taxi',	1,	'round trip',	'8',	'19'),
(5,	'chiura (beaten rice)',	2880,	'Rs',	'8',	'17'),
(6,	'salt',	690,	'Rs',	'8',	'17'),
(7,	'transportation and other expenses',	30000,	'Rs',	'8',	'20'),
(8,	'tripal',	127,	'pieces',	'8',	'21'),
(9,	'clothes',	6,	'bags',	'8',	'6'),
(10,	'noodle',	2,	'cartoons',	'8',	'17'),
(11,	'lentil',	30,	'kilogram',	'8',	'17'),
(12,	'sugar',	21,	'kilogram',	'8',	'17'),
(13,	'others',	630,	'Rs',	'8',	'22'),
(14,	'travel (taxi)',	700,	'Rs',	'8',	'19'),
(15,	'travel cost to vdc',	1700,	'Rs',	'8',	'20'),
(16,	'bread',	100,	'packet',	'8',	'17'),
(17,	'rice',	0,	'Rs',	'8',	'17'),
(18,	'cloths',	0,	'Rs',	'8',	'6'),
(19,	'tarp roll',	14000,	'Rs',	'8',	'21'),
(20,	'medicine',	9230,	'Rs',	'8',	'23'),
(21,	'transportation + staff cost',	10000,	'Rs',	'8',	'22'),
(22,	'mask',	17,	'pcs',	'8',	'24'),
(23,	'yellow gloves',	6,	'pcs',	'8',	'25'),
(24,	'shovel',	5,	'pcs',	'8',	'26'),
(25,	'pick axe',	5,	'pcs',	'8',	'27'),
(26,	'tarp',	1,	'pcs',	'8',	'28'),
(27,	'bags of rice',	147,	'bags',	'8',	'29'),
(28,	'ors',	500,	'units',	'8',	'22'),
(29,	'cartoons of oil',	20,	'cartoons',	'8',	'30'),
(30,	'lifeboy soap',	600,	'pieces',	'8',	'31');

Truncate item_cluster_debug;
INSERT INTO `item_cluster_debug` (`item_cluster_id`, `item_id`, `cluster_item_qty`, `item_name`, `pkg_id`) VALUES
(1,	1,	5700,	'chiura',	'mission to gorkha'),
(2,	2,	7950,	'sakkhar, salt, soybean',	'mission to gorkha'),
(3,	3,	1075,	'plastic bag',	'mission to gorkha'),
(4,	3,	714,	'plastic bag',	'mission to gorkha'),
(5,	4,	1,	'taxi',	'mission to gorkha'),
(6,	5,	2880,	'chiura (beaten rice)',	'mission to gorkha'),
(7,	6,	500,	'salt',	'mission to gorkha'),
(8,	7,	30000,	'transportation and other expenses',	'mission to gorkha'),
(9,	8,	127,	'tripal',	'relief mission to lalitpur'),
(10,	9,	6,	'clothes',	'relief mission to lalitpur'),
(11,	10,	2,	'noodle',	'relief mission to sakhu'),
(12,	11,	30,	'lentil',	'relief mission to lele'),
(13,	12,	21,	'sugar',	'relief mission to lele'),
(14,	6,	40,	'salt',	'relief mission to lele'),
(15,	13,	630,	'others',	'relief mission to lele'),
(16,	14,	700,	'travel (taxi)',	'relief mission to lele'),
(17,	15,	1700,	'travel cost to vdc',	'relief mission to lele'),
(18,	16,	100,	'bread',	'relief mission to lele'),
(19,	17,	0,	'rice',	'relief mission to lele'),
(20,	18,	0,	'cloths',	'relief mission to lele'),
(21,	19,	14000,	'tarp roll',	'relief mission to gorkha'),
(22,	20,	4310,	'medicine',	'relief mission to gorkha'),
(23,	20,	4920,	'medicine',	'relief mission to gorkha'),
(24,	21,	10000,	'transportation + staff cost',	'purchase of 485 tents from butwal for distribution'),
(25,	22,	17,	'mask',	'rebuilding support at bhaktapur'),
(26,	23,	6,	'yellow gloves',	'rebuilding support at bhaktapur'),
(27,	24,	5,	'shovel',	'rebuilding support at bhaktapur'),
(28,	25,	5,	'pick axe',	'rebuilding support at bhaktapur'),
(29,	26,	1,	'tarp',	'rebuilding support at bhaktapur'),
(30,	27,	147,	'bags of rice',	'relief mission to nuwakot'),
(31,	28,	500,	'ors',	'relief mission to nuwakot'),
(32,	29,	20,	'cartoons of oil',	'relief mission to nuwakot'),
(33,	6,	150,	'salt',	'relief mission to nuwakot'),
(34,	30,	600,	'lifeboy soap',	'relief mission to nuwakot');

Truncate package_debug;
INSERT INTO `package_debug` (`pkg_id`, `pkg_count`, `pkg_status`, `pkg_timestamp`, `pkg_approval`, `agent_id`, `help_call_id`, `help_call_latlng`, `w_id`) VALUES
('loan pay',	15,	'2',	'2015-05-20 21:25:21',	'1',	15,	-1,	'27.6701623,85.308871',	8),
('mission daayitwa (rotary) #500',	9,	'2',	'2015-05-20 21:25:21',	'1',	9,	-1,	'27.6701623,85.308871',	8),
('mission dhanej (daayitwa fellow) #500',	8,	'2',	'2015-05-20 21:25:21',	'1',	8,	-1,	'84.8984775,27.9711357',	8),
('mission nima lama #500',	10,	'2',	'2015-05-20 21:25:21',	'1',	10,	-1,	'85.56121,27.525942',	8),
('mission prabin chandra subedi #500',	11,	'2',	'2015-05-20 21:25:21',	'1',	11,	51031,	'83.8724825,28.1378529',	8),
('mission samasty #500',	12,	'2',	'2015-05-20 21:25:21',	'1',	12,	-1,	'78.4120206,24.6878597',	8),
('mission to gorkha',	1,	'2',	'2015-04-05 00:00:00',	'1',	1,	36053,	'84.72,28.14',	8),
('purchase of 485 tents from butwal for distribution',	7,	'2',	'2015-06-05 00:00:00',	'1',	7,	-1,	'27.6701623,85.308871',	8),
('rebuilding support at bhaktapur',	13,	'2',	'2015-05-20 21:25:21',	'1',	13,	-1,	'85.427778,27.672222',	8),
('relief mission to gorkha',	6,	'2',	'2015-05-05 00:00:00',	'1',	6,	-1,	'84.633333,28',	8),
('relief mission to lalitpur',	2,	'2',	'2015-04-05 00:00:00',	'1',	2,	25020,	'85.4,27.5',	8),
('relief mission to lele',	4,	'2',	'2015-05-05 00:00:00',	'1',	3,	25029,	'85.34,27.57',	8),
('relief mission to nuwakot',	14,	'2',	'2015-05-20 21:25:21',	'1',	14,	51031,	'83.8724825,28.1378529',	8),
('relief mission to sakhu',	3,	'2',	'2015-04-05 00:00:00',	'1',	3,	-1,	'84.0880839,23.2920179',	8),
('relief propose',	16,	'2',	'2015-05-20 21:25:21',	'1',	16,	-1,	'84.7420032,28.2103675',	8),
('tarp delivery to gorkha mission',	5,	'2',	'2015-05-05 00:00:00',	'1',	5,	36053,	'84.72,28.14',	8);

-- 2015-05-20 15:41:24
