USE `bhagyarekha`;

-- Add optional image columns (for screenshot-like homepage cards)
ALTER TABLE `services` ADD COLUMN `image_path` VARCHAR(191) NOT NULL DEFAULT '' AFTER `description`;
ALTER TABLE `products` ADD COLUMN `image_path` VARCHAR(191) NOT NULL DEFAULT '' AFTER `description`;
ALTER TABLE `awards` ADD COLUMN `image_path` VARCHAR(191) NOT NULL DEFAULT '' AFTER `title`;

