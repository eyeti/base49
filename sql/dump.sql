-- --------------------------------------------------------

--
-- Table structure for table `tblarea`
--

CREATE TABLE IF NOT EXISTS `tblarea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stamp` int(10) NOT NULL,
  `author` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbldescription`
--

CREATE TABLE IF NOT EXISTS `tbldescription` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stamp` int(10) NOT NULL,
  `author` varchar(50) NOT NULL,
  `areaid` int(10) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbllog`
--

CREATE TABLE IF NOT EXISTS `tbllog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `areaid` int(10) NOT NULL,
  `descriptionid` int(10) NOT NULL,
  `tag` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

