-- This structure of db need to be analyzed and the services separately.

-- TOTAL TABLE --> 21 || and 7 separate in DB_Services.sql

-- 
-- Table Provinsi
-- 

DROP TABLE IF EXISTS `province`;
CREATE TABLE `province`  (
  `prov_id` int NOT null AUTO_INCREMENT,
  `prov_name` varchar(75) NULL DEFAULT NULL,
  `locationid` int NOT null,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`prov_id`) USING BTREE
)

select * from province p 

  INDEX `fk_id_country_province`(`country_id` ASC) USING BTREE,
  CONSTRAINT `fk_id_country_province` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT


-- 
-- Table city
-- 

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city`  (
  `city_id` int NOT NULL AUTO_INCREMENT,
  `prov_id` int NOT NULL,
  `city_name` varchar(75)  NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`city_id`) USING BTREE,
  INDEX `fk_province_id_city`(`prov_id` ASC) USING BTREE,
  CONSTRAINT `fk_province_id_city` FOREIGN KEY (`prov_id`) REFERENCES `province` (`prov_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from city c 


-- 
-- Table ditrict
-- 

DROP TABLE IF EXISTS `districts`;
CREATE TABLE `districts`  (
  `dis_id` int NOT NULL AUTO_INCREMENT,
  `dis_name` varchar(75)  NULL DEFAULT NULL,
  `city_id` int NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dis_id`) USING BTREE,
  INDEX `fk_city_id_districts`(`city_id` ASC) USING BTREE,
  CONSTRAINT `fk_city_id_districts` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from districts d

-- 
-- Table subdistrict
-- 

DROP TABLE IF EXISTS `subdistricts`;
CREATE TABLE `subdistricts`  (
  `subdis_id` int NOT NULL AUTO_INCREMENT,
  `dis_id` int NOT NULL,
  `subdis_name` varchar(75)  NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`subdis_id`) USING BTREE,
  INDEX `fk_districts_id_subdistricts`(`dis_id` ASC) USING BTREE,
  CONSTRAINT `fk_districts_id_subdistricts` FOREIGN KEY (`dis_id`) REFERENCES `districts` (`dis_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
 
select * from subdistricts s 

-- 
-- Table Distrik untuk Distrik II Silindung
-- 

DROP TABLE IF EXISTS `distrik`;
CREATE TABLE `distrik`  (
  `id_distrik` int NOT NULL AUTO_INCREMENT,
  `kode_distrik` varchar(100) NOT NULL,
  `nama_distrik` varchar(150) NOT NULL,
  `alamat` varchar(250)  NOT NULL,
  `subdis_id` int NOT NULL,
  `nama_praeses` varchar(100)  NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_distrik`) USING BTREE,
  INDEX `fk_id_kota_distrik`(`subdis_id` ASC) USING BTREE,
  CONSTRAINT `fk_subdistricts_id_distrik` FOREIGN KEY (`subdis_id`) REFERENCES `subdistricts` (`subdis_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from distrik d 

-- 
-- Table Ressort
-- 

DROP TABLE IF EXISTS `ressort`;
CREATE TABLE `ressort`  (
  `id_ressort` int NOT NULL AUTO_INCREMENT,
  `id_distrik` int NOT NULL,
  `kode_ressort` varchar(50) NOT NULL,
  `nama_ressort` varchar(100) NOT NULL,
  `alamat` varchar(250)  NOT NULL,
  `subdis_id` int NOT NULL,
  `pendeta_ressort` varchar(100)  NOT NULL,
  `tgl_berdiri` date NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_ressort`) USING BTREE,
  INDEX `distrik_id_ressort`(`id_distrik` ASC) USING BTREE,
  INDEX `fk_id_kota_ressort`(`subdis_id` ASC) USING BTREE,
  CONSTRAINT `fk_id_distrik_ressort` FOREIGN KEY (`id_distrik`) REFERENCES `distrik` (`id_distrik`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_sudistricts_ressort` FOREIGN KEY (`subdis_id`) REFERENCES `subdistricts` (`subdis_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from ressort r 



-- 
-- Table Gereja
-- 

DROP TABLE IF EXISTS `gereja`;
CREATE TABLE `gereja`  (
  `id_gereja` int NOT NULL AUTO_INCREMENT,
  `id_ressort` int NOT NULL,
  `id_jenis_gereja` int NOT NULL,
  `kode_gereja` varchar(25) NOT NULL,
  `nama_gereja` varchar(100) NOT NULL,
  `alamat` varchar(250)  NOT NULL,
  `subdis_id` int NOT NULL,
  `nama_pendeta` varchar(100) NOT NULL,
  `tgl_berdiri` date NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_gereja`) USING BTREE,
  INDEX `ressort_id_gereja`(`id_ressort` ASC) USING BTREE,
  INDEX `jenis_gereja_id_gereja`(`id_jenis_gereja` ASC) USING BTREE,
  INDEX `fk_id_kota_gereja`(`subdis_id` ASC) USING BTREE,
  CONSTRAINT `fk_id_jenis_gereja_gereja` FOREIGN KEY (`id_jenis_gereja`) REFERENCES `jenis_gereja` (`id_jenis_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_subdistricts_gereja` FOREIGN KEY (`subdis_id`) REFERENCES `subdistricts` (`subdis_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_ressort_gereja` FOREIGN KEY (`id_ressort`) REFERENCES `ressort` (`id_ressort`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;


select * from gereja g 




-- 
-- Table Sidi
-- 

DROP TABLE IF EXISTS `sidi`;
CREATE TABLE `sidi`  (
  `id_sidi` int NOT NULL AUTO_INCREMENT,
  `id_gereja_sidi` int NOT NULL,
  `id_jemaat` int NOT NULL,
  `id_status` int NOT NULL,
  `tgl_sidi` date NOT NULL,
  `no_surat_sidi` int NOT NULL,
  `nats_sidi` varchar(250)  NOT NULL,
  `isHKBP` tinyint(1) NOT NULL DEFAULT 0,
  `nama_gereja_non_hkbp` varchar(100)  NULL DEFAULT NULL,
  `nama_pendeta_sidi` varchar(100)  NOT NULL,
  `file_surat_sidi` varchar(100) NOT NULL,
  `keterangan` varchar(250)  NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_sidi`) USING BTREE,
  INDEX `fk_jemaat_id_sidi`(`id_jemaat` ASC) USING BTREE,
  INDEX `fk_status_id_sidi`(`id_status` ASC) USING BTREE,
  INDEX `fk_id_gereja_sidi_sidi`(`id_gereja_sidi` ASC) USING BTREE,
  CONSTRAINT `fk_id_gereja_sidi_sidi` FOREIGN KEY (`id_gereja_sidi`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_jemaat_sidi` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_status_sidi` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
)


select * from sidi s 

-- 
-- Table Pernikahaan
-- 

drop table if exists `pernikahan`
CREATE TABLE `pernikahan`  (
  `id_pernikahan` int NOT NULL AUTO_INCREMENT,
  `id_gereja` int not NULL,
  `tgl_pernikahan` date NOT NULL,
  `nats_pernikahan` varchar(250)  NOT NULL,
  `isHKBP` tinyint(1) NULL DEFAULT 0,
  `id_gereja_nikah` int NOT NULL,
  `nama_gereja_non_HKBP` varchar(200)  NULL DEFAULT NULL,
  `nama_pendeta` varchar(125)  NOT NULL,
  `keterangan` varchar(250)  NULL DEFAULT NULL,
  `id_status` int NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pernikahan`) USING BTREE,
  INDEX `gereja_id_pernikahan`(`id_gereja` ASC) USING BTREE,
  INDEX `gereja_nikah_id_pernikahan`(`id_gereja_nikah` ASC) USING BTREE,
  INDEX `status_id_pernikahan`(`id_status` ASC) USING BTREE,
  CONSTRAINT `gereja_id_pernikahan` FOREIGN KEY (`id_gereja`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `gereja_nikah_id_pernikahan` FOREIGN KEY (`id_gereja_nikah`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `status_id_pernikahan` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from pernikahan p 

-- 
-- Table Pernikahaan Jemaat [TIDAK ADA PRIMARY KEY]
-- 

DROP TABLE IF EXISTS `pernikahan_jemaat`;
CREATE TABLE `pernikahan_jemaat`  (
  `id_pernikahan_jemaat` int NOT null AUTO_INCREMENT,	
  `id_pernikahan` int NOT NULL,
  `id_jemaat_laki` int NOT NULL,
  `id_jemaat_perempuan` int NOT NULL,
  `keterangan` varchar(250)  NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_pernikahan_jemaat`) USING BTREE,
  INDEX `pernikahan_id_pernikahan_jemaat`(`id_pernikahan` ASC) USING BTREE,
  INDEX `jemaat_laki_id_pernikahan_jemaat`(`id_jemaat_laki` ASC) USING BTREE,
  INDEX `fk_id_jemaat_perempuan_pernikahan_jemaat`(`id_jemaat_perempuan` ASC) USING BTREE,
  CONSTRAINT `fk_id_jemaat_laki_pernikahan_jemaat` FOREIGN KEY (`id_jemaat_laki`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_jemaat_perempuan_pernikahan_jemaat` FOREIGN KEY (`id_jemaat_perempuan`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_pernikahan_jemaat` FOREIGN KEY (`id_pernikahan`) REFERENCES `pernikahan` (`id_pernikahan`) ON DELETE RESTRICT ON UPDATE RESTRICT
)


-- 
-- Table Baptis
--

DROP TABLE IF EXISTS `baptis`;
CREATE TABLE `baptis`  (
  `id_baptis` int NOT NULL AUTO_INCREMENT,
  `id_jemaat` int NOT NULL,
  `tgl_baptis` date NOT NULL,
  `no_surat_baptis` int NOT NULL,
  `isHKBP` tinyint(1) NOT NULL DEFAULT 0,
  `id_gereja_baptis` int NOT NULL,
  `nama_gereja_non_HKBP` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nama_pendeta_baptis` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `file_surat_baptis` varchar(255) NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_status` int NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_baptis`) USING BTREE,
  INDEX `jemaat_id_baptis`(`id_jemaat` ASC) USING BTREE,
  INDEX `gereja_baptis_id_baptis`(`id_gereja_baptis` ASC) USING BTREE,
  INDEX `jemaat_id_status`(`id_status` ASC) USING BTREE,
  CONSTRAINT `fk_id_gereja_baptis` FOREIGN KEY (`id_gereja_baptis`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_jemaat_baptis` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_status_id_baptis` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
)


-- 
-- Table Bidang Pendidikan
-- 

DROP TABLE IF EXISTS `bidang_pendidikan`;
CREATE TABLE `bidang_pendidikan`  (
  `id_bidang_pendidikan` int NOT NULL AUTO_INCREMENT,
  `nama_bidang_pendidikan` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_bidang_pendidikan`) USING BTREE
) 	

select * from bidang_pendidikan bp

-- 
-- Table Jemaat
-- 

DROP TABLE IF EXISTS `jemaat`;
CREATE TABLE `jemaat`  (
  `id_jemaat` int NOT NULL AUTO_INCREMENT,
  `id_hub_keluarga` int NULL DEFAULT NULL,
  `id_status_pernikahan` int NULL DEFAULT 3,
  `id_status_ama_ina` int NULL DEFAULT NULL,
  `id_status_anak` int NULL DEFAULT NULL,
  `id_pendidikan` int NULL DEFAULT NULL,
  `id_bidang_pendidikan` int NULL DEFAULT NULL,
  `id_pekerjaan` int NULL DEFAULT NULL,
  `subdis_id` int NULL DEFAULT 31,
  `id_gereja` int null default null,
  `id_wijk` int null default null,
  `nama_depan` varchar(50)  NOT NULL,
  `nama_belakang` varchar(50)  NOT NULL,
  `gelar_depan` varchar(25) NULL DEFAULT NULL,	
  `gelar_belakang` varchar(25) NULL default NULL,
  `tempat_lahir` varchar(100)  NOT NULL,
  `tanggal_lahir` date NOT NULL, -- tidak ada di desain DB
  `jenis_kelamin` varchar(25)  NOT NULL,
  `bidang_pendidikan_lain` varchar(255)  NULL DEFAULT NULL,
  `nama_pekerjaan_lain` varchar(100)  NULL DEFAULT NULL,
  `gol_darah` varchar(5)  NULL DEFAULT NULL,
  `alamat` varchar(250)  NULL DEFAULT NULL,
  `no_telepon` varchar(20)  NULL DEFAULT NULL,
  `no_ponsel` varchar(20)  NULL DEFAULT NULL,
  `foto_jemaat` varchar(255)  NULL DEFAULT NULL,
  `keterangan` varchar(250)  NULL DEFAULT NULL,
  `isBaptis` tinyint(1) NULL DEFAULT 1,
  `isSidi` tinyint(1) NULL DEFAULT 1,
  `isMenikah` tinyint(1) NULL DEFAULT NULL,
  `isMeninggal` tinyint(1) NULL DEFAULT 0,
  `isRPP` tinyint(1) NULL DEFAULT 0,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_jemaat`) USING BTREE,
  INDEX `hub_keluarga_id_jemaat`(`id_hub_keluarga` ASC) USING BTREE,
  INDEX `status_pernikahan_id_jemaat`(`id_status_pernikahan` ASC) USING BTREE,
  INDEX `pendidikan_id_jemaat`(`id_pendidikan` ASC) USING BTREE,
  INDEX `bidang_pendidikan_id_jemaat`(`id_bidang_pendidikan` ASC) USING BTREE,
  INDEX `pekerjaan_id_jemaat`(`id_pekerjaan` ASC) USING BTREE,
  INDEX `fk_id_sudistricts_jemaat`(`subdis_id` ASC) USING BTREE,
  INDEX `fk_id_gereja_jemaat`(`id_gereja` ASC) USING BTREE,
  INDEX `fk_id_wijk_jemaat`(`id_wijk` ASC) USING BTREE,
  INDEX `fk_id_status_anak_jemaat`(`id_status_anak` ASC) USING BTREE,
  INDEX `fk_id_status_ama_ina_jemaat`(`id_status_ama_ina` ASC) USING BTREE,
  CONSTRAINT `fk_id_bidang_pendidikan_jemaat` FOREIGN KEY (`id_bidang_pendidikan`) REFERENCES `bidang_pendidikan` (`id_bidang_pendidikan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_hub_keluarga_jemaat` FOREIGN KEY (`id_hub_keluarga`) REFERENCES `hubungan_keluarga` (`id_hub_keluarga`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_pekerjaan_jemaat` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_pendidikan_jemaat` FOREIGN KEY (`id_pendidikan`) REFERENCES `pendidikan` (`id_pendidikan`) ON DELETE RESTRICT ON UPDATE restrict,
  CONSTRAINT `fk_id_sudistricts_jemaat` FOREIGN KEY (`subdis_id`) REFERENCES `subdistricts` (`subdis_id`) ON DELETE RESTRICT ON UPDATE restrict,
  CONSTRAINT `fk_id_gereja_jemaat` FOREIGN KEY (`id_gereja`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE restrict,
  CONSTRAINT `fk_id_wijk_jemaat` FOREIGN KEY (`id_wijk`) REFERENCES `wijk` (`id_wijk`) ON DELETE RESTRICT ON UPDATE restrict,
  CONSTRAINT `fk_id_status_pernikahan_jemaat` FOREIGN KEY (`id_status_pernikahan`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE restrict,
  CONSTRAINT `fk_id_status_ama_ina_jemaat` FOREIGN KEY (`id_status_ama_ina`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE restrict,
  CONSTRAINT `fk_id_status_anak_jemaat` FOREIGN KEY (`id_status_anak`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE restrict
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

select * from jemaat j 
truncate table jemaat 
--
-- Table Head Pindah
--

DROP TABLE IF EXISTS `head_pindah`;
CREATE TABLE `head_pindah`  (
  `id_head_pindah` int NOT NULL AUTO_INCREMENT,
  `id_jemaat` int NULL DEFAULT NULL,
  `id_gereja` int NOT NULL DEFAULT 1,
  `no_surat_pindah` int NULL DEFAULT NULL,
  `tgl_pindah` date NOT NULL,
  `tgl_warta` date NULL DEFAULT NULL,
  `id_gereja_tujuan` int NULL DEFAULT NULL,
  `nama_gereja_no_hkbp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `file_surat_pindah` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_head_pindah`) USING BTREE,
  INDEX `gereja_id_head_pindah`(`id_gereja` ASC) USING BTREE,
  INDEX `fk_id_jemaat_head_pindah`(`id_jemaat` ASC) USING BTREE,
  CONSTRAINT `fk_id_gereja_head_pindah` FOREIGN KEY (`id_gereja`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_jemaat_head_pindah` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_gerejaTujuan_head_pindah` FOREIGN KEY (`id_gereja_tujuan`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from head_pindah hp 


--
-- Detail Pindah
-- 

DROP TABLE IF EXISTS `detail_pindah`;
CREATE TABLE `detail_pindah`  (
  `id_det_reg_pindah` int NOT null AUTO_INCREMENT,
  `id_jemaat` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_det_reg_pindah`) USING BTREE,
  INDEX `jemaat_id_pindah`(`id_jemaat` ASC) USING BTREE,
  CONSTRAINT `fk_id_jemaat_pindah` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT
) 

select * from detail_pindah dp 

truncate table detail_pindah 
--
-- Table Pelayan Gereja
--

DROP TABLE IF EXISTS `pelayan_gereja`;
CREATE TABLE `pelayan_gereja`  (
  `id_pelayan_gereja` int NOT NULL AUTO_INCREMENT,
  `id_jemaat` int NOT NULL,
  `isTahbisan` tinyint(1) NOT NULL DEFAULT 0,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pelayan_gereja`) USING BTREE,
  INDEX `id_jemaat_pelayan_gereja`(`id_pelayan_gereja` ASC) USING BTREE,
  CONSTRAINT `fk_id_jemaat_pelayan_gereja` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT
) 


-- 
-- Table Majelis
-- 

DROP TABLE IF EXISTS `majelis`;
CREATE TABLE `majelis`  (
  `id_majelis` int NOT NULL AUTO_INCREMENT,
  `id_jemaat` int NOT NULL,
  `id_status_pelayanan` int NOT NULL,
  `id_gereja` int NOT NULL DEFAULT 1,
  `tgl_tahbis` date NOT NULL,
  `tgl_akhir_jawatan` date NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_majelis`) USING BTREE,
  INDEX `gereja_id_majelis`(`id_gereja` ASC) USING BTREE,
  INDEX `jemaat_id_majelis`(`id_jemaat` ASC) USING BTREE,
  INDEX `status_pelayanan_id_majelis`(`id_status_pelayanan` ASC) USING BTREE,
  CONSTRAINT `fk_id_gereja_majelis` FOREIGN KEY (`id_gereja`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_jemaat_majelis` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_status_pelayanan_majelis` FOREIGN KEY (`id_status_pelayanan`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
)


-- 
-- Table pelayanan_nonTahbisan (majelis many to many pelayan gereja)
-- 

DROP TABLE IF EXISTS `pelayanan_nonTahbisan`;
CREATE TABLE `pelayanan_nonTahbisan`  (
  `id_pelayanan_nonTahbisan` int NOT NULL AUTO_INCREMENT,
  `id_majelis` int NOT NULL,
  `id_pelayan_gereja` int NOT NULL,
  `id_gereja` int NOT NULL DEFAULT 1,
  `id_status_pelayanan` int NOT NULL DEFAULT 1,
  `nama_pelayanan_nonTahbisan` varchar(100)  NULL DEFAULT NULL,
  `tgl_pengangkatan` date NOT NULL,
  `tgl_berakhir` date NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_pelayanan_nonTahbisan`) USING BTREE,
  INDEX `gereja_id_majelis`(`id_gereja` ASC) USING BTREE,
  INDEX `jemaat_id_majelis`(`id_majelis` ASC) USING BTREE,
  INDEX `pelayan_id_majelis`(`id_pelayan_gereja` ASC) USING BTREE,
  INDEX `status_pelayanan_id_majelis`(`id_status_pelayanan` ASC) USING BTREE,
  CONSTRAINT `fk_id_gereja_majelis_nonTahbisan` FOREIGN KEY (`id_gereja`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_majelis_pelayanan_nonTahbisan` FOREIGN KEY (`id_majelis`) REFERENCES `majelis` (`id_majelis`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_pelayan_majelis` FOREIGN KEY (`id_pelayan_gereja`) REFERENCES `pelayan_gereja` (`id_pelayan_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_status_pelayanan_majelis_nonTahbisan` FOREIGN KEY (`id_status_pelayanan`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
)


select * from pelayan_gereja

-- 
-- Table Wijk
--

DROP TABLE IF EXISTS `wijk`;
CREATE TABLE `wijk`  (
  `id_wijk` int NOT NULL AUTO_INCREMENT,
  `nama_wijk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_wijk`) USING BTREE
)

select * from wijk w 

-- 
-- Table Majelis_Lingkungan
-- 

DROP TABLE IF EXISTS `majelis_lingkungan`;
CREATE TABLE `majelis_lingkungan`  (
  `id_majelis` int NOT NULL,
  `id_wijk` int NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDelete` tinyint(1) NOT NULL DEFAULT 0,
  primary key(`id_majelis`) USING BTREE,
  INDEX `wijk_id_majelis_lingkungan`(`id_wijk` ASC) USING BTREE,
  CONSTRAINT `fk_id_majelis_majelis_lingkungan` FOREIGN KEY (`id_majelis`) REFERENCES `majelis` (`id_majelis`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_wijk_majelis_lingkungan` FOREIGN KEY (`id_wijk`) REFERENCES `wijk` (`id_wijk`) ON DELETE RESTRICT ON UPDATE RESTRICT
)


-- 
-- Table meninggal
-- 

DROP TABLE IF EXISTS `meninggal`;
CREATE TABLE `meninggal`  (
  `id_meninggal` int NOT NULL AUTO_INCREMENT,
  `id_gereja` int NOT NULL,
  `id_jemaat` int NOT NULL,
  `tgl_meninggal` date NOT NULL,
  `tgl_warta_meninggal` date null default null,
  `tempat_pemakaman` varchar(150)  NOT NULL,
  `nama_pendeta_melayani` varchar(100)  NOT NULL,
  `keterangan` varchar(250)  NULL DEFAULT NULL,
  `id_status` int NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_meninggal`) USING BTREE,
  INDEX `gereja_id_meninggal`(`id_gereja` ASC) USING BTREE,
  INDEX `jemaat_id__meninggal`(`id_jemaat` ASC) USING BTREE,
  INDEX `status_id_meninggal`(`id_status` ASC) USING BTREE,
  CONSTRAINT `fk_id_gereja_meninggal` FOREIGN KEY (`id_gereja`) REFERENCES `gereja` (`id_gereja`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_jemaat_meninggal` FOREIGN KEY (`id_jemaat`) REFERENCES `jemaat` (`id_jemaat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_status_meninggal` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT
)

select * from meninggal m 








