-- 
-- ALL STORE PROCEDURE will CREATE in This SQL File
-- 

###########################################################################################################################################

####
#### - SP for Bidang_Pendidikan
####

-- 
-- SP - INSERT data BidangPendidikan
-- 

	CREATE DEFINER=root@localhost PROCEDURE insert_bidangPendidikan(IN dataBidangPendidikan JSON)
	BEGIN
		#Routine body goes here...
		SET @bidangPendidikan= JSON_UNQUOTE(JSON_EXTRACT(dataBidangPendidikan,'$.BidangPendidikan'));
		SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataBidangPendidikan,'$.Keterangan'));
	
		INSERT INTO bidang_pendidikan(bidang_pendidikan.nama_bidang_pendidikan, bidang_pendidikan.keterangan)
		VALUES(@bidangPendidikan, @keterangan);
	end

-- 
-- SP - UPDATE data BidangPendidikan
-- 
	
	CREATE DEFINER=root@localhost PROCEDURE update_bidangPendidikan(IN dataBidangPendidikan JSON)
	BEGIN
		#Routine body goes here...
		SET @idBidangPendidikan= JSON_UNQUOTE(JSON_EXTRACT(dataBidangPendidikan,'$.IdBidangPendidikan'));
		SET @bidangPendidikan= JSON_UNQUOTE(JSON_EXTRACT(dataBidangPendidikan,'$.BidangPendidikan'));
		SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataBidangPendidikan,'$.Keterangan'));
	
		UPDATE bidang_pendidikan SET nama_bidang_pendidikan = @bidangPendidikan, bidang_pendidikan.keterangan = @keterangan, bidang_pendidikan.updateAt=NOW()
		WHERE id_bidang_pendidikan = @idBidangPendidikan;
	end

-- 
-- SP - VIEW_ALL data BidangPendidikan
-- 

	CREATE DEFINER=root@localhost PROCEDURE viewAll_BidangPendidikan()
	BEGIN
		#Routine body goes here...
	SELECT
		bidang_pendidikan.id_bidang_pendidikan, 
		bidang_pendidikan.nama_bidang_pendidikan, 
		bidang_pendidikan.keterangan
	FROM
		bidang_pendidikan
	WHERE
		bidang_pendidikan.isDeleted = 0;
	end


-- 
-- SP - VIEW_ById data BidangPendidikan
-- 
	
	CREATE DEFINER=root@localhost PROCEDURE view_BidangPendidikan_byId(IN id INT)
	BEGIN
		#Routine body goes here...
	SELECT
		bidang_pendidikan.id_bidang_pendidikan, 
		bidang_pendidikan.nama_bidang_pendidikan, 
		bidang_pendidikan.keterangan
	FROM
		bidang_pendidikan
	WHERE
		bidang_pendidikan.id_bidang_pendidikan = id;
	end


-- 
-- SP - DELETE(set is_deleted to 1(true) data BidangPendidikan
--

	CREATE DEFINER=root@localhost PROCEDURE delete_bidangPendidikan(IN id int)
	BEGIN
		#Routine body goes here...
		UPDATE bidang_pendidikan SET bidang_pendidikan.isDeleted = 1, bidang_pendidikan.updateAt = NOW()
		WHERE bidang_pendidikan.id_bidang_pendidikan = id;
	end

	
###########################################################################################################################################

####
#### -- SP for Pendidikan
####
	
-- 
-- SP - INSERT data Pendidikan
-- 

	CREATE DEFINER=root@localhost PROCEDURE insert_pendidikan(IN dataPendidikan JSON)
	BEGIN
		#Routine body goes here...
		SET @pendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataPendidikan, '$.pendidikan'));
		SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPendidikan, '$.keterangan'));
	
		INSERT INTO pendidikan (pendidikan, keterangan)
		VALUES (@pendidikan, @keterangan);
	END

-- 
-- SP - UPDATE data Pendidikan
-- 
	
	CREATE DEFINER=root@localhost PROCEDURE update_pendidikan(IN dataPendidikan JSON)
	BEGIN
		#Routine body goes here...
		SET @idPendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataPendidikan, '$.id_pendidikan'));
		SET @pendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataPendidikan, '$.pendidikan'));
		SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPendidikan, '$.keterangan'));
	
		UPDATE pendidikan
		SET pendidikan = @pendidikan, keterangan = @keterangan, updateAt = NOW()
		WHERE id_pendidikan = @idPendidikan;
	END

-- 
-- SP - VIEW_ALL data Pendidikan
-- 

	CREATE DEFINER=root@localhost PROCEDURE viewAll_Pendidikan()
	BEGIN
		#Routine body goes here...
		SELECT id_pendidikan, pendidikan, keterangan
		FROM pendidikan
		WHERE isDeleted = 0;
	END


-- 
-- SP - VIEW_ById data Pendidikan
-- 

	CREATE DEFINER=root@localhost PROCEDURE view_Pendidikan_byId(IN id INT)
	BEGIN
		#Routine body goes here...
		SELECT id_pendidikan, pendidikan, keterangan
		FROM pendidikan
		WHERE id_pendidikan = id;
	END


-- 
-- SP - DELETE(set is_deleted to 1(true) data Pendidikan
-- 

	CREATE DEFINER=root@localhost PROCEDURE delete_pendidikan(IN id INT)
	BEGIN
		#Routine body goes here...
		UPDATE pendidikan
		SET isDeleted = 1, updateAt = NOW()
		WHERE id_pendidikan = id;
	end


###########################################################################################################################################

####
#### - SP for Pekerjaan
####

-- 
-- SP - INSERT data Pekerjaan
-- 

	CREATE DEFINER=root@localhost PROCEDURE insert_pekerjaan(IN dataPekerjaan JSON)
	BEGIN
	    SET @pekerjaan = JSON_UNQUOTE(JSON_EXTRACT(dataPekerjaan, '$.pekerjaan'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPekerjaan, '$.keterangan'));
	
	    INSERT INTO pekerjaan (pekerjaan, keterangan)
	    VALUES (@pekerjaan, @keterangan);
	END

-- 
-- SP - UPDATE data Pekerjaan
-- 

	CREATE DEFINER=root@localhost PROCEDURE update_pekerjaan(IN dataPekerjaan JSON)
	BEGIN
	    SET @idPekerjaan = JSON_UNQUOTE(JSON_EXTRACT(dataPekerjaan, '$.id_pekerjaan'));
	    SET @pekerjaan = JSON_UNQUOTE(JSON_EXTRACT(dataPekerjaan, '$.pekerjaan'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPekerjaan, '$.keterangan'));
	
	    UPDATE pekerjaan
	    SET pekerjaan = @pekerjaan, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_pekerjaan = @idPekerjaan;
	END

-- 
-- SP - VIEW_ALL data Pekerjaan
-- 
	
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Pekerjaan()
	BEGIN
	    SELECT id_pekerjaan, pekerjaan, keterangan
	    FROM pekerjaan
	    WHERE isDeleted = 0;
	END

-- 
-- SP - VIEW_ById data Pekerjaan
-- 
	
	CREATE DEFINER=root@localhost PROCEDURE view_Pekerjaan_byId(IN id INT)
	BEGIN
	    SELECT id_pekerjaan, pekerjaan, keterangan
	    FROM pekerjaan
	    WHERE id_pekerjaan = id;
	END

-- 
-- SP - DELETE(set is_deleted to 1(true) data Pekerjaan)
-- 
	
	CREATE DEFINER=root@localhost PROCEDURE delete_pekerjaan(IN id INT)
	BEGIN
	    UPDATE pekerjaan
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_pekerjaan = id;
	END


	
###########################################################################################################################################

####
#### - SP for JenisStatus
####
	
-- SP - INSERT data JenisStatus
	CREATE DEFINER=root@localhost PROCEDURE insert_jenis_status(IN dataJenisStatus JSON)
	BEGIN
	    SET @jenisStatus = JSON_UNQUOTE(JSON_EXTRACT(dataJenisStatus, '$.jenis_status'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataJenisStatus, '$.keterangan'));
	
	    INSERT INTO jenis_status (jenis_status, keterangan)
	    VALUES (@jenisStatus, @keterangan);
	END

-- SP - UPDATE data JenisStatus
	CREATE DEFINER=root@localhost PROCEDURE update_jenis_status(IN dataJenisStatus JSON)
	BEGIN
	    SET @idJenisStatus = JSON_UNQUOTE(JSON_EXTRACT(dataJenisStatus, '$.id_jenis_status'));
	    SET @jenisStatus = JSON_UNQUOTE(JSON_EXTRACT(dataJenisStatus, '$.jenis_status'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataJenisStatus, '$.keterangan'));
	
	    UPDATE jenis_status
	    SET jenis_status = @jenisStatus, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_jenis_status = @idJenisStatus;
	END

-- SP - VIEW_ALL data JenisStatus
	CREATE DEFINER=root@localhost PROCEDURE viewAll_JenisStatus()
	BEGIN
	    SELECT id_jenis_status, jenis_status, keterangan
	    FROM jenis_status
	    WHERE isDeleted = 0;
	END

-- SP - VIEW_ById data JenisStatus
	CREATE DEFINER=root@localhost PROCEDURE view_JenisStatus_byId(IN id INT)
	BEGIN
	    SELECT id_jenis_status, jenis_status, keterangan
	    FROM jenis_status
	    WHERE id_jenis_status = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data JenisStatus)
	CREATE DEFINER=root@localhost PROCEDURE delete_jenis_status(IN id INT)
	BEGIN
	    UPDATE jenis_status
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_jenis_status = id;
	END

	
	
###########################################################################################################################################

####
#### - SP for Status
####

-- SP - INSERT data Status
	CREATE DEFINER=root@localhost PROCEDURE insert_status(IN dataStatus JSON)
	BEGIN
	    DECLARE idJenisStatus INT;
	    SET @status = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.status'));
	    SET @idJenisStatus = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.id_jenis_status'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.keterangan'));
	
	    INSERT INTO status (status, id_jenis_status, keterangan)
	    VALUES (@status, @idJenisStatus, @keterangan);
	END

-- SP - UPDATE data Status
	CREATE DEFINER=root@localhost PROCEDURE update_status(IN dataStatus JSON)
	BEGIN
	    SET @idStatus = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.id_status'));
	    SET @status = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.status'));
	    SET @idJenisStatus = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.id_jenis_status'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataStatus, '$.keterangan'));
	
	    UPDATE status
	    SET status = @status, id_jenis_status = @idJenisStatus, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_status = @idStatus;
	END

-- SP - VIEW_ALL data Status
	CREATE PROCEDURE viewAll_Status()
	BEGIN
	    SELECT s.id_status, s.status, s.id_jenis_status, s.keterangan, js.jenis_status AS jenis_status_name
	    FROM status s
	    JOIN jenis_status js ON s.id_jenis_status = js.id_jenis_status
	    WHERE s.isDeleted = 0;
	END


-- SP - VIEW_ById data Status
	CREATE DEFINER=root@localhost PROCEDURE view_Status_byId(IN id INT)
	BEGIN
	    SELECT s.id_status, s.status, s.id_jenis_status, s.keterangan, js.jenis_status AS jenis_status
	    FROM status s
	    JOIN jenis_status js ON s.id_jenis_status = js.id_jenis_status
	    WHERE s.id_status = id;
	END


-- SP - DELETE(set is_deleted to 1(true) data Status)
	CREATE DEFINER=root@localhost PROCEDURE delete_status(IN id INT)
	BEGIN
	    UPDATE status
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_status = id;
	END

	
	
###########################################################################################################################################

####
#### - SP for Hubungan Keluarga
####
	
-- SP - INSERT data Hubungan Keluarga
	CREATE DEFINER=root@localhost PROCEDURE insert_hubungan_keluarga(IN dataHubunganKeluarga JSON)
	BEGIN
	    SET @namaHubKeluarga = JSON_UNQUOTE(JSON_EXTRACT(dataHubunganKeluarga, '$.nama_hub_keluarga'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataHubunganKeluarga, '$.keterangan'));
	
	    INSERT INTO hubungan_keluarga (nama_hub_keluarga, keterangan)
	    VALUES (@namaHubKeluarga, @keterangan);
	END

-- SP - UPDATE data Hubungan Keluarga
	CREATE DEFINER=root@localhost PROCEDURE update_hubungan_keluarga(IN dataHubunganKeluarga JSON)
	BEGIN
	    SET @idHubKeluarga = JSON_UNQUOTE(JSON_EXTRACT(dataHubunganKeluarga, '$.id_hub_keluarga'));
	    SET @namaHubKeluarga = JSON_UNQUOTE(JSON_EXTRACT(dataHubunganKeluarga, '$.nama_hub_keluarga'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataHubunganKeluarga, '$.keterangan'));
	
	    UPDATE hubungan_keluarga
	    SET nama_hub_keluarga = @namaHubKeluarga, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_hub_keluarga = @idHubKeluarga;
	END

-- SP - VIEW_ALL data Hubungan Keluarga
	CREATE DEFINER=root@localhost PROCEDURE viewAll_HubunganKeluarga()
	BEGIN
	    SELECT id_hub_keluarga, nama_hub_keluarga, keterangan
	    FROM hubungan_keluarga
	    WHERE isDeleted = 0;
	END

-- SP - VIEW_ById data Hubungan Keluarga
	CREATE DEFINER=root@localhost PROCEDURE view_HubunganKeluarga_byId(IN id INT)
	BEGIN
	    SELECT id_hub_keluarga, nama_hub_keluarga, keterangan
	    FROM hubungan_keluarga
	    WHERE id_hub_keluarga = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data Hubungan Keluarga)
	CREATE DEFINER=root@localhost PROCEDURE delete_hubungan_keluarga(IN id INT)
	BEGIN
	    UPDATE hubungan_keluarga
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_hub_keluarga = id;
	END


	
###########################################################################################################################################

####
#### - SP for Country
####
	
-- SP - INSERT data Country
	CREATE DEFINER=root@localhost PROCEDURE insert_country(IN dataCountry JSON)
	BEGIN
	    SET @countryCode = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.country_code'));
	    SET @countryName = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.country_name'));
	    SET @code = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.code'));
	
	    INSERT INTO country (country_code, country_name, code)
	    VALUES (@countryCode, @countryName, @code);
	END

-- SP - UPDATE data Country
	CREATE DEFINER=root@localhost PROCEDURE update_country(IN dataCountry JSON)
	BEGIN
	    SET @countryId = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.country_id'));
	    SET @countryCode = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.country_code'));
	    SET @countryName = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.country_name'));
	    SET @code = JSON_UNQUOTE(JSON_EXTRACT(dataCountry, '$.code'));
	
	    UPDATE country
	    SET country_code = @countryCode, country_name = @countryName, code = @code, update_at = NOW()
	    WHERE country_id = @countryId;
	END

-- SP - VIEW_ALL data Country
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Country()
	BEGIN
	    SELECT country_id, country_code, country_name, code
	    FROM country
	    WHERE is_deleted = 0;
	END

-- SP - VIEW_ById data Country
	CREATE DEFINER=root@localhost PROCEDURE view_Country_byId(IN id INT)
	BEGIN
	    SELECT country_id, country_code, country_name, code
	    FROM country
	    WHERE country_id = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data Country)
	CREATE DEFINER=root@localhost PROCEDURE delete_country(IN id INT)
	BEGIN
	    UPDATE country
	    SET is_deleted = 1, update_at = NOW()
	    WHERE country_id = id;
	END



###########################################################################################################################################

####
#### - SP for JenisGereja
####
	
-- SP - INSERT data jenis_gereja
	CREATE DEFINER=root@localhost PROCEDURE insert_jenis_gereja(IN dataJenisGereja JSON)
	BEGIN
	    SET @jenisGereja = JSON_UNQUOTE(JSON_EXTRACT(dataJenisGereja, '$.jenis_gereja'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataJenisGereja, '$.keterangan'));
	
	    INSERT INTO jenis_gereja (jenis_gereja, keterangan)
	    VALUES (@jenisGereja, @keterangan);
	END

-- SP - UPDATE data jenis_gereja
	CREATE DEFINER=root@localhost PROCEDURE update_jenis_gereja(IN dataJenisGereja JSON)
	BEGIN
	    SET @idJenisGereja = JSON_UNQUOTE(JSON_EXTRACT(dataJenisGereja, '$.id_jenis_gereja'));
	    SET @jenisGereja = JSON_UNQUOTE(JSON_EXTRACT(dataJenisGereja, '$.jenis_gereja'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataJenisGereja, '$.keterangan'));
	
	    UPDATE jenis_gereja
	    SET jenis_gereja = @jenisGereja, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_jenis_gereja = @idJenisGereja;
	END

-- SP - VIEW_ALL data jenis_gereja
	CREATE DEFINER=root@localhost PROCEDURE viewAll_JenisGereja()
	BEGIN
	    SELECT id_jenis_gereja, jenis_gereja, keterangan
	    FROM jenis_gereja
	    WHERE isDeleted = 0;
	END

-- SP - VIEW_ById data jenis_gereja
	CREATE DEFINER=root@localhost PROCEDURE view_JenisGereja_byId(IN id INT)
	BEGIN
	    SELECT id_jenis_gereja, jenis_gereja, keterangan
	    FROM jenis_gereja
	    WHERE id_jenis_gereja = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data jenis_gereja)
	CREATE DEFINER=root@localhost PROCEDURE delete_jenis_gereja(IN id INT)
	BEGIN
	    UPDATE jenis_gereja
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_jenis_gereja = id;
	END

	
###########################################################################################################################################

####
#### - SP for WIJK
####
	
-- SP - INSERT data wijk
	CREATE DEFINER=root@localhost PROCEDURE insert_wijk(IN dataWijk JSON)
	BEGIN
	    SET @namaWijk = JSON_UNQUOTE(JSON_EXTRACT(dataWijk, '$.nama_wijk'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataWijk, '$.keterangan'));
	
	    INSERT INTO wijk (nama_wijk, keterangan)
	    VALUES (@namaWijk, @keterangan);
	END

-- SP - UPDATE data wijk
	CREATE DEFINER=root@localhost PROCEDURE update_wijk(IN dataWijk JSON)
	BEGIN
	    SET @idWijk = JSON_UNQUOTE(JSON_EXTRACT(dataWijk, '$.id_wijk'));
	    SET @namaWijk = JSON_UNQUOTE(JSON_EXTRACT(dataWijk, '$.nama_wijk'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataWijk, '$.keterangan'));
	
	    UPDATE wijk
	    SET nama_wijk = @namaWijk, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_wijk = @idWijk;
	END

-- SP - VIEW_ALL data wijk
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Wijk()
	BEGIN
	    SELECT id_wijk, nama_wijk, keterangan
	    FROM wijk
	    WHERE isDeleted = 0;
	END

-- SP - VIEW_ById data wijk
	CREATE DEFINER=root@localhost PROCEDURE view_Wijk_byId(IN id INT)
	BEGIN
	    SELECT id_wijk, nama_wijk, keterangan
	    FROM wijk
	    WHERE id_wijk = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data wijk)
	CREATE DEFINER=root@localhost PROCEDURE delete_wijk(IN id INT)
	BEGIN
	    UPDATE wijk
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_wijk = id;
	END

	
###########################################################################################################################################

####
#### - SP for Province
####
	
-- SP - INSERT data Province
	CREATE DEFINER=root@localhost PROCEDURE insert_province(IN dataProvince JSON)
	BEGIN
	    SET @provName = JSON_UNQUOTE(JSON_EXTRACT(dataProvince, '$.prov_name'));
	    SET @locationId = JSON_UNQUOTE(JSON_EXTRACT(dataProvince, '$.locationid'));
	
	    INSERT INTO province (prov_name, locationid, create_at)
	    VALUES (@provName, @locationId, NOW());
	END

-- SP - UPDATE data Province
	CREATE DEFINER=root@localhost PROCEDURE update_province(IN dataProvince JSON)
	BEGIN
	    SET @provId = JSON_UNQUOTE(JSON_EXTRACT(dataProvince, '$.prov_id'));
	    SET @provName = JSON_UNQUOTE(JSON_EXTRACT(dataProvince, '$.prov_name'));
	    SET @locationId = JSON_UNQUOTE(JSON_EXTRACT(dataProvince, '$.locationid'));
	
	    UPDATE province
	    SET prov_name = @provName, locationid = @locationId, update_at = NOW()
	    WHERE prov_id = @provId;
	END

-- SP - VIEW_ALL data Province
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Province()
	BEGIN
	    SELECT prov_id, prov_name, locationid, create_at, update_at
	    FROM province
	    WHERE is_deleted = 0;
	END

-- SP - VIEW_ById data Province
	CREATE DEFINER=root@localhost PROCEDURE view_Province_byId(IN id INT)
	BEGIN
	    SELECT prov_id, prov_name, locationid, create_at, update_at
	    FROM province
	    WHERE prov_id = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data Province)
	CREATE DEFINER=root@localhost PROCEDURE delete_province(IN id INT)
	BEGIN
	    UPDATE province
	    SET is_deleted = 1, update_at = NOW()
	    WHERE prov_id = id;
	END

	
###########################################################################################################################################

####
#### - SP for City
####

-- SP - INSERT data City
	CREATE DEFINER=root@localhost PROCEDURE insert_city(IN dataCity JSON)
	BEGIN
	    SET @provId = JSON_UNQUOTE(JSON_EXTRACT(dataCity, '$.prov_id'));
	    SET @cityName = JSON_UNQUOTE(JSON_EXTRACT(dataCity, '$.city_name'));
	
	    INSERT INTO city (prov_id, city_name, create_at)
	    VALUES (@provId, @cityName, NOW());
	end

-- SP - UPDATE data City
	CREATE DEFINER=root@localhost PROCEDURE update_city(IN dataCity JSON)
	BEGIN
	    SET @cityId = JSON_UNQUOTE(JSON_EXTRACT(dataCity, '$.city_id'));
	    SET @provId = JSON_UNQUOTE(JSON_EXTRACT(dataCity, '$.prov_id'));
	    SET @cityName = JSON_UNQUOTE(JSON_EXTRACT(dataCity, '$.city_name'));
	
	    UPDATE city
	    SET prov_id = @provId, city_name = @cityName, update_at = NOW()
	    WHERE city_id = @cityId;
	END

-- SP - VIEW_ALL data City
	CREATE DEFINER=root@localhost PROCEDURE viewAll_City()
	BEGIN
	    SELECT c.city_id, c.prov_id, c.city_name, c.create_at, c.update_at, p.prov_name AS province_name
	    FROM city c
	    JOIN province p ON c.prov_id = p.prov_id
	    WHERE c.is_deleted = 0;
	END

-- SP - VIEW_ById data City
	CREATE DEFINER=root@localhost PROCEDURE view_City_byId(IN id INT)
	BEGIN
	    SELECT c.city_id, c.prov_id, c.city_name, c.create_at, c.update_at, p.prov_name AS province_name
	    FROM city c
	    JOIN province p ON c.prov_id = p.prov_id
	    WHERE c.city_id = id;
	END

-- SP - DELETE(set is_deleted to 1(true) data City)
	CREATE DEFINER=root@localhost PROCEDURE delete_city(IN id INT)
	BEGIN
	    UPDATE city
	    SET is_deleted = 1, update_at = NOW()
	    WHERE city_id = id;
	END

	
###########################################################################################################################################

####
#### - SP for Districts
####

-- SP - INSERT data Districts
	CREATE DEFINER=root@localhost PROCEDURE insert_district(IN dataDistrict JSON)
	BEGIN
	    SET @cityId = JSON_UNQUOTE(JSON_EXTRACT(dataDistrict, '$.city_id'));
	    SET @districtName = JSON_UNQUOTE(JSON_EXTRACT(dataDistrict, '$.dis_name'));
	
	    INSERT INTO districts (city_id, dis_name, create_at)
	    VALUES (@cityId, @districtName, NOW());
	END


-- SP - UPDATE data Districts
	CREATE DEFINER=root@localhost PROCEDURE update_district(IN dataDistrict JSON)
	BEGIN
	    SET @districtId = JSON_UNQUOTE(JSON_EXTRACT(dataDistrict, '$.dis_id'));
	    SET @cityId = JSON_UNQUOTE(JSON_EXTRACT(dataDistrict, '$.city_id'));
	    SET @districtName = JSON_UNQUOTE(JSON_EXTRACT(dataDistrict, '$.dis_name'));
	
	    UPDATE districts
	    SET city_id = @cityId, dis_name = @districtName, update_at = NOW()
	    WHERE dis_id = @districtId;
	END


-- SP - VIEW_ALL data Districts
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Districts()
	BEGIN
	    SELECT d.dis_id, d.city_id, d.dis_name, d.create_at, d.update_at, c.city_name AS city_name
	    FROM districts d
	    JOIN city c ON d.city_id = c.city_id
	    WHERE d.is_deleted = 0;
	END


-- SP - VIEW_ById data Districts
	CREATE DEFINER=root@localhost PROCEDURE view_District_byId(IN id INT)
	BEGIN
	    SELECT d.dis_id, d.city_id, d.dis_name, d.create_at, d.update_at, c.city_name AS city_name
	    FROM districts d
	    JOIN city c ON d.city_id = c.city_id
	    WHERE d.dis_id = id;
	END


-- SP - DELETE(set is_deleted to 1(true) data Districts)
	CREATE DEFINER=root@localhost PROCEDURE delete_district(IN id INT)
	BEGIN
	    UPDATE districts
	    SET is_deleted = 1, update_at = NOW()
	    WHERE dis_id = id;
	END


	
###########################################################################################################################################

####
#### - SP for Subdistricts
####

-- SP - INSERT data Subdistricts
	CREATE DEFINER=root@localhost PROCEDURE insert_subdistrict(IN dataSubdistrict JSON)
	BEGIN
	    SET @districtId = JSON_UNQUOTE(JSON_EXTRACT(dataSubdistrict, '$.dis_id'));
	    SET @subdistrictName = JSON_UNQUOTE(JSON_EXTRACT(dataSubdistrict, '$.subdis_name'));
	
	    INSERT INTO subdistricts (dis_id, subdis_name, create_at)
	    VALUES (@districtId, @subdistrictName, NOW());
	END


-- SP - UPDATE data Subdistricts
	CREATE DEFINER=root@localhost PROCEDURE update_subdistrict(IN dataSubdistrict JSON)
	BEGIN
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataSubdistrict, '$.subdis_id'));
	    SET @districtId = JSON_UNQUOTE(JSON_EXTRACT(dataSubdistrict, '$.dis_id'));
	    SET @subdistrictName = JSON_UNQUOTE(JSON_EXTRACT(dataSubdistrict, '$.subdis_name'));
	
	    UPDATE subdistricts
	    SET dis_id = @districtId, subdis_name = @subdistrictName, update_at = NOW()
	    WHERE subdis_id = @subdistrictId;
	END


-- SP - VIEW_ALL data Subdistricts
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Subdistricts()
	BEGIN
	    SELECT s.subdis_id, s.dis_id, s.subdis_name, s.create_at, s.update_at, d.dis_name AS district_name
	    FROM subdistricts s
	    JOIN districts d ON s.dis_id = d.dis_id
	    WHERE s.is_deleted = 0;
	END


-- SP - VIEW_ById data Subdistricts
	CREATE DEFINER=root@localhost PROCEDURE view_Subdistrict_byId(IN id INT)
	BEGIN
	    SELECT s.subdis_id, s.dis_id, s.subdis_name, s.create_at, s.update_at, d.dis_name AS district_name
	    FROM subdistricts s
	    JOIN districts d ON s.dis_id = d.dis_id
	    WHERE s.subdis_id = id;
	END


-- SP - DELETE(set is_deleted to 1(true) data Subdistricts)
	CREATE DEFINER=root@localhost PROCEDURE delete_subdistrict(IN id INT)
	BEGIN
	    UPDATE subdistricts
	    SET is_deleted = 1, update_at = NOW()
	    WHERE subdis_id = id;
	END

	
###########################################################################################################################################

####
#### - SP for Distrik
####
	
-- SP - INSERT data Distrik
	CREATE DEFINER=root@localhost PROCEDURE insert_distrik(IN dataDistrik JSON)
	BEGIN
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.subdis_id'));
	    SET @kodeDistrik = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.kode_distrik'));
	    SET @namaDistrik = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.nama_distrik'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.alamat'));
	    SET @namaPraeses = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.nama_praeses'));
	
	    INSERT INTO distrik (subdis_id, kode_distrik, nama_distrik, alamat, nama_praeses, createAt)
	    VALUES (@subdistrictId, @kodeDistrik, @namaDistrik, @alamat, @namaPraeses, NOW());
	END


-- SP - UPDATE data Distrik
	CREATE DEFINER=root@localhost PROCEDURE update_distrik(IN dataDistrik JSON)
	BEGIN
	    SET @distrikId = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.id_distrik'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.subdis_id'));
	    SET @kodeDistrik = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.kode_distrik'));
	    SET @namaDistrik = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.nama_distrik'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.alamat'));
	    SET @namaPraeses = JSON_UNQUOTE(JSON_EXTRACT(dataDistrik, '$.nama_praeses'));
	
	    UPDATE distrik
	    SET subdis_id = @subdistrictId, kode_distrik = @kodeDistrik, nama_distrik = @namaDistrik, alamat = @alamat, 
	        nama_praeses = @namaPraeses, updateAt = NOW()
	    WHERE id_distrik = @distrikId;
	END


-- SP - VIEW_ALL data Distrik
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Distrik()
	BEGIN
	    SELECT d.id_distrik, d.subdis_id, d.kode_distrik, d.nama_distrik, d.alamat, d.nama_praeses, d.createAt, d.updateAt, 
	           s.subdis_name AS subdistrict_name
	    FROM distrik d
	    JOIN subdistricts s ON d.subdis_id = s.subdis_id
	    WHERE d.isDeleted = 0;
	END


-- SP - VIEW_ById data Distrik
	CREATE DEFINER=root@localhost PROCEDURE view_Distrik_byId(IN id INT)
	BEGIN
	    SELECT d.id_distrik, d.subdis_id, d.kode_distrik, d.nama_distrik, d.alamat, d.nama_praeses, d.createAt, d.updateAt, 
	           s.subdis_name AS subdistrict_name
	    FROM distrik d
	    JOIN subdistricts s ON d.subdis_id = s.subdis_id
	    WHERE d.id_distrik = id;
	END


-- SP - DELETE(set isDeleted to 1(true) data Distrik)
	CREATE DEFINER=root@localhost PROCEDURE delete_distrik(IN id INT)
	BEGIN
	    UPDATE distrik
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_distrik = id;
	END

	
###########################################################################################################################################

####
#### - SP for Ressort
####

-- SP - INSERT data Ressort
	CREATE DEFINER=root@localhost PROCEDURE insert_ressort(IN dataRessort JSON)
	BEGIN
	    SET @distrikId = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.id_distrik'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.subdis_id'));
	    SET @kodeRessort = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.kode_ressort'));
	    SET @namaRessort = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.nama_ressort'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.alamat'));
	    SET @pendetaRessort = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.pendeta_ressort'));
	    SET @tglBerdiri = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.tgl_berdiri'));
	    
	    INSERT INTO ressort (id_distrik, subdis_id, kode_ressort, nama_ressort, alamat, pendeta_ressort, tgl_berdiri, createAt)
	    VALUES (@distrikId, @subdistrictId, @kodeRessort, @namaRessort, @alamat, @pendetaRessort, @tglBerdiri, NOW());
	end
	
-- SP - UPDATE data Ressort
	CREATE DEFINER=root@localhost PROCEDURE update_ressort(IN dataRessort JSON)
	BEGIN
	    SET @ressortId = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.id_ressort'));
	    SET @distrikId = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.id_distrik'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.subdis_id'));
	    SET @kodeRessort = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.kode_ressort'));
	    SET @namaRessort = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.nama_ressort'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.alamat'));
	    SET @pendetaRessort = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.pendeta_ressort'));
	    SET @tglBerdiri = JSON_UNQUOTE(JSON_EXTRACT(dataRessort, '$.tgl_berdiri'));
	    
	    UPDATE ressort
	    SET id_distrik = @distrikId, subdis_id = @subdistrictId, kode_ressort = @kodeRessort,
	        nama_ressort = @namaRessort, alamat = @alamat, pendeta_ressort = @pendetaRessort,
	        tgl_berdiri = @tglBerdiri, updateAt = NOW()
	    WHERE id_ressort = @ressortId;
	END

-- SP - View_ALL data Ressort
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Ressort()
	BEGIN
	    SELECT r.id_ressort, r.id_distrik, r.subdis_id, r.kode_ressort, r.nama_ressort, r.alamat, r.pendeta_ressort,
	           r.tgl_berdiri, r.createAt, r.updateAt,
	           d.nama_distrik AS distrik_name,
	           s.subdis_name AS subdistrict_name
	    FROM ressort r
	    JOIN distrik d ON r.id_distrik = d.id_distrik
	    JOIN subdistricts s ON r.subdis_id = s.subdis_id
	    WHERE r.isDeleted = 0;
	END

-- SP - View_byId data Ressort
	CREATE DEFINER=root@localhost PROCEDURE view_Ressort_byId(IN id INT)
	BEGIN
	    SELECT r.id_ressort, r.id_distrik, r.subdis_id, r.kode_ressort, r.nama_ressort, r.alamat, r.pendeta_ressort,
	           r.tgl_berdiri, r.createAt, r.updateAt,
	           d.nama_distrik AS distrik_name,
	           s.subdis_name AS subdistrict_name
	    FROM ressort r
	    JOIN distrik d ON r.id_distrik = d.id_distrik
	    JOIN subdistricts s ON r.subdis_id = s.subdis_id
	    WHERE r.id_ressort = id;
	END

-- SP - DELETE(set isDeleted to 1(true) data Ressort)
	CREATE DEFINER=root@localhost PROCEDURE delete_ressort(IN id INT)
	BEGIN
	    UPDATE ressort
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_ressort = id;
	END

	
###########################################################################################################################################

####
#### - SP for Gereja
####

-- SP - INSERT data Gereja
	CREATE DEFINER=root@localhost PROCEDURE insert_gereja(IN dataGereja JSON)
	BEGIN
	    SET @ressortId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.id_ressort'));
	    SET @jenisGerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.id_jenis_gereja'));
	    SET @kodeGereja = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.kode_gereja'));
	    SET @namaGereja = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.nama_gereja'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.alamat'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.subdis_id'));
	    SET @namaPendeta = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.nama_pendeta'));
	    SET @tglBerdiri = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.tgl_berdiri'));
	
	    INSERT INTO gereja (id_ressort, id_jenis_gereja, kode_gereja, nama_gereja, alamat, subdis_id, nama_pendeta, tgl_berdiri, createAt)
	    VALUES (@ressortId, @jenisGerejaId, @kodeGereja, @namaGereja, @alamat, @subdistrictId, @namaPendeta, @tglBerdiri, NOW());
	END

	
-- SP - UPDATE data Gereja
	CREATE DEFINER=root@localhost PROCEDURE update_gereja(IN dataGereja JSON)
	BEGIN
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.id_gereja'));
	    SET @ressortId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.id_ressort'));
	    SET @jenisGerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.id_jenis_gereja'));
	    SET @kodeGereja = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.kode_gereja'));
	    SET @namaGereja = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.nama_gereja'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.alamat'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.subdis_id'));
	    SET @namaPendeta = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.nama_pendeta'));
	    SET @tglBerdiri = JSON_UNQUOTE(JSON_EXTRACT(dataGereja, '$.tgl_berdiri'));
	
	    UPDATE gereja
	    SET id_ressort = @ressortId, id_jenis_gereja = @jenisGerejaId, kode_gereja = @kodeGereja,
	        nama_gereja = @namaGereja, alamat = @alamat, subdis_id = @subdistrictId,
	        nama_pendeta = @namaPendeta, tgl_berdiri = @tglBerdiri, updateAt = NOW()
	    WHERE id_gereja = @gerejaId;
	END


-- SP - View_ALL data Gereja
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Gereja()
	BEGIN
	    SELECT g.id_gereja, g.id_ressort, g.id_jenis_gereja, g.kode_gereja, g.nama_gereja, g.alamat, g.subdis_id,
	           g.nama_pendeta, g.tgl_berdiri, g.createAt, g.updateAt,
	           r.nama_ressort AS ressort_name,
	           j.jenis_gereja AS jenis_gereja_name,
	           s.subdis_name AS subdistrict_name
	    FROM gereja g
	    JOIN ressort r ON g.id_ressort = r.id_ressort
	    JOIN jenis_gereja j ON g.id_jenis_gereja = j.id_jenis_gereja
	    JOIN subdistricts s ON g.subdis_id = s.subdis_id
	    WHERE g.is_deleted = 0;
	END


-- SP - View_byId data Gereja
	CREATE DEFINER=root@localhost PROCEDURE view_Gereja_byId(IN id INT)
	BEGIN
	    SELECT g.id_gereja, g.id_ressort, g.id_jenis_gereja, g.kode_gereja, g.nama_gereja, g.alamat, g.subdis_id,
	           g.nama_pendeta, g.tgl_berdiri, g.createAt, g.updateAt,
	           r.nama_ressort AS ressort_name,
	           j.jenis_gereja AS jenis_gereja_name,
	           s.subdis_name AS subdistrict_name
	    FROM gereja g
	    JOIN ressort r ON g.id_ressort = r.id_ressort
	    JOIN jenis_gereja j ON g.id_jenis_gereja = j.id_jenis_gereja
	    JOIN subdistricts s ON g.subdis_id = s.subdis_id
	    WHERE g.id_gereja = id;
	END


-- SP - DELETE(set isDeleted to 1(true) data Gereja)
	CREATE DEFINER=root@localhost PROCEDURE delete_gereja(IN id INT)
	BEGIN
	    UPDATE gereja
	    SET is_deleted = 1, updateAt = NOW()
	    WHERE id_gereja = id;
	END


###########################################################################################################################################

####
#### - SP for Jemaat
####
	
-- SP - INSERT data Jemaat
	CREATE DEFINER=root@localhost PROCEDURE insert_jemaat(IN dataJemaat JSON)
	BEGIN
	    SET @namaDepan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.nama_depan'));
	    SET @namaBelakang = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.nama_belakang'));
	    SET @gelarDepan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.gelar_depan'));
	    SET @gelarBelakang = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.gelar_belakang'));
	    SET @tempatLahir = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.tempat_lahir'));
	    SET @tanggalLahir = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.tanggal_lahir'));
	    SET @jenisKelamin = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.jenis_kelamin'));
	    SET @idHubKeluarga = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_hub_keluarga'));
	    SET @idStatusPernikahan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_status_pernikahan'));
	    SET @idStatusAmaIna = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_status_ama_ina'));
	    SET @idStatusAnak = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_status_anak'));
	    SET @idPendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_pendidikan'));
	    SET @idBidangPendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_bidang_pendidikan'));
	    SET @bidangPendidikanLain = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.bidang_pendidikan_lain'));
	    SET @idPekerjaan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_pekerjaan'));
	    SET @namaPekerjaanLain = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.nama_pekerjaan_lain'));
	    SET @golDarah = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.gol_darah'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.alamat'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.subdis_id'));
	   	SET @idGereja = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_gereja'));
	  	SET @idWijk = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_wijk'));
	    SET @noTelepon = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.no_telepon'));
	    SET @noPonsel = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.no_ponsel'));
	    SET @fotoJemaat = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.foto_jemaat'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.keterangan'));
	    SET @isBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isBaptis'));
	    SET @isSidi = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isSidi'));
	    SET @isMenikah = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isMenikah'));
	    SET @isMeninggal = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isMeninggal'));
	    SET @isRPP = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isRPP'));
	
	    INSERT INTO jemaat (nama_depan, nama_belakang, gelar_depan, gelar_belakang, tempat_lahir, tanggal_lahir,
	                        jenis_kelamin, id_hub_keluarga, id_status_pernikahan, id_status_ama_ina, id_status_anak,
	                        id_pendidikan, id_bidang_pendidikan, bidang_pendidikan_lain, id_pekerjaan,
	                        nama_pekerjaan_lain, gol_darah, alamat, subdis_id, id_gereja, id_wijk, no_telepon, no_ponsel,
	                        foto_jemaat, keterangan, isBaptis, isSidi, isMenikah, isMeninggal, isRPP, createAt)
	    VALUES (@namaDepan, @namaBelakang, @gelarDepan, @gelarBelakang, @tempatLahir, @tanggalLahir,
	            @jenisKelamin, @idHubKeluarga, @idStatusPernikahan, @idStatusAmaIna, @idStatusAnak,
	            @idPendidikan, @idBidangPendidikan, @bidangPendidikanLain, @idPekerjaan,
	            @namaPekerjaanLain, @golDarah, @alamat, @subdistrictId, @idGereja, @idWijk, @noTelepon, @noPonsel,
	            @fotoJemaat, @keterangan, @isBaptis, @isSidi, @isMenikah, @isMeninggal, @isRPP, NOW());
	END


-- SP - UPDATE data Jemaat
	CREATE DEFINER=root@localhost PROCEDURE update_jemaat(IN dataJemaat JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_jemaat'));
	    SET @namaDepan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.nama_depan'));
	    SET @namaBelakang = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.nama_belakang'));
	    SET @gelarDepan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.gelar_depan'));
	    SET @gelarBelakang = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.gelar_belakang'));
	    SET @tempatLahir = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.tempat_lahir'));
	    SET @tanggalLahir = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.tanggal_lahir'));
	    SET @jenisKelamin = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.jenis_kelamin'));
	    SET @idHubKeluarga = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_hub_keluarga'));
	    SET @idStatusPernikahan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_status_pernikahan'));
	    SET @idStatusAmaIna = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_status_ama_ina'));
	    SET @idStatusAnak = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_status_anak'));
	    SET @idPendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_pendidikan'));
	    SET @idBidangPendidikan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_bidang_pendidikan'));
	    SET @bidangPendidikanLain = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.bidang_pendidikan_lain'));
	    SET @idPekerjaan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_pekerjaan'));
	    SET @namaPekerjaanLain = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.nama_pekerjaan_lain'));
	    SET @golDarah = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.gol_darah'));
	    SET @alamat = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.alamat'));
	    SET @subdistrictId = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.subdis_id'));
	    SET @noTelepon = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.no_telepon'));
	   	SET @idGereja = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_gereja'));
	  	SET @idWijk = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.id_wijk'));
	    SET @noPonsel = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.no_ponsel'));
	    SET @fotoJemaat = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.foto_jemaat'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.keterangan'));
	    SET @isBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isBaptis'));
	    SET @isSidi = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isSidi'));
	    SET @isMenikah = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isMenikah'));
	    SET @isMeninggal = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isMeninggal'));
	    SET @isRPP = JSON_UNQUOTE(JSON_EXTRACT(dataJemaat, '$.isRPP'));
	
	    UPDATE jemaat
	    SET nama_depan = @namaDepan, nama_belakang = @namaBelakang, gelar_depan = @gelarDepan,
	        gelar_belakang = @gelarBelakang, tempat_lahir = @tempatLahir, tanggal_lahir = @tanggalLahir,
	        jenis_kelamin = @jenisKelamin, id_hub_keluarga = @idHubKeluarga, id_status_pernikahan = @idStatusPernikahan,
	        id_status_ama_ina = @idStatusAmaIna, id_status_anak = @idStatusAnak, id_pendidikan = @idPendidikan,
	        id_bidang_pendidikan = @idBidangPendidikan, bidang_pendidikan_lain = @bidangPendidikanLain,
	        id_pekerjaan = @idPekerjaan, nama_pekerjaan_lain = @namaPekerjaanLain, gol_darah = @golDarah,
	        alamat = @alamat, subdis_id = @subdistrictId, id_gereja = @idGereja, id_wijk = @idWijk, no_telepon = @noTelepon, no_ponsel = @noPonsel,
	        foto_jemaat = @fotoJemaat, keterangan = @keterangan, isBaptis = @isBaptis, isSidi = @isSidi,
	        isMenikah = @isMenikah, isMeninggal = @isMeninggal, isRPP = @isRPP, updateAt = NOW()
	    WHERE id_jemaat = @jemaatId;
	end
	
-- SP - View_ALL data Jemaat
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Jemaat()
	BEGIN
	    SELECT 
	        j.id_jemaat, j.nama_depan, j.nama_belakang, j.gelar_depan, j.gelar_belakang,
	        j.tempat_lahir, j.tanggal_lahir, j.jenis_kelamin, j.id_hub_keluarga, 
	        j.id_status_pernikahan, j.id_status_ama_ina, j.id_status_anak, 
	        j.id_pendidikan, j.id_bidang_pendidikan, j.bidang_pendidikan_lain, 
	        j.id_pekerjaan, j.nama_pekerjaan_lain, j.gol_darah, j.alamat, 
	        j.subdis_id, j.id_gereja, j.id_wijk, j.no_telepon, j.no_ponsel, j.foto_jemaat, j.keterangan, 
	        j.isBaptis, j.isSidi, j.isMenikah, j.isMeninggal, j.isRPP, 
	        j.createAt, j.updateAt,
	        hk.nama_hub_keluarga AS hubungan_keluarga_name,
	        s_pernikahan.status AS status_pernikahan_name,
	        s_ama_ina.status AS status_ama_ina_name,
	        s_anak.status AS status_anak_name,
	        p.pendidikan AS pendidikan_name,
	        b_pendidikan.nama_bidang_pendidikan AS bidang_pendidikan_name,
	        pkerjaan.pekerjaan AS pekerjaan_name,
	        s.subdis_name AS subdistrict_name,
	        g.nama_gereja as gereja_name,
	        w.nama_wijk as wijk_name
	    FROM 
	        jemaat j
	    LEFT JOIN 
	        hubungan_keluarga hk ON j.id_hub_keluarga = hk.id_hub_keluarga
	    LEFT JOIN 
	        status s_pernikahan ON j.id_status_pernikahan = s_pernikahan.id_status
	    LEFT JOIN 
	        status s_ama_ina ON j.id_status_ama_ina = s_ama_ina.id_status
	    LEFT JOIN 
	        status s_anak ON j.id_status_anak = s_anak.id_status
	    LEFT JOIN 
	        pendidikan p ON j.id_pendidikan = p.id_pendidikan
	    LEFT JOIN 
	        bidang_pendidikan b_pendidikan ON j.id_bidang_pendidikan = b_pendidikan.id_bidang_pendidikan
	    LEFT JOIN 
	        pekerjaan pkerjaan ON j.id_pekerjaan = pkerjaan.id_pekerjaan
	    LEFT JOIN 
	        subdistricts s ON j.subdis_id = s.subdis_id
	    left join
	    	gereja g on j.id_gereja = g.id_gereja
	    left join 
	    	wijk w on j.id_wijk = w.id_wijk
	    WHERE j.isDeleted = 0;
	END

-- SP - View_ALL_jemaatLaki data Jemaat
	CREATE DEFINER=root@localhost PROCEDURE viewAll_JemaatLaki()
	BEGIN
	    SELECT 
	        j.id_jemaat, j.nama_depan, j.nama_belakang, j.gelar_depan, j.gelar_belakang,
	        j.tempat_lahir, j.tanggal_lahir, j.jenis_kelamin, j.id_hub_keluarga, 
	        j.id_status_pernikahan, j.id_status_ama_ina, j.id_status_anak, 
	        j.id_pendidikan, j.id_bidang_pendidikan, j.bidang_pendidikan_lain, 
	        j.id_pekerjaan, j.nama_pekerjaan_lain, j.gol_darah, j.alamat, 
	        j.subdis_id, j.id_gereja, j.id_wijk, j.no_telepon, j.no_ponsel, j.foto_jemaat, j.keterangan, 
	        j.isBaptis, j.isSidi, j.isMenikah, j.isMeninggal, j.isRPP, 
	        j.createAt, j.updateAt,
	        hk.nama_hub_keluarga AS hubungan_keluarga_name,
	        s_pernikahan.status AS status_pernikahan_name,
	        s_ama_ina.status AS status_ama_ina_name,
	        s_anak.status AS status_anak_name,
	        p.pendidikan AS pendidikan_name,
	        b_pendidikan.nama_bidang_pendidikan AS bidang_pendidikan_name,
	        pkerjaan.pekerjaan AS pekerjaan_name,
	        s.subdis_name AS subdistrict_name,
	        g.nama_gereja as gereja_name,
	        w.nama_wijk as wijk_name
	    FROM 
	        jemaat j
	    LEFT JOIN 
	        hubungan_keluarga hk ON j.id_hub_keluarga = hk.id_hub_keluarga
	    LEFT JOIN 
	        status s_pernikahan ON j.id_status_pernikahan = s_pernikahan.id_status
	    LEFT JOIN 
	        status s_ama_ina ON j.id_status_ama_ina = s_ama_ina.id_status
	    LEFT JOIN 
	        status s_anak ON j.id_status_anak = s_anak.id_status
	    LEFT JOIN 
	        pendidikan p ON j.id_pendidikan = p.id_pendidikan
	    LEFT JOIN 
	        bidang_pendidikan b_pendidikan ON j.id_bidang_pendidikan = b_pendidikan.id_bidang_pendidikan
	    LEFT JOIN 
	        pekerjaan pkerjaan ON j.id_pekerjaan = pkerjaan.id_pekerjaan
	    LEFT JOIN 
	        subdistricts s ON j.subdis_id = s.subdis_id
	    left join
	    	gereja g on j.id_gereja = g.id_gereja
	    left join 
	    	wijk w on j.id_wijk = w.id_wijk
	    WHERE j.isDeleted = 0 and j.jenis_kelamin = 'Laki-laki';
	end
	
-- SP - View_ALL_jemaatPerempuan data Jemaat
	CREATE DEFINER=root@localhost PROCEDURE viewAll_JemaatPerempuan()
	BEGIN
	    SELECT 
	        j.id_jemaat, j.nama_depan, j.nama_belakang, j.gelar_depan, j.gelar_belakang,
	        j.tempat_lahir, j.tanggal_lahir, j.jenis_kelamin, j.id_hub_keluarga, 
	        j.id_status_pernikahan, j.id_status_ama_ina, j.id_status_anak, 
	        j.id_pendidikan, j.id_bidang_pendidikan, j.bidang_pendidikan_lain, 
	        j.id_pekerjaan, j.nama_pekerjaan_lain, j.gol_darah, j.alamat, 
	        j.subdis_id, j.id_gereja, j.id_wijk, j.no_telepon, j.no_ponsel, j.foto_jemaat, j.keterangan, 
	        j.isBaptis, j.isSidi, j.isMenikah, j.isMeninggal, j.isRPP, 
	        j.createAt, j.updateAt,
	        hk.nama_hub_keluarga AS hubungan_keluarga_name,
	        s_pernikahan.status AS status_pernikahan_name,
	        s_ama_ina.status AS status_ama_ina_name,
	        s_anak.status AS status_anak_name,
	        p.pendidikan AS pendidikan_name,
	        b_pendidikan.nama_bidang_pendidikan AS bidang_pendidikan_name,
	        pkerjaan.pekerjaan AS pekerjaan_name,
	        s.subdis_name AS subdistrict_name,
	        g.nama_gereja as gereja_name,
	        w.nama_wijk as wijk_name
	    FROM 
	        jemaat j
	    LEFT JOIN 
	        hubungan_keluarga hk ON j.id_hub_keluarga = hk.id_hub_keluarga
	    LEFT JOIN 
	        status s_pernikahan ON j.id_status_pernikahan = s_pernikahan.id_status
	    LEFT JOIN 
	        status s_ama_ina ON j.id_status_ama_ina = s_ama_ina.id_status
	    LEFT JOIN 
	        status s_anak ON j.id_status_anak = s_anak.id_status
	    LEFT JOIN 
	        pendidikan p ON j.id_pendidikan = p.id_pendidikan
	    LEFT JOIN 
	        bidang_pendidikan b_pendidikan ON j.id_bidang_pendidikan = b_pendidikan.id_bidang_pendidikan
	    LEFT JOIN 
	        pekerjaan pkerjaan ON j.id_pekerjaan = pkerjaan.id_pekerjaan
	    LEFT JOIN 
	        subdistricts s ON j.subdis_id = s.subdis_id
	    left join
	    	gereja g on j.id_gereja = g.id_gereja
	    left join 
	    	wijk w on j.id_wijk = w.id_wijk
	    WHERE j.isDeleted = 0 and j.jenis_kelamin = 'Perempuan';
	END
	
-- SP - View_byId data Jemaat
	CREATE DEFINER=root@localhost PROCEDURE view_Jemaat_byId(IN id INT)
	BEGIN
	    SELECT 
	        j.id_jemaat, j.nama_depan, j.nama_belakang, j.gelar_depan, j.gelar_belakang,
	        j.tempat_lahir, j.tanggal_lahir, j.jenis_kelamin, j.id_hub_keluarga, 
	        j.id_status_pernikahan, j.id_status_ama_ina, j.id_status_anak, 
	        j.id_pendidikan, j.id_bidang_pendidikan, j.bidang_pendidikan_lain, 
	        j.id_pekerjaan, j.nama_pekerjaan_lain, j.gol_darah, j.alamat, 
	        j.subdis_id, j.id_gereja, j.id_wijk, j.no_telepon, j.no_ponsel, j.foto_jemaat, j.keterangan, 
	        j.isBaptis, j.isSidi, j.isMenikah, j.isMeninggal, j.isRPP, 
	        j.createAt, j.updateAt,
	        hk.nama_hub_keluarga AS hubungan_keluarga_name,
	        s_pernikahan.status AS status_pernikahan_name,
	        s_ama_ina.status AS status_ama_ina_name,
	        s_anak.status AS status_anak_name,
	        p.pendidikan AS pendidikan_name,
	        b_pendidikan.nama_bidang_pendidikan AS bidang_pendidikan_name,
	        pkerjaan.pekerjaan AS pekerjaan_name,
	        s.subdis_name AS subdistrict_name,
	        g.nama_gereja as gereja_name,
	        w.nama_wijk as wijk_name
	    FROM 
	        jemaat j
	    LEFT JOIN 
	        hubungan_keluarga hk ON j.id_hub_keluarga = hk.id_hub_keluarga
	    LEFT JOIN 
	        status s_pernikahan ON j.id_status_pernikahan = s_pernikahan.id_status
	    LEFT JOIN 
	        status s_ama_ina ON j.id_status_ama_ina = s_ama_ina.id_status
	    LEFT JOIN 
	        status s_anak ON j.id_status_anak = s_anak.id_status
	    LEFT JOIN 
	        pendidikan p ON j.id_pendidikan = p.id_pendidikan
	    LEFT JOIN 
	        bidang_pendidikan b_pendidikan ON j.id_bidang_pendidikan = b_pendidikan.id_bidang_pendidikan
	    LEFT JOIN 
	        pekerjaan pkerjaan ON j.id_pekerjaan = pkerjaan.id_pekerjaan
	    LEFT JOIN 
	        subdistricts s ON j.subdis_id = s.subdis_id
	    left join
	    	gereja g on j.id_gereja = g.id_gereja
	    left join 
	    	wijk w on j.id_wijk = w.id_wijk
	    WHERE 
	        j.id_jemaat = id;
	END
	
-- SP - DELETE(set isDeleted to 1(true) data Jemaat)
	CREATE DEFINER=root@localhost PROCEDURE delete_jemaat(IN id INT)
	BEGIN
	    UPDATE jemaat
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_jemaat = id;
	end
	
	
###########################################################################################################################################

####
#### - SP for Detail_pindah
####
	
-- SP - INSERT data detail_pindah
	CREATE DEFINER=root@localhost PROCEDURE insert_detail_pindah(IN dataDetailPindah JSON)
	BEGIN
	    SET @idJemaat = JSON_UNQUOTE(JSON_EXTRACT(dataDetailPindah, '$.id_jemaat'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataDetailPindah, '$.keterangan'));
	
	    INSERT INTO detail_pindah (id_jemaat, keterangan)
	    VALUES (@idJemaat, @keterangan);
	END

-- SP - UPDATE data detail_pindah
	CREATE DEFINER=root@localhost PROCEDURE update_detail_pindah(IN dataDetailPindah JSON)
	BEGIN
	    SET @idDetRegPindah = JSON_UNQUOTE(JSON_EXTRACT(dataDetailPindah, '$.id_det_reg_pindah'));
	    SET @idJemaat = JSON_UNQUOTE(JSON_EXTRACT(dataDetailPindah, '$.id_jemaat'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataDetailPindah, '$.keterangan'));
	
	    UPDATE detail_pindah
	    SET id_jemaat = @idJemaat, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_det_reg_pindah = @idDetRegPindah;
	END

-- SP - VIEW_ALL data detail_pindah with jemaat data
	CREATE DEFINER=root@localhost PROCEDURE viewAll_DetailPindah()
	BEGIN
	    SELECT dp.id_det_reg_pindah, dp.id_jemaat, dp.keterangan, j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang
	    FROM detail_pindah dp
	    JOIN jemaat j ON dp.id_jemaat = j.id_jemaat
	    WHERE dp.isDeleted = 0;
	END

-- SP - VIEW_ById data detail_pindah with jemaat data
	CREATE DEFINER=root@localhost PROCEDURE view_DetailPindah_byId(IN id INT)
	BEGIN
	    SELECT dp.id_det_reg_pindah, dp.id_jemaat, dp.keterangan, j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang
	    FROM detail_pindah dp
	    JOIN jemaat j ON dp.id_jemaat = j.id_jemaat
	    WHERE dp.id_det_reg_pindah = id;
	END
	

-- SP - DELETE (set is_deleted to 1(true) data detail_pindah)
	CREATE DEFINER=root@localhost PROCEDURE delete_detail_pindah(IN id INT)
	BEGIN
	    UPDATE detail_pindah
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_det_reg_pindah = id;
	end

	
###########################################################################################################################################

####
#### - SP for Meninggal
####
	
-- SP - INSERT data Meinggal
	CREATE DEFINER=root@localhost PROCEDURE insert_meninggal(IN dataMeninggal JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_jemaat'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_status'));
	    SET @tglMeninggal = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.tgl_meninggal'));
	    SET @tglWartaMeninggal = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.tgl_warta_meninggal'));
	    SET @tempatPemakaman = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.tempat_pemakaman'));
	    SET @namaPendetaMelayani = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.nama_pendeta_melayani'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.keterangan'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_gereja'));
	
	    INSERT INTO meninggal (id_gereja, id_jemaat, tgl_meninggal, tgl_warta_meninggal, tempat_pemakaman, nama_pendeta_melayani,
	              keterangan, id_status, createAt)
	    VALUES (@gerejaId, @jemaatId, @tglMeninggal, @tglWartaMeninggal, @tempatPemakaman, @namaPendetaMelayani,
	            @keterangan, @statusId, NOW());
	end
	
-- SP - UPDATE data Meninggal
	CREATE DEFINER=root@localhost PROCEDURE update_meninggal(IN dataMeninggal JSON)
	BEGIN
	    SET @meninggalId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_meninggal'));
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_jemaat'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_status'));
	    SET @tglMeninggal = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.tgl_meninggal'));
	    SET @tglWartaMeninggal = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.tgl_warta_meninggal'));
	    SET @tempatPemakaman = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.tempat_pemakaman'));
	    SET @namaPendetaMelayani = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.nama_pendeta_melayani'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.keterangan'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataMeninggal, '$.id_gereja'));
	
	    UPDATE meninggal
	    SET id_gereja = @gerejaId, id_jemaat = @jemaatId, tgl_meninggal = @tglMeninggal, tgl_warta_meninggal = @tglWartaMeninggal,
	        tempat_pemakaman = @tempatPemakaman, nama_pendeta_melayani = @namaPendetaMelayani, keterangan = @keterangan,
	        id_status = @statusId, updateAt = NOW()
	    WHERE id_meninggal = @meninggalId;
	END


-- SP - View_ALL data Meninggal
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Meninggal()
	BEGIN
	    SELECT m.id_meninggal, m.id_gereja, m.id_jemaat, m.tgl_meninggal, m.tgl_warta_meninggal, m.tempat_pemakaman,
	           m.nama_pendeta_melayani, m.keterangan, m.createAt, m.updateAt, m.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           st.status,
	           g.nama_gereja AS gereja_name
	    FROM meninggal m
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN status st ON m.id_status = st.id_status
	    JOIN gereja g ON m.id_gereja = g.id_gereja
	    WHERE m.isDeleted = 0;
	END


-- SP - View_byId data Meninggal
	CREATE DEFINER=root@localhost PROCEDURE view_Meninggal_byId(IN id INT)
	BEGIN
	    SELECT m.id_meninggal, m.id_gereja, m.id_jemaat, m.tgl_meninggal, m.tgl_warta_meninggal, m.tempat_pemakaman,
	           m.nama_pendeta_melayani, m.keterangan, m.createAt, m.updateAt, m.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           st.status,
	           g.nama_gereja AS gereja_name
	    FROM meninggal m
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN status st ON m.id_status = st.id_status
	    JOIN gereja g ON m.id_gereja = g.id_gereja
	    WHERE m.id_meninggal = id;
	END


-- SP - DELETE(set isDeleted to 1(true) data Meinggal)
	CREATE DEFINER=root@localhost PROCEDURE delete_meninggal(IN id INT)
	BEGIN
	    UPDATE meninggal
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_meninggal = id;
	END




###########################################################################################################################################

####
#### - SP for Head Pindah
####
	
-- SP - INSERT data Head Pindah
	CREATE DEFINER=root@localhost PROCEDURE insert_head_pindah(IN dataHeadPindah JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_jemaat'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_gereja'));
	    SET @noSuratPindah = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.no_surat_pindah'));
	    SET @tglPindah = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.tgl_pindah'));
	    SET @tglWarta = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.tgl_warta'));
	    SET @gerejaTujuanId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_gereja_tujuan'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.nama_gereja_no_hkbp'));
	    SET @fileSuratPindah = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.file_surat_pindah'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.keterangan'));
	
	    INSERT INTO head_pindah (id_jemaat, id_gereja, no_surat_pindah, tgl_pindah, tgl_warta, id_gereja_tujuan,
	                             nama_gereja_no_hkbp, file_surat_pindah, keterangan, create_at)
	    VALUES (@jemaatId, @gerejaId, @noSuratPindah, @tglPindah, @tglWarta, @gerejaTujuanId, @namaGerejaNonHKBP,
	            @fileSuratPindah, @keterangan, NOW());
	END

-- SP - UPDATE data Head Pindah
	CREATE DEFINER=root@localhost PROCEDURE update_head_pindah(IN dataHeadPindah JSON)
	BEGIN
	    SET @headPindahId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_head_pindah'));
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_jemaat'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_gereja'));
	    SET @noSuratPindah = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.no_surat_pindah'));
	    SET @tglPindah = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.tgl_pindah'));
	    SET @tglWarta = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.tgl_warta'));
	    SET @gerejaTujuanId = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.id_gereja_tujuan'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.nama_gereja_no_hkbp'));
	    SET @fileSuratPindah = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.file_surat_pindah'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataHeadPindah, '$.keterangan'));
	
	    UPDATE head_pindah
	    SET id_jemaat = @jemaatId, id_gereja = @gerejaId, no_surat_pindah = @noSuratPindah, tgl_pindah = @tglPindah,
	        tgl_warta = @tglWarta, id_gereja_tujuan = @gerejaTujuanId, nama_gereja_no_hkbp = @namaGerejaNonHKBP,
	        file_surat_pindah = @fileSuratPindah, keterangan = @keterangan, update_at = NOW()
	    WHERE id_head_pindah = @headPindahId;
	END

-- SP - View_ALL data Head Pindah
	CREATE DEFINER=root@localhost PROCEDURE viewAll_HeadPindah()
	BEGIN
	    SELECT hp.id_head_pindah, hp.id_jemaat, hp.id_gereja, hp.no_surat_pindah, hp.tgl_pindah, hp.tgl_warta,
	           hp.id_gereja_tujuan, hp.nama_gereja_no_hkbp, hp.file_surat_pindah, hp.keterangan, hp.create_at,
	           hp.update_at, hp.is_deleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           g.nama_gereja AS gereja_asal_name,
	           g2.nama_gereja AS gereja_tujuan_name
	    FROM head_pindah hp
	    JOIN jemaat j ON hp.id_jemaat = j.id_jemaat
	    JOIN gereja g ON hp.id_gereja = g.id_gereja
	    JOIN gereja g2 ON hp.id_gereja_tujuan = g2.id_gereja
	    WHERE hp.is_deleted = 0;
	END

-- SP - View_byId data Head Pindah
	CREATE DEFINER=root@localhost PROCEDURE view_HeadPindah_byId(IN id INT)
	BEGIN
	    SELECT hp.id_head_pindah, hp.id_jemaat, hp.id_gereja, hp.no_surat_pindah, hp.tgl_pindah, hp.tgl_warta,
	           hp.id_gereja_tujuan, hp.nama_gereja_no_hkbp, hp.file_surat_pindah, hp.keterangan, hp.create_at,
	           hp.update_at, hp.is_deleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           g.nama_gereja AS gereja_asal_name,
	           g2.nama_gereja AS gereja_tujuan_name
	    FROM head_pindah hp
	    JOIN jemaat j ON hp.id_jemaat = j.id_jemaat
	    JOIN gereja g ON hp.id_gereja = g.id_gereja
	    JOIN gereja g2 ON hp.id_gereja_tujuan = g2.id_gereja
	    WHERE hp.id_head_pindah = id;
	END

-- SP - DELETE(set isDeleted to 1(true) data Head Pindah)
	CREATE DEFINER=root@localhost PROCEDURE delete_head_pindah(IN id INT)
	BEGIN
	    UPDATE head_pindah
	    SET is_deleted = 1, update_at = NOW()
	    WHERE id_head_pindah = id;
	END

	
###########################################################################################################################################

####
#### - SP for Sidi
####
	
-- SP - INSERT data Sidi
	CREATE DEFINER=root@localhost PROCEDURE insert_sidi(IN dataSidi JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_jemaat'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_status'));
	    SET @tglSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.tgl_sidi'));
	    SET @noSuratSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.no_surat_sidi'));
	    SET @natsSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.nats_sidi'));
	    SET @gerejaSidiId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_gereja_sidi'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.nama_gereja_non_hkbp'));
	    SET @namaPendetaSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.nama_pendeta_sidi'));
	    SET @fileSuratSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.file_surat_sidi'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.keterangan'));
	
	    INSERT INTO sidi (id_jemaat, id_status, tgl_sidi, no_surat_sidi, nats_sidi, id_gereja_sidi,
                  nama_gereja_non_hkbp, nama_pendeta_sidi, file_surat_sidi, keterangan, createAt)
		VALUES (@jemaatId, @statusId, @tglSidi, @noSuratSidi, @natsSidi, @gerejaSidiId, @namaGerejaNonHKBP,
        		@namaPendetaSidi, @fileSuratSidi, @keterangan, NOW());

	END


-- SP - UPDATE data Sidi
	CREATE DEFINER=root@localhost PROCEDURE update_sidi(IN dataSidi JSON)
	BEGIN
	    SET @sidiId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_sidi'));
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_jemaat'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_status'));
	    SET @tglSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.tgl_sidi'));
	    SET @noSuratSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.no_surat_sidi'));
	    SET @natsSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.nats_sidi'));
	    SET @gerejaSidiId = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.id_gereja_sidi'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.nama_gereja_non_hkbp'));
	    SET @namaPendetaSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.nama_pendeta_sidi'));
	    SET @fileSuratSidi = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.file_surat_sidi'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataSidi, '$.keterangan'));
	
	    UPDATE sidi
	    SET id_jemaat = @jemaatId, id_status = @statusId, tgl_sidi = @tglSidi, no_surat_sidi = @noSuratSidi,
	        nats_sidi = @natsSidi, id_gereja_sidi = @gerejaSidiId, nama_gereja_non_hkbp = @namaGerejaNonHKBP,
	        nama_pendeta_sidi = @namaPendetaSidi, file_surat_sidi = @fileSuratSidi, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_sidi = @sidiId;
	END


-- SP - View_ALL data Sidi
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Sidi()
	BEGIN
	    SELECT s.id_sidi, s.id_jemaat, s.id_status, s.tgl_sidi, s.no_surat_sidi, s.nats_sidi, s.isHKBP,
	           s.id_gereja_sidi, s.nama_gereja_non_hkbp, s.nama_pendeta_sidi, s.file_surat_sidi, s.keterangan,
	           s.createAt, s.updateAt, s.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           st.status,
	           g.nama_gereja AS gereja_sidi_name
	    FROM sidi s
	    JOIN jemaat j ON s.id_jemaat = j.id_jemaat
	    JOIN status st ON s.id_status = st.id_status
	    JOIN gereja g ON s.id_gereja_sidi = g.id_gereja
	    WHERE s.isDeleted = 0;
	END


-- SP - View_byId data Sidi
	CREATE DEFINER=root@localhost PROCEDURE view_Sidi_byId(IN id INT)
	BEGIN
	    SELECT s.id_sidi, s.id_jemaat, s.id_status, s.tgl_sidi, s.no_surat_sidi, s.nats_sidi, s.isHKBP,
	           s.id_gereja_sidi, s.nama_gereja_non_hkbp, s.nama_pendeta_sidi, s.file_surat_sidi, s.keterangan,
	           s.createAt, s.updateAt, s.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           st.status,
	           g.nama_gereja AS gereja_sidi_name
	    FROM sidi s
	    JOIN jemaat j ON s.id_jemaat = j.id_jemaat
	    JOIN status st ON s.id_status = st.id_status
	    JOIN gereja g ON s.id_gereja_sidi = g.id_gereja
	    WHERE s.id_sidi = id;
	END


-- SP - DELETE(set isDeleted to 1(true) data Sidi)
	CREATE DEFINER=root@localhost PROCEDURE delete_sidi(IN id INT)
	BEGIN
	    UPDATE sidi
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_sidi = id;
	END


###########################################################################################################################################

####
#### - SP for Baptis
####	
	
-- SP - INSERT data Baptis
	CREATE DEFINER=root@localhost PROCEDURE insert_baptis(IN dataBaptis JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_jemaat'));
	    SET @tglBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.tgl_baptis'));
	    SET @noSuratBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.no_surat_baptis'));
	    SET @gerejaBaptisId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_gereja_baptis'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.nama_gereja_non_HKBP'));
	    SET @namaPendetaBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.nama_pendeta_baptis'));
	    SET @fileSuratBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.file_surat_baptis'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.keterangan'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_status'));
	
	    INSERT INTO baptis (id_jemaat, tgl_baptis, no_surat_baptis, id_gereja_baptis, nama_gereja_non_HKBP,
	              nama_pendeta_baptis, file_surat_baptis, keterangan, id_status, createAt)
	    VALUES (@jemaatId, @tglBaptis, @noSuratBaptis, @gerejaBaptisId, @namaGerejaNonHKBP,
	            @namaPendetaBaptis, @fileSuratBaptis, @keterangan, @statusId, NOW());
	END


-- SP - UPDATE data Baptis
	CREATE DEFINER=root@localhost PROCEDURE update_baptis(IN dataBaptis JSON)
	BEGIN
	    SET @baptisId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_baptis'));
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_jemaat'));
	    SET @tglBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.tgl_baptis'));
	    SET @noSuratBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.no_surat_baptis'));
	    SET @gerejaBaptisId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_gereja_baptis'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.nama_gereja_non_HKBP'));
	    SET @namaPendetaBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.nama_pendeta_baptis'));
	    SET @fileSuratBaptis = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.file_surat_baptis'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.keterangan'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataBaptis, '$.id_status'));
	
	    UPDATE baptis
	    SET id_jemaat = @jemaatId, tgl_baptis = @tglBaptis, no_surat_baptis = @noSuratBaptis,
	        id_gereja_baptis = @gerejaBaptisId, nama_gereja_non_HKBP = @namaGerejaNonHKBP,
	        nama_pendeta_baptis = @namaPendetaBaptis, file_surat_baptis = @fileSuratBaptis,
	        keterangan = @keterangan, id_status = @statusId, updateAt = NOW()
	    WHERE id_baptis = @baptisId;
	END


-- SP - View_ALL data Baptis
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Baptis()
	BEGIN
	    SELECT b.id_baptis, b.id_jemaat, b.tgl_baptis, b.no_surat_baptis, b.isHKBP, b.id_gereja_baptis,
	           b.nama_gereja_non_HKBP, b.nama_pendeta_baptis, b.file_surat_baptis, b.keterangan, b.id_status,
	           b.createAt, b.updateAt, b.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           g.nama_gereja AS gereja_baptis_name,
	           st.status
	    FROM baptis b
	    JOIN jemaat j ON b.id_jemaat = j.id_jemaat
	    JOIN gereja g ON b.id_gereja_baptis = g.id_gereja
	    JOIN status st ON b.id_status = st.id_status
	    WHERE b.isDeleted = 0;
	END


-- SP - View_byId data Baptis
	CREATE DEFINER=root@localhost PROCEDURE view_Baptis_byId(IN id INT)
	BEGIN
	    SELECT b.id_baptis, b.id_jemaat, b.tgl_baptis, b.no_surat_baptis, b.isHKBP, b.id_gereja_baptis,
	           b.nama_gereja_non_HKBP, b.nama_pendeta_baptis, b.file_surat_baptis, b.keterangan, b.id_status,
	           b.createAt, b.updateAt, b.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           g.nama_gereja AS gereja_baptis_name,
	           st.status
	    FROM baptis b
	    JOIN jemaat j ON b.id_jemaat = j.id_jemaat
	    JOIN gereja g ON b.id_gereja_baptis = g.id_gereja
	    JOIN status st ON b.id_status = st.id_status
	    WHERE b.id_baptis = id;
	END


-- SP - DELETE(set isDeleted to 1(true) data Baptis)
	CREATE DEFINER=root@localhost PROCEDURE delete_baptis(IN id INT)
	BEGIN
	    UPDATE baptis
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_baptis = id;
	END

	
###########################################################################################################################################

####
#### - SP for Pernikahan
####
	
-- SP - INSERT data Pernikahan
	CREATE DEFINER=root@localhost PROCEDURE insert_pernikahan(IN dataPernikahan JSON)
	BEGIN
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_gereja'));
	    SET @tglPernikahan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.tgl_pernikahan'));
	    SET @natsPernikahan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.nats_pernikahan'));
	    SET @isHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.isHKBP'));
	    SET @gerejaNikahId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_gereja_nikah'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.nama_gereja_non_HKBP'));
	    SET @namaPendeta = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.nama_pendeta'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.keterangan'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_status'));
	
	    INSERT INTO pernikahan (id_gereja, tgl_pernikahan, nats_pernikahan, isHKBP, id_gereja_nikah,
	                            nama_gereja_non_HKBP, nama_pendeta, keterangan, id_status, createAt)
	    VALUES (@gerejaId, @tglPernikahan, @natsPernikahan, @isHKBP, @gerejaNikahId, @namaGerejaNonHKBP,
	            @namaPendeta, @keterangan, @statusId, NOW());
	END

-- SP - UPDATE data Pernikahan
	CREATE DEFINER=root@localhost PROCEDURE update_pernikahan(IN dataPernikahan JSON)
	BEGIN
	    SET @pernikahanId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_pernikahan'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_gereja'));
	    SET @tglPernikahan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.tgl_pernikahan'));
	    SET @natsPernikahan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.nats_pernikahan'));
	    SET @isHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.isHKBP'));
	    SET @gerejaNikahId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_gereja_nikah'));
	    SET @namaGerejaNonHKBP = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.nama_gereja_non_HKBP'));
	    SET @namaPendeta = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.nama_pendeta'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.keterangan'));
	    SET @statusId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahan, '$.id_status'));
	
	    UPDATE pernikahan
	    SET id_gereja = @gerejaId, tgl_pernikahan = @tglPernikahan, nats_pernikahan = @natsPernikahan,
	        isHKBP = @isHKBP, id_gereja_nikah = @gerejaNikahId, nama_gereja_non_HKBP = @namaGerejaNonHKBP,
	        nama_pendeta = @namaPendeta, keterangan = @keterangan, id_status = @statusId, updateAt = NOW()
	    WHERE id_pernikahan = @pernikahanId;
	END

-- SP - View_ALL data Pernikahan
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Pernikahan()
	BEGIN
	    SELECT p.id_pernikahan, p.id_gereja, p.tgl_pernikahan, p.nats_pernikahan, p.isHKBP, p.id_gereja_nikah,
	           p.nama_gereja_non_HKBP, p.nama_pendeta, p.keterangan, p.createAt, p.updateAt, p.isDeleted,
	           g.nama_gereja AS gereja_name,
	           g2.nama_gereja AS gereja_nikah_name,
	           s.status
	    FROM pernikahan p
	    JOIN gereja g ON p.id_gereja = g.id_gereja
	    JOIN gereja g2 ON p.id_gereja_nikah = g2.id_gereja
	    JOIN status s ON p.id_status = s.id_status
	    WHERE p.isDeleted = 0;
	END

-- SP - View_byId data Pernikahan
	CREATE DEFINER=root@localhost PROCEDURE view_Pernikahan_byId(IN id INT)
	BEGIN
	    SELECT p.id_pernikahan, p.id_gereja, p.tgl_pernikahan, p.nats_pernikahan, p.isHKBP, p.id_gereja_nikah,
	           p.nama_gereja_non_HKBP, p.nama_pendeta, p.keterangan, p.createAt, p.updateAt, p.isDeleted,
	           g.nama_gereja AS gereja_name,
	           g2.nama_gereja AS gereja_nikah_name,
	           s.status
	    FROM pernikahan p
	    JOIN gereja g ON p.id_gereja = g.id_gereja
	    JOIN gereja g2 ON p.id_gereja_nikah = g2.id_gereja
	    JOIN status s ON p.id_status = s.id_status
	    WHERE p.id_pernikahan = id;
	END

-- SP - DELETE(set isDeleted to 1(true) data Pernikahan)
	CREATE DEFINER=root@localhost PROCEDURE delete_pernikahan(IN id INT)
	BEGIN
	    UPDATE pernikahan
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_pernikahan = id;
	END

	
###########################################################################################################################################

####
#### - SP for Pernikahan Jemaat
####
	
-- SP - INSERT data Pernikahan Jemaat
	CREATE DEFINER=root@localhost PROCEDURE insert_pernikahan_jemaat(IN dataPernikahanJemaat JSON)
	BEGIN
	    SET @pernikahanId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_pernikahan'));
	    SET @jemaatLakiId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_jemaat_laki'));
	    SET @jemaatPerempuanId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_jemaat_perempuan'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.keterangan'));
	    
	    INSERT INTO pernikahan_jemaat (id_pernikahan, id_jemaat_laki, id_jemaat_perempuan, keterangan, createAt)
	    VALUES (@pernikahanId, @jemaatLakiId, @jemaatPerempuanId, @keterangan, NOW());
	END

-- SP - UPDATE data Pernikahan Jemaat
	CREATE DEFINER=root@localhost PROCEDURE update_pernikahan_jemaat(IN dataPernikahanJemaat JSON)
	BEGIN
	    SET @pernikahanJemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_pernikahan_jemaat'));
	    SET @pernikahanId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_pernikahan'));
	    SET @jemaatLakiId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_jemaat_laki'));
	    SET @jemaatPerempuanId = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.id_jemaat_perempuan'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPernikahanJemaat, '$.keterangan'));
	    
	    UPDATE pernikahan_jemaat
	    SET id_pernikahan = @pernikahanId, id_jemaat_laki = @jemaatLakiId, id_jemaat_perempuan = @jemaatPerempuanId,
	        keterangan = @keterangan, updateAt = NOW()
	    WHERE id_pernikahan_jemaat = @pernikahanJemaatId;
	END

-- SP - View_ALL data Pernikahan Jemaat
	CREATE DEFINER=root@localhost PROCEDURE viewAll_PernikahanJemaat()
	BEGIN
	    SELECT pj.id_pernikahan_jemaat, pj.id_pernikahan, pj.id_jemaat_laki, pj.id_jemaat_perempuan, pj.keterangan,
	           pj.createAt, pj.updateAt, pj.is_deleted,
	           j1.gelar_depan AS gelar_depan_laki, j1.nama_depan AS nama_depan_laki, j1.nama_belakang AS nama_belakang_laki,
	           j2.gelar_depan AS gelar_depan_perempuan, j2.nama_depan AS nama_depan_perempuan, j2.nama_belakang AS nama_belakang_perempuan
	    FROM pernikahan_jemaat pj
	    JOIN jemaat j1 ON pj.id_jemaat_laki = j1.id_jemaat
	    JOIN jemaat j2 ON pj.id_jemaat_perempuan = j2.id_jemaat
	    WHERE pj.is_deleted = 0;
	END

-- SP - View_byId data Pernikahan Jemaat
	CREATE DEFINER=root@localhost PROCEDURE view_PernikahanJemaat_byId(IN id INT)
	BEGIN
	    SELECT pj.id_pernikahan_jemaat, pj.id_pernikahan, pj.id_jemaat_laki, pj.id_jemaat_perempuan, pj.keterangan,
	           pj.createAt, pj.updateAt, pj.is_deleted,
	           j1.gelar_depan AS gelar_depan_laki, j1.nama_depan AS nama_depan_laki, j1.nama_belakang AS nama_belakang_laki,
	           j2.gelar_depan AS gelar_depan_perempuan, j2.nama_depan AS nama_depan_perempuan, j2.nama_belakang AS nama_belakang_perempuan
	    FROM pernikahan_jemaat pj
	    JOIN jemaat j1 ON pj.id_jemaat_laki = j1.id_jemaat
	    JOIN jemaat j2 ON pj.id_jemaat_perempuan = j2.id_jemaat
	    WHERE pj.id_pernikahan_jemaat = id;
	END

-- SP - DELETE(set isDeleted to 1(true) data Pernikahan Jemaat)
	CREATE DEFINER=root@localhost PROCEDURE delete_pernikahan_jemaat(IN id INT)
	BEGIN
	    UPDATE pernikahan_jemaat
	    SET is_deleted = 1, updateAt = NOW()
	    WHERE id_pernikahan_jemaat = id;
	END

	
	
###########################################################################################################################################

####
#### - SP for Majelis
####
	

-- SP - INSERT data Majelis
	CREATE DEFINER=root@localhost PROCEDURE insert_majelis(IN dataMajelis JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_jemaat'));
	    SET @statusPelayananId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_status_pelayanan'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_gereja'));
	    SET @tglTahbis = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.tgl_tahbis'));
	    SET @tglAkhirJawatan = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.tgl_akhir_jawatan'));
	    
	    INSERT INTO majelis (id_jemaat, id_status_pelayanan, id_gereja, tgl_tahbis, tgl_akhir_jawatan, createAt)
	    VALUES (@jemaatId, @statusPelayananId, @gerejaId, @tglTahbis, @tglAkhirJawatan, NOW());
	END


-- SP - UPDATE data Majelis
	CREATE DEFINER=root@localhost PROCEDURE update_majelis(IN dataMajelis JSON)
	BEGIN
	    SET @majelisId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_majelis'));
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_jemaat'));
	    SET @statusPelayananId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_status_pelayanan'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.id_gereja'));
	    SET @tglTahbis = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.tgl_tahbis'));
	    SET @tglAkhirJawatan = JSON_UNQUOTE(JSON_EXTRACT(dataMajelis, '$.tgl_akhir_jawatan'));
	    
	    UPDATE majelis
	    SET id_jemaat = @jemaatId, id_status_pelayanan = @statusPelayananId, id_gereja = @gerejaId, tgl_tahbis = @tglTahbis,
	        tgl_akhir_jawatan = @tglAkhirJawatan, updateAt = NOW()
	    WHERE id_majelis = @majelisId;
	END


-- SP - View_ALL data Majelis
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Majelis()
	BEGIN
	    SELECT m.id_majelis, m.id_jemaat, m.id_status_pelayanan, m.id_gereja, m.tgl_tahbis, m.tgl_akhir_jawatan,
	           m.createAt, m.updateAt, m.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           s.status,
	           g.nama_gereja AS gereja_name
	    FROM majelis m
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN status s ON m.id_status_pelayanan = s.id_status
	    JOIN gereja g ON m.id_gereja = g.id_gereja
	    WHERE m.isDeleted = 0;
	END


-- SP - View_byId data Majelis
	CREATE DEFINER=root@localhost PROCEDURE view_Majelis_byId(IN id INT)
	BEGIN
	    SELECT m.id_majelis, m.id_jemaat, m.id_status_pelayanan, m.id_gereja, m.tgl_tahbis, m.tgl_akhir_jawatan,
	           m.createAt, m.updateAt, m.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           s.status,
	           g.nama_gereja AS gereja_name
	    FROM majelis m
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN status s ON m.id_status_pelayanan = s.id_status
	    JOIN gereja g ON m.id_gereja = g.id_gereja
	    WHERE m.id_majelis = id;
	END


-- SP - DELETE(set isDeleted to 1(true) data Majelis)
	CREATE DEFINER=root@localhost PROCEDURE delete_majelis(IN id INT)
	BEGIN
	    UPDATE majelis
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_majelis = id;
	END


###########################################################################################################################################

####
#### - SP for Majelis Lingkungan
####	
	
-- SP - INSERT data Majelis Lingkungan
	CREATE DEFINER=root@localhost PROCEDURE insert_majelis_lingkungan(IN dataMajelisLingkungan JSON)
	BEGIN
	    
	    SET @majelisId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelisLingkungan, '$.id_majelis'));
	    SET @wijkId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelisLingkungan, '$.id_wijk'));
	
	    INSERT INTO majelis_lingkungan (id_majelis, id_wijk, createAt)
	    VALUES (@majelisId, @wijkId, NOW());
	END;


-- SP - UPDATE data Majelis Lingkungan
	CREATE DEFINER=root@localhost PROCEDURE update_majelis_lingkungan(IN dataMajelisLingkungan JSON)
	BEGIN
	    
	    SET @majelisId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelisLingkungan, '$.id_majelis'));
	    SET @wijkId = JSON_UNQUOTE(JSON_EXTRACT(dataMajelisLingkungan, '$.id_wijk'));
	
	    UPDATE majelis_lingkungan
	    SET id_wijk = @wijkId, updateAt = NOW()
	    WHERE id_majelis = @majelisId;
	END;


-- SP - View_ALL data Majelis Lingkungan
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Majelis_Lingkungan()
	BEGIN
	    SELECT ml.id_majelis, ml.id_wijk, ml.createAt, ml.updateAt, ml.isDelete,
	           m.id_jemaat, m.id_status_pelayanan, m.id_gereja, m.tgl_tahbis, m.tgl_akhir_jawatan,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           s.status,
	           g.nama_gereja AS gereja_name,
	           w.nama_wijk as wijk_name
	    FROM majelis_lingkungan ml
	    JOIN majelis m ON ml.id_majelis = m.id_majelis
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN status s ON m.id_status_pelayanan = s.id_status
	    JOIN gereja g ON m.id_gereja = g.id_gereja
	    JOIN wijk w ON m.id_gereja = w.id_wijk
	    WHERE ml.isDelete = 0;
	END;


-- SP - View_byId data Majelis Lingkungan
	CREATE DEFINER=root@localhost PROCEDURE view_Majelis_Lingkungan_byId(IN majelisId INT)
	BEGIN
	    SELECT ml.id_majelis, ml.id_wijk, ml.createAt, ml.updateAt, ml.isDelete,
	           m.id_jemaat, m.id_status_pelayanan, m.id_gereja, m.tgl_tahbis, m.tgl_akhir_jawatan,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           s.status,
	           g.nama_gereja AS gereja_name,
	           w.nama_wijk as wijk_name
	    FROM majelis_lingkungan ml
	    JOIN majelis m ON ml.id_majelis = m.id_majelis
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN status s ON m.id_status_pelayanan = s.id_status
	    JOIN gereja g ON m.id_gereja = g.id_gereja
	    JOIN wijk w ON m.id_gereja = w.id_wijk
	    WHERE ml.id_majelis = majelisId AND ml.isDelete = 0;
	END;


-- SP - DELETE(set isDeleted to 1(true) data Majelis Lingkungan)
	CREATE DEFINER=root@localhost PROCEDURE delete_majelis_lingkungan(IN majelisId INT)
	BEGIN
	    UPDATE majelis_lingkungan
	    SET isDelete = 1, updateAt = NOW()
	    WHERE id_majelis = majelisId;
	END;


###########################################################################################################################################

####
#### - SP for Pelayan Gereja
####
	
-- SP - INSERT data Pelayan Gereja
	CREATE DEFINER=root@localhost PROCEDURE insert_pelayan_gereja(IN dataPelayanGereja JSON)
	BEGIN
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanGereja, '$.id_jemaat'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanGereja, '$.keterangan'));
	    
	    INSERT INTO pelayan_gereja (id_jemaat, keterangan, createAt)
	    VALUES (@jemaatId, @keterangan, NOW());
	END

-- SP - UPDATE data Pelayan Gereja
	CREATE DEFINER=root@localhost PROCEDURE update_pelayan_gereja(IN dataPelayanGereja JSON)
	BEGIN
	    SET @pelayanGerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanGereja, '$.id_pelayan_gereja'));
	    SET @jemaatId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanGereja, '$.id_jemaat'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanGereja, '$.keterangan'));
	    
	    UPDATE pelayan_gereja
	    SET id_jemaat = @jemaatId, keterangan = @keterangan, updateAt = NOW()
	    WHERE id_pelayan_gereja = @pelayanGerejaId;
	END

-- SP - View_ALL data Pelayan Gereja
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Pelayan_Gereja()
	BEGIN
	    SELECT pg.id_pelayan_gereja, pg.id_jemaat, pg.keterangan, pg.createAt, pg.updateAt, pg.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang
	    FROM pelayan_gereja pg
	    JOIN jemaat j ON pg.id_jemaat = j.id_jemaat
	    WHERE pg.isDeleted = 0;
	END

-- SP - View_byId data Pelayan Gereja
	CREATE DEFINER=root@localhost PROCEDURE view_Pelayan_Gereja_byId(IN id INT)
	BEGIN
	    SELECT pg.id_pelayan_gereja, pg.id_jemaat, pg.keterangan, pg.createAt, pg.updateAt, pg.isDeleted,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang
	    FROM pelayan_gereja pg
	    JOIN jemaat j ON pg.id_jemaat = j.id_jemaat
	    WHERE pg.id_pelayan_gereja = id;
	END

-- SP - DELETE(set isDeleted to 1(true) data Pelayan Gereja)
	CREATE DEFINER=root@localhost PROCEDURE delete_pelayan_gereja(IN id INT)
	BEGIN
	    UPDATE pelayan_gereja
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_pelayan_gereja = id;
	end
	
	
###########################################################################################################################################

####
#### - SP for Pelayan Non Tahbisan
####
	
-- SP - INSERT data Pelayanan Non Tahbisan
	CREATE DEFINER=root@localhost PROCEDURE insert_pelayanan_nonTahbisan(IN dataPelayanan JSON)
	BEGIN
	    SET @majelisId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_majelis'));
	    SET @pelayanGerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_pelayan_gereja'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_gereja'));
	    SET @statusPelayananId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_status_pelayanan'));
	    SET @namaPelayanan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.nama_pelayanan_nonTahbisan'));
	    SET @tglPengangkatan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.tgl_pengangkatan'));
	    SET @tglBerakhir = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.tgl_berakhir'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.keterangan'));
	    
	    INSERT INTO pelayanan_nonTahbisan (id_majelis, id_pelayan_gereja, id_gereja, id_status_pelayanan, 
	        nama_pelayanan_nonTahbisan, tgl_pengangkatan, tgl_berakhir, keterangan, createAt)
	    VALUES (@majelisId, @pelayanGerejaId, @gerejaId, @statusPelayananId, @namaPelayanan, @tglPengangkatan, 
	        @tglBerakhir, @keterangan, NOW());
	END;


-- SP - UPDATE data Pelayanan Non Tahbisan
	CREATE DEFINER=root@localhost PROCEDURE update_pelayanan_nonTahbisan(IN dataPelayanan JSON)
	BEGIN
	    SET @pelayananId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_pelayanan_nonTahbisan'));
	    SET @majelisId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_majelis'));
	    SET @pelayanGerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_pelayan_gereja'));
	    SET @gerejaId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_gereja'));
	    SET @statusPelayananId = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.id_status_pelayanan'));
	    SET @namaPelayanan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.nama_pelayanan_nonTahbisan'));
	    SET @tglPengangkatan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.tgl_pengangkatan'));
	    SET @tglBerakhir = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.tgl_berakhir'));
	    SET @keterangan = JSON_UNQUOTE(JSON_EXTRACT(dataPelayanan, '$.keterangan'));
	    
	    UPDATE pelayanan_nonTahbisan
	    SET id_majelis = @majelisId, id_pelayan_gereja = @pelayanGerejaId, id_gereja = @gerejaId, 
	        id_status_pelayanan = @statusPelayananId, nama_pelayanan_nonTahbisan = @namaPelayanan, 
	        tgl_pengangkatan = @tglPengangkatan, tgl_berakhir = @tglBerakhir, keterangan = @keterangan,
	        updateAt = NOW()
	    WHERE id_pelayanan_nonTahbisan = @pelayananId;
	END;


-- SP - View_ALL data Pelayanan Non Tahbisan
	CREATE DEFINER=root@localhost PROCEDURE viewAll_Pelayanan_nonTahbisan()
	BEGIN
	    SELECT p.id_pelayanan_nonTahbisan, m.id_jemaat, p.id_majelis, p.id_pelayan_gereja, p.id_gereja, p.id_status_pelayanan, 
	           p.nama_pelayanan_nonTahbisan, p.tgl_pengangkatan, p.tgl_berakhir, p.keterangan,
	           p.createAt, p.updateAt, p.isDeleted,
	           m.id_jemaat, m.id_status_pelayanan AS majelis_status, m.tgl_tahbis, m.tgl_akhir_jawatan,
	           g.nama_gereja AS gereja_name,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           s.status AS status_name
	    FROM pelayanan_nonTahbisan p
	    JOIN majelis m ON p.id_majelis = m.id_majelis
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN pelayan_gereja pg ON p.id_pelayan_gereja = pg.id_pelayan_gereja
	    JOIN gereja g ON p.id_gereja = g.id_gereja
	    JOIN status s ON p.id_status_pelayanan = s.id_status
	    WHERE p.isDeleted = 0;
	END;


-- SP - View_byId data Pelayanan Non Tahbisan
	CREATE DEFINER=root@localhost PROCEDURE view_Pelayanan_nonTahbisan_byId(IN id INT)
	BEGIN
	    SELECT p.id_pelayanan_nonTahbisan, m.id_jemaat, p.id_majelis, p.id_pelayan_gereja, p.id_gereja, p.id_status_pelayanan, 
	           p.nama_pelayanan_nonTahbisan, p.tgl_pengangkatan, p.tgl_berakhir, p.keterangan,
	           p.createAt, p.updateAt, p.isDeleted,
	           m.id_jemaat, m.id_status_pelayanan AS majelis_status, m.tgl_tahbis, m.tgl_akhir_jawatan,
	           g.nama_gereja AS gereja_name,
	           j.gelar_depan, j.nama_depan, j.nama_belakang, j.gelar_belakang,
	           s.status AS status_name
	    FROM pelayanan_nonTahbisan p
	    JOIN majelis m ON p.id_majelis = m.id_majelis
	    JOIN jemaat j ON m.id_jemaat = j.id_jemaat
	    JOIN pelayan_gereja pg ON p.id_pelayan_gereja = pg.id_pelayan_gereja
	    JOIN gereja g ON p.id_gereja = g.id_gereja
	    JOIN status s ON p.id_status_pelayanan = s.id_status
	    WHERE p.id_pelayanan_nonTahbisan = id;
	END;


-- SP - DELETE(set isDeleted to 1(true) data Pelayanan Non Tahbisan)
	CREATE DEFINER=root@localhost PROCEDURE delete_pelayanan_nonTahbisan(IN id INT)
	BEGIN
	    UPDATE pelayanan_nonTahbisan
	    SET isDeleted = 1, updateAt = NOW()
	    WHERE id_pelayanan_nonTahbisan = id;
	END;
