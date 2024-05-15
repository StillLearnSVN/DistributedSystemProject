package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"strconv"

	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
)

type HubunganKeluarga struct {
	ID              int    `json:"id_hub_keluarga"`
	NamaHubKeluarga string `json:"nama_hub_keluarga"`
	Keterangan      string `json:"keterangan"`
}

var db *sql.DB

func main() {
	// Initialize database connection
	var err error
	db, err = sql.Open("mysql", "root:Mypass123@tcp(localhost:3306)/Services-HubKeluarga")
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Initialize router
	r := mux.NewRouter()

	// Define API endpoints
	r.HandleFunc("/hubungan_keluarga", handleHubunganKeluarga).Methods("GET", "POST")
	r.HandleFunc("/hubungan_keluarga/{id}", handleHubunganKeluargaByID).Methods("GET", "PUT")
	r.HandleFunc("/hubungan_keluarga/{id}", deleteHubunganKeluarga).Methods("DELETE")

	// Start server
	fmt.Println("Server running on port 8082")
	log.Fatal(http.ListenAndServe(":8082", r))
}

func handleHubunganKeluarga(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getHubunganKeluarga(w, r)
	case http.MethodPost:
		createHubunganKeluarga(w, r)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func handleHubunganKeluargaByID(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getHubunganKeluargaByID(w, id)
	case http.MethodPut:
		updateHubunganKeluarga(w, r, id)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func getHubunganKeluarga(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("CALL viewAll_HubunganKeluarga()")
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var hubunganKeluargas []HubunganKeluarga
	for rows.Next() {
		var hubunganKeluarga HubunganKeluarga
		if err := rows.Scan(&hubunganKeluarga.ID, &hubunganKeluarga.NamaHubKeluarga, &hubunganKeluarga.Keterangan); err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		hubunganKeluargas = append(hubunganKeluargas, hubunganKeluarga)
	}

	if err := rows.Err(); err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(hubunganKeluargas)
}

func createHubunganKeluarga(w http.ResponseWriter, r *http.Request) {
	var hubunganKeluarga HubunganKeluarga
	if err := json.NewDecoder(r.Body).Decode(&hubunganKeluarga); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both nama hub keluarga and keterangan fields
	data := map[string]interface{}{
		"nama_hub_keluarga": hubunganKeluarga.NamaHubKeluarga,
		"keterangan":         hubunganKeluarga.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL insert_hubungan_keluarga(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
}

func getHubunganKeluargaByID(w http.ResponseWriter, id int) {
	row := db.QueryRow("CALL view_HubunganKeluarga_byId(?)", id)
	var hubunganKeluarga HubunganKeluarga
	if err := row.Scan(&hubunganKeluarga.ID, &hubunganKeluarga.NamaHubKeluarga, &hubunganKeluarga.Keterangan); err != nil {
		http.Error(w, "Hubungan Keluarga not found", http.StatusNotFound)
		return
	}

	json.NewEncoder(w).Encode(hubunganKeluarga)
}

func updateHubunganKeluarga(w http.ResponseWriter, r *http.Request, id int) {
	var hubunganKeluarga HubunganKeluarga
	if err := json.NewDecoder(r.Body).Decode(&hubunganKeluarga); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both id, nama hub keluarga, and keterangan fields
	data := map[string]interface{}{
		"id_hub_keluarga":   id,
		"nama_hub_keluarga": hubunganKeluarga.NamaHubKeluarga,
		"keterangan":         hubunganKeluarga.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL update_hubungan_keluarga(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}

func deleteHubunganKeluarga(w http.ResponseWriter, r *http.Request) {
	params := mux.Vars(r)
	id := params["id"]

	_, err := db.Exec("CALL delete_hubungan_keluarga(?)", id)
	if err != nil {
		log.Fatal(err)
	}

	json.NewEncoder(w).Encode("Hubungan Keluarga deleted successfully")
}
