--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `first` varchar(100) NOT NULL,
  `last` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first`, `last`, `username`, `email` , `password`) VALUES
(1, 'Tanjina', 'Akter', 'Tanju', 'tanzz@gmail.com','12345'),
(2, 'Jannatul', 'Ferdues', 'Kely', 'kely@gmail.com','67890');
-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `bid` int(100) NOT NULL,
  `b_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `type` int(100) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bid`, `b_name`,  `status`, `type`, `price`) VALUES
(1, 'Principal of electronics', 'Available',  'EEE',120),
(2, 'The Complete Reference C++',  'Available', 'CSE',160),
(3, 'Data Structure',  'Available','ECE',200);




-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

CREATE TABLE IF NOT EXISTS `issue_book` (
  `username` varchar(100) NOT NULL,
  `bid` int(100) NOT NULL,
  `approve` varchar(100) NOT NULL,
  `issue` varchar(100) NOT NULL,
  `return` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`username`, `bid`, `approve`, `issue`, `return`) VALUES
('Promi', 3, '<p style="color:yellow; background-color:red;">EXPIRED</p>', '2023-04-22', '2023-05-16'),
('Promi', 1, '<p style="color:yellow; background-color:green;">RETURNED</p>', '2023-03-20', '2023-04-20'),
('Promi', 2, '<p style="color:yellow; background-color:green;">RETURNED</p>', '2023-01-30', '2023-02-28'),
('Afifa', 1, '<p style="color:yellow; background-color:green;">RETURNED</p>', '2023-04-20', '2023-05-20'),
('Afifa', 2, '<p style="color:yellow; background-color:green;">RETURNED</p>', '2023-02-20', '2023-02-10'),
('Afifa', 1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `first` varchar(100) NOT NULL,
  `last` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first`, `last`, `username`, `password` , `email`) VALUES
(1, 'Tanjina', 'Akter', 'Tanju', '12345','tanzz@gmail.com'),
(2, 'Jannatul', 'Ferdues', 'Kely', '67890','kely@gmail.com',),
(3, 'Mr.', 'Abdul', 'Hamid','123456', 'mr.hamid@gmail.com' ),
(4, 'Nobonita', 'Das', 'Nobonita','123456', 'nobonita@gmail.com'),
(5, 'Mr.', 'X', 'X','123456', 'samiarahman@gmail.com');