-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2019 at 06:02 PM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 5.6.40-0+deb8u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `metube`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(10) unsigned NOT NULL,
  `mediaid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `userid` int(10) unsigned NOT NULL,
  `contactid` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `userid` int(10) unsigned NOT NULL,
  `mediaid` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
`id` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `filename` text NOT NULL,
  `filepath` text NOT NULL,
  `type` text NOT NULL,
  `title` text NOT NULL,
  `description` text,
  `category` set('Politics','Entertainment','Gaming','Sports','Music','Movies','TV Shows','News','Spotlight') DEFAULT NULL,
  `allow_comments` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mediatags`
--

CREATE TABLE IF NOT EXISTS `mediatags` (
  `mediaid` int(10) unsigned NOT NULL,
  `tag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(10) unsigned NOT NULL,
  `recvid` int(10) unsigned NOT NULL,
  `sendid` int(10) unsigned NOT NULL,
  `subject` text NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playlistcontent`
--

CREATE TABLE IF NOT EXISTS `playlistcontent` (
  `playlistid` int(10) unsigned NOT NULL,
  `mediaid` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
`id` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `userid` int(10) unsigned NOT NULL,
  `channelid` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(320) NOT NULL,
  `password` varchar(32) NOT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD KEY `comments_media` (`mediaid`), ADD KEY `comments_author` (`userid`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
 ADD UNIQUE KEY `userid` (`userid`,`contactid`), ADD KEY `contacts_contact` (`contactid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
 ADD UNIQUE KEY `favorites_nodup` (`userid`,`mediaid`), ADD KEY `favorites_media` (`mediaid`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
 ADD PRIMARY KEY (`id`), ADD KEY `media_owner` (`userid`);

--
-- Indexes for table `mediatags`
--
ALTER TABLE `mediatags`
 ADD KEY `mediatags_media` (`mediaid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`), ADD KEY `messages_receiver` (`recvid`), ADD KEY `messages_sender` (`sendid`);

--
-- Indexes for table `playlistcontent`
--
ALTER TABLE `playlistcontent`
 ADD KEY `playlistcontent_playlists` (`playlistid`), ADD KEY `playlistcontent_media` (`mediaid`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
 ADD PRIMARY KEY (`id`), ADD KEY `playlists_owner` (`userid`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
 ADD UNIQUE KEY `sub_unique` (`userid`,`channelid`), ADD KEY `userid_user` (`userid`), ADD KEY `channelid_user` (`channelid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `comments_author` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `comments_media` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
ADD CONSTRAINT `contacts_contact` FOREIGN KEY (`contactid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `contacts_user` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
ADD CONSTRAINT `favorites_media` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `favorites_user` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
ADD CONSTRAINT `media_owner` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mediatags`
--
ALTER TABLE `mediatags`
ADD CONSTRAINT `mediatags_media` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
ADD CONSTRAINT `messages_receiver` FOREIGN KEY (`recvid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `messages_sender` FOREIGN KEY (`sendid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlistcontent`
--
ALTER TABLE `playlistcontent`
ADD CONSTRAINT `playlistcontent_media` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `playlistcontent_playlists` FOREIGN KEY (`playlistid`) REFERENCES `playlists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
ADD CONSTRAINT `playlists_owner` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscribers`
--
ALTER TABLE `subscribers`
ADD CONSTRAINT `channelid_foreign` FOREIGN KEY (`channelid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
