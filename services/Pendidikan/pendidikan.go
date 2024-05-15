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

type Pendidikan struct {
	ID          int    `json:"id_pendidikan"`
	Pendidikan  string `json:"pendidikan"`
	Keterangan  string `json:"keterangan"`
}

var db *sql.DB

func main() {
	// Initialize database connection
	var err error
	db, err = sql.Open("mysql", "root:Mypass123@tcp(localhost:3306)/Services-Pendidikan")
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Initialize router
	r := mux.NewRouter()

	// Define API endpoints
	r.HandleFunc("/pendidikan", handlePendidikan).Methods("GET", "POST")
	r.HandleFunc("/pendidikan/{id}", handlePendidikanByID).Methods("GET", "PUT")
	r.HandleFunc("/pendidikan/{id}", deletePendidikan).Methods("DELETE")

	// Start server
	fmt.Println("Server running on port 8083")
	log.Fatal(http.ListenAndServe(":8083", r))
}

func handlePendidikan(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getPendidikan(w, r)
	case http.MethodPost:
		createPendidikan(w, r)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func handlePendidikanByID(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getPendidikanByID(w, id)
	case http.MethodPut:
		updatePendidikan(w, r, id)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func getPendidikan(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("CALL viewAll_Pendidikan()")
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var pendidikans []Pendidikan
	for rows.Next() {
		var pendidikan Pendidikan
		if err := rows.Scan(&pendidikan.ID, &pendidikan.Pendidikan, &pendidikan.Keterangan); err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		pendidikans = append(pendidikans, pendidikan)
	}

	if err := rows.Err(); err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(pendidikans)
}

func createPendidikan(w http.ResponseWriter, r *http.Request) {
	var pendidikan Pendidikan
	if err := json.NewDecoder(r.Body).Decode(&pendidikan); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both pendidikan and keterangan fields
	data := map[string]interface{}{
		"pendidikan":  pendidikan.Pendidikan,
		"keterangan": pendidikan.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL insert_pendidikan(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
}

func getPendidikanByID(w http.ResponseWriter, id int) {
	row := db.QueryRow("CALL view_Pendidikan_byId(?)", id)
	var pendidikan Pendidikan
	if err := row.Scan(&pendidikan.ID, &pendidikan.Pendidikan, &pendidikan.Keterangan); err != nil {
		http.Error(w, "Pendidikan not found", http.StatusNotFound)
		return
	}

	json.NewEncoder(w).Encode(pendidikan)
}

func updatePendidikan(w http.ResponseWriter, r *http.Request, id int) {
	var pendidikan Pendidikan
	if err := json.NewDecoder(r.Body).Decode(&pendidikan); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Construct a JSON object containing both id, pendidikan, and keterangan fields
	data := map[string]interface{}{
		"id_pendidikan": id,
		"pendidikan":    pendidikan.Pendidikan,
		"keterangan":    pendidikan.Keterangan,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	// Call the stored procedure with the JSON object as the argument
	_, err = db.Exec("CALL update_pendidikan(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}

func deletePendidikan(w http.ResponseWriter, r *http.Request) {
	params := mux.Vars(r)
	id := params["id"]

	_, err := db.Exec("CALL delete_pendidikan(?)", id)
	if err != nil {
		log.Fatal(err)
	}

	json.NewEncoder(w).Encode("Pendidikan deleted successfully")
}
