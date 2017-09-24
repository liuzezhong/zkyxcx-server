-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-08-22 07:46:53
-- 服务器版本： 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zkyxcx`
--

-- --------------------------------------------------------

--
-- 表的结构 `zk_enrol`
--

CREATE TABLE `zk_enrol` (
  `enrol_id` int(11) NOT NULL COMMENT '报名ID',
  `tasks_id` int(11) NOT NULL DEFAULT '0' COMMENT '任务ID',
  `project_id` int(11) NOT NULL COMMENT '项目ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未交费 1:已缴费',
  `sign_time` int(11) NOT NULL DEFAULT '0' COMMENT '签到时间',
  `complete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否完成比赛，0为未完成，1为完成'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zk_enrol`
--

INSERT INTO `zk_enrol` (`enrol_id`, `tasks_id`, `project_id`, `user_id`, `create_time`, `pay_status`, `sign_time`, `complete`) VALUES
(67, 29, 8, 51, 1502699177, 1, 0, 0),
(68, 31, 17, 51, 1502852323, 1, 1503282941, 0),
(69, 29, 8, 54, 1502871119, 1, 0, 0),
(70, 31, 14, 54, 1502871672, 0, 0, 0),
(71, 29, 7, 56, 1502873176, 1, 0, 0),
(72, 31, 17, 56, 1502873338, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zk_enrol_k`
--

CREATE TABLE `zk_enrol_k` (
  `k_id` int(11) NOT NULL COMMENT '报名ID',
  `tasks_id` int(11) NOT NULL COMMENT '项目ID',
  `name_id` int(11) NOT NULL COMMENT '列名ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='报名列名映射表';

--
-- 转存表中的数据 `zk_enrol_k`
--

INSERT INTO `zk_enrol_k` (`k_id`, `tasks_id`, `name_id`) VALUES
(13, 29, 1),
(14, 29, 2),
(15, 29, 3),
(16, 29, 4),
(17, 29, 5),
(18, 29, 7),
(19, 29, 9),
(20, 29, 10),
(21, 29, 11),
(22, 29, 12),
(23, 29, 13),
(24, 29, 14),
(25, 29, 15),
(26, 29, 16),
(27, 29, 18),
(28, 30, 1),
(29, 30, 2),
(30, 30, 3),
(31, 30, 4),
(32, 30, 5),
(33, 30, 9),
(34, 30, 14),
(35, 30, 15),
(36, 30, 16),
(37, 30, 19),
(38, 31, 2);

-- --------------------------------------------------------

--
-- 表的结构 `zk_enrol_name`
--

CREATE TABLE `zk_enrol_name` (
  `name_id` int(11) NOT NULL COMMENT '列名ID',
  `name` varchar(255) NOT NULL COMMENT '列名',
  `fieldtype` varchar(250) NOT NULL COMMENT '字段类型',
  `required` int(1) NOT NULL DEFAULT '0' COMMENT '必填项，0为非，1为必填',
  `attribute` int(1) NOT NULL DEFAULT '0' COMMENT '列属性，1为官方，0为普通',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zk_enrol_name`
--

INSERT INTO `zk_enrol_name` (`name_id`, `name`, `fieldtype`, `required`, `attribute`, `create_time`) VALUES
(1, '参赛者姓名', 'input', 1, 1, 0),
(2, '手机号', 'input', 1, 1, 0),
(3, '出生日期', '', 0, 1, 0),
(4, '性别', '', 0, 1, 0),
(5, '血型', '', 0, 1, 0),
(6, '国籍', '', 0, 1, 0),
(7, '所在城市', '', 0, 1, 0),
(8, '证件类型', '', 0, 1, 0),
(9, '身份证号', '', 0, 1, 0),
(10, '电子邮箱', '', 0, 1, 0),
(11, '紧急联系人', '', 0, 1, 0),
(12, '紧急联系电话', '', 0, 1, 0),
(13, '通讯地址', '', 0, 1, 0),
(14, '身高', '', 0, 1, 0),
(15, '体重', '', 0, 1, 0),
(16, '衣服尺码', '', 0, 1, 0),
(17, '学历', '', 0, 1, 0),
(18, '职业', '', 0, 1, 0),
(19, '保险单号', '', 0, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zk_enrol_value`
--

CREATE TABLE `zk_enrol_value` (
  `value_id` int(11) NOT NULL COMMENT '列值ID',
  `enrol_id` int(11) NOT NULL COMMENT '报名ID',
  `name_id` int(11) NOT NULL COMMENT '列名ID',
  `value` varchar(255) NOT NULL COMMENT '列值',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='列值ID';

--
-- 转存表中的数据 `zk_enrol_value`
--

INSERT INTO `zk_enrol_value` (`value_id`, `enrol_id`, `name_id`, `value`, `create_time`) VALUES
(824, 67, 1, '刘泽中', 1502699177),
(825, 67, 2, '18852983610', 1502699177),
(826, 67, 3, '2017-08-15', 1502699177),
(827, 67, 4, '女', 1502699177),
(828, 67, 5, 'B', 1502699177),
(829, 67, 7, '[\"\\u6c5f\\u82cf\\u7701\",\"\\u65e0\\u9521\\u5e02\",\"\\u5317\\u5858\\u533a\"]', 1502699177),
(830, 67, 9, '420114199510250070', 1502699177),
(831, 67, 10, 'zhongliuze@gmail.com', 1502699177),
(832, 67, 11, '吕单凤', 1502699177),
(833, 67, 12, '18206183097', 1502699177),
(834, 67, 13, '时代峰峻爱丽丝到家里', 1502699177),
(835, 67, 14, '153cm', 1502699177),
(836, 67, 15, '43kg', 1502699177),
(837, 67, 16, 'XXL', 1502699177),
(838, 67, 18, '[0,5]', 1502699177),
(839, 68, 2, '18852983610', 1502852323),
(840, 69, 1, '钱峰', 1502871120),
(841, 69, 2, '17712372385', 1502871120),
(842, 69, 3, '1989-03-08', 1502871120),
(843, 69, 4, '男', 1502871120),
(844, 69, 5, 'O', 1502871120),
(845, 69, 7, '[\"\\u6c5f\\u82cf\\u7701\",\"\\u65e0\\u9521\\u5e02\",\"\\u5317\\u5858\\u533a\"]', 1502871120),
(846, 69, 9, '320204198903083511', 1502871120),
(847, 69, 10, '1827793966@qq.com', 1502871120),
(848, 69, 11, '徐晓燕', 1502871120),
(849, 69, 12, '13861882361', 1502871120),
(850, 69, 13, '无锡东门和泰苑8号102', 1502871120),
(851, 69, 14, '170cm', 1502871120),
(852, 69, 15, '60kg', 1502871120),
(853, 69, 16, 'L', 1502871120),
(854, 69, 18, '[0,0]', 1502871120),
(855, 70, 2, '15868866655555', 1502871672),
(856, 71, 1, '赵曈', 1502873176),
(857, 71, 2, '18694951102', 1502873176),
(858, 71, 3, '1989-11-02', 1502873176),
(859, 71, 4, '女', 1502873176),
(860, 71, 5, 'B', 1502873177),
(861, 71, 7, '[9,1,2]', 1502873177),
(862, 71, 9, '152128198911021826', 1502873177),
(863, 71, 10, '211307932@qq.com', 1502873177),
(864, 71, 11, '郭晨霞', 1502873177),
(865, 71, 12, ' 13314806875', 1502873177),
(866, 71, 13, '', 1502873177),
(867, 71, 14, '168cm', 1502873177),
(868, 71, 15, '请选择体重', 1502873177),
(869, 71, 16, 'M', 1502873177),
(870, 71, 18, '[0,0]', 1502873177),
(871, 72, 2, '18694951102', 1502873338),
(872, 73, 1, '', 1503045894),
(873, 73, 2, '', 1503045894),
(874, 73, 3, '1995-10-25', 1503045894),
(875, 73, 4, '', 1503045894),
(876, 73, 5, '请选择血型', 1503045895),
(877, 73, 7, '[\"\\u6c5f\\u82cf\\u7701\",\"\\u65e0\\u9521\\u5e02\",\"\\u5317\\u5858\\u533a\"]', 1503045895),
(878, 73, 9, '', 1503045895),
(879, 73, 10, '', 1503045895),
(880, 73, 11, '', 1503045895),
(881, 73, 12, '', 1503045895),
(882, 73, 13, '', 1503045895),
(883, 73, 14, '请选择身高', 1503045895),
(884, 73, 15, '请选择体重', 1503045895),
(885, 73, 16, '请选择尺码', 1503045895),
(886, 73, 18, '[0,0]', 1503045895);

-- --------------------------------------------------------

--
-- 表的结构 `zk_evaluate`
--

CREATE TABLE `zk_evaluate` (
  `evaluate_id` int(11) NOT NULL COMMENT '评论ID',
  `tasks_id` int(11) NOT NULL COMMENT '任务ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `value` varchar(500) NOT NULL COMMENT '评论主体',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务评价信息表';

-- --------------------------------------------------------

--
-- 表的结构 `zk_event`
--

CREATE TABLE `zk_event` (
  `event_id` int(11) NOT NULL COMMENT '类别ID',
  `name` varchar(255) NOT NULL COMMENT '类别名',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '状态：0为正常，1为冻结',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zk_event`
--

INSERT INTO `zk_event` (`event_id`, `name`, `status`, `create_time`) VALUES
(1, '跑步', 0, 0),
(2, '户外', 0, 0),
(3, '骑行', 0, 0),
(4, '足球', 0, 0),
(5, '篮球', 0, 0),
(6, '网球', 0, 0),
(7, '羽毛球', 0, 0),
(8, '高尔夫', 0, 0),
(9, '游泳', 0, 0),
(10, '乒乓球', 0, 0),
(11, '排球', 0, 0),
(12, '跆拳道', 0, 0),
(13, '台球', 0, 0),
(14, '瑜伽', 0, 0),
(15, '舞蹈', 0, 0),
(16, '武术', 0, 0),
(17, '健美', 0, 0),
(18, '赛车', 0, 0),
(19, '水上', 0, 0),
(20, '冰雪', 0, 0),
(21, '柔道', 0, 0),
(22, '棋牌', 0, 0),
(23, '搏击', 0, 0),
(24, '轮滑', 0, 0),
(25, '射击', 0, 0),
(26, '骑马', 0, 0),
(27, '体操', 0, 0),
(28, '保龄球', 0, 0),
(29, '棒球', 0, 0),
(30, '电子竞技', 0, 0),
(31, '垒球', 0, 0),
(32, '手球', 0, 0),
(33, '曲棍球', 0, 0),
(34, '击剑', 0, 0),
(35, '民族体育', 0, 0),
(36, '其它', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zk_payrecord`
--

CREATE TABLE `zk_payrecord` (
  `payrecord_id` int(11) NOT NULL COMMENT '交易记录ID',
  `total_fee` float(8,2) NOT NULL COMMENT '交易金额',
  `open_id` varchar(255) NOT NULL COMMENT '用户标识',
  `out_trade_no` varchar(255) NOT NULL COMMENT '商户订单号',
  `tasks_id` int(11) NOT NULL COMMENT '任务ID',
  `project_id` int(11) NOT NULL COMMENT '项目ID',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zk_payrecord`
--

INSERT INTO `zk_payrecord` (`payrecord_id`, `total_fee`, `open_id`, `out_trade_no`, `tasks_id`, `project_id`, `create_time`) VALUES
(1, 1.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '3349d8b8fda841a7d3f44bf312a54db5', 0, 0, 0),
(2, 1.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '066d9d28b391df4f60fedd5104d011cd', 0, 0, 0),
(3, 1.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', 'f7173901fc6d7175b413f1a045d32bd8', 0, 0, 0),
(4, 5000.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '93bbea219313033cc2b60d1f9cf54f61', 0, 0, 0),
(5, 1.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '72dbb95f715ff2e3de57839a2703ef51', 0, 0, 0),
(6, 10.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '50f2a40e4cc7625967244ae3f3d8aa81', 0, 0, 1501482619),
(7, 50.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '84fb8c1e1da80311dd726547b62f4027', 0, 0, 1501482665),
(8, 0.01, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '89d93229f6da6c263e5367a0520bb259', 0, 0, 1501482717),
(9, 30.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '89d93229f6da6c263e5367a0520bb259', 29, 5, 1501482733),
(10, 0.01, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '9e4e284f734faf4f39599488d67463c4', 0, 0, 1501482871),
(11, 10.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '9e4e284f734faf4f39599488d67463c4', 29, 7, 1501482896),
(15, 10.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', '8237f2c1f00153566b425f9a63957320', 29, 7, 1501489525),
(28, 1.00, 'oUpv60BxQQMlCkOc-DqTgoT78hQs', 'fbc0aaca3601a7b30380feb07eee55c7', 29, 7, 1502072401),
(36, 0.00, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', 'undefined', 29, 8, 1502699177),
(37, 0.00, 'oUpv60BxQQMlCkOc-DqTgoT78hQs', 'undefined', 29, 8, 1502871120),
(38, 1.00, 'oUpv60FaDJsXSaWjf_7FJEUvakzg', 'edb137f4f4844912ffa11d4764ea1122', 29, 7, 1502873191);

-- --------------------------------------------------------

--
-- 表的结构 `zk_project`
--

CREATE TABLE `zk_project` (
  `project_id` int(11) NOT NULL COMMENT '项目ID',
  `tasks_id` int(11) NOT NULL COMMENT '任务ID',
  `title` varchar(255) NOT NULL COMMENT '项目标题',
  `price` double(8,2) NOT NULL DEFAULT '0.00' COMMENT '项目价格',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目表';

--
-- 转存表中的数据 `zk_project`
--

INSERT INTO `zk_project` (`project_id`, `tasks_id`, `title`, `price`, `create_time`, `update_time`) VALUES
(5, 29, '3v3篮球赛', 30.00, 1500861402, 0),
(6, 29, '5v5篮球赛', 50.00, 1500861402, 0),
(7, 29, '1v1斗牛', 1.00, 1500861402, 0),
(8, 29, '花式篮球', 0.00, 1500861402, 0),
(9, 30, '花式游泳', 20.00, 1500948886, 0),
(10, 30, '自由泳', 20.00, 1500948886, 0),
(11, 30, '蛙泳', 20.00, 1500948886, 0),
(12, 30, '仰泳', 20.00, 1500948886, 0),
(13, 31, '50米自由泳', 20.00, 1500962546, 0),
(14, 31, '100米自由泳', 20.00, 1500962546, 0),
(15, 31, '50米蛙泳', 20.00, 1500962546, 0),
(16, 31, '100米蛙泳', 20.00, 1500962547, 0),
(17, 31, '800米自由泳', 20.00, 1500962547, 0);

-- --------------------------------------------------------

--
-- 表的结构 `zk_session`
--

CREATE TABLE `zk_session` (
  `id` int(11) NOT NULL COMMENT '会话 ID（自增长）',
  `openid` varchar(255) NOT NULL COMMENT '微信服务端返回的 `open_id` 值',
  `session_key` varchar(255) NOT NULL COMMENT '微信服务端返回的 `session_key` 值',
  `skey` varchar(255) NOT NULL COMMENT '会话 Skey',
  `create_time` int(11) NOT NULL COMMENT '会话创建时间',
  `last_visit_time` int(11) NOT NULL COMMENT '最近访问时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会话记录表';

--
-- 转存表中的数据 `zk_session`
--

INSERT INTO `zk_session` (`id`, `openid`, `session_key`, `skey`, `create_time`, `last_visit_time`) VALUES
(54, 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', 'ojcpHqYJaSeiaHxFsDAoMA==', '4e4a1efccbf5e38faf59a4316753d57c', 1502070726, 1503372153),
(57, 'oUpv60BxQQMlCkOc-DqTgoT78hQs', 'tS61654BatrwQrnX9dla3Q==', '79ac34f5b613c0fb7064bcfb91e30e8e', 1502866373, 1503045735),
(59, 'oUpv60FaDJsXSaWjf_7FJEUvakzg', '8WyVNkgEj4DvCf2SwoGUcA==', 'bbcfea3ae0a5905aac0b4957e693edcc', 1502872886, 1502872903);

-- --------------------------------------------------------

--
-- 表的结构 `zk_tasks`
--

CREATE TABLE `zk_tasks` (
  `tasks_id` int(11) NOT NULL COMMENT '任务ID',
  `title` varchar(255) NOT NULL COMMENT '任务标题',
  `category` int(11) NOT NULL COMMENT '类别ID',
  `description` text NOT NULL COMMENT '任务描述',
  `reward` int(11) NOT NULL DEFAULT '0' COMMENT '任务奖励',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '任务开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '任务结束时间',
  `leader` varchar(255) NOT NULL COMMENT '负责人姓名',
  `contact` varchar(20) NOT NULL COMMENT '负责人联系方式',
  `enrol_start_time` int(11) NOT NULL DEFAULT '0' COMMENT '报名开始时间',
  `enrol_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '报名结束时间',
  `personal_limit` int(11) NOT NULL DEFAULT '0' COMMENT '个人报名人数上限',
  `team_limit` int(11) NOT NULL DEFAULT '0' COMMENT '团体报名数上限',
  `team_personal_limit` int(11) NOT NULL DEFAULT '0' COMMENT '单个团队人数上限',
  `total_personal` int(11) NOT NULL DEFAULT '0' COMMENT '活动总人数上限',
  `minimum_age` int(11) NOT NULL DEFAULT '0' COMMENT '最小年龄',
  `maximum_age` int(11) NOT NULL DEFAULT '0' COMMENT '最大年龄',
  `statement` text NOT NULL COMMENT '参赛选手说明',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '任务创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '任务创建者ID',
  `program_code` varchar(50) NOT NULL COMMENT '任务小程序二维码',
  `tasks_image` varchar(500) NOT NULL COMMENT '任务图片',
  `sponsor` varchar(250) NOT NULL COMMENT '主办方',
  `view_times` int(11) NOT NULL COMMENT '查看次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务信息表';

--
-- 转存表中的数据 `zk_tasks`
--

INSERT INTO `zk_tasks` (`tasks_id`, `title`, `category`, `description`, `reward`, `start_time`, `end_time`, `leader`, `contact`, `enrol_start_time`, `enrol_end_time`, `personal_limit`, `team_limit`, `team_personal_limit`, `total_personal`, `minimum_age`, `maximum_age`, `statement`, `create_time`, `update_time`, `user_id`, `program_code`, `tasks_image`, `sponsor`, `view_times`) VALUES
(29, '街区篮球赛', 5, '请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。', 100, 1500912000, 1501171200, '刘泽中', '18852983610', 1500912000, 1501084800, 20, 20, 5, 120, 18, 50, '请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。', 1503303320, 0, 0, 'http://127.0.0.1/Public/image/program/29.png', 'http://192.168.100.252/public/image/tasks/lanqiu.jpg', '由中铠街区体育主办', 13),
(30, '年度羽毛球赛', 9, '请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。请列出将要举办赛事活动的相关简介或竞赛规程，并详细介绍活动信息。', 200, 1501171200, 1501344000, '刘泽中', '18852983610', 1499788800, 1500652800, 15, 20, 5, 120, 5, 60, '请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。请列出将要参赛选手的相关约定或竞赛规程，并详细介绍活动信息。', 1500948859, 0, 0, 'http://127.0.0.1/Public/image/program/30.png', 'http://192.168.100.252/public/image/tasks/yumaoqiu.jpg', '无锡市羽毛球协会主办', 250),
(31, '全民健身游泳', 5, '一、主办单位：市委宣传部、市委网信办、市体育局、市互联网协会\n\n二、承办单位：无锡新传媒、无锡运动网、市蠡湖风景区管理处、市乒乓球协会、市武术协会、市篮球协会、市羽毛球协会、市游泳协会、无锡市博威体育产业投资发展有限公司、无锡市新威体育场馆运营管理有限公司、无锡中铠城市运动公园\n\n三、媒体支持：扬子晚报、现代快报、无锡日报、江南晚报、无锡商报、无锡广电新闻综合频道、都市资讯频道、新闻广播、经济广播、交通广播、无锡发布、太湖明珠网、江南晚报网、无锡观察、无锡博报、智慧无锡、人民日报数字大屏\n视觉支持：大衍文化\n保险支持：国联人寿', 100, 1501516800, 1501689600, '无锡中铠城市运动公园', '13812084569', 1500998400, 1501430400, 200, 100, 0, 0, 0, 0, '', 1500962083, 0, 0, 'http://192.168.100.252/Public/image/program/31.png', 'http://192.168.100.252/public/image/tasks/youyong.jpg', '市体育局主办中铠协办', 3);

-- --------------------------------------------------------

--
-- 表的结构 `zk_user`
--

CREATE TABLE `zk_user` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `nick_name` varchar(255) DEFAULT NULL COMMENT '昵称',
  `openid` varchar(250) NOT NULL COMMENT '小程序用户标识',
  `avatarurl` varchar(1000) DEFAULT NULL COMMENT '头像地址',
  `rankmoney` int(11) NOT NULL DEFAULT '0' COMMENT '铠币',
  `user_type` int(1) NOT NULL DEFAULT '0' COMMENT '用户类型：0普通用户 1管理员',
  `user_status` int(1) NOT NULL DEFAULT '0' COMMENT '用户状态：0正常 1冻结',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `zk_user`
--

INSERT INTO `zk_user` (`user_id`, `nick_name`, `openid`, `avatarurl`, `rankmoney`, `user_type`, `user_status`, `create_time`) VALUES
(51, '刘泽中', 'oUpv60E98MOGnr9Z9Ele1UYroiLQ', 'https://wx.qlogo.cn/mmopen/ajNVdqHZLLBTmGj2tHjiclnwugcGBLM8iaoPKrm5s6VAdM3XKol53cZ4af5r8dCJgeGLtlwNzFgw5g1k7PrhPVXg/0', 800, 0, 0, 1502070725),
(54, 'qf', 'oUpv60BxQQMlCkOc-DqTgoT78hQs', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83errYzcnqaKEicIlib63yw1o0Fd0c6ZRFvmonmvoMw6iaCrVkuhKgYaibDeNyLicplAU4jwbKK8icp1NMXibw/0', 10, 0, 0, 1502866373),
(56, '加菲', 'oUpv60FaDJsXSaWjf_7FJEUvakzg', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eodv94ia77LicR1VGiaB2hfQqRYKP7dgWiam7vNMRskor0W1HWyViaTqhopF4gFSn1Gkfq9yicaFIme1eMA/0', 10, 0, 0, 1502872886);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zk_enrol`
--
ALTER TABLE `zk_enrol`
  ADD PRIMARY KEY (`enrol_id`);

--
-- Indexes for table `zk_enrol_k`
--
ALTER TABLE `zk_enrol_k`
  ADD PRIMARY KEY (`k_id`);

--
-- Indexes for table `zk_enrol_name`
--
ALTER TABLE `zk_enrol_name`
  ADD PRIMARY KEY (`name_id`);

--
-- Indexes for table `zk_enrol_value`
--
ALTER TABLE `zk_enrol_value`
  ADD PRIMARY KEY (`value_id`);

--
-- Indexes for table `zk_evaluate`
--
ALTER TABLE `zk_evaluate`
  ADD PRIMARY KEY (`evaluate_id`);

--
-- Indexes for table `zk_event`
--
ALTER TABLE `zk_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `zk_payrecord`
--
ALTER TABLE `zk_payrecord`
  ADD PRIMARY KEY (`payrecord_id`);

--
-- Indexes for table `zk_project`
--
ALTER TABLE `zk_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `zk_session`
--
ALTER TABLE `zk_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zk_tasks`
--
ALTER TABLE `zk_tasks`
  ADD PRIMARY KEY (`tasks_id`);

--
-- Indexes for table `zk_user`
--
ALTER TABLE `zk_user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `zk_enrol`
--
ALTER TABLE `zk_enrol`
  MODIFY `enrol_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '报名ID', AUTO_INCREMENT=74;
--
-- 使用表AUTO_INCREMENT `zk_enrol_k`
--
ALTER TABLE `zk_enrol_k`
  MODIFY `k_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '报名ID', AUTO_INCREMENT=39;
--
-- 使用表AUTO_INCREMENT `zk_enrol_name`
--
ALTER TABLE `zk_enrol_name`
  MODIFY `name_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '列名ID', AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `zk_enrol_value`
--
ALTER TABLE `zk_enrol_value`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '列值ID', AUTO_INCREMENT=887;
--
-- 使用表AUTO_INCREMENT `zk_evaluate`
--
ALTER TABLE `zk_evaluate`
  MODIFY `evaluate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID';
--
-- 使用表AUTO_INCREMENT `zk_event`
--
ALTER TABLE `zk_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '类别ID', AUTO_INCREMENT=37;
--
-- 使用表AUTO_INCREMENT `zk_payrecord`
--
ALTER TABLE `zk_payrecord`
  MODIFY `payrecord_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '交易记录ID', AUTO_INCREMENT=39;
--
-- 使用表AUTO_INCREMENT `zk_project`
--
ALTER TABLE `zk_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目ID', AUTO_INCREMENT=18;
--
-- 使用表AUTO_INCREMENT `zk_session`
--
ALTER TABLE `zk_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会话 ID（自增长）', AUTO_INCREMENT=60;
--
-- 使用表AUTO_INCREMENT `zk_tasks`
--
ALTER TABLE `zk_tasks`
  MODIFY `tasks_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '任务ID', AUTO_INCREMENT=32;
--
-- 使用表AUTO_INCREMENT `zk_user`
--
ALTER TABLE `zk_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID', AUTO_INCREMENT=57;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
