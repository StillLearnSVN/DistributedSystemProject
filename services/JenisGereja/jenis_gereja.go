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

type JenisGereja struct {
	ID           int    `json:"id_jenis_gereja"`
	JenisGereja  string `json:"jenis_gereja"`
	Keterangan   string `json:"keterangan"`
}

var db *sql.DB

func main() {
	// Initialize database connection
	var err error
	db, err = sql.Open("mysql", "root:Mypass123@tcp(localhost:3306)/Services-JenisGereja")
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Initialize router
	r := mux.NewRouter()

	// Define API endpoints
	r.HandleFunc("/jenis_gereja", handleJenisGereja).Methods("GET", "POST")
	r.HandleFunc("/jenis_gereja/{id}", handleJenisGerejaByID).Methods("GET", "PUT")
	r.HandleFunc("/jenis_gereja/{id}", deleteJenisGereja).Methods("DELETE")

	// Start server
	fmt.Println("Server running on port 8081")
	log.Fatal(http.ListenAndServe(":8081", r))
}

func handleJenisGereja(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getJenisGereja(w, r)
	case http.MethodPost:
		createJenisGereja(w, r)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func handleJenisGerejaByID(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getJenisGerejaByID(w, id)
	case http.MethodPut:
		updateJenisGereja(w, r, id)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func getJenisGereja(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("CALL viewAll_JenisGereja()")
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var jenisGerejas []JenisGereja
	for rows.Next() {
		var jenisGereja JenisGereja
		if err := rows.Scan(&jenisGereja.ID, &jenisGereja.JenisGereja, &jenisGereja.Keterangan); err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		jenisGerejas = append(jenisGerejas, jenisGereja)
	}

	if err := rows.Err(); err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(jenisGerejas)
}

func createJenisGereja(w http.ResponseWriter, r *http.Request) {
	var jenisGereja JenisGereja
	if err := json.NewDecoder(r.Body).Decode(&jenisGereja); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both jenis gereja and keterangan fields
	data := map[string]interface{}{
		"jenis_gereja": jenisGereja.JenisGereja,
		"keterangan":   jenisGereja.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL insert_jenis_gereja(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
}

func getJenisGerejaByID(w http.ResponseWriter, id int) {
	row := db.QueryRow("CALL view_JenisGereja_byId(?)", id)
	var jenisGereja JenisGereja
	if err := row.Scan(&jenisGereja.ID, &jenisGereja.JenisGereja, &jenisGereja.Keterangan); err != nil {
		http.Error(w, "Jenis Gereja not found", http.StatusNotFound)
		return
	}

	json.NewEncoder(w).Encode(jenisGereja)
}

func updateJenisGereja(w http.ResponseWriter, r *http.Request, id int) {
	var jenisGereja JenisGereja
	if err := json.NewDecoder(r.Body).Decode(&jenisGereja); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both id, jenis gereja, and keterangan fields
	data := map[string]interface{}{
		"id_jenis_gereja": id,
		"jenis_gereja":    jenisGereja.JenisGereja,
		"keterangan":      jenisGereja.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL update_jenis_gereja(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}

func deleteJenisGereja(w http.ResponseWriter, r *http.Request) {
	params := mux.Vars(r)
	id := params["id"]

	_, err := db.Exec("CALL delete_jenis_gereja(?)", id)
	if err != nil {
		log.Fatal(err)
	}

	json.NewEncoder(w).Encode("Jenis Gereja deleted successfully")
}
