Use Services-Country;

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country`  (
  `country_id` int NOT NULL AUTO_INCREMENT,
  `country_code` char(3)  NULL DEFAULT NULL,
  `country_name` varchar(75)  NULL DEFAULT NULL,
  `code` char(2)  NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`country_id`) USING BTREE
);


Use Services-HubKeluarga;
DROP TABLE IF EXISTS `hubungan_keluarga`;
CREATE TABLE `hubungan_keluarga`  (
  `id_hub_keluarga` int NOT NULL AUTO_INCREMENT,
  `nama_hub_keluarga` varchar(100)  NOT NULL,
  `keterangan` varchar(250)  NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_hub_keluarga`) USING BTREE
);


Use Services-JenisGereja;

DROP TABLE IF EXISTS `jenis_gereja`;
CREATE TABLE `jenis_gereja`  (
  `id_jenis_gereja` int NOT NULL AUTO_INCREMENT,
  `jenis_gereja` varchar(100) NOT NULL,
  `keterangan` varchar(250) NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_jenis_gereja`) USING BTREE
);


Use Services-Pendidikan;
DROP TABLE IF EXISTS `pendidikan`;
CREATE TABLE `pendidikan`  (
  `id_pendidikan` int NOT NULL AUTO_INCREMENT,
  `pendidikan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pendidikan`) USING BTREE
);


Use Services-Pekerjaan;
DROP TABLE IF EXISTS `pekerjaan`;
CREATE TABLE `pekerjaan`  (
  `id_pekerjaan` int NOT NULL AUTO_INCREMENT,
  `pekerjaan` varchar(50)  NOT NULL,
  `keterangan` varchar(250)  NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pekerjaan`) USING BTREE
);


Use Services-JenisStatus;
DROP TABLE IF EXISTS `jenis_status`;
CREATE TABLE `jenis_status`  (
  `id_jenis_status` int NOT NULL AUTO_INCREMENT,
  `jenis_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_jenis_status`) USING BTREE
);


Use Services-JenisStatus;
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `status` varchar(100)  NOT NULL,
  `id_jenis_status` int NOT NULL,
  `keterangan` varchar(250)  NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_status`) USING BTREE,
  INDEX `jenis_status_id_status`(`id_jenis_status` ASC) USING BTREE,
  CONSTRAINT `fk_id_jenis_status_status` FOREIGN KEY (`id_jenis_status`) REFERENCES `jenis_status` (`id_jenis_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
);