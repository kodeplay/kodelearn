-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2011 at 01:15 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kodelearn_blank`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE IF NOT EXISTS `attendances` (
  `event_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `present` tinyint(1) NOT NULL,
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendances`
--


-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE IF NOT EXISTS `batches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `batches`
--


-- --------------------------------------------------------

--
-- Table structure for table `batches_users`
--

CREATE TABLE IF NOT EXISTS `batches_users` (
  `user_id` int(11) unsigned NOT NULL,
  `batch_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`batch_id`),
  KEY `batch_id` (`batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batches_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `access_code` varchar(50) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `courses`
--


-- --------------------------------------------------------

--
-- Table structure for table `courses_users`
--

CREATE TABLE IF NOT EXISTS `courses_users` (
  `user_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `documents_courses`
--

CREATE TABLE IF NOT EXISTS `documents_courses` (
  `course_id` int(11) unsigned NOT NULL,
  `document_id` int(11) unsigned NOT NULL,
  KEY `course_id` (`course_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents_courses`
--


-- --------------------------------------------------------

--
-- Table structure for table `documents_roles`
--

CREATE TABLE IF NOT EXISTS `documents_roles` (
  `role_id` int(11) unsigned NOT NULL,
  `document_id` int(11) unsigned NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents_roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eventtype` enum('exam','lecture') NOT NULL,
  `eventstart` varchar(15) NOT NULL,
  `eventend` varchar(15) NOT NULL,
  `room_id` int(10) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `cancel` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_events_rooms` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `events`
--


-- --------------------------------------------------------

--
-- Table structure for table `examgroups`
--

CREATE TABLE IF NOT EXISTS `examgroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `publish` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `examgroups`
--


-- --------------------------------------------------------

--
-- Table structure for table `examresults`
--

CREATE TABLE IF NOT EXISTS `examresults` (
  `exam_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `marks` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examresults`
--


-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE IF NOT EXISTS `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `examgroup_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  `total_marks` int(10) unsigned NOT NULL,
  `passing_marks` int(10) unsigned NOT NULL,
  `reminder` enum('1','0') NOT NULL DEFAULT '1',
  `reminder_days` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_exams_examgroups` (`examgroup_id`),
  KEY `FK_exams_events` (`event_id`),
  KEY `FK_exams_courses` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exams`
--


-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE IF NOT EXISTS `feeds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `respective_id` int(11) unsigned NOT NULL DEFAULT '0',
  `course_id` int(11) unsigned NOT NULL DEFAULT '0',
  `actor_id` int(11) unsigned NOT NULL,
  `time` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_feed_courses` (`course_id`),
  KEY `FK_feed_users` (`actor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `feeds`
--


-- --------------------------------------------------------

--
-- Table structure for table `feedstreams`
--

CREATE TABLE IF NOT EXISTS `feedstreams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `course_id` int(11) NOT NULL DEFAULT '0',
  `batch_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idk_unique_combination` (`id`,`user_id`,`role_id`,`course_id`,`batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `feedstreams`
--


-- --------------------------------------------------------

--
-- Table structure for table `feeds_feedstreams`
--

CREATE TABLE IF NOT EXISTS `feeds_feedstreams` (
  `feed_id` int(11) unsigned NOT NULL,
  `feedstream_id` int(11) NOT NULL,
  KEY `feedstream_id` (`feedstream_id`),
  KEY `feed_id` (`feed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feeds_feedstreams`
--


-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE IF NOT EXISTS `institutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `institution_type_id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `website` varchar(128) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `name`, `institution_type_id`, `logo`, `address`, `website`, `last_modified`) VALUES
(1, 'SFIT', 1, 'inst_1315202896_android.jpg', 'test', 'http://www.sfit.com', '2011-09-05 11:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `institutiontypes`
--

CREATE TABLE IF NOT EXISTS `institutiontypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `institutiontypes`
--

INSERT INTO `institutiontypes` (`id`, `name`) VALUES
(1, 'High School'),
(2, 'Junior College'),
(3, 'Professional Institution'),
(4, 'Coaching Class'),
(5, 'B-School');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE IF NOT EXISTS `lectures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `course_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `room_id` int(11) unsigned NOT NULL,
  `type` enum('once','repeat') CHARACTER SET latin1 NOT NULL DEFAULT 'once',
  `when` varchar(255) NOT NULL COMMENT 'It will sotre the unserialized array of the days of the lecture with time if the lecture is repeating',
  `start_date` varchar(15) NOT NULL,
  `end_date` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_lectures_courses` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lectures`
--


-- --------------------------------------------------------

--
-- Table structure for table `lectures_events`
--

CREATE TABLE IF NOT EXISTS `lectures_events` (
  `lecture_id` int(11) unsigned NOT NULL,
  `event_id` int(11) unsigned NOT NULL,
  KEY `FK_lectures_events_lectures` (`lecture_id`),
  KEY `FK_lectures_events_events` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lectures_events`
--


-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `image` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `locations`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET latin1 NOT NULL,
  `link` varchar(512) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_posts_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `questionattributes`
--

CREATE TABLE IF NOT EXISTS `questionattributes` (
  `question_id` int(11) NOT NULL,
  `attribute_name` varchar(32) NOT NULL,
  `attribute_value` text NOT NULL,
  `explanation` text NOT NULL,
  `correctness` tinyint(1) NOT NULL,
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questionattributes`
--


-- --------------------------------------------------------

--
-- Table structure for table `questionhints`
--

CREATE TABLE IF NOT EXISTS `questionhints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `hint` text NOT NULL,
  `deduction` float NOT NULL,
  `sort_order` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `questionhints`
--


-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `extra` varchar(255) NOT NULL,
  `type` enum('choice','grouped','matching','open','ordering') NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) unsigned NOT NULL,   
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `questions`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `permissions`) VALUES
(2, 'Admin', 'Administrative user, has access to everything.cd', 'a:94:{s:12:"account_view";s:1:"1";s:14:"account_create";s:1:"1";s:12:"account_edit";s:1:"1";s:14:"account_delete";s:1:"1";s:15:"assignment_view";s:1:"1";s:17:"assignment_create";s:1:"1";s:15:"assignment_edit";s:1:"1";s:17:"assignment_delete";s:1:"1";s:15:"attendance_view";s:1:"1";s:17:"attendance_create";s:1:"1";s:15:"attendance_edit";s:1:"1";s:17:"attendance_delete";s:1:"1";s:10:"batch_view";s:1:"1";s:12:"batch_create";s:1:"1";s:10:"batch_edit";s:1:"1";s:12:"batch_delete";s:1:"1";s:13:"calendar_view";s:1:"1";s:11:"course_view";s:1:"1";s:13:"course_create";s:1:"1";s:11:"course_edit";s:1:"1";s:13:"course_delete";s:1:"1";s:11:"course_join";s:1:"1";s:13:"document_view";s:1:"1";s:15:"document_upload";s:1:"1";s:17:"document_download";s:1:"1";s:13:"document_edit";s:1:"1";s:15:"document_delete";s:1:"1";s:10:"event_view";s:1:"1";s:12:"event_create";s:1:"1";s:10:"event_edit";s:1:"1";s:12:"event_delete";s:1:"1";s:9:"exam_view";s:1:"1";s:11:"exam_create";s:1:"1";s:9:"exam_edit";s:1:"1";s:11:"exam_delete";s:1:"1";s:14:"examgroup_view";s:1:"1";s:16:"examgroup_create";s:1:"1";s:14:"examgroup_edit";s:1:"1";s:16:"examgroup_delete";s:1:"1";s:18:"exammarksheet_view";s:1:"1";s:20:"exammarksheet_create";s:1:"1";s:18:"exammarksheet_edit";s:1:"1";s:20:"exammarksheet_delete";s:1:"1";s:15:"examresult_view";s:1:"1";s:17:"examresult_create";s:1:"1";s:15:"examresult_edit";s:1:"1";s:17:"examresult_delete";s:1:"1";s:9:"feed_view";s:1:"1";s:14:"flashcard_view";s:1:"1";s:16:"flashcard_create";s:1:"1";s:14:"flashcard_edit";s:1:"1";s:16:"flashcard_delete";s:1:"1";s:12:"lecture_view";s:1:"1";s:14:"lecture_create";s:1:"1";s:12:"lecture_edit";s:1:"1";s:14:"lecture_delete";s:1:"1";s:11:"lesson_view";s:1:"1";s:13:"lesson_create";s:1:"1";s:11:"lesson_edit";s:1:"1";s:13:"lesson_delete";s:1:"1";s:13:"location_view";s:1:"1";s:15:"location_create";s:1:"1";s:13:"location_edit";s:1:"1";s:15:"location_delete";s:1:"1";s:9:"post_view";s:1:"1";s:11:"post_create";s:1:"1";s:9:"post_edit";s:1:"1";s:11:"post_delete";s:1:"1";s:13:"question_view";s:1:"1";s:15:"question_create";s:1:"1";s:13:"question_edit";s:1:"1";s:15:"question_delete";s:1:"1";s:9:"quiz_view";s:1:"1";s:11:"quiz_create";s:1:"1";s:9:"quiz_edit";s:1:"1";s:11:"quiz_delete";s:1:"1";s:9:"role_view";s:1:"1";s:11:"role_create";s:1:"1";s:9:"role_edit";s:1:"1";s:11:"role_delete";s:1:"1";s:19:"role_set_permission";s:1:"1";s:9:"room_view";s:1:"1";s:11:"room_create";s:1:"1";s:9:"room_edit";s:1:"1";s:11:"room_delete";s:1:"1";s:11:"system_view";s:1:"1";s:13:"system_create";s:1:"1";s:11:"system_edit";s:1:"1";s:13:"system_delete";s:1:"1";s:9:"user_view";s:1:"1";s:11:"user_create";s:1:"1";s:9:"user_edit";s:1:"1";s:11:"user_delete";s:1:"1";s:15:"user_upload_csv";s:1:"1";}'),
(3, 'Teacher', 'Courses and Limited Admin accessdfdf', 'a:91:{s:12:"account_view";s:1:"1";s:14:"account_create";s:1:"1";s:12:"account_edit";s:1:"1";s:14:"account_delete";s:1:"1";s:15:"assignment_view";s:1:"1";s:17:"assignment_create";s:1:"1";s:15:"assignment_edit";s:1:"1";s:17:"assignment_delete";s:1:"1";s:15:"attendance_view";s:1:"1";s:17:"attendance_create";s:1:"1";s:15:"attendance_edit";s:1:"1";s:17:"attendance_delete";s:1:"1";s:10:"batch_view";s:1:"1";s:12:"batch_create";s:1:"1";s:10:"batch_edit";s:1:"1";s:12:"batch_delete";s:1:"1";s:13:"calendar_view";s:1:"1";s:11:"course_view";s:1:"1";s:13:"course_create";s:1:"1";s:11:"course_edit";s:1:"1";s:13:"course_delete";s:1:"1";s:13:"document_view";s:1:"1";s:15:"document_upload";s:1:"1";s:17:"document_download";s:1:"1";s:13:"document_edit";s:1:"1";s:15:"document_delete";s:1:"1";s:10:"event_view";s:1:"1";s:12:"event_create";s:1:"1";s:10:"event_edit";s:1:"1";s:12:"event_delete";s:1:"1";s:9:"exam_view";s:1:"1";s:11:"exam_create";s:1:"1";s:9:"exam_edit";s:1:"1";s:11:"exam_delete";s:1:"1";s:14:"examgroup_view";s:1:"1";s:16:"examgroup_create";s:1:"1";s:14:"examgroup_edit";s:1:"1";s:16:"examgroup_delete";s:1:"1";s:18:"exammarksheet_view";s:1:"1";s:20:"exammarksheet_create";s:1:"1";s:18:"exammarksheet_edit";s:1:"1";s:20:"exammarksheet_delete";s:1:"1";s:15:"examresult_view";s:1:"1";s:17:"examresult_create";s:1:"1";s:15:"examresult_edit";s:1:"1";s:17:"examresult_delete";s:1:"1";s:9:"feed_view";s:1:"1";s:14:"flashcard_view";s:1:"1";s:16:"flashcard_create";s:1:"1";s:14:"flashcard_edit";s:1:"1";s:16:"flashcard_delete";s:1:"1";s:12:"lecture_view";s:1:"1";s:14:"lecture_create";s:1:"1";s:12:"lecture_edit";s:1:"1";s:14:"lecture_delete";s:1:"1";s:11:"lesson_view";s:1:"1";s:13:"lesson_create";s:1:"1";s:11:"lesson_edit";s:1:"1";s:13:"lesson_delete";s:1:"1";s:13:"location_view";s:1:"1";s:15:"location_create";s:1:"1";s:13:"location_edit";s:1:"1";s:15:"location_delete";s:1:"1";s:9:"post_view";s:1:"1";s:11:"post_create";s:1:"1";s:9:"post_edit";s:1:"1";s:11:"post_delete";s:1:"1";s:13:"question_view";s:1:"1";s:15:"question_create";s:1:"1";s:13:"question_edit";s:1:"1";s:15:"question_delete";s:1:"1";s:9:"quiz_view";s:1:"1";s:11:"quiz_create";s:1:"1";s:9:"quiz_edit";s:1:"1";s:11:"quiz_delete";s:1:"1";s:9:"role_view";s:1:"1";s:11:"role_create";s:1:"1";s:9:"role_edit";s:1:"1";s:11:"role_delete";s:1:"1";s:9:"room_view";s:1:"1";s:11:"room_create";s:1:"1";s:9:"room_edit";s:1:"1";s:11:"room_delete";s:1:"1";s:11:"system_view";s:1:"1";s:13:"system_create";s:1:"1";s:11:"system_edit";s:1:"1";s:13:"system_delete";s:1:"1";s:9:"user_view";s:1:"1";s:11:"user_create";s:1:"1";s:9:"user_edit";s:1:"1";s:11:"user_delete";s:1:"1";}'),
(4, 'Student', 'Restricted access', 'a:29:{s:12:"account_view";s:1:"1";s:15:"assignment_view";s:1:"1";s:15:"attendance_view";s:1:"1";s:10:"batch_view";s:1:"1";s:13:"calendar_view";s:1:"1";s:11:"course_view";s:1:"1";s:11:"course_join";s:1:"1";s:13:"document_view";s:1:"1";s:17:"document_download";s:1:"1";s:10:"event_view";s:1:"1";s:9:"exam_view";s:1:"1";s:14:"examgroup_view";s:1:"1";s:18:"exammarksheet_view";s:1:"1";s:15:"examresult_view";s:1:"1";s:9:"feed_view";s:1:"1";s:14:"flashcard_view";s:1:"1";s:12:"lecture_view";s:1:"1";s:11:"lesson_view";s:1:"1";s:13:"location_view";s:1:"1";s:9:"post_view";s:1:"1";s:11:"post_create";s:1:"1";s:9:"post_edit";s:1:"1";s:11:"post_delete";s:1:"1";s:13:"question_view";s:1:"1";s:9:"quiz_view";s:1:"1";s:9:"role_view";s:1:"1";s:9:"room_view";s:1:"1";s:11:"system_view";s:1:"1";s:9:"user_view";s:1:"1";}'),
(5, 'Parent', 'Restricted access', 'a:36:{s:12:"account_view";s:1:"1";s:14:"account_create";s:1:"1";s:12:"account_edit";s:1:"1";s:14:"account_delete";s:1:"1";s:15:"assignment_view";s:1:"1";s:15:"attendance_view";s:1:"1";s:10:"batch_view";s:1:"1";s:12:"batch_create";s:1:"1";s:10:"batch_edit";s:1:"1";s:12:"batch_delete";s:1:"1";s:13:"calendar_view";s:1:"1";s:11:"course_view";s:1:"1";s:13:"document_view";s:1:"1";s:10:"event_view";s:1:"1";s:9:"exam_view";s:1:"1";s:14:"examgroup_view";s:1:"1";s:18:"exammarksheet_view";s:1:"1";s:15:"examresult_view";s:1:"1";s:9:"feed_view";s:1:"1";s:14:"flashcard_view";s:1:"1";s:12:"lecture_view";s:1:"1";s:11:"lesson_view";s:1:"1";s:13:"location_view";s:1:"1";s:9:"post_view";s:1:"1";s:13:"question_view";s:1:"1";s:9:"quiz_view";s:1:"1";s:9:"role_view";s:1:"1";s:11:"role_create";s:1:"1";s:9:"role_edit";s:1:"1";s:11:"role_delete";s:1:"1";s:9:"room_view";s:1:"1";s:11:"system_view";s:1:"1";s:9:"user_view";s:1:"1";s:11:"user_create";s:1:"1";s:9:"user_edit";s:1:"1";s:11:"user_delete";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `room_number` varchar(100) CHARACTER SET latin1 NOT NULL,
  `room_name` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rooms`
--


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `config_key` varchar(128) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `group_name`, `config_key`, `config_value`) VALUES
(1, 'config', 'language_id', '1'),
(2, 'config', 'default_role', '5'),
(3, 'config', 'membership', '0'),
(4, 'config', 'user_approval', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(127) NOT NULL,
  `password` varchar(64) NOT NULL,
  `about_me` varchar(256) DEFAULT '',
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `forgot_password_string` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `parent_user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `about_me`, `logins`, `last_login`, `avatar`, `forgot_password_string`, `status`, `parent_user_id`) VALUES
(1, 'admin', 'demo', 'admin.demo@kodelearn.com', '2ec953bb23dc94f9e661494a97fde5997dac5c9377da42b8fa4f236edcc5ec5e', '', 0, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_tokens`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches_users`
--
ALTER TABLE `batches_users`
  ADD CONSTRAINT `batches_users_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `batches_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_batches_users_batches` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_batches_users_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses_users`
--
ALTER TABLE `courses_users`
  ADD CONSTRAINT `courses_users_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_courses_users_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_courses_users_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `documents_courses`
--
ALTER TABLE `documents_courses`
  ADD CONSTRAINT `documents_courses_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_courses_ibfk_4` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_courses_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_courses_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents_roles`
--
ALTER TABLE `documents_roles`
  ADD CONSTRAINT `documents_roles_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_roles_ibfk_4` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_roles_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_events_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_ibfk_3` FOREIGN KEY (`examgroup_id`) REFERENCES `examgroups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_exams_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_exams_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_exams_examgroups` FOREIGN KEY (`examgroup_id`) REFERENCES `examgroups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feeds`
--
ALTER TABLE `feeds`
  ADD CONSTRAINT `feeds_ibfk_1` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_feed_users` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feeds_feedstreams`
--
ALTER TABLE `feeds_feedstreams`
  ADD CONSTRAINT `feeds_feedstreams_ibfk_3` FOREIGN KEY (`feedstream_id`) REFERENCES `feedstreams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeds_feedstreams_ibfk_4` FOREIGN KEY (`feed_id`) REFERENCES `feeds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeds_feedstreams_ibfk_1` FOREIGN KEY (`feedstream_id`) REFERENCES `feedstreams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feeds_feedstreams_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feeds` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_lectures_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lectures_events`
--
ALTER TABLE `lectures_events`
  ADD CONSTRAINT `lectures_events_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lectures_events_ibfk_2` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_lectures_events_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_lectures_events_lectures` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_posts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questionattributes`
--
ALTER TABLE `questionattributes`
  ADD CONSTRAINT `questionattributes_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questionattributes_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questionhints`
--
ALTER TABLE `questionhints`
  ADD CONSTRAINT `questionhints_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `questionhints_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
