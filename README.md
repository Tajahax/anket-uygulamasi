# anket-uygulamasi
Tajahax Anket Uygulaması


Projemin SQL Kodları: SQL ile 'anket' adında bir veritabanı oluşturun. 

CREATE TABLE `anketler` (
  `anket_id` int(11) NOT NULL,
  `soru` varchar(255) DEFAULT NULL,
  `cevap1` varchar(255) DEFAULT NULL,
  `cevap2` varchar(255) DEFAULT NULL,
  `secenek1_oy` int(11) DEFAULT '0',
  `secenek2_oy` int(11) DEFAULT '0'
);

-- --------------------------------------------------------
CREATE TABLE `oy_kullananlar` (
  `anket_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
CREATE TABLE `uyeler` (
  `kadi` varchar(11) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `tekrarsifre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ve SQL kısmından 3 adet SQL kodlarını çalıştırıp 3 adet tabloyu veritabanına aktarın.
