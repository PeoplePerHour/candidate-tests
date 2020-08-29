import React from "react";
import { useSelector } from "react-redux";

function Pagination({changePage}) {

  const info = useSelector((state) => state.characters.info);
  
  return (
    <nav aria-label="Page navigation example" className="pagination-container">
      <ul className="pagination">
        <li className="page-item ">
          <button
            type="button"
            className="btn  pagination-button"
            disabled={info && info.prev === null}
            onClick={() => changePage("prev")}
          >
            Previous
          </button>
        </li>
        <li className="page-item">
          <button
            type="button"
            className="btn  pagination-button"
            onClick={() => changePage("next")}
            disabled={info && info.next === null}
          >
            Next
          </button>
        </li>
      </ul>
    </nav>
  );
}
export default Pagination;
