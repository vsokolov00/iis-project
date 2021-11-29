CREATE TABLE `users` (
    `id`               int(10) unsigned NOT NULL AUTO_INCREMENT,
    `typ`              ENUM('admin', 'user', 'auctioneer') COLLATE utf8mb4_unicode_520_ci DEFAULT 'user' NOT NULL,
    `name`             varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    `email`            varchar(128) NOT NULL,
    `created_at`       datetime,
    `updated_at`       datetime,
    `password`         varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auction_items` (
    `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
    `owner`         int(10) unsigned DEFAULT NULL,
    `item_name`     varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    `image`         varchar(256) DEFAULT NULL,
    `description`   varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
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
    `is_approved`       tinyint(1) DEFAULT NULL,
    `starting_price`    float NOT NULL,
    `bid_min`           int(10) unsigned DEFAULT NULL,
    `bid_max`           int(10) unsigned DEFAULT NULL,
    `start_time`        datetime DEFAULT NULL,
    `closing_price`     float DEFAULT NULL,
    `time_limit`        datetime DEFAULT NULL,
    `results_approved`  tinyint(1) DEFAULT NULL,
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
    `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
    `participant`       int(10) unsigned NOT NULL,
    `auction`           int(10) unsigned NOT NULL,
    `registered_at`     datetime,
    `is_approved`       tinyint(1) DEFAULT 1,
    `last_bid`          decimal(10,0) DEFAULT NULL,
    `date_of_last_bid`  datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`participant`,`auction`),
    KEY `part_of_fk` (`auction`),
    CONSTRAINT `part_fk` FOREIGN KEY (`participant`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `part_of_fk` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auctioneers_of` (
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user` int(10) unsigned NOT NULL,
    `auction` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`user`,`auction`),
    KEY `auction_fk` (`auction`),
    CONSTRAINT `auction_fk` FOREIGN KEY (`auction`) REFERENCES `auctions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `auctioneer_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
