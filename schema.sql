-- noinspection SpellCheckingInspectionForFile

CREATE DATABASE IF NOT EXISTS `dotdev-db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `dotdev-db`;

CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT         NOT NULL AUTO_INCREMENT,
    `username` TINYTEXT    NOT NULL,
    `password` VARCHAR(64) NOT NULL,
    `level`    TINYINT     NOT NULL DEFAULT 0, -- 0: default / 1: mod / 2: admin
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `posts`
(
    `id`                  INT         NOT NULL AUTO_INCREMENT,
    `title`               TEXT(512)   NOT NULL,
    `text`                LONGTEXT    NOT NULL,
    `owner_id`            INT         NOT NULL,
    `views`               INT         NOT NULL DEFAULT 0,
    `total_votes`         INT         NOT NULL DEFAULT 0,
    `average_score`       FLOAT(2, 2) NOT NULL DEFAULT 0.00,
    `creation_date`       DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_updated`        DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_update_user_id` INT         NOT NULL DEFAULT -1,
    `hidden`              BOOLEAN     NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `posts`
    ADD CONSTRAINT `posts_owner_id_users_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE;

INSERT INTO `users` (`username`, `password`, `level`)
VALUES ('root', SHA2('toor', 256), 2);