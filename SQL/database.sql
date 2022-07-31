-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Feb 03, 2019 alle 23:29
-- Versione del server: 10.0.37-MariaDB-cll-lve
-- Versione PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jogbzwtn_testw2`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `country_codes`
--

CREATE TABLE `country_codes` (
  `country_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `country_codes`
--

INSERT INTO `country_codes` (`country_id`, `name`, `code`) VALUES
(1, 'Italia', '039');

-- --------------------------------------------------------

--
-- Struttura della tabella `price_option`
--

CREATE TABLE `price_option` (
  `id` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `page` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `price_option`
--

INSERT INTO `price_option` (`id`, `price`, `currency`, `page`, `active`) VALUES
(1, 1, '€', '15', 1),
(2, 3, '€', '50', 1),
(3, 5, '€', '75', 1),
(4, 10, '€', '90', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `print_job`
--

CREATE TABLE `print_job` (
  `job_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `file_type` varchar(10) NOT NULL,
  `number_of_pages` int(10) NOT NULL,
  `stauts` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `paper_size` varchar(25) NOT NULL,
  `orientation` varchar(10) NOT NULL,
  `print_type` varchar(20) DEFAULT NULL,
  `copies` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `binding_position` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `system_preference`
--

CREATE TABLE `system_preference` (
  `enable_color` tinyint(1) NOT NULL,
  `paypal_account` varchar(50) NOT NULL,
  `default_printer` varchar(30) NOT NULL,
  `enable_a3` tinyint(1) NOT NULL,
  `enable_2_sided` tinyint(1) NOT NULL,
  `enable_booklet` tinyint(1) NOT NULL,
  `print_complt_txt` varchar(1000) NOT NULL,
  `print_problm_txt` varchar(1000) NOT NULL,
  `whatsapp_complete_text` varchar(1000) NOT NULL,
  `whatsapp_error_text` varchar(1000) NOT NULL,
  `a4_price` int(11) NOT NULL DEFAULT '1',
  `a3_price_margin` int(11) NOT NULL DEFAULT '1',
  `colored_price_margin` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `system_preference`
--

INSERT INTO `system_preference` (`enable_color`, `paypal_account`, `default_printer`, `enable_a3`, `enable_2_sided`, `enable_booklet`, `print_complt_txt`, `print_problm_txt`, `whatsapp_complete_text`, `whatsapp_error_text`, `a4_price`, `a3_price_margin`, `colored_price_margin`) VALUES
(1, 'insert@paypal.email', 'laser', 1, 1, 0, 'Your print is ready. You can come and pick it up', 'A problem occurred during printing. Please contact us', 'Whatsapp completed message.\r\n\r\nThanks!', 'Whatsapp error message.', 1, 1, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `is_whatsapp_message` tinyint(1) NOT NULL,
  `user_email_address` varchar(30) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `credits` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `forgot_password_token` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `name`, `surname`, `password`, `country_code`, `phone_number`, `is_whatsapp_message`, `user_email_address`, `registration_date`, `type`, `address`, `credits`, `active`, `forgot_password_token`) VALUES
(1, 'test', 'User', 'test', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, '', '2019-02-03 22:28:47', '0', 'test', 10, 1, ''),
(2, 'admin', 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, '', '2019-02-03 22:29:05', 'admin', 'admin', 1, 1, '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `country_codes`
--
ALTER TABLE `country_codes`
  ADD PRIMARY KEY (`country_id`);

--
-- Indici per le tabelle `price_option`
--
ALTER TABLE `price_option`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `print_job`
--
ALTER TABLE `print_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `country_codes`
--
ALTER TABLE `country_codes`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `price_option`
--
ALTER TABLE `price_option`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `print_job`
--
ALTER TABLE `print_job`
  MODIFY `job_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
