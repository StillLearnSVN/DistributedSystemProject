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

type JenisStatus struct {
	ID          int    `json:"id_jenis_status"`
	JenisStatus string `json:"jenis_status"`
	Keterangan  string `json:"keterangan"`
}

var db *sql.DB

func main() {
	// Initialize database connection
	var err error
	db, err = sql.Open("mysql", "root:Mypass123@tcp(localhost:3306)/Services-JenisStatus")
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Initialize router
	r := mux.NewRouter()

	// Define API endpoints
	r.HandleFunc("/jenis_status", handleJenisStatus).Methods("GET", "POST")
	r.HandleFunc("/jenis_status/{id}", handleJenisStatusByID).Methods("GET", "PUT")
	r.HandleFunc("/jenis_status/{id}", deleteJenisStatus).Methods("DELETE")

	// Start server
	fmt.Println("Server running on port 8084")
	log.Fatal(http.ListenAndServe(":8084", r))
}

func handleJenisStatus(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getJenisStatus(w, r)
	case http.MethodPost:
		createJenisStatus(w, r)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func handleJenisStatusByID(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getJenisStatusByID(w, id)
	case http.MethodPut:
		updateJenisStatus(w, r, id)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func getJenisStatus(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("CALL viewAll_JenisStatus()")
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var jenisStatuses []JenisStatus
	for rows.Next() {
		var jenisStatus JenisStatus
		if err := rows.Scan(&jenisStatus.ID, &jenisStatus.JenisStatus, &jenisStatus.Keterangan); err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		jenisStatuses = append(jenisStatuses, jenisStatus)
	}

	if err := rows.Err(); err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(jenisStatuses)
}

func createJenisStatus(w http.ResponseWriter, r *http.Request) {
	var jenisStatus JenisStatus
	if err := json.NewDecoder(r.Body).Decode(&jenisStatus); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both jenis_status and keterangan fields
	data := map[string]interface{}{
		"jenis_status": jenisStatus.JenisStatus,
		"keterangan":   jenisStatus.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL insert_jenis_status(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
}

func getJenisStatusByID(w http.ResponseWriter, id int) {
	row := db.QueryRow("CALL view_JenisStatus_byId(?)", id)
	var jenisStatus JenisStatus
	if err := row.Scan(&jenisStatus.ID, &jenisStatus.JenisStatus, &jenisStatus.Keterangan); err != nil {
		http.Error(w, "JenisStatus not found", http.StatusNotFound)
		return
	}

	json.NewEncoder(w).Encode(jenisStatus)
}

func updateJenisStatus(w http.ResponseWriter, r *http.Request, id int) {
	var jenisStatus JenisStatus
	if err := json.NewDecoder(r.Body).Decode(&jenisStatus); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both id, jenis_status, and keterangan fields
	data := map[string]interface{}{
		"id_jenis_status": id,
		"jenis_status":    jenisStatus.JenisStatus,
		"keterangan":      jenisStatus.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL update_jenis_status(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}

func deleteJenisStatus(w http.ResponseWriter, r *http.Request) {
	params := mux.Vars(r)
	id := params["id"]

	_, err := db.Exec("CALL delete_jenis_status(?)", id)
	if err != nil {
		log.Fatal(err)
	}

	json.NewEncoder(w).Encode("JenisStatus deleted successfully")
}
