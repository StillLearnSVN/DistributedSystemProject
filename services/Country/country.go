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

type Country struct {
	CountryID   int    `json:"country_id"`
	CountryCode string `json:"country_code"`
	CountryName string `json:"country_name"`
	Code        string `json:"code"`
}

var db *sql.DB

func main() {
	// Initialize database connection
	var err error
	db, err = sql.Open("mysql", "root:Mypass123@tcp(localhost:3306)/Services-Country")
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Initialize router
	r := mux.NewRouter()

	// Define API endpoints
	r.HandleFunc("/country", handleCountry).Methods("GET", "POST")
	r.HandleFunc("/country/{id}", handleCountryByID).Methods("GET", "PUT")
	r.HandleFunc("/country/{id}", deleteCountry).Methods("DELETE")

	// Start server
	fmt.Println("Server running on port 8086")
	log.Fatal(http.ListenAndServe(":8086", r))
}

func handleCountry(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case http.MethodGet:
		getCountries(w, r)
	case http.MethodPost:
		createCountry(w, r)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func handleCountryByID(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	switch r.Method {
	case http.MethodGet:
		getCountryByID(w, id)
	case http.MethodPut:
		updateCountry(w, r, id)
	default:
		http.Error(w, "Method not allowed", http.StatusMethodNotAllowed)
	}
}

func getCountries(w http.ResponseWriter, r *http.Request) {
	rows, err := db.Query("CALL viewAll_Country()")
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var countries []Country
	for rows.Next() {
		var country Country
		if err := rows.Scan(&country.CountryID, &country.CountryCode, &country.CountryName, &country.Code); err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		countries = append(countries, country)
	}

	if err := rows.Err(); err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(countries)
}

func createCountry(w http.ResponseWriter, r *http.Request) {
	var country Country
	if err := json.NewDecoder(r.Body).Decode(&country); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	data := map[string]interface{}{
		"country_code": country.CountryCode,
		"country_name": country.CountryName,
		"code":         country.Code,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	_, err = db.Exec("CALL insert_country(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusCreated)
}

func getCountryByID(w http.ResponseWriter, id int) {
	row := db.QueryRow("CALL view_Country_byId(?)", id)
	var country Country
	if err := row.Scan(&country.CountryID, &country.CountryCode, &country.CountryName, &country.Code); err != nil {
		http.Error(w, "Country not found", http.StatusNotFound)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(country)
}

func updateCountry(w http.ResponseWriter, r *http.Request, id int) {
	var country Country
	if err := json.NewDecoder(r.Body).Decode(&country); err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	data := map[string]interface{}{
		"country_id":   id,
		"country_code": country.CountryCode,
		"country_name": country.CountryName,
		"code":         country.Code,
	}
	jsonData, err := json.Marshal(data)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	_, err = db.Exec("CALL update_country(?)", string(jsonData))
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}

func deleteCountry(w http.ResponseWriter, r *http.Request) {
	idStr := mux.Vars(r)["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	_, err = db.Exec("CALL delete_country(?)", id)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusNoContent)
}
