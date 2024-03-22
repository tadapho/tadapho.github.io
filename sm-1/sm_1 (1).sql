-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2024 at 10:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sm_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `AMS_Project`
--

CREATE TABLE `AMS_Project` (
  `AMS_ID` varchar(6) DEFAULT NULL,
  `Project_ID` varchar(5) DEFAULT NULL,
  `Measurement` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `AMS_Project`
--

INSERT INTO `AMS_Project` (`AMS_ID`, `Project_ID`, `Measurement`) VALUES
('A1', 'P01', '800');

-- --------------------------------------------------------

--
-- Table structure for table `Area_Measurement_Sheet`
--

CREATE TABLE `Area_Measurement_Sheet` (
  `AMS_ID` varchar(6) NOT NULL,
  `AMS_time` varchar(4) DEFAULT NULL,
  `AMS_date` date DEFAULT NULL,
  `Loc_HNo` varchar(12) DEFAULT NULL,
  `Loc_city` varchar(12) DEFAULT NULL,
  `Loc_street` varchar(18) DEFAULT NULL,
  `loc_zipcode` varchar(5) DEFAULT NULL,
  `Quot_ID` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Area_Measurement_Sheet`
--

INSERT INTO `Area_Measurement_Sheet` (`AMS_ID`, `AMS_time`, `AMS_date`, `Loc_HNo`, `Loc_city`, `Loc_street`, `loc_zipcode`, `Quot_ID`) VALUES
('A1', 'jan', '2024-03-01', '1', NULL, '3', '4', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `Bill`
--

CREATE TABLE `Bill` (
  `Bill_ID` varchar(6) NOT NULL,
  `Pay_50` int(11) DEFAULT NULL,
  `Pay_30` int(11) DEFAULT NULL,
  `Pay_20` int(11) DEFAULT NULL,
  `Status_50` varchar(10) DEFAULT NULL,
  `Status_30` varchar(10) DEFAULT NULL,
  `Status_20` varchar(10) DEFAULT NULL,
  `Slip_50` blob DEFAULT NULL,
  `Slip_30` blob DEFAULT NULL,
  `Slip_20` blob DEFAULT NULL,
  `DatePay_50` date DEFAULT NULL,
  `DatePay_30` date DEFAULT NULL,
  `DatePay_20` date DEFAULT NULL,
  `Cus_ID` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Bill`
--

INSERT INTO `Bill` (`Bill_ID`, `Pay_50`, `Pay_30`, `Pay_20`, `Status_50`, `Status_30`, `Status_20`, `Slip_50`, `Slip_30`, `Slip_20`, `DatePay_50`, `DatePay_30`, `DatePay_20`, `Cus_ID`) VALUES
('B01', 3, 4, 5, '6', '7', '8', NULL, NULL, NULL, '2024-03-03', '2024-03-04', '2024-03-05', 'asd'),
('B02', 0, 0, 0, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `Cus_ID` varchar(4) NOT NULL,
  `Cus_Fname` varchar(18) DEFAULT NULL,
  `Cus_Lname` varchar(18) DEFAULT NULL,
  `Cus_Tel` varchar(11) DEFAULT NULL,
  `Cus_Content` varchar(9) DEFAULT NULL,
  `Cus_HNo` varchar(12) DEFAULT NULL,
  `Cus_city` varchar(12) DEFAULT NULL,
  `Cus_street` varchar(18) DEFAULT NULL,
  `Cus_zipcode` varchar(5) DEFAULT NULL,
  `Emp_ID` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`Cus_ID`, `Cus_Fname`, `Cus_Lname`, `Cus_Tel`, `Cus_Content`, `Cus_HNo`, `Cus_city`, `Cus_street`, `Cus_zipcode`, `Emp_ID`) VALUES
('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', '1'),
('asd', 'asf', 'asdf', 'asdf', 'asdf', '', '', '', '', NULL),
('z', 'z', 'z', '', '', '', '', '', '', '2');

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

CREATE TABLE `Department` (
  `Dept_ID` varchar(3) NOT NULL,
  `Dept_name` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Department`
--

INSERT INTO `Department` (`Dept_ID`, `Dept_name`) VALUES
('455', 'ธุรการ'),
('8', 'ฝ่ายขาย'),
('9', 'การตลาด'),
('AAA', 'AAAAA'),
('cba', 'การเงิน');

-- --------------------------------------------------------

--
-- Table structure for table `Department_Manager`
--

CREATE TABLE `Department_Manager` (
  `Emp_manager` varchar(4) NOT NULL,
  `Dept_ID` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Department_Manager`
--

INSERT INTO `Department_Manager` (`Emp_manager`, `Dept_ID`) VALUES
('gg', 'AAA'),
('b', 'cba');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `Emp_ID` varchar(4) NOT NULL,
  `Emp_Fname` varchar(18) DEFAULT NULL,
  `Emp_Lname` varchar(18) DEFAULT NULL,
  `Emp_Tel` varchar(11) DEFAULT NULL,
  `Emp_role` varchar(18) DEFAULT NULL,
  `Emp_salary` int(11) DEFAULT NULL,
  `Emp_HNo` varchar(12) DEFAULT NULL,
  `Emp_city` varchar(12) DEFAULT NULL,
  `Emp_street` varchar(18) DEFAULT NULL,
  `Emp_zipcode` varchar(5) DEFAULT NULL,
  `Emp_manager` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`Emp_ID`, `Emp_Fname`, `Emp_Lname`, `Emp_Tel`, `Emp_role`, `Emp_salary`, `Emp_HNo`, `Emp_city`, `Emp_street`, `Emp_zipcode`, `Emp_manager`) VALUES
('1', 'ชยพล', 'วงศ์ทิพย์', '0111122222', 'หัวหน้า', 30000, '12', 'กรุงเทพฯ', 'พหลโยธิน', '12345', 'b'),
('2', 'แพรพิไล', 'ทรัพย์ธารา', '0222233333', 'เจ้าหน้าที่', 15000, '', '', '', '', 'b'),
('3', '3', '3', '3', '3', 3, '3', '3', '3', '3', 'b'),
('a', 'b', 'c', '', '', 0, '', '', '', '', NULL),
('c', 'c', 'c', '', '', 0, '', '', '', '', 'gg');

-- --------------------------------------------------------

--
-- Table structure for table `MakingOrder_Customer_Project`
--

CREATE TABLE `MakingOrder_Customer_Project` (
  `Cus_ID` varchar(4) DEFAULT NULL,
  `Project_ID` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Managment_Quottaiont_Employee`
--

CREATE TABLE `Managment_Quottaiont_Employee` (
  `Quot_ID` varchar(4) DEFAULT NULL,
  `Emp_ID` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Managment_Quottaiont_Employee`
--

INSERT INTO `Managment_Quottaiont_Employee` (`Quot_ID`, `Emp_ID`) VALUES
('A', '1');

-- --------------------------------------------------------

--
-- Table structure for table `Material`
--

CREATE TABLE `Material` (
  `M_SKU` varchar(30) NOT NULL,
  `M_name` varchar(20) DEFAULT NULL,
  `M_Stock` int(11) DEFAULT NULL,
  `M_numStock` int(11) DEFAULT NULL,
  `M_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Material`
--

INSERT INTO `Material` (`M_SKU`, `M_name`, `M_Stock`, `M_numStock`, `M_price`) VALUES
('M', 'a', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Material_Area_Measurement_Sheet`
--

CREATE TABLE `Material_Area_Measurement_Sheet` (
  `AMS_ID` varchar(6) DEFAULT NULL,
  `M_SKU` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Material_Area_Measurement_Sheet`
--

INSERT INTO `Material_Area_Measurement_Sheet` (`AMS_ID`, `M_SKU`) VALUES
('A1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Material_PO`
--

CREATE TABLE `Material_PO` (
  `PO_ID` varchar(6) DEFAULT NULL,
  `M_SKU` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Material_PO`
--

INSERT INTO `Material_PO` (`PO_ID`, `M_SKU`) VALUES
('order2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Material_Use`
--

CREATE TABLE `Material_Use` (
  `Quot_ID` varchar(4) DEFAULT NULL,
  `M_SKU` varchar(30) DEFAULT NULL,
  `Use_num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Production_Order`
--

CREATE TABLE `Production_Order` (
  `PO_ID` varchar(6) NOT NULL,
  `PO_month` varchar(4) DEFAULT NULL,
  `PO_detail` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Production_Order`
--

INSERT INTO `Production_Order` (`PO_ID`, `PO_month`, `PO_detail`) VALUES
('order2', '5', 'ทดสอบ2');

-- --------------------------------------------------------

--
-- Table structure for table `Project`
--

CREATE TABLE `Project` (
  `Project_ID` varchar(5) NOT NULL,
  `P_name` varchar(8) DEFAULT NULL,
  `P_num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Project`
--

INSERT INTO `Project` (`Project_ID`, `P_name`, `P_num`) VALUES
('P01', 'งาน01', 10),
('P02', 'งาน02', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Quotation`
--

CREATE TABLE `Quotation` (
  `Quot_ID` varchar(4) NOT NULL,
  `Net_Price` int(11) DEFAULT NULL,
  `Quot_date` date DEFAULT NULL,
  `Quot_detail` varchar(1000) DEFAULT NULL,
  `Cus_ID` varchar(4) DEFAULT NULL,
  `Project_ID` varchar(5) DEFAULT NULL,
  `Bill_ID` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Quotation`
--

INSERT INTO `Quotation` (`Quot_ID`, `Net_Price`, `Quot_date`, `Quot_detail`, `Cus_ID`, `Project_ID`, `Bill_ID`) VALUES
('A', 0, NULL, '', 'A', NULL, 'B01');

-- --------------------------------------------------------

--
-- Table structure for table `Quot_Cus`
--

CREATE TABLE `Quot_Cus` (
  `Quot_ID` varchar(4) DEFAULT NULL,
  `Cus_ID` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Sending_Materal`
--

CREATE TABLE `Sending_Materal` (
  `M_SKU` varchar(30) DEFAULT NULL,
  `Sup_ID` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Sending_Materal`
--

INSERT INTO `Sending_Materal` (`M_SKU`, `Sup_ID`) VALUES
('M', 'S01');

-- --------------------------------------------------------

--
-- Table structure for table `Supplier`
--

CREATE TABLE `Supplier` (
  `Sup_ID` varchar(3) NOT NULL,
  `Sup_name` varchar(50) DEFAULT NULL,
  `Sup_Tel` varchar(11) DEFAULT NULL,
  `Sup_HNo` varchar(12) DEFAULT NULL,
  `Sup_city` varchar(12) DEFAULT NULL,
  `Sup_street` varchar(18) DEFAULT NULL,
  `Sup_zipcode` varchar(5) DEFAULT NULL,
  `Project_ID` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Supplier`
--

INSERT INTO `Supplier` (`Sup_ID`, `Sup_name`, `Sup_Tel`, `Sup_HNo`, `Sup_city`, `Sup_street`, `Sup_zipcode`, `Project_ID`) VALUES
('S01', 'บริษัท A', '01234567898', '1/1', 'กทม', '-', '11111', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AMS_Project`
--
ALTER TABLE `AMS_Project`
  ADD KEY `AMS_ID` (`AMS_ID`,`Project_ID`),
  ADD KEY `Project_ID` (`Project_ID`);

--
-- Indexes for table `Area_Measurement_Sheet`
--
ALTER TABLE `Area_Measurement_Sheet`
  ADD PRIMARY KEY (`AMS_ID`),
  ADD KEY `Quot_ID` (`Quot_ID`);

--
-- Indexes for table `Bill`
--
ALTER TABLE `Bill`
  ADD PRIMARY KEY (`Bill_ID`),
  ADD KEY `Cus_ID` (`Cus_ID`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`Cus_ID`),
  ADD KEY `Emp_ID` (`Emp_ID`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
  ADD PRIMARY KEY (`Dept_ID`);

--
-- Indexes for table `Department_Manager`
--
ALTER TABLE `Department_Manager`
  ADD PRIMARY KEY (`Emp_manager`),
  ADD KEY `Dept_ID` (`Dept_ID`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`Emp_ID`),
  ADD KEY `Emp_manager` (`Emp_manager`);

--
-- Indexes for table `MakingOrder_Customer_Project`
--
ALTER TABLE `MakingOrder_Customer_Project`
  ADD KEY `fk_project_id_make` (`Project_ID`),
  ADD KEY `Cus_ID` (`Cus_ID`);

--
-- Indexes for table `Managment_Quottaiont_Employee`
--
ALTER TABLE `Managment_Quottaiont_Employee`
  ADD KEY `Emp_ID` (`Emp_ID`),
  ADD KEY `Quot_ID` (`Quot_ID`);

--
-- Indexes for table `Material`
--
ALTER TABLE `Material`
  ADD PRIMARY KEY (`M_SKU`);

--
-- Indexes for table `Material_Area_Measurement_Sheet`
--
ALTER TABLE `Material_Area_Measurement_Sheet`
  ADD KEY `AMS_ID` (`AMS_ID`,`M_SKU`),
  ADD KEY `M_SKU` (`M_SKU`);

--
-- Indexes for table `Material_PO`
--
ALTER TABLE `Material_PO`
  ADD KEY `M_SKU` (`M_SKU`),
  ADD KEY `PO_ID` (`PO_ID`);

--
-- Indexes for table `Material_Use`
--
ALTER TABLE `Material_Use`
  ADD KEY `M_SKU` (`M_SKU`,`Quot_ID`),
  ADD KEY `Quot_ID` (`Quot_ID`);

--
-- Indexes for table `Production_Order`
--
ALTER TABLE `Production_Order`
  ADD PRIMARY KEY (`PO_ID`);

--
-- Indexes for table `Project`
--
ALTER TABLE `Project`
  ADD PRIMARY KEY (`Project_ID`);

--
-- Indexes for table `Quotation`
--
ALTER TABLE `Quotation`
  ADD PRIMARY KEY (`Quot_ID`),
  ADD KEY `fk_project_id_qout` (`Project_ID`),
  ADD KEY `Bill_ID` (`Bill_ID`),
  ADD KEY `Cus_ID` (`Cus_ID`);

--
-- Indexes for table `Quot_Cus`
--
ALTER TABLE `Quot_Cus`
  ADD KEY `Quot_ID` (`Quot_ID`),
  ADD KEY `Cus_ID` (`Cus_ID`);

--
-- Indexes for table `Sending_Materal`
--
ALTER TABLE `Sending_Materal`
  ADD KEY `Sup_ID` (`Sup_ID`,`M_SKU`),
  ADD KEY `M_SKU` (`M_SKU`);

--
-- Indexes for table `Supplier`
--
ALTER TABLE `Supplier`
  ADD PRIMARY KEY (`Sup_ID`),
  ADD KEY `fk_project_id_pj` (`Project_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AMS_Project`
--
ALTER TABLE `AMS_Project`
  ADD CONSTRAINT `AMS_Project_ibfk_2` FOREIGN KEY (`AMS_ID`) REFERENCES `Area_Measurement_Sheet` (`AMS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AMS_Project_ibfk_3` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Area_Measurement_Sheet`
--
ALTER TABLE `Area_Measurement_Sheet`
  ADD CONSTRAINT `Area_Measurement_Sheet_ibfk_1` FOREIGN KEY (`Quot_ID`) REFERENCES `Quotation` (`Quot_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Bill`
--
ALTER TABLE `Bill`
  ADD CONSTRAINT `Bill_ibfk_1` FOREIGN KEY (`Cus_ID`) REFERENCES `Customer` (`Cus_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Customer`
--
ALTER TABLE `Customer`
  ADD CONSTRAINT `Customer_ibfk_1` FOREIGN KEY (`Emp_ID`) REFERENCES `Employee` (`Emp_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Department_Manager`
--
ALTER TABLE `Department_Manager`
  ADD CONSTRAINT `Department_Manager_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `Department` (`Dept_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Employee`
--
ALTER TABLE `Employee`
  ADD CONSTRAINT `Employee_ibfk_1` FOREIGN KEY (`Emp_manager`) REFERENCES `Department_Manager` (`Emp_manager`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `MakingOrder_Customer_Project`
--
ALTER TABLE `MakingOrder_Customer_Project`
  ADD CONSTRAINT `MakingOrder_Customer_Project_ibfk_1` FOREIGN KEY (`Cus_ID`) REFERENCES `Customer` (`Cus_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project_id_make` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`);

--
-- Constraints for table `Managment_Quottaiont_Employee`
--
ALTER TABLE `Managment_Quottaiont_Employee`
  ADD CONSTRAINT `Managment_Quottaiont_Employee_ibfk_3` FOREIGN KEY (`Emp_ID`) REFERENCES `Employee` (`Emp_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Managment_Quottaiont_Employee_ibfk_4` FOREIGN KEY (`Quot_ID`) REFERENCES `Quotation` (`Quot_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Material_Area_Measurement_Sheet`
--
ALTER TABLE `Material_Area_Measurement_Sheet`
  ADD CONSTRAINT `Material_Area_Measurement_Sheet_ibfk_1` FOREIGN KEY (`M_SKU`) REFERENCES `Material` (`M_SKU`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_Area_Measurement_Sheet_ibfk_2` FOREIGN KEY (`AMS_ID`) REFERENCES `Area_Measurement_Sheet` (`AMS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sku` FOREIGN KEY (`M_SKU`) REFERENCES `Material` (`M_SKU`);

--
-- Constraints for table `Material_PO`
--
ALTER TABLE `Material_PO`
  ADD CONSTRAINT `Material_PO_ibfk_2` FOREIGN KEY (`M_SKU`) REFERENCES `Material` (`M_SKU`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_PO_ibfk_3` FOREIGN KEY (`PO_ID`) REFERENCES `Production_Order` (`PO_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Material_Use`
--
ALTER TABLE `Material_Use`
  ADD CONSTRAINT `Material_Use_ibfk_1` FOREIGN KEY (`Quot_ID`) REFERENCES `Quotation` (`Quot_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_Use_ibfk_2` FOREIGN KEY (`M_SKU`) REFERENCES `Material` (`M_SKU`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Quotation`
--
ALTER TABLE `Quotation`
  ADD CONSTRAINT `Quotation_ibfk_1` FOREIGN KEY (`Bill_ID`) REFERENCES `Bill` (`Bill_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Quotation_ibfk_2` FOREIGN KEY (`Cus_ID`) REFERENCES `Customer` (`Cus_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project_id_qout` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`);

--
-- Constraints for table `Quot_Cus`
--
ALTER TABLE `Quot_Cus`
  ADD CONSTRAINT `Quot_Cus_ibfk_4` FOREIGN KEY (`Cus_ID`) REFERENCES `Customer` (`Cus_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Quot_Cus_ibfk_5` FOREIGN KEY (`Quot_ID`) REFERENCES `Quotation` (`Quot_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Sending_Materal`
--
ALTER TABLE `Sending_Materal`
  ADD CONSTRAINT `Sending_Materal_ibfk_1` FOREIGN KEY (`M_SKU`) REFERENCES `Material` (`M_SKU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Sending_Materal_ibfk_2` FOREIGN KEY (`Sup_ID`) REFERENCES `Supplier` (`Sup_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `Supplier`
--
ALTER TABLE `Supplier`
  ADD CONSTRAINT `fk_project_id_pj` FOREIGN KEY (`Project_ID`) REFERENCES `Project` (`Project_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
