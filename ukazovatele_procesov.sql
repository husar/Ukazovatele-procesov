-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1:3308
-- Čas generovania: Po 12.Apr 2021, 05:58
-- Verzia serveru: 5.7.31
-- Verzia PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `ukazovatele_procesov`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `av`
--

DROP TABLE IF EXISTS `av`;
CREATE TABLE IF NOT EXISTS `av` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac` double DEFAULT NULL,
  `priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka` longtext COLLATE utf8_unicode_ci,
  `prirastok_vyrobkov_nove_vyrobky/kabelaze` int(11) DEFAULT NULL,
  `prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka` longtext COLLATE utf8_unicode_ci,
  `prirastok_vyrobkov_inovovane_vyrobky` int(11) DEFAULT NULL,
  `prirastok_vyrobkov_inovovane_vyrobky_poznamka` longtext COLLATE utf8_unicode_ci,
  `prirastok_vyrobkov_nove_navody` int(11) DEFAULT NULL,
  `prirastok_vyrobkov_nove_navody_poznamka` longtext COLLATE utf8_unicode_ci,
  `prirastok_vyrobkov_vzorkovanie-empb` int(11) DEFAULT NULL,
  `prirastok_vyrobkov_vzorkovanie-empb_poznamka` longtext COLLATE utf8_unicode_ci,
  `naklady_na_investicie` double DEFAULT NULL,
  `naklady_na_investicie_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `av`
--

INSERT INTO `av` (`id`, `priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac`, `priemerny_pocet_dni_na spracovanie_dokumentacie/mesiac_poznamka`, `prirastok_vyrobkov_nove_vyrobky/kabelaze`, `prirastok_vyrobkov_nove_vyrobky/kabelaze_poznamka`, `prirastok_vyrobkov_inovovane_vyrobky`, `prirastok_vyrobkov_inovovane_vyrobky_poznamka`, `prirastok_vyrobkov_nove_navody`, `prirastok_vyrobkov_nove_navody_poznamka`, `prirastok_vyrobkov_vzorkovanie-empb`, `prirastok_vyrobkov_vzorkovanie-empb_poznamka`, `naklady_na_investicie`, `naklady_na_investicie_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-23 09:54:22', NULL, 0, NULL, '2021-03-01'),
(2, 6, 'ffffffffffffffffffffffff asi', 600, 'ahoj', NULL, '', 78, '', 9, '', 2125, '', '2021-03-23 10:04:03', '2021-03-31 15:11:44', 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `bu`
--

DROP TABLE IF EXISTS `bu`;
CREATE TABLE IF NOT EXISTS `bu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hv_kumulativne` double DEFAULT NULL,
  `hv_kumulativne_poznamka` longtext COLLATE utf8_unicode_ci,
  `trzby_vlastne_vyrobky` double DEFAULT NULL,
  `trzby_vlastne_vyrobky_poznamka` longtext COLLATE utf8_unicode_ci,
  `spotreba_materialu` double DEFAULT NULL,
  `spotreba_materialu_poznamka` longtext COLLATE utf8_unicode_ci,
  `spotreba_energie` double DEFAULT NULL,
  `spotreba_energie_poznamka` longtext COLLATE utf8_unicode_ci,
  `mzdove_naklady` double DEFAULT NULL,
  `mzdove_naklady_poznamka` longtext COLLATE utf8_unicode_ci,
  `priemerny_zarobok` double DEFAULT NULL,
  `priemerny_zarobok_poznamka` longtext COLLATE utf8_unicode_ci,
  `priemerny_pocet_zamestnancov` double DEFAULT NULL,
  `priemerny_pocet_zamestnancov_poznamka` longtext COLLATE utf8_unicode_ci,
  `stav_posledny_den` double DEFAULT NULL,
  `stav_posledny_den_poznamka` longtext COLLATE utf8_unicode_ci,
  `fluktuacia` double DEFAULT NULL,
  `fluktuacia_poznamka` longtext COLLATE utf8_unicode_ci,
  `pracovny_fond_100` double DEFAULT NULL,
  `pracovny_fond_100_poznamka` longtext COLLATE utf8_unicode_ci,
  `pracovny_fond_200` double DEFAULT NULL,
  `pracovny_fond_200_poznamka` longtext COLLATE utf8_unicode_ci,
  `pracovny_fond_mkem` double DEFAULT NULL,
  `pracovny_fond_mkem_poznamka` longtext COLLATE utf8_unicode_ci,
  `nadcasove_hodiny_100` double DEFAULT NULL,
  `nadcasove_hodiny_100_poznamka` longtext COLLATE utf8_unicode_ci,
  `nadcasove_hodiny_200` double DEFAULT NULL,
  `nadcasove_hodiny_200_poznamka` longtext COLLATE utf8_unicode_ci,
  `nadcasove_hodiny_mkem` double DEFAULT NULL,
  `nadcasove_hodiny_mkem_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `obdobie` (`obdobie`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `bu`
--

INSERT INTO `bu` (`id`, `hv_kumulativne`, `hv_kumulativne_poznamka`, `trzby_vlastne_vyrobky`, `trzby_vlastne_vyrobky_poznamka`, `spotreba_materialu`, `spotreba_materialu_poznamka`, `spotreba_energie`, `spotreba_energie_poznamka`, `mzdove_naklady`, `mzdove_naklady_poznamka`, `priemerny_zarobok`, `priemerny_zarobok_poznamka`, `priemerny_pocet_zamestnancov`, `priemerny_pocet_zamestnancov_poznamka`, `stav_posledny_den`, `stav_posledny_den_poznamka`, `fluktuacia`, `fluktuacia_poznamka`, `pracovny_fond_100`, `pracovny_fond_100_poznamka`, `pracovny_fond_200`, `pracovny_fond_200_poznamka`, `pracovny_fond_mkem`, `pracovny_fond_mkem_poznamka`, `nadcasove_hodiny_100`, `nadcasove_hodiny_100_poznamka`, `nadcasove_hodiny_200`, `nadcasove_hodiny_200_poznamka`, `nadcasove_hodiny_mkem`, `nadcasove_hodiny_mkem_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(3, 60, '', NULL, '', -58, 'ahoj', 7234.75, '', 157503.97, 'Koľko z navýšenie robia odmeny (dochádzka + výkonnosť) asi', 1121.41, '', 153, '', 153, '', 0.6, '', 88.9, '', 97.9, '', 90.8, '', 1011.25, '', 0, '', 1011.25, 'priem.% PN - SR: ?, Pešovský kraj: ? ,, mkem: 9,9', '2021-03-18 11:16:12', '2021-04-07 10:58:25', 0, NULL, '2021-02-01'),
(6, 0.05, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', '2021-04-07 09:34:08', '2021-04-07 11:04:45', 0, NULL, '2021-03-01'),
(20, 0.04, '', NULL, '', -0.02, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '', '2021-04-07 10:57:42', '2021-04-07 11:07:13', 0, NULL, '2021-04-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `edv`
--

DROP TABLE IF EXISTS `edv`;
CREATE TABLE IF NOT EXISTS `edv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vypadky_siete_lan` double DEFAULT NULL,
  `vypadky_siete_lan_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `edv`
--

INSERT INTO `edv` (`id`, `vypadky_siete_lan`, `vypadky_siete_lan_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(1, NULL, NULL, '2021-03-23 10:34:32', NULL, 0, NULL, '2021-03-01'),
(2, 6, '', '2021-03-23 10:37:20', '2021-04-01 09:10:05', 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `ek`
--

DROP TABLE IF EXISTS `ek`;
CREATE TABLE IF NOT EXISTS `ek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objem_zasob_materialu` double DEFAULT NULL,
  `objem_zasob_materialu_poznamka` longtext COLLATE utf8_unicode_ci,
  `obratka_zasob` double DEFAULT NULL,
  `obratka_zasob_poznamka` longtext COLLATE utf8_unicode_ci,
  `spotreba_materialu_k_trzbam` double DEFAULT NULL,
  `spotreba_materialu_k_trzbam_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `ek`
--

INSERT INTO `ek` (`id`, `objem_zasob_materialu`, `objem_zasob_materialu_poznamka`, `obratka_zasob`, `obratka_zasob_poznamka`, `spotreba_materialu_k_trzbam`, `spotreba_materialu_k_trzbam_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-23 10:40:10', NULL, 0, NULL, '2021-03-01'),
(2, 6.04, '', 600.05, '', NULL, 'ahoj', '2021-03-23 10:45:30', '2021-04-01 09:44:29', 0, NULL, '2021-02-01'),
(3, 0.02, '', 0.03, '', 0.02, 'aaaaaaaa', '2021-03-23 10:50:19', NULL, 0, NULL, '2021-03-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_filename` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `menu`
--

INSERT INTO `menu` (`id`, `name`, `seo_name`, `module_filename`) VALUES
(1, 'BU', 'BU-add', 'mod_BU_add.php'),
(2, 'VK', 'VK-add', 'mod_VK_add.php'),
(3, 'QS', 'QS-add', 'mod_QS_add.php'),
(4, 'QV', 'QV-add', 'mod_QV_add.php'),
(5, 'PL', 'PL-add', 'mod_PL_add.php'),
(6, 'PL200', 'PL200-add', 'mod_PL200_add.php'),
(7, 'PL_SMT/THT', 'PL SMT/THT-add', 'mod_PL smttht_add.php'),
(8, 'AV', 'AV-add', 'mod_AV_add.php'),
(9, 'TE', 'TE-add', 'mod_TE_add.php'),
(10, 'EDV', 'EDV-add', 'mod_EDV_add.php'),
(11, 'EK', 'EK-add', 'mod_EK_add.php'),
(12, 'Prehľad', 'prehlad', 'mod_prehlad.php'),
(13, 'AV', 'AV-edit', 'mod_AV_edit.php'),
(14, 'BU', 'BU-edit', 'mod_BU_edit.php'),
(15, 'VK', 'VK-edit', 'mod_VK_edit.php'),
(16, 'QS', 'QS-edit', 'mod_QS_edit.php'),
(17, 'QV', 'QV-edit', 'mod_QV_edit.php'),
(18, 'PL', 'PL-edit', 'mod_PL_edit.php'),
(19, 'PL200', 'PL200-edit', 'mod_PL200_edit.php'),
(20, 'PL_SMT/THT', 'PL SMT/THT-edit', 'mod_PL smttht_edit.php'),
(21, 'AV', 'AV-edit', 'mod_AV_edit.php'),
(22, 'TE', 'TE-edit', 'mod_TE_edit.php'),
(23, 'EDV', 'EDV-edit', 'mod_EDV_edit.php'),
(24, 'EK', 'EK-edit', 'mod_EK_edit.php');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `pl`
--

DROP TABLE IF EXISTS `pl`;
CREATE TABLE IF NOT EXISTS `pl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priemerna_doba_obratu_zasob_voci_trzbam` double DEFAULT NULL,
  `priemerna_doba_obratu_zasob_voci_trzbam_poznamka` longtext COLLATE utf8_unicode_ci,
  `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1` double DEFAULT NULL,
  `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka` longtext COLLATE utf8_unicode_ci,
  `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2` double DEFAULT NULL,
  `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka` longtext COLLATE utf8_unicode_ci,
  `efektivnost_vyroby` double DEFAULT NULL,
  `efektivnost_vyroby_poznamka` longtext COLLATE utf8_unicode_ci,
  `priemerny_pocet_vyrobnych_pracovnikov_za_obd` double DEFAULT NULL,
  `priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka` longtext COLLATE utf8_unicode_ci,
  `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci` double DEFAULT NULL,
  `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka` longtext COLLATE utf8_unicode_ci,
  `efektivnost_vyroby_trzby/vyrob_pracovnik/den` double DEFAULT NULL,
  `efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka` longtext COLLATE utf8_unicode_ci,
  `denny_prietok_vyroby_esady_ks` double DEFAULT NULL,
  `denny_prietok_vyroby_esady_ks_poznamka` longtext COLLATE utf8_unicode_ci,
  `denny_prietok_vyroby/vyr_pracovnika/den` double DEFAULT NULL,
  `denny_prietok_vyroby/vyr_pracovnika/den_poznamka` longtext COLLATE utf8_unicode_ci,
  `plnenie_vykonovych_noriem` double DEFAULT NULL,
  `plnenie_vykonovych_noriem_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `pl`
--

INSERT INTO `pl` (`id`, `priemerna_doba_obratu_zasob_voci_trzbam`, `priemerna_doba_obratu_zasob_voci_trzbam_poznamka`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_1_poznamka`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2`, `straty_z_nvn_z_odvedenej_vyroby_oproti_trzbam_2_poznamka`, `efektivnost_vyroby`, `efektivnost_vyroby_poznamka`, `priemerny_pocet_vyrobnych_pracovnikov_za_obd`, `priemerny_pocet_vyrobnych_pracovnikov_za_obd_poznamka`, `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci`, `pocet_vyrobnych_pracovnikov_k_poslednemu_dnu_v_mesiaci_poznamka`, `efektivnost_vyroby_trzby/vyrob_pracovnik/den`, `efektivnost_vyroby_trzby/vyrob_pracovnik/den_poznamka`, `denny_prietok_vyroby_esady_ks`, `denny_prietok_vyroby_esady_ks_poznamka`, `denny_prietok_vyroby/vyr_pracovnika/den`, `denny_prietok_vyroby/vyr_pracovnika/den_poznamka`, `plnenie_vykonovych_noriem`, `plnenie_vykonovych_noriem_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(2, 6, '', 600, '', NULL, 'Cieľ: za  obdobie -  ≤ 0,02 dňa asi', 97.72, 'Plán na r.2021: nad 95%; Zaúčanie nových pracovníkov, neplnenie noriem.', 87.12, 'ahoj', 91, '', 506.57, '', 12.52, '', 230.6, '', 104.26, 'Priemer plnenia VN za r.2018 105,83%', '2021-03-31 14:17:50', NULL, 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `pl200`
--

DROP TABLE IF EXISTS `pl200`;
CREATE TABLE IF NOT EXISTS `pl200` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vyrobene_kusy` double DEFAULT NULL,
  `vyrobene_kusy_poznamka` longtext COLLATE utf8_unicode_ci,
  `nto_na_vyrobene_mnozstvo_dielcov` double DEFAULT NULL,
  `nto_na_vyrobene_mnozstvo_dielcov_poznamka` longtext COLLATE utf8_unicode_ci,
  `hodnota_nto_za_cele_obdobie` double DEFAULT NULL,
  `hodnota_nto_za_cele_obdobie_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `pl200`
--

INSERT INTO `pl200` (`id`, `vyrobene_kusy`, `vyrobene_kusy_poznamka`, `nto_na_vyrobene_mnozstvo_dielcov`, `nto_na_vyrobene_mnozstvo_dielcov_poznamka`, `hodnota_nto_za_cele_obdobie`, `hodnota_nto_za_cele_obdobie_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(2, 6, '', 600, '', NULL, 'ahoj\r\n', '2021-03-23 09:45:36', '2021-03-31 14:46:23', 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `pl_smt_tht`
--

DROP TABLE IF EXISTS `pl_smt_tht`;
CREATE TABLE IF NOT EXISTS `pl_smt_tht` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zasoba_vyrobenych_modulov` longtext COLLATE utf8_unicode_ci,
  `zasoba_vyrobenych_modulov_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `pl_smt_tht`
--

INSERT INTO `pl_smt_tht` (`id`, `zasoba_vyrobenych_modulov`, `zasoba_vyrobenych_modulov_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(1, NULL, NULL, '2021-03-23 09:46:50', NULL, 0, NULL, '2021-03-01'),
(2, '', '', '2021-03-23 09:52:31', '2021-04-01 09:46:58', 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `qs`
--

DROP TABLE IF EXISTS `qs`;
CREATE TABLE IF NOT EXISTS `qs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reklamovane_ks_od_zakaznikov` double DEFAULT NULL,
  `reklamovane_ks_od_zakaznikov_poznamka` longtext COLLATE utf8_unicode_ci,
  `uznane_reklamovane_ks_od_zakaznikov` double DEFAULT NULL,
  `uznane_reklamovane_ks_od_zakaznikov_poznamka` longtext COLLATE utf8_unicode_ci,
  `uznane_naklady_za_reklamovane_ks` double DEFAULT NULL,
  `uznane_naklady_za_reklamovane_ks_poznamka` longtext COLLATE utf8_unicode_ci,
  `naklady_na_reklamacie_od_zakaznikov` double DEFAULT NULL,
  `naklady_na_reklamacie_od_zakaznikov_poznamky` longtext COLLATE utf8_unicode_ci,
  `mnozstvo_zaznamenanych_internych_nvo_av` double DEFAULT NULL,
  `mnozstvo_zaznamenanych_internych_nvo_av_poznamka` longtext COLLATE utf8_unicode_ci,
  `mnozstvo_zaznamenanych_internych_nvo_pl` double DEFAULT NULL,
  `mnozstvo_zaznamenanych_internych_nvo_pl_poznamka` longtext COLLATE utf8_unicode_ci,
  `mnozstvo_zaznamenanych_internych_nvo_celkom` double DEFAULT NULL,
  `mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka` longtext COLLATE utf8_unicode_ci,
  `naklady_na_interne_chyby` double DEFAULT NULL,
  `naklady_na_interne_chyby_poznamka` longtext COLLATE utf8_unicode_ci,
  `nv_4_sigma_6210ppm` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nv_4_sigma_6210ppm_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `qs`
--

INSERT INTO `qs` (`id`, `reklamovane_ks_od_zakaznikov`, `reklamovane_ks_od_zakaznikov_poznamka`, `uznane_reklamovane_ks_od_zakaznikov`, `uznane_reklamovane_ks_od_zakaznikov_poznamka`, `uznane_naklady_za_reklamovane_ks`, `uznane_naklady_za_reklamovane_ks_poznamka`, `naklady_na_reklamacie_od_zakaznikov`, `naklady_na_reklamacie_od_zakaznikov_poznamky`, `mnozstvo_zaznamenanych_internych_nvo_av`, `mnozstvo_zaznamenanych_internych_nvo_av_poznamka`, `mnozstvo_zaznamenanych_internych_nvo_pl`, `mnozstvo_zaznamenanych_internych_nvo_pl_poznamka`, `mnozstvo_zaznamenanych_internych_nvo_celkom`, `mnozstvo_zaznamenanych_internych_nvo_celkom_poznamka`, `naklady_na_interne_chyby`, `naklady_na_interne_chyby_poznamka`, `nv_4_sigma_6210ppm`, `nv_4_sigma_6210ppm_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-10 14:18:04', NULL, 0, NULL, '2021-03-15'),
(3, 6, '', 600, '', NULL, 'Náklady viem sledovať len kumulatívne asi', 189.05, '570,23 € náklady na moduly', 109, 'AV špecifikácia (chybné podklady do výroby)', 250, 'PL identifikácia (značenie výrobkov)', 359, 'ahoj', 179.9, '', '8900;12780', 'Celkové ppm v r.2019=AV+PL', '2021-03-22 14:11:47', '2021-03-31 13:33:55', 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `qv`
--

DROP TABLE IF EXISTS `qv`;
CREATE TABLE IF NOT EXISTS `qv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slovne_hodnotenie_riesenych_projektov` longtext COLLATE utf8_unicode_ci,
  `slovne_hodnotenie_riesenych_projektov_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `qv`
--

INSERT INTO `qv` (`id`, `slovne_hodnotenie_riesenych_projektov`, `slovne_hodnotenie_riesenych_projektov_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(2, 'asi', 'ahoj\r\n', '2021-03-22 14:29:04', '2021-04-01 09:48:08', 0, NULL, '2021-02-01'),
(3, '', '', '2021-03-31 13:43:48', '2021-03-31 13:52:19', 0, NULL, '2021-03-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `te`
--

DROP TABLE IF EXISTS `te`;
CREATE TABLE IF NOT EXISTS `te` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investicie_do_vyvoja` double DEFAULT NULL,
  `investicie_do_vyvoja_poznamka` longtext COLLATE utf8_unicode_ci,
  `pocet_hodin_venovanych_vyvoju` double DEFAULT NULL,
  `pocet_hodin_venovanych_vyvoju_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `te`
--

INSERT INTO `te` (`id`, `investicie_do_vyvoja`, `investicie_do_vyvoja_poznamka`, `pocet_hodin_venovanych_vyvoju`, `pocet_hodin_venovanych_vyvoju_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(1, NULL, NULL, NULL, NULL, '2021-03-23 10:28:46', NULL, 0, NULL, '2021-03-01'),
(2, 6, 'ahoj', NULL, '', '2021-03-23 10:33:08', '2021-04-01 09:00:00', 0, NULL, '2021-02-01');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `vk`
--

DROP TABLE IF EXISTS `vk`;
CREATE TABLE IF NOT EXISTS `vk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doba_vybavovania_reklamacii` double DEFAULT NULL,
  `doba_vybavovania_reklamacii_poznamka` longtext COLLATE utf8_unicode_ci,
  `podiel_nakladov_z_trzieb` double DEFAULT NULL,
  `podiel_nakladov_z_trzieb_poznamka` longtext COLLATE utf8_unicode_ci,
  `index_perfektnej_dodavky` double DEFAULT NULL,
  `index_perfektnej_dodavky_poznamka` longtext COLLATE utf8_unicode_ci,
  `priemerne_dni_dodania` double DEFAULT NULL,
  `priemerne_dni_dodania_poznamka` longtext COLLATE utf8_unicode_ci,
  `efektivnost_predaja` double DEFAULT NULL,
  `efektivnost_predaja_poznamka` longtext COLLATE utf8_unicode_ci,
  `sledovanie_objemu_predanych_vyrobkov` double DEFAULT NULL,
  `sledovanie_objemu_predanych_vyrobkov_poznamka` longtext COLLATE utf8_unicode_ci,
  `nove_vyrobky` double DEFAULT NULL,
  `nove_vyrobky_poznamka` longtext COLLATE utf8_unicode_ci,
  `mnozstvo_predanych_esad_ks` double DEFAULT NULL,
  `mnozstvo_predanych_esad_ks_poznamka` longtext COLLATE utf8_unicode_ci,
  `mnozstvo_predanych_esad_eur` double DEFAULT NULL,
  `mnozstvo_predanych_esad_eur_poznamka` longtext COLLATE utf8_unicode_ci,
  `zakazky_k_datum` date DEFAULT NULL,
  `zakazky_k` double DEFAULT NULL,
  `zakazky_k_poznamka` longtext COLLATE utf8_unicode_ci,
  `zakazky_k_na_sklade` double DEFAULT NULL,
  `zakazky_k_na_sklade_poznamka` longtext COLLATE utf8_unicode_ci,
  `datetime_created` datetime NOT NULL,
  `datetime_edited` datetime DEFAULT NULL,
  `sent` int(11) NOT NULL DEFAULT '0',
  `datetime_sent` datetime DEFAULT NULL,
  `obdobie` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `vk`
--

INSERT INTO `vk` (`id`, `doba_vybavovania_reklamacii`, `doba_vybavovania_reklamacii_poznamka`, `podiel_nakladov_z_trzieb`, `podiel_nakladov_z_trzieb_poznamka`, `index_perfektnej_dodavky`, `index_perfektnej_dodavky_poznamka`, `priemerne_dni_dodania`, `priemerne_dni_dodania_poznamka`, `efektivnost_predaja`, `efektivnost_predaja_poznamka`, `sledovanie_objemu_predanych_vyrobkov`, `sledovanie_objemu_predanych_vyrobkov_poznamka`, `nove_vyrobky`, `nove_vyrobky_poznamka`, `mnozstvo_predanych_esad_ks`, `mnozstvo_predanych_esad_ks_poznamka`, `mnozstvo_predanych_esad_eur`, `mnozstvo_predanych_esad_eur_poznamka`, `zakazky_k_datum`, `zakazky_k`, `zakazky_k_poznamka`, `zakazky_k_na_sklade`, `zakazky_k_na_sklade_poznamka`, `datetime_created`, `datetime_edited`, `sent`, `datetime_sent`, `obdobie`) VALUES
(4, 6, '', 0.06, 'Cieľ pre r.2021: doba vybav.: ≤  0,10% asi', NULL, 'Plán na r.2021:≥ 65% a viac ', 27.95, 'Plán na r.2021: ≤  40 dní', 14.97, 'Plán na r.2021: ≥  16%', 926772.39, 'ahoj', 6.65, '', 20710, '', 854244.9, '', '2021-02-08', NULL, '', NULL, '', '2021-03-19 13:54:18', '2021-04-01 09:48:53', 0, NULL, '2021-02-01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
