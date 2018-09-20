CREATE TABLE testerdb.answer
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    question_id int(11) NOT NULL,
    text varchar(32) NOT NULL,
    is_correct tinyint(1),
    CONSTRAINT answer_ibfk_1 FOREIGN KEY (question_id) REFERENCES testerdb.question (id)
);
CREATE INDEX question_id ON testerdb.answer (question_id);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (1, 1, 'Jānis Čakste', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (2, 1, 'Alberts Kviesis', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (3, 1, 'Kārlis Ulmanis', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (4, 1, 'Guntis Ulmanis', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (5, 2, '2002', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (6, 2, '2003', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (7, 2, '2004', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (8, 2, '2005', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (9, 3, '2013', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (10, 3, '2014', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (11, 3, '2015', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (12, 3, '2016', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (13, 4, 'Baumaņu Kārlis', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (14, 4, 'Raimonds Pauls', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (15, 4, 'Prāta Vētra', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (16, 4, 'Jāzeps Vītols', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (17, 5, 'Zviedrijas', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (18, 5, 'Somijas', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (19, 5, 'Norvēģijas', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (20, 5, 'Nīderlandes', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (21, 6, 'Liepājā un Rīgā', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (22, 6, 'Rīgā un Ventspilī', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (23, 6, 'Liepājā un Ventspilī

', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (24, 6, 'Ventspilī', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (25, 6, 'Rīgā', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (26, 6, 'Liepājā', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (27, 7, 'Lietuva', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (28, 7, 'Igaunija', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (29, 7, 'Polija', 1);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (30, 7, 'Baltkrievija', 0);
INSERT INTO testerdb.answer (id, question_id, text, is_correct) VALUES (31, 7, 'Krievija', 0);
CREATE TABLE testerdb.log
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user varchar(32) NOT NULL,
    passing_id int(11) NOT NULL,
    question_id int(11) NOT NULL,
    answer_id int(11) NOT NULL,
    CONSTRAINT log_ibfk_1 FOREIGN KEY (passing_id) REFERENCES testerdb.passing (id),
    CONSTRAINT log_ibfk_2 FOREIGN KEY (question_id) REFERENCES testerdb.question (id),
    CONSTRAINT log_ibfk_3 FOREIGN KEY (answer_id) REFERENCES testerdb.answer (id)
);
CREATE INDEX passing_id ON testerdb.log (passing_id);
CREATE INDEX question_id ON testerdb.log (question_id);
CREATE INDEX answer_id ON testerdb.log (answer_id);
INSERT INTO testerdb.log (id, user, passing_id, question_id, answer_id) VALUES (1, 'Vladislavs', 2, 1, 1);
INSERT INTO testerdb.log (id, user, passing_id, question_id, answer_id) VALUES (2, 'Vladislavs', 2, 2, 5);
INSERT INTO testerdb.log (id, user, passing_id, question_id, answer_id) VALUES (3, 'Vladislavs', 2, 3, 9);
INSERT INTO testerdb.log (id, user, passing_id, question_id, answer_id) VALUES (4, 'Vladislavs', 2, 4, 13);
INSERT INTO testerdb.log (id, user, passing_id, question_id, answer_id) VALUES (5, 'Vladislavs', 2, 5, 17);
CREATE TABLE testerdb.passing
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user varchar(32) NOT NULL,
    test_id int(11) NOT NULL,
    is_complete tinyint(1) DEFAULT '0',
    result int(11) DEFAULT '0' NOT NULL,
    CONSTRAINT passing_ibfk_1 FOREIGN KEY (test_id) REFERENCES testerdb.test (id)
);
CREATE INDEX test_id ON testerdb.passing (test_id);
INSERT INTO testerdb.passing (id, user, test_id, is_complete, result) VALUES (1, 'Vladislavs', 1, 0, 0);
INSERT INTO testerdb.passing (id, user, test_id, is_complete, result) VALUES (2, 'Vladislavs', 1, 1, 3);
CREATE TABLE testerdb.question
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    test_id int(11),
    text varchar(255) NOT NULL,
    CONSTRAINT question_ibfk_1 FOREIGN KEY (test_id) REFERENCES testerdb.test (id)
);
CREATE INDEX test_id ON testerdb.question (test_id);
INSERT INTO testerdb.question (id, test_id, text) VALUES (1, 1, 'Pirmais Latvijas prezidents?');
INSERT INTO testerdb.question (id, test_id, text) VALUES (2, 1, 'Kurā gadā Latvija iestājās ES un NATO?');
INSERT INTO testerdb.question (id, test_id, text) VALUES (3, 1, 'Kurā gadā Latvijā ieviesa eiro?');
INSERT INTO testerdb.question (id, test_id, text) VALUES (4, 1, 'Kurš ir Latvijas valsts himnas autors?');
INSERT INTO testerdb.question (id, test_id, text) VALUES (5, 1, 'Kuras valsts pakļautībā 16. - 19. gadsimtā bija vismaz daļa Latvijas teritorijas?');
INSERT INTO testerdb.question (id, test_id, text) VALUES (6, 2, 'Kurās Latvijas pilsētās atrodas neaizsalstošās jūras ostas?');
INSERT INTO testerdb.question (id, test_id, text) VALUES (7, 2, 'Ar kurām valstīm Latvijai NAV sauszemes robeža?');
CREATE TABLE testerdb.test
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL
);
INSERT INTO testerdb.test (id, title) VALUES (1, 'Vēsture');
INSERT INTO testerdb.test (id, title) VALUES (2, 'Ģeogrāfija');