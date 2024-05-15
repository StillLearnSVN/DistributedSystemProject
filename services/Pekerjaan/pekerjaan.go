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

type Pekerjaan struct {
    ID         int    `json:"id_pekerjaan"`
    Pekerjaan  string `json:"pekerjaan"`
    Keterangan string `json:"keterangan"`
}

var db *sql.DB

func main() {
    // Initialize database connection
    var err error
    db, err = sql.Open("mysql", "root:Mypass123@tcp(localhost:3306)/Services-Pekerjaan")
    if err != nil {
        log.Fatal(err)
    }
    defer db.Close()

    // Initialize router
    r := mux.NewRouter()

    // Define API endpoints
    r.HandleFunc("/pekerjaan", handlePekerjaan).Methods("GET", "POST")
    r.HandleFunc("/pekerjaan/{id}", handlePekerjaanByID).Methods("GET", "PUT")
	r.HandleFunc("/pekerjaan/{id}", deletePekerjaan).Methods("DELETE")

    // Start server
    fmt.Println("Server running on port 8080")
    log.Fatal(http.ListenAndServe(":8080", r))
}

func handlePekerjaan(w http.ResponseWriter, r *http.Request) {
    switch r.Method {
    case http.MethodGet:
        getPekerjaan(w, r)
    case http.MethodPost:
        createPekerjaan(w, r)
    default:
        http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
    }
}

func handlePekerjaanByID(w http.ResponseWriter, r *http.Request) {
    idStr := mux.Vars(r)["id"]
    id, err := strconv.Atoi(idStr)
    if err != nil {
        http.Error(w, "Invalid ID", http.StatusBadRequest)
        return
    }

    switch r.Method {
    case http.MethodGet:
        getPekerjaanByID(w, id)
    case http.MethodPut:
        updatePekerjaan(w, r, id)
    default:
        http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
    }
}

func getPekerjaan(w http.ResponseWriter, r *http.Request) {
    rows, err := db.Query("CALL viewAll_Pekerjaan()")
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    defer rows.Close()

    var pekerjaans []Pekerjaan
    for rows.Next() {
        var pekerjaan Pekerjaan
        if err := rows.Scan(&pekerjaan.ID, &pekerjaan.Pekerjaan, &pekerjaan.Keterangan); err != nil {
            http.Error(w, err.Error(), http.StatusInternalServerError)
            return
        }
        pekerjaans = append(pekerjaans, pekerjaan)
    }

    if err := rows.Err(); err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }

    json.NewEncoder(w).Encode(pekerjaans)
}

func createPekerjaan(w http.ResponseWriter, r *http.Request) {
    var pekerjaan Pekerjaan
    if err := json.NewDecoder(r.Body).Decode(&pekerjaan); err != nil {
        http.Error(w, err.Error(), http.StatusBadRequest)
        return
    }

    // Construct a JSON object containing both pekerjaan and keterangan fields
    data := map[string]interface{}{
        "pekerjaan":  pekerjaan.Pekerjaan,
        "keterangan": pekerjaan.Keterangan,
    }
    jsonData, err := json.Marshal(data)
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }

    // Call the stored procedure with the JSON object as the argument
    _, err = db.Exec("CALL insert_pekerjaan(?)", string(jsonData))
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }

    w.WriteHeader(http.StatusCreated)
}


func getPekerjaanByID(w http.ResponseWriter, id int) {
    row := db.QueryRow("CALL view_Pekerjaan_byId(?)", id)
    var pekerjaan Pekerjaan
    if err := row.Scan(&pekerjaan.ID, &pekerjaan.Pekerjaan, &pekerjaan.Keterangan); err != nil {
        http.Error(w, "Pekerjaan not found", http.StatusNotFound)
        return
    }

    json.NewEncoder(w).Encode(pekerjaan)
}

func updatePekerjaan(w http.ResponseWriter, r *http.Request, id int) {
    var pekerjaan Pekerjaan
    if err := json.NewDecoder(r.Body).Decode(&pekerjaan); err != nil {
        http.Error(w, err.Error(), http.StatusBadRequest)
        return
    }

    // Construct a JSON object containing both id, pekerjaan, and keterangan fields
    data := map[string]interface{}{
        "id_pekerjaan": id,
        "pekerjaan":  pekerjaan.Pekerjaan,
        "keterangan": pekerjaan.Keterangan,
    }
    jsonData, err := json.Marshal(data)
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }

    // Call the stored procedure with the JSON object as the argument
    _, err = db.Exec("CALL update_pekerjaan(?)", string(jsonData))
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }

    w.WriteHeader(http.StatusNoContent)
}

func deletePekerjaan(w http.ResponseWriter, r *http.Request) {
    params := mux.Vars(r)
    id := params["id"]

    _, err := db.Exec("CALL delete_pekerjaan(?)", id)
    if err != nil {
        log.Fatal(err)
    }

    json.NewEncoder(w).Encode("Pekerjaan deleted successfully")
}