
CREATE TABLE IF NOT EXISTS `vehicol` (
  `nrvehicol` int(11) NOT NULL,
  `marca` varchar(128) NOT NULL,
  `tip` varchar(128) NOT NULL,
  `seriemotor` varchar(128) NOT NULL,
  `seriecaroserie` varchar(128) NOT NULL,
  `carburant` varchar(128) NOT NULL,
  `culoare` varchar(128) NOT NULL,
  `capacitatecil` int(128) NOT NULL,
  PRIMARY KEY (`nrvehicol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vehicol` (`nrvehicol`, `marca`, `tip`, `seriemotor`, `seriecaroserie`, `carburant`, `culoare`, `capacitatecil`) VALUES
(123456, 'aaaa', 'aa', '123456789', 'a123456789', 'b,cng', 'crem', 1600),
(654321, 'bbbb', 'bb', '987654321', 'b987654321', 'b,lpg', 'gri', 1300);



CREATE TABLE IF NOT EXISTS `proprietate` (
  `cnp` varchar(128) NOT NULL,
  `nrvehicol` int(11) NOT NULL,
  `datacumpararii` varchar(32) NOT NULL,
  `pret` int(11) NOT NULL,
  PRIMARY KEY (`nrvehicol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `proprietate` (`cnp`, `nrvehicol`, `datacumpararii`, `pret`) VALUES
('1234567890122', 123456, '2021-01-24', 132456),
('1234567890123', 654321, '2020-13-24', 654321);



CREATE TABLE IF NOT EXISTS `persoana` (
  `nume` varchar(128) NOT NULL,
  `prenume` varchar(128) NOT NULL,
  `carteidentitate` varchar(32) NOT NULL,
  `cnp` varchar(13) NOT NULL,
  `adresa` text NOT NULL,
  PRIMARY KEY (`cnp`),
  UNIQUE KEY `cnp` (`cnp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `persoana` (`nume`, `prenume`, `carteidentitate`, `cnp`, `adresa`) VALUES
('Cutarescu', 'Cutarila', 'B-123456', '1234567890122', 'undeva departe'),
('Testescu', 'Testel', 'OT-123456', '1234567890123', 'acasa');
