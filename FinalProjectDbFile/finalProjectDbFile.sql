drop
database if exists school;
create
database if not exists school;
use
school;
/* notes - consider removing testId and just going with testName
consider removing answers table and just putting answers in questions table*/
create table section
(
    sectionId varchar(40) not null primary key
);

insert into section
values ("Level 1 Chapter 1"),
       ("Level 1 Chapter 2"),
       ("Level 1 Chapter 3");

create table classes
(
    classId          varchar(10) not null primary key,
    classDays        varchar(20) not null,
    classTime        varchar(20) not null,
    classLevel       varchar(10) not null,
    classMaxStudents int         not null
);

insert into classes
values ("Class 1", "Monday, Wednesday, Friday", "3:00 to 5:00", "level 1", 10),
       ("Class 2", "Tuesday, Thrusday", "3:00 to 6:00", "level 2", 10),
       ("Class 3", "Monday, Wednesday, Friday", "3:00 to 5:00", "level 3", 10);

create table student
(
    studentId                int unsigned not null auto_increment primary key,
    studentName              varchar(50) not null,
    studentPhone             varchar(50) not null,
    studentEmail             varchar(50) not null,
    studentAddress           varchar(50) not null,
    studentParentName        varchar(50) not null,
    studentParentContactInfo varchar(50) not null,
    classId                  varchar(10) not null,
    pass                     varchar(40) not null,
    FOREIGN KEY (classId) REFERENCES classes (classId) ON DELETE CASCADE
);

insert into student
values (NULL, "Alex", "902-111-1111", "alex@email.com", "Charlottetown, PEI", "Mom and Dad", "902-111-0000", "Class 1",
        sha1('pass')),
       (NULL, "Ethan", "902-222-2222", "ethan@email.com", "Charlottetown, PEI", "Mom and Dad", "902-222-0000",
        "Class 2", sha1('pass')),
       (NULL, "Euijung", "902-333-3333", "euijung@email.com", "Charlottetown, PEI", "Mom and Dad", "902-333-0000",
        "Class 3", sha1('pass'));


create table tests
(
    testId    int unsigned not null auto_increment primary key,
    classId   varchar(10) not null,
    testName  varchar(20) not null,
    sectionId varchar(40) not null,

    FOREIGN KEY (classId) REFERENCES classes (classId) ON DELETE CASCADE,
    FOREIGN KEY (sectionId) REFERENCES section (sectionId) ON DELETE CASCADE
);

insert into tests
values (NULL, "Class 1", "Test1", "Level 1 Chapter 1"),
       (NULL, "Class 1", "Test2", "Level 1 Chapter 1");

create table questions
(
    questionId   int unsigned not null auto_increment primary key,
    questionText varchar(100)  not null,
    points       decimal(3, 2) not null,
    testId       int unsigned not null,
    FOREIGN KEY (testId) REFERENCES tests (testId) ON DELETE CASCADE
);
insert into questions
values (NULL, "How high is up?", 5, 1),
       (Null, "How are you today?", 5, 1),
       (NULL, "Where do you live?", 5, 2),
       (NULL, "What day is it today?", 5, 2);


-- Table for correct answers - multiple choice questions == for future use
create table choices
(
    choiceId   int unsigned not null auto_increment primary key,
    choiceText varchar(20) not null,
    questionId int unsigned not null,
    isCorrect  boolean     not null default false,
    FOREIGN KEY (questionId) REFERENCES questions (questionId) ON DELETE CASCADE
);

-- Table for correct answers - written questions == may delete later
create table answers
(
    answerId   int unsigned not null auto_increment primary key,
    answerText varchar(100) not null,
    questionId int unsigned not null,
    FOREIGN KEY (questionId) REFERENCES questions (questionId) ON DELETE CASCADE
);
insert into answers
values (NULL, "Very high.", 1),
       (Null, "I'm fine, thank you. And you?", 2),
       (NULL, "I live on PEI.", 3),
       (NULL, "Today is Monday.", 4);


create table studentTests
(
    studentId int unsigned not null,
    testId    int unsigned not null,
    grade     decimal(5, 2),
    PRIMARY KEY (studentId, testId),
    FOREIGN KEY (studentId) REFERENCES student (studentId) ON DELETE CASCADE,
    FOREIGN KEY (testId) REFERENCES tests (testId) ON DELETE CASCADE
);
insert into studentTests
values (1, 1, 80.0),
       (2, 1, 90.5),
       (1, 2, 90.5),
       (2, 2, 99.0);

create table studentAnswers
(
    studentAnswerId int unsigned not null auto_increment primary key,
    studentId       int unsigned not null,
    questionId      int unsigned not null,
    studentAnswer   varchar(50),
    pointsAwarded   decimal(3, 2),
    feedback        varchar(100),
    FOREIGN KEY (studentId) REFERENCES student (studentId) ON DELETE CASCADE,
    FOREIGN KEY (questionId) REFERENCES questions (questionId) ON DELETE CASCADE
);
insert into studentAnswers
values (NULL, 1, 1, "Kinda high.", NULL, NULL),
       (Null, 1, 2, "I'm fine, thanks. You?", NULL, NULL),
       (NULL, 1, 3, "I live on here.", NULL, NULL),
       (NULL, 1, 4, "Today is Christmas.", NULL, NULL),
       (NULL, 2, 1, "Not high.", NULL, NULL),
       (Null, 2, 2, "Me good.", NULL, NULL),
       (NULL, 2, 3, "Here, there, and everywhere.", NULL, NULL),
       (NULL, 2, 4, "Today.", NULL, NULL);


create table teachers
(
    teacherId   int unsigned not null auto_increment primary key,
    teacherName varchar(20),
    pass        varchar(40)
);
/* MySQL sha1() function calculates an SHA-1 160-bit checksum for a string. */
insert into teachers
values (NULL, 'joel', sha1('pass'));

/* data to be used for the section report. In future to be replaced with real data*/

create table homework
(
    homeworkId         varchar(20) not null,
    studentId          int unsigned not null,
    sectionId          varchar(40) not null,
    homeworkAssessment varchar(20) not null,

    PRIMARY KEY (homeworkId, studentId),
    FOREIGN KEY (studentId) REFERENCES student (studentId) ON DELETE CASCADE,
    FOREIGN KEY (sectionId) REFERENCES section (sectionId) ON DELETE CASCADE
);

insert into homework
values ("L1C1 H1", 1, "Level 1 Chapter 1", "9/10"),
       ("L1C1 H2", 1, "Level 1 Chapter 1", "7/10"),
       ("L1C1 H3", 1, "Level 1 Chapter 1", "8/10"),
       ("L1C2 H1", 1, "Level 1 Chapter 2", "10/10"),
       ("L1C3 H1", 1, "Level 1 Chapter 3", "7/10"),
       ("L1C1 H1", 2, "Level 1 Chapter 1", "10/10"),
       ("L1C1 H2", 2, "Level 1 Chapter 1", "6/10"),
       ("L1C1 H3", 2, "Level 1 Chapter 1", "9/10"),
       ("L1C2 H1", 2, "Level 1 Chapter 2", "9/10"),
       ("L1C3 H1", 2, "Level 1 Chapter 3", "8/10");


/* In future with real data, probably need 2-3 tables
   one for homework, one for answers. Or combine everything with questions, answers, student answers, etc
   the same way tests are done. Work down from questions*/
