import React, { useState, useEffect } from "react";
import "./App.css";

const Character = ({ character }) => (
  <div className="col-md-3 character">
    <img src={character.image} />
    <h2>{character.name}</h2>

    <div className="information-block">
      <strong>Status: </strong> {character.status} <br />
      <strong>Species: </strong> {character.species} <br />
      <strong>Gender: </strong> {character.gender} <br />
      <br />
      <strong>Origin: </strong> {character.origin.name} <br />
      <strong>Location: </strong> {character.location.name}
      <br />
    </div>
  </div>
);

function App() {
  const [list, setList] = useState([]);
  const [page, setPage] = useState(1);
  const [loading, setLoading] = useState(true);
  const [name, setName] = useState("");
  const [gender, setGender] = useState("");
  const [maxPage, setMaxPage] = useState(false);

  const onNameChange = (e) => {
    window.clearTimeout(window.timeout);
    
    window.timeout = setTimeout(() => {
      const params = new URLSearchParams(window.location.search);

      params.set("name", e.target.value);
      window.location.search = params;

      setName(e.target.value);
    }, 200);
  };

  const onGenderChange = (e) => {
    const params = new URLSearchParams(window.location.search);

    params.set("gender", e.target.value);
    window.location.search = params;

    setGender(e.target.value);
  };

  useEffect(() => {
    setLoading(true);
    fetch(
      `http://localhost:8000/characters?page=${page}&name=${name}&gender=${gender}`
    )
      .then((res) => res.json())
      .then((res) => {
        let out = [];
        if (!(res.data instanceof Array)) {
          Object.keys(res.data).forEach((key) => {
            out.push(res.data[key]);
          });
        } else {
          out = res.data;
        }

        setList(out);
        setMaxPage(res.to === res.total);
      })
      .catch((e) => {
        console.log(e);
        alert("An error occurred while fetching data");
      })
      .finally(() => {
        setLoading(false);
      });
  }, [page, name, gender]);

  return (
    <div className="container">
      <form className="form-inline filters">
        <div className="row g-3 grow">
          <div className="col-sm">
            <input
              type="text"
              className="form-control"
              placeholder="Enter Character Name"
              onChange={(e) => onNameChange(e)}
            />
          </div>
          <div className="col-sm">
            <select
              title="Gender"
              placeholder="Gender"
              className="form-control"
              onChange={(e) => onGenderChange(e)}
            >
              <option value="">All</option>
              <option value="female">Female</option>
              <option value="male">Male</option>
            </select>
          </div>
        </div>
      </form>
      <div className="row">
        {list &&
          list.map((item) => <Character key={item.id} character={item} />)}
      </div>

      <nav className="mt-20" aria-label="Page navigation example">
        <ul className="pagination justify-content-center">
          <li className={"page-item" + (page === 1 ? " disabled" : "")}>
            <a
              disabled={page === 1}
              onClick={() => setPage(page - 1)}
              className="page-link"
              href="#"
              tabIndex="-1"
            >
              Previous
            </a>
          </li>
          <li className={"page-item" + (maxPage ? " disabled" : "")}>
            <a
              disabled={maxPage}
              onClick={() => setPage(page + 1)}
              className="page-link"
              href="#"
            >
              Next
            </a>
          </li>
        </ul>
      </nav>
    </div>
  );
}

export default App;
