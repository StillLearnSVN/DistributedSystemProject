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

type Status struct {
	ID             int    `json:"id_status"`
	Status         string `json:"status"`
	IDJenisStatus  int    `json:"id_jenis_status"`
	JenisStatus    string `json:"jenis_status"`
	Keterangan     string `json:"keterangan"`
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
	r.HandleFunc("/status", handleStatus).Methods("GET", "POST")
	r.HandleFunc("/status/{id}", handleStatusByID).Methods("GET", "PUT")
	r.HandleFunc("/status/{id}", deleteStatus).Methods("DELETE")

	// Start server
	fmt.Println("Server running on port 8085")
	log.Fatal(http.ListenAndServe(":8085", r))
}

func handleStatus(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getStatus(w, r)
	case http.MethodPost:
		createStatus(w, r)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func handleStatusByID(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getStatusByID(w, id)
	case http.MethodPut:
		updateStatus(w, r, id)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func getStatus(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("CALL viewAll_Status()")
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var statuses []Status
	for rows.Next() {
		var status Status
		if err := rows.Scan(&status.ID, &status.Status, &status.IDJenisStatus, &status.Keterangan, &status.JenisStatus); err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		statuses = append(statuses, status)
	}

	if err := rows.Err(); err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(statuses)
}

func createStatus(w http.ResponseWriter, r *http.Request) {
	var status Status
	if err := json.NewDecoder(r.Body).Decode(&status); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	data := map[string]interface{}{
		"status":         status.Status,
		"id_jenis_status": status.IDJenisStatus,
		"keterangan":    status.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	_, err = db.Exec("CALL insert_status(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
}

func getStatusByID(w http.ResponseWriter, id int) {
	row := db.QueryRow("CALL view_Status_byId(?)", id)
	var status Status
	if err := row.Scan(&status.ID, &status.Status, &status.IDJenisStatus, &status.Keterangan, &status.JenisStatus); err != nil {
		http.Error(w, "Status not found", http.StatusNotFound)
		return
	}

	json.NewEncoder(w).Encode(status)
}

func updateStatus(w http.ResponseWriter, r *http.Request, id int) {
	var status Status
	if err := json.NewDecoder(r.Body).Decode(&status); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	data := map[string]interface{}{
		"id_status":      id,
		"status":         status.Status,
		"id_jenis_status": status.IDJenisStatus,
		"keterangan":    status.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	_, err = db.Exec("CALL update_status(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}

func deleteStatus(w http.ResponseWriter, r *http.Request) {
	params := mux.Vars(r)
	id := params["id"]

	_, err := db.Exec("CALL delete_status(?)", id)
	if err != nil {
		log.Fatal(err)
	}

	json.NewEncoder(w).Encode("Status deleted successfully")
}
