-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2014 at 05:12 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `unt_proto`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE IF NOT EXISTS `admin_notifications` (
`id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL COMMENT 'The User ID of who sent the notification',
  `type` varchar(20) NOT NULL COMMENT 'candidate or vote',
  `election_id` int(10) NOT NULL,
  `response` varchar(10) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
`id` mediumint(5) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `name`, `description`) VALUES
(1, 'arts_and_sciences', 'College of Arts and Sciences'),
(2, 'business', 'College of Business'),
(3, 'education', 'College of Education'),
(4, 'engineering', 'College of Engineering'),
(5, 'information', 'College of Information'),
(6, 'merchandising_hospitality_tourism', 'College of Merchandising, Hospitality and Tourism'),
(7, 'music', 'College of Music'),
(8, 'public_affairs', 'College of Public Affairs and Community Service'),
(10, 'visual_arts', 'College of Visual Arts and Design'),
(11, 'journalism', 'Frank W. and Sue Mayborn School of Journalism'),
(12, 'honors', 'Honors College'),
(13, 'tams', 'Texas Academy of Mathematics and Science (TAMS)'),
(14, 'toulouse', 'Toulouse Graduate School'),
(15, 'all', 'All');

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

CREATE TABLE IF NOT EXISTS `election` (
`id` int(11) NOT NULL,
  `election_name` varchar(100) NOT NULL,
  `election_description` varchar(500) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `college_id` int(11) NOT NULL,
  `total_votes` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `remind_users` tinyint(1) NOT NULL DEFAULT '0',
  `reminder_sent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `election`
--

INSERT INTO `election` (`id`, `election_name`, `election_description`, `slug`, `start_time`, `end_time`, `college_id`, `total_votes`, `status`, `remind_users`, `reminder_sent`) VALUES
(8, 'Computer Science President', 'Who should be the president of the Computer Science department', 'computer-science-president', '2014-11-27', '2014-11-27', 2, 0, 'Closed', 1, 0),
(10, 'College of Engineering Dean', 'Dean of the College of Engineering and some long description...', 'college-of-engineering-dean', '2014-11-27', '2014-11-28', 4, 1, 'Active', 0, 0),
(11, 'Testing Colleges', 'Testing Limiting Colleges', 'testing-colleges', '2014-10-30', '2014-10-31', 2, 0, 'Closed', 0, 0),
(12, 'Testing Dates', 'Testing to see if elections are updated', 'election-update', '2014-10-01', '2014-11-01', 1, 0, 'Closed', 0, 0),
(15, 'Candidates Election', 'Testing Adding Candidates to an Election', 'candidates-election', '2014-11-02', '2014-11-03', 1, 0, 'Closed', 0, 0),
(16, 'Adding Candidates', 'Testing Adding Candidates to an Election and editing an election.', 'adding-candidates', '2014-11-27', '2014-11-29', 4, 2, 'Active', 0, 0),
(17, 'Creating Candidates', 'I am testing editing and creating candidates in this election', 'creating-candidates', '2014-11-11', '2014-11-12', 4, 0, 'Closed', 0, 0),
(19, 'Testing New Create Election', 'Testing the new new Create Election form and date format', 'testing-new-create-election', '2014-11-04', '2014-11-07', 4, 11, 'Closed', 0, 0),
(20, 'Testing Views', 'Testing whether or not the new create election form is working', 'testing-views', '2014-11-05', '2014-11-06', 4, 1, 'Closed', 0, 0),
(21, 'New Testing Elections', 'jkfldsjflksj fjsk fsjkl fsdjkl jkflsd jfklds fsdjklf jkflsd jkflsd jkfls jklfs jklfsd jkflsd', 'new-testing-elections', '2014-11-15', '2014-11-17', 4, 1, 'Closed', 0, 0),
(22, 'UNTVote President', 'UNTVote is here!  Now who should be the president of this wonderful system?', 'untvote-president', '2014-11-17', '2014-11-19', 15, 2, 'Closed', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `election_candidates`
--

CREATE TABLE IF NOT EXISTS `election_candidates` (
`id` int(10) NOT NULL,
  `candidate_id` int(10) NOT NULL,
  `election_id` int(10) NOT NULL,
  `votes` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `election_candidates`
--

INSERT INTO `election_candidates` (`id`, `candidate_id`, `election_id`, `votes`) VALUES
(6, 5, 18, 0),
(8, 5, 19, 11),
(10, 5, 20, 1),
(23, 1, 8, 0),
(25, 1, 21, 0),
(26, 1, 16, 0),
(27, 6, 16, 2),
(28, 6, 21, 1),
(29, 5, 21, 0),
(30, 6, 22, 2),
(31, 5, 22, 0),
(32, 6, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` mediumint(8) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'candidates', 'The Election Candidates');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
`id` int(11) unsigned NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `about_me` varchar(500) DEFAULT NULL,
  `goals` text,
  `avatar` varchar(50) NOT NULL DEFAULT 'assets/img/user-default.png'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `about_me`, `goals`, `avatar`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$CARllLsGWWMSbq4bPpGbieDtMj8C6IUISiM5K4nlg.1dwA9dJHEmq', '', 'admin@my.unt.edu', '', NULL, NULL, 'JYUnmSCuWwE.zu.zxJdOuu', 1268889823, 1417141667, 1, 'Admin', 'Smith', 'None', '2147296420', 'I am the lead server side programmer on UNTVote.  I lead and designed the backend system and designed all of the databases. ', 'I will bring great things to the school.  I will bring UNTVote to the public!', 'assets/upload/meandDog.jpg'),
(5, '::1', 'cs0357', '$2y$08$uMmijbEwzlwy4.yXjhcaauRO/U3hSWSayBU26RuZrM193Zt6A6B7e', NULL, 'chadsmith4@my.unt.edu', NULL, NULL, NULL, NULL, 1411505230, 1417067439, 1, 'Chad', 'Smith', NULL, NULL, 'I''m the best their is, best their was', 'Free Books!', 'assets/upload/untBowlGame3.png'),
(6, '::1', 'km0389', '$2y$08$Omns6N4bIV7AtZL8KNqja.65mxtbgCFPEBOmWCR69zsZMI/QK2.DO', NULL, 'test@test.com', NULL, NULL, NULL, NULL, 1411658190, 1411658208, 1, 'Kieth', '', NULL, NULL, 'I''m a master at UX!', NULL, 'assets/img/user-default.png'),
(34, '::1', 'root', '$2y$08$9thZv5u.Vq.HlT4THEjEWOT.pqRduVuGQ9sxcay.XaGWjmlHFvru6', NULL, 'root@gmail.com', NULL, NULL, NULL, NULL, 1412727194, 1412727194, 1, 'Steve', 'Jobs', NULL, NULL, NULL, NULL, 'assets/img/user-default.png'),
(35, '::1', 'root2', '$2y$08$z6/aMT1rKPdNV3W1BOWDPeMG9g4zXe8.pFgnhbVLQD/Q0/c2VA7zK', NULL, 'root@root.com', NULL, NULL, NULL, NULL, 1412727278, 1412727278, 1, 'Jony', 'Ive', NULL, NULL, NULL, NULL, 'assets/img/user-default.png'),
(36, '::1', 'cs1', '$2y$08$Pooyam.gF/K00NNfDVS3z.fI07rCPmCSLiFw/XjoptIIPcJP5PKwe', NULL, 'testing@test.com', NULL, NULL, NULL, NULL, 1412909291, 1412909291, 1, 'Bill', 'Gates', NULL, NULL, NULL, NULL, 'assets/img/user-default.png'),
(37, '::1', 'ej123', '$2y$08$FmiA9AF55Y3KIKaZownv6O0Sh5ztVxZ.EPHqGNcXEUSjeEFmW/LVy', NULL, 'rootemail@my.unt.edu', NULL, NULL, NULL, NULL, 1412916249, 1412916249, 1, 'Steve', 'Balmer', NULL, NULL, NULL, NULL, 'assets/img/user-default.png');

-- --------------------------------------------------------

--
-- Table structure for table `users_colleges`
--

CREATE TABLE IF NOT EXISTS `users_colleges` (
`id` mediumint(5) NOT NULL,
  `user_id` mediumint(5) NOT NULL,
  `college_id` mediumint(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `users_colleges`
--

INSERT INTO `users_colleges` (`id`, `user_id`, `college_id`) VALUES
(28, 6, 2),
(29, 11, 3),
(30, 7, 1),
(35, 17, 2),
(36, 31, 1),
(37, 32, 1),
(38, 33, 1),
(39, 34, 1),
(42, 35, 4),
(43, 36, 4),
(44, 37, 4),
(49, 8, 15),
(114, 1, 4),
(115, 1, 15),
(116, 5, 4),
(117, 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=158 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(155, 1, 1),
(157, 5, 2),
(14, 6, 2),
(151, 6, 3),
(136, 34, 2),
(138, 35, 2),
(139, 36, 2),
(140, 37, 2);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE IF NOT EXISTS `voters` (
`id` int(10) NOT NULL,
  `election_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `has_voted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `election_id`, `user_id`, `has_voted`) VALUES
(14, 17, 5, 0),
(16, 19, 5, 0),
(19, 8, 1, 0),
(20, 8, 5, 0),
(21, 21, 1, 0),
(22, 21, 5, 0),
(24, 16, 1, 0),
(27, 22, 5, 0),
(28, 22, 1, 0),
(29, 10, 5, 0),
(30, 16, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vote_log`
--

CREATE TABLE IF NOT EXISTS `vote_log` (
`id` int(11) NOT NULL,
  `election_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL,
  `vote_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `vote_log`
--

INSERT INTO `vote_log` (`id`, `election_id`, `candidate_id`, `voter_id`, `vote_time`) VALUES
(23, 19, 5, 1, '2014-11-27 06:28:49'),
(26, 20, 5, 5, '2014-11-27 06:28:49'),
(29, 19, 5, 5, '2014-11-27 06:28:49'),
(37, 17, 6, 5, '2014-11-27 06:28:49'),
(39, 8, 39, 5, '2014-11-27 06:28:49'),
(41, 8, 39, 1, '2014-11-27 06:28:49'),
(43, 21, 6, 1, '2014-11-27 06:28:49'),
(47, 22, 6, 5, '2014-11-27 06:28:49'),
(49, 22, 6, 1, '2014-11-27 06:28:49'),
(50, 10, 6, 5, '2014-11-27 06:28:49'),
(58, 16, 6, 5, '2014-11-27 08:02:30'),
(59, 16, 6, 1, '2014-11-28 02:59:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `election`
--
ALTER TABLE `election`
 ADD PRIMARY KEY (`id`), ADD KEY `election_name` (`election_name`);

--
-- Indexes for table `election_candidates`
--
ALTER TABLE `election_candidates`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_colleges`
--
ALTER TABLE `users_colleges`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`), ADD KEY `fk_users_groups_users1_idx` (`user_id`), ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote_log`
--
ALTER TABLE `vote_log`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `election`
--
ALTER TABLE `election`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `election_candidates`
--
ALTER TABLE `election_candidates`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `users_colleges`
--
ALTER TABLE `users_colleges`
MODIFY `id` mediumint(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=158;
--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `vote_log`
--
ALTER TABLE `vote_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
