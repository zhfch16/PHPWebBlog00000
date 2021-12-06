--
-- Database: `php`
--
CREATE DATABASE IF NOT EXISTS `php` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `php`;

-- --------------------------------------------------------

--
-- 表的结构 `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- 使用表AUTO_INCREMENT `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;