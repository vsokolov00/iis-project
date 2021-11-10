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
    `created_at`       datetime,
    `updated_at`       datetime,
    `password`         varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auction_items` (
    `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
    `owner`         int(10) unsigned DEFAULT NULL,
    `item_name`     varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    `image`         varchar(256) DEFAULT NULL,
    `description`   varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    `created_at`      datetime,
    `updated_at`       datetime,
    PRIMARY KEY (`id`),
    KEY `owner_of_item_fk` (`owner`),
    CONSTRAINT `owner_of_item_fk` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auctions` (
    `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
    `item`              int(10) unsigned NOT NULL,
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
    `winner`            int(10) unsigned DEFAULT NULL,
    `created_at`        datetime,
    `updated_at`        datetime,
    PRIMARY KEY (`id`),
    KEY `winner_fk` (`winner`),
    KEY `item_fk` (`item`),
    CONSTRAINT `winner_fk` FOREIGN KEY (`winner`) REFERENCES `users` (`id`),
    CONSTRAINT `item_fk` FOREIGN KEY (`item`) REFERENCES `auction_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `participants_of` (
    `participant`       int(10) unsigned NOT NULL,
    `auction`           int(10) unsigned NOT NULL,
    `registered_at`     datetime,
    `is_approved`       tinyint(1) DEFAULT NULL,
    `last_bid`          decimal(10,0) DEFAULT NULL,
    `date_of_last_bid`  datetime DEFAULT NULL,
    PRIMARY KEY (`participant`,`auction`),
    KEY `part_of_fk` (`auction`),
    CONSTRAINT `part_fk` FOREIGN KEY (`participant`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `part_of_fk` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auctioneers_of` (
    `user` int(10) unsigned NOT NULL,
    `auction` int(10) unsigned NOT NULL,
    PRIMARY KEY (`user`,`auction`),
    KEY `auction_fk` (`auction`),
    CONSTRAINT `auction_fk` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `auctioneer_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `auction_items` (`id`, `owner`, `item_name`, `description`, `created_at`)
VALUES (1, 1, 'Test item', 'The best item!', now());

INSERT INTO `auctions` (`id`, `item`, `is_open`, `is_selling`, `is_approved`, `starting_price`, `is_active`, `closing_price`, `created_at`)
VALUES (1, 1, 1, 1, 1, 100, 1, 500, now());
