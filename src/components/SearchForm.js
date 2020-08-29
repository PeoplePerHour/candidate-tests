import React from "react";

function SearchForm({ onSubmit, onChange, name, gender }) {
  return (
    <div>
        {/* <h3 className="display-4 mb-3 title">
           Search for a character
        </h3> */}

    <div className="jumbotron jumbotron-fluid mt-5 text-center form-container">

      
      <div className="container">
        
        <form id="searchForm" className="form-row" onSubmit={onSubmit}>
          <div className="col-md-6">
            <input
              type="text"
              className="form-control"
              name="searchText"
              placeholder="Search Character"
              onChange={(e) => onChange("name", e)}
              value={name}
            />
          </div>
          <div className="col-md-4">
            <select
              className="custom-select"
              onChange={(e) => onChange("gender", e)}
              value={gender}
            >
              <option value="">Select by Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <button type="submit" className="btn  btn-bg search-button col-md-2">
          <i className="fa fa-search search-symbols" />
            Search
          </button>
        </form>
      </div>
    </div>
    </div>
  );
}

export default SearchForm;
