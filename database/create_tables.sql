-- DROP TABLE `auctioneer_of`;
-- DROP TABLE `participant_of`;
-- DROP TABLE `auction`;
-- DROP TABLE `auction_item`;
-- DROP TABLE `user`;

SET NAMES utf8mb4;

-- USE `test`;

CREATE TABLE `users` (
    `id`               int(10) unsigned NOT NULL AUTO_INCREMENT,
    `typ`              ENUM('admin', 'user', 'auctioneer') COLLATE utf8mb4_unicode_520_ci DEFAULT 'user' NOT NULL,
    `name`             varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    `email`            varchar(128) NOT NULL,
    `created_at`       DATETIME,
    `updated_at`       DATETIME,
    `password`         varchar(255) DEFAULT NULL,
    `birthday`         date DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auction_item` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `item_name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    `image` varchar(256) DEFAULT NULL,
    `description` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auction` (
    `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
    `item` int(10)      unsigned DEFAULT NULL,
    `is_open`           tinyint(1) NOT NULL,
    `is_selling`        tinyint(1) NOT NULL,
    `is_approved`       tinyint(1) NOT NULL DEFAULT 0,
    `starting_price`    float NOT NULL,
    `bid_constraint`    varchar(64) DEFAULT NULL,
    `start_time`        datetime DEFAULT NULL,
    `is_active`         tinyint(1) NOT NULL DEFAULT 0,
    `closing_price`     float DEFAULT NULL,
    `time_limit`        datetime DEFAULT NULL,
    `is_finished`       tinyint(1) DEFAULT 0,
    `seller`            int(10) unsigned DEFAULT NULL,
    `buyer`             int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `seller_fk` (`seller`),
    KEY `buyer_fk` (`buyer`),
    KEY `item_fk` (`item`),
    CONSTRAINT `buyer_fk` FOREIGN KEY (`buyer`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `item_fk` FOREIGN KEY (`item`) REFERENCES `auction_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `seller_fk` FOREIGN KEY (`seller`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `participant_of` (
    `participant`       int(10) unsigned NOT NULL,
    `auction`           int(10) unsigned NOT NULL,
    `is_approved`       tinyint(1) DEFAULT NULL,
    `last_bid`          decimal(10,0) DEFAULT NULL,
    `date_of_last_bid`  datetime DEFAULT NULL,
    PRIMARY KEY (`participant`,`auction`),
    KEY `part_of_fk` (`auction`),
    CONSTRAINT `part_fk` FOREIGN KEY (`participant`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `part_of_fk` FOREIGN KEY (`auction`) REFERENCES `auction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auctioneer_of` (
    `user` int(10) unsigned NOT NULL,
    `auction` int(10) unsigned NOT NULL,
    PRIMARY KEY (`user`,`auction`),
    KEY `auction_fk` (`auction`),
    CONSTRAINT `auction_fk` FOREIGN KEY (`auction`) REFERENCES `auction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `auctioneer_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
