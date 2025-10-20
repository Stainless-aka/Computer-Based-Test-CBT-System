-- SQL Dump for CBT System - GOVERNMENT DAY SENIOR SECONDARY SCHOOL GASHUA
CREATE DATABASE IF NOT EXISTS cbt_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cbt_system;

-- Drop tables if they exist
DROP TABLE IF EXISTS results;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS exams;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS meta;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username,password) VALUES ('admin','admin123');

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(50) UNIQUE NOT NULL,
  username VARCHAR(100),
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(100),
  middle_name VARCHAR(100),
  last_name VARCHAR(100),
  date_registered DATETIME DEFAULT CURRENT_TIMESTAMP,
  year_level VARCHAR(50),
  class_name VARCHAR(100),
  course VARCHAR(100)
);

INSERT INTO students (student_id,username,password,first_name,last_name,year_level,class_name,course) VALUES
('STU001','student01','pass123','Ridwan','Kamaluddeen','SSS3','SSS3','Science'),
('STU002','student02','pass123','Khadija','Buba','SSS2','SSS2','Arts'),
('STU003','student03','pass123','Ali','Hussaini','SSS1','SSS1','Science');

CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_name VARCHAR(150) NOT NULL
);

INSERT INTO subjects (subject_name) VALUES
('Mathematics'),
('English'),
('Biology'),
('Chemistry'),
('Computer Science');

CREATE TABLE exams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_id INT NOT NULL,
  duration_minutes INT NOT NULL DEFAULT 30,
  active TINYINT(1) NOT NULL DEFAULT 1,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

INSERT INTO exams (subject_id,duration_minutes,active) VALUES
(1,30,1),(2,30,1),(3,30,1),(4,30,1),(5,30,1);

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject_id INT NOT NULL,
  question TEXT NOT NULL,
  option_a VARCHAR(500) NOT NULL,
  option_b VARCHAR(500) NOT NULL,
  option_c VARCHAR(500) NOT NULL,
  option_d VARCHAR(500) NOT NULL,
  correct CHAR(1) NOT NULL,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- We'll add 15 questions per subject below
-- Mathematics (1)
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'What is 7 × 8?', '54', '56', '64', '49', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'If f(x)=2x+3, what is f(5)?', '10', '13', '8', '7', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Solve for x: 3x - 9 = 0', '3', '-3', '9', '0', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'What is the square root of 144?', '10', '11', '12', '14', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'What is 15% of 200?', '20', '25', '30', '35', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Simplify: (2^3) × (2^4)', '2^7', '2^12', '2^24', '2^1', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'If triangle angles are 90°, 45°, the third angle is:', '35°', '45°', '60°', '90°', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Expand: (x+2)(x+3)', 'x^2+5x+6', 'x^2+6x+5', 'x^2+3x+2', 'x^2+2x+3', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Perimeter of a square with side 6 cm?', '12 cm', '18 cm', '24 cm', '36 cm', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Convert 0.75 to fraction', '3/4', '1/2', '7/10', '2/3', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'If probability is 0.2, percent is:', '0.02%', '2%', '20%', '200%', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'LCM of 4 and 6?', '12', '24', '6', '8', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Mean of 2,4,6,8,10?', '6', '5', '7', '4', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'Solve: 5x + 10 = 35', '3', '5', '7', '4', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (1, 'What is 9 ÷ 0.3?', '3', '30', '0.3', '27', 'B');
-- English (2)
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Choose the correct spelling:', 'Accomodate', 'Acommodate', 'Accommodate', 'Acomodate', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Opposite of ''scarce'':', 'Rare', 'Abundant', 'Little', 'Sparse', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Pick the correct form: ''She ___ to school every day.''', 'go', 'goes', 'gone', 'going', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Which is a noun?', 'Quickly', 'Happy', 'School', 'Bright', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Past tense of ''teach'':', 'teached', 'taught', 'teach', 'tought', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Identify the adjective: ''A bright student''', 'Student', 'Bright', 'A', 'None', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Pick the correct article: ''I saw ___ elephant.''', 'a', 'an', 'the', 'no article', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Which sentence is punctuated correctly?', 'Whats your name?', 'What''s your name?', 'Whats your name.', 'Whats your name!', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Synonym of ''begin'':', 'Start', 'End', 'Stop', 'Finish', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Choose best completion: ''If I ___ you, I''d apologize.''', 'am', 'were', 'was', 'be', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Which is a pronoun?', 'Table', 'They', 'Running', 'Red', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Plural of ''child'':', 'childs', 'childes', 'children', 'childrens', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Fill: ''She is better ___ him at math.''', 'then', 'than', 'that', 'to', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Identify the adverb in: ''He runs quickly.''', 'He', 'runs', 'quickly', 'none', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (2, 'Choose correct sentence:', 'Their coming soon.', 'They''re coming soon.', 'There coming soon.', 'Theyre coming soon.', 'B');
-- Biology (3)
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which organ pumps blood around the body?', 'Lungs', 'Liver', 'Heart', 'Kidney', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Photosynthesis occurs mainly in which part?', 'Roots', 'Leaves', 'Stem', 'Flower', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which blood cells fight infection?', 'Red blood cells', 'White blood cells', 'Platelets', 'Plasma', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Basic unit of life?', 'Atom', 'Molecule', 'Cell', 'Organ', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which organ is for breathing?', 'Heart', 'Lungs', 'Stomach', 'Skin', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'What carries oxygen in blood?', 'Platelets', 'Hemoglobin in RBCs', 'Plasma', 'White cells', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which organ digests food?', 'Kidney', 'Lungs', 'Stomach', 'Brain', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Process that produces gametes?', 'Mitosis', 'Meiosis', 'Fertilization', 'Osmosis', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which is not a vertebrate?', 'Fish', 'Bird', 'Insect', 'Mammal', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Where does fertilization usually occur?', 'Uterus', 'Ovary', 'Fallopian tube', 'Vagina', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Green pigment in leaves?', 'Chlorophyll', 'Melanin', 'Haemoglobin', 'Carotene', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'System that controls hormones?', 'Digestive', 'Endocrine', 'Respiratory', 'Skeletal', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which gas is produced in respiration?', 'Oxygen', 'Nitrogen', 'Carbon dioxide', 'Hydrogen', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'What stores genetic information?', 'Proteins', 'Lipids', 'DNA', 'Carbohydrates', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (3, 'Which part filters blood to make urine?', 'Liver', 'Kidney', 'Heart', 'Spleen', 'B');
-- Chemistry (4)
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Water''s chemical formula is:', 'H2O', 'CO2', 'O2', 'NaCl', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'pH of neutral water is:', '0', '7', '14', '1', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Salt forms from acid + ?', 'Metal', 'Base', 'Gas', 'Alcohol', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Atomic number of carbon?', '6', '12', '14', '8', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Which is a noble gas?', 'Oxygen', 'Nitrogen', 'Argon', 'Hydrogen', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Which particle has a negative charge?', 'Proton', 'Neutron', 'Electron', 'Nucleus', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Common name for NaCl is:', 'Sugar', 'Baking soda', 'Salt', 'Chalk', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'State with definite volume no fixed shape?', 'Solid', 'Liquid', 'Gas', 'Plasma', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Avogadro''s constant approx?', '6.02×10^23', '3.14', '9.81', '1.6×10^-19', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Process separating mixtures by boiling points?', 'Filtration', 'Distillation', 'Chromatography', 'Evaporation', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Which gas supports combustion?', 'Carbon dioxide', 'Oxygen', 'Nitrogen', 'Helium', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Formula for methane?', 'CH4', 'C2H6', 'CO2', 'H2O', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'pH < 7 indicates:', 'Neutral', 'Alkaline', 'Acidic', 'Basic', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Example of a polymer is:', 'Polyethene', 'Water', 'Salt', 'Oxygen', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (4, 'Rusting commonly involves which metal?', 'Gold', 'Iron', 'Copper', 'Silver', 'B');
-- Computer Science (5)
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'What does CPU stand for?', 'Central Performance Unit', 'Central Processing Unit', 'Computer Personal Unit', 'Control Processing Unit', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Language primarily for webpage structure?', 'CSS', 'Python', 'HTML', 'SQL', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'What does RAM stand for?', 'Read Access Memory', 'Random Access Memory', 'Run Access Memory', 'Read-only Access Memory', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Which is non-volatile storage?', 'RAM', 'ROM', 'Cache', 'Register', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'HTML is used for:', 'Styling pages', 'Structuring pages', 'Programming logic', 'Database', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Which is a programming language?', 'HTTP', 'HTML', 'Java', 'FTP', 'C');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Tag for paragraph in HTML?', '<p>', '<div>', '<a>', '<span>', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Binary uses which digits?', '0 and 1', '0 to 9', 'A to F', '1 to 2', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'What is an IP address used for?', 'Storing data', 'Identifying a device on network', 'Encrypting files', 'Programming', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'What does ''OS'' stand for?', 'Open Source', 'Operating System', 'Output Stream', 'Online Service', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Used to query relational DB?', 'HTML', 'CSS', 'JavaScript', 'SQL', 'D');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Device that forwards packets between networks?', 'Switch', 'Router', 'Printer', 'Monitor', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Which is markup language?', 'HTML', 'Python', 'C++', 'Java', 'A');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'What is source code?', 'Compiled program', 'Human-readable program instructions', 'Binary only', 'Encrypted files', 'B');
INSERT INTO questions (subject_id, question, option_a, option_b, option_c, option_d, correct) VALUES (5, 'Symbol for single-line comment in PHP?', '//', '#', '/*', '<!--', 'A');

CREATE TABLE results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  subject_id INT NOT NULL,
  score INT NOT NULL,
  total INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

CREATE TABLE meta (k VARCHAR(100) PRIMARY KEY, v TEXT);
INSERT INTO meta (k,v) VALUES ('school_name','GOVERNMENT DAY SENIOR SECONDARY SCHOOL GASHUA') 
ON DUPLICATE KEY UPDATE v=VALUES(v);
