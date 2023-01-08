<?php
// Copyright 2022 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.

$create_table_commands = [
    "users" => "CREATE TABLE IF NOT EXISTS users(
        user_id             INT NOT NULL AUTO_INCREMENT,
        username            VARCHAR(20) NOT NULL UNIQUE,
        age                 INT,
        PRIMARY KEY         (user_id)
    );",

    "correct_answers" => "CREATE TABLE IF NOT EXISTS correct_answers(
        answer_id           INT NOT NULL AUTO_INCREMENT,
        text                VARCHAR(128) NOT NULL,
        PRIMARY KEY         (answer_id)
    );",

    "questions" => "CREATE TABLE IF NOT EXISTS questions(
        question_id         INT NOT NULL AUTO_INCREMENT,
        text                VARCHAR(128) NOT NULL UNIQUE,
        correct_answer_id   INT,
        author_id           INT,

        PRIMARY KEY         (question_id)
    );",

    "user_answers" => "CREATE TABLE IF NOT EXISTS user_answers(
        answer_id           INT NOT NULL AUTO_INCREMENT,
        text                VARCHAR(128) NOT NULL,
        user_id             INT,
        question_id         INT,

        PRIMARY KEY         (answer_id)
    );",

    "foreign_keys" => "ALTER TABLE questions
        ADD FOREIGN KEY (correct_answer_id) REFERENCES correct_answers (answer_id);

        ALTER TABLE questions
        ADD FOREIGN KEY author_id REFERENCES users (user_id);

        ALTER TABLE user_answers
        FOREIGN KEY (question_id) REFERENCES questions(question_id);

        ALTER TABLE user_answers
        ADD FOREIGN KEY (user_id) REFERENCES users (user_id);"
];

$create_table_commands = [
    "users" => "CREATE TABLE IF NOT EXISTS users(
        user_id             INT NOT NULL AUTO_INCREMENT,
        username            VARCHAR(20) NOT NULL UNIQUE,
        age                 INT,
        PRIMARY KEY         (user_id)
    );",

    "questions" => "CREATE TABLE IF NOT EXISTS questions(
        question_id         INT NOT NULL AUTO_INCREMENT,
        text                VARCHAR(128) NOT NULL UNIQUE,

        PRIMARY KEY         (question_id)
    );",

    "answer_options" => "CREATE TABLE IF NOT EXISTS answer_options(
        option_id           INT NOT NULL AUTO_INCREMENT,
        text                VARCHAR(128) NOT NULL,
        option_index        INT NOT NULL,
        question_id         INT,

        PRIMARY KEY         (option_id)
    );",

    "user_answers" => "CREATE TABLE IF NOT EXISTS user_answers(
        answer_id           INT NOT NULL AUTO_INCREMENT,
        answer_index        INT,
        question_id         INT,
        user_id             INT,

        PRIMARY KEY         (answer_id)
    );",

    "foreign_keys" => "ALTER TABLE answer_options
        ADD FOREIGN KEY (question_id) REFERENCES questions(question_id);

        ALTER TABLE user_answers
        ADD FOREIGN KEY (question_id) REFERENCES questions(question_id);

        ALTER TABLE user_answers
        ADD FOREIGN KEY (user_id) REFERENCES users (user_id);"
];

?>
